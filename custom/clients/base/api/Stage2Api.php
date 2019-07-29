<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

use Sugarcrm\Sugarcrm\custom\Hint\Config\ConfigTrait;
use Sugarcrm\Sugarcrm\custom\Hint\Initializer;
use Sugarcrm\Sugarcrm\custom\Hint\Logger\Logger;
use Sugarcrm\Sugarcrm\custom\Hint\Manager;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\UserDeleteEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\QueueProcessor;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\QueueTrait;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class Stage2Api extends \SugarApi implements LoggerAwareInterface
{
    use LoggerAwareTrait, ConfigTrait, QueueTrait;


    /**
     * Stage2Api constructor.
     */
    public function __construct()
    {
        $this->eventQueue = $this->getEventQueue();
        $this->config = $this->getConfig();
        $this->setLogger(new Logger());
    }

    // This function is only called whenever the rest service cache file is deleted.
    // This should return an array of arrays that define how different paths map to different functions
    public function registerApiRest()
    {
        return [
            'readConfig' => [
                'reqType' => 'GET',
                'path' => ['hint', 'config'],
                'pathVars' => [''],
                'method' => 'readConfig',
                'shortHelp' => 'Reads Hint configuration',
                'longHelp' => '',
            ],

            'createConfig' => [
                'reqType' => 'POST',
                'path' => ['hint', 'config'],
                'pathVars' => [''],
                'method' => 'updateConfig',
                'shortHelp' => 'Updates Hint configuration',
                'longHelp' => '',
            ],

            'updateConfig' => [
                'reqType' => 'PUT',
                'path' => ['hint', 'config'],
                'pathVars' => [''],
                'method' => 'updateConfig',
                'shortHelp' => 'Updates Hint configuration',
                'longHelp' => '',
            ],

            'resync' => [
                'reqType' => 'POST',
                'path' => ['hint', 'insights', 'resync'],
                'pathVars' => [''],
                'method' => 'resync',
                'shortHelp' => 'Triggers instance synchronization',
                'longHelp' => '',
            ],

            'token' => [
                'reqType' => 'POST',
                'path' => ['stage2', 'token'],
                'pathVars' => [''],
                'method' => 'createToken',
                'shortHelp' => 'Generates a new Stage2 access token for the user',
                'longHelp' => '',
            ],
            'params' => [
                'reqType' => 'GET',
                'path' => ['stage2', 'params'],
                'pathVars' => [''],
                'method' => 'getParams',
                'shortHelp' => 'Returns different Stage2 information particular for the user',
                'longHelp' => '',
            ],

            'notificationsServiceToken' => [
                'reqType' => 'POST',
                'path' => ['stage2', 'notificationsServiceToken'],
                'pathVars' => [''],
                'method' => 'createNotificationsServiceToken',
                'shortHelp' => 'Generates a new notifications service access token for the user',
                'longHelp' => '',
            ],

            // -------------------------------------------------------------------------
            // Scaffolding below here for manually running these
            'updateNotifications' => [
                'reqType' => 'POST',
                'noLoginRequired' => true,      // REMIND: need to put this back somehow
                'path' => ['hint', 'insights', 'notifications', 'updateNotifications'],
                'pathVars' => [''],
                'method' => 'updateNotifications',
                'shortHelp' => 'Records updated notifications',
                'longHelp' => '',
            ],

            'processQueue' => [
                'reqType' => 'GET',
                'noLoginRequired' => true,      // REMIND: need to put this back somehow
                'path' => ['hint', 'insights', 'notifications', 'processQueue'],
                'pathVars' => [''],
                'method' => 'processQueue',
                'shortHelp' => 'Test endpoint for processing the queue',
                'longHelp' => '',
            ],

            'createAccountset' => [
                'reqType' => 'GET',
                'noLoginRequired' => true,      // REMIND: need to put this back somehow
                'path' => ['hint', 'insights', 'notifications', 'createAccountset'],
                'pathVars' => ['', '', '', ''],
                'method' => 'createAccountset',
                'shortHelp' => 'Test endpoint for processing the queue',
                'longHelp' => '',
            ],

            'deleteAccountset' => [
                'reqType' => 'GET',
                'noLoginRequired' => true,      // REMIND: need to put this back somehow
                'path' => ['hint', 'insights', 'notifications', 'deleteAccountset'],
                'pathVars' => ['', '', '', ''],
                'method' => 'deleteAccountset',
                'shortHelp' => 'Test endpoint for processing the queue',
                'longHelp' => '',
            ],

            'updateAccountset' => [
                'reqType' => 'GET',
                'noLoginRequired' => true,      // REMIND: need to put this back somehow
                'path' => ['hint', 'insights', 'notifications', 'updateAccountset'],
                'pathVars' => ['', '', '', ''],
                'method' => 'updateAccountset',
                'shortHelp' => 'Test endpoint for processing the queue',
                'longHelp' => '',
            ],

            'accountsetAddRelation' => [
                'reqType' => 'GET',
                'noLoginRequired' => true,      // REMIND: need to put this back somehow
                'path' => ['hint', 'insights', 'notifications', 'accountsetAddRelation'],
                'pathVars' => ['', '', '', ''],
                'method' => 'accountsetAddRelation',
                'shortHelp' => 'Test endpoint for adding a relation to an account set',
                'longHelp' => '',
            ],

            'accountsetDeleteRelation' => [
                'reqType' => 'GET',
                'noLoginRequired' => true,      // REMIND: need to put this back somehow
                'path' => ['hint', 'insights', 'notifications', 'accountsetDeleteRelation'],
                'pathVars' => ['', '', '', ''],
                'method' => 'accountsetDeleteRelation',
                'shortHelp' => 'Test endpoint for adding a relation to an account set',
                'longHelp' => '',
            ],

            'createNotificationTarget' => [
                'reqType' => 'GET',
                'noLoginRequired' => true,      // REMIND: need to put this back somehow
                'path' => ['hint', 'insights', 'notifications', 'createNotificationTarget'],
                'pathVars' => ['', '', '', ''],
                'method' => 'createNotificationTarget',
                'shortHelp' => 'Test endpoint for processing the queue',
                'longHelp' => '',
            ],

            'createUserDeleteEvent' => [
                'reqType' => 'GET',
                'noLoginRequired' => true,      // REMIND: need to put this back somehow
                'path' => ['hint', 'insights', 'notifications', 'createUserDeleteEvent'],
                'pathVars' => ['', '', '', ''],
                'method' => 'createUserDeleteEvent',
                'shortHelp' => 'Test endpoint for processing the queue',
                'longHelp' => '',
            ],
        ];
    }

    /**
     * @param \ServiceBase $api
     * @param array $args
     * @return array
     * @throws \SugarApiExceptionNotAuthorized
     * @throws \SugarApiExceptionError
     */
    public function readConfig(\ServiceBase $api, array $args): array
    {
        $this->ensureAdminUser();

        try {
            $loggerConfig = $this->config->getLoggerConfig();
        } catch (\Throwable $e) {
            throw new \SugarApiExceptionError($e->getMessage());
        }

        return [
            'logger' => $loggerConfig,
        ];
    }

    /**
     * @param \ServiceBase $api
     * @param array $args
     * @return array
     * @throws \SugarApiExceptionInvalidParameter
     * @throws \SugarApiExceptionNotAuthorized
     */
    public function updateConfig(\ServiceBase $api, array $args): array
    {
        $this->ensureAdminUser();

        try {
            $loggerConfig = $this->config->setLoggerConfig($args['logger'] ?? []);
        } catch (\Throwable $e) {
            throw new \SugarApiExceptionInvalidParameter($e->getMessage());
        }

        return [
            'logger' => $loggerConfig,
        ];
    }

    /**
     * @param \ServiceBase $api
     * @param array $args
     * @return array
     * @throws \SugarApiExceptionNotAuthorized
     * @throws \SugarApiException
     */
    public function resync(\ServiceBase $api, array $args): array
    {
        $this->ensureAdminUser();

        try {
            $this->getInitializer()->resync();
        } catch (\Throwable $e) {
            throw new \SugarApiException($e->getMessage());
        }

        return [
            'success' => true,
        ];
    }

    function createToken($api, $args)
    {
        $tokenResponse = Manager::instance()->getNewAccessToken();

        $clientResponse = array('accessToken' => $tokenResponse['accessToken']);
        // older servers won't send the subscription type, so be check before using
        if (isset($tokenResponse['subscriptionType'])) {
            $clientResponse['subscriptionType'] = $tokenResponse['subscriptionType'];
        }
        return $clientResponse;
    }

    function getParams($api, $args)
    {
        $manager = Manager::instance();
        return [
            'serviceUrl' => $manager->serviceUrl,
            'pushNotificationKey' => $manager->getVAPIDPublicKey(),
            'instanceId' => $manager->instanceId,
            'sugarVersion' => $manager->sugarVersion,
            'isps' => $manager->getISPs(),
            'analyticsUserId' => $manager->getCurrentUserAnalyticsId(),
            'enrichmentServiceUrl' => $manager->serviceUrl . '/hint/data-enrichment/v1',
            'notificationsServiceUrl' =>
                $manager->notificationsServiceUrl . '/hint/notifications-service/v1'
        ];
    }

    /**
     * Creates a new authentication token for the notifications service.
     *
     * Returns an array (hashmap) of the form:
     * [
     *      accessToken => randomTokenString
     *      ttlMs => time to live of the token in millseconds (just # ms, not a date!)
     *      maxReqPerSec => max permitted requests per second
     * ]
     *
     * Can throw various exceptions if the notifications service cannot be contacted or if it
     * the license key is not present or is invalid
     */
    function createNotificationsServiceToken($api, $args)
    {
        $manager = Manager::instance();
        return $manager->createNotificationsServiceAccessToken();
    }

    function updateNotifications($api, $args)
    {
        return array(
            'serviceUrl' => 'foo',
            'instanceId' => 'bar',
        );
    }

    /**
     * @param \ServiceBase $api
     * @param array $args
     * @return array
     */
    public function processQueue(\ServiceBase $api, array $args): array
    {
        global $current_user;
        $current_user->getSystemUser();

        if (!$this->config->isInsightsEnabled()) {
            return [
                'queue' => 'processed',
            ];
        }

        $this->getQueueProcessor()->processQueue();

        return [
            'queue' => 'processed',
        ];
    }

    function createAccountset($api, $args)
    {
        global $current_user;
        $current_user->getSystemUser();

        $this->logger->debug("creating account set " . print_r($args, true));

        return \HintAccountset::createAccountset($args);
    }

    function deleteAccountset($api, $args)
    {
        global $current_user;
        $current_user->getSystemUser();

        $this->logger->debug("deleting account set " . print_r($args, true));

        return \HintAccountset::deleteAccountset($args);
    }

    function updateAccountset($api, $args)
    {
        global $current_user;
        $current_user->getSystemUser();

        $this->logger->debug("updating account set " . print_r($args, true));

        return \HintAccountset::updateAccountset($args);
    }

    function accountsetAddRelation($api, $args)
    {
        global $current_user;
        $current_user->getSystemUser();

        // Args are accountsetId, tagName
        $this->logger->debug("accountset add relation " . print_r($args, true));

        return \HintAccountset::createAccountsetTagRelation($args);
    }

    function accountsetDeleteRelation($api, $args)
    {
        global $current_user;
        $current_user->getSystemUser();

        // Args are accountsetId, tagName
        $this->logger->debug("accountset delete relation " . print_r($args, true));

        return \HintAccountset::deleteAccountsetTagRelation($args);
    }

    function createNotificationTarget($api, $args)
    {
        global $current_user;
        $current_user->getSystemUser();

        $fields = array_flip(['assigned_user_id', 'type', 'credentials']);
        $params = array_merge($fields, array_intersect_key($args, $fields));

        $this->logger->debug('creating notification target: ' . print_r($params, true));

        return \HintNotificationTarget::activateTarget(
            $params['assigned_user_id'],
            $params['type'],
            $params['credentials']
        );
    }

    /**
     * @param \ServiceBase $api
     * @param array $args
     */
    function createUserDeleteEvent(\ServiceBase $api, array $args): void
    {
        global $current_user;
        $current_user->getSystemUser();

        $this->eventQueue->recordEvent(new UserDeleteEvent($args));
    }

    /**
     * Get Initializer
     * @return Initializer
     */
    protected function getInitializer(): Initializer
    {
        return new Initializer();
    }

    /**
     * Get queue processor
     * @return QueueProcessor
     */
    protected function getQueueProcessor(): QueueProcessor
    {
        return new QueueProcessor();
    }

    /**
     * Ensure current user has admin permissions
     * @throws \SugarApiExceptionNotAuthorized
     */
    private function ensureAdminUser(): void
    {
        global $current_user, $app_strings;

        if (!$current_user->isAdmin()) {
            throw new \SugarApiExceptionNotAuthorized($app_strings['EXCEPTION_NOT_AUTHORIZED']);
        }
    }
}
