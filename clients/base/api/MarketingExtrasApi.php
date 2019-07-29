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
declare(strict_types=1);

use Sugarcrm\Sugarcrm\DependencyInjection\Container;
use Sugarcrm\Sugarcrm\Marketing\MarketingExtras;
use Sugarcrm\Sugarcrm\Security\Validator\ConstraintBuilder;
use Sugarcrm\Sugarcrm\Security\Validator\Validator;

/**
 * Marketing Extras API implementation.
 */
class MarketingExtrasApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'getMarketingExtras' => array(
                'reqType' => 'GET',
                'path' => array('login', 'content'),
                'method' => 'getMarketingExtras',
                'shortHelp' => 'An API to receive marketing extra URLs',
                'longHelp' => 'include/api/help/marketing_extras_get_help.html',
                'minVersion' => '11.2',
                'noLoginRequired' => true,
            ),
        );
    }

    /**
     * Retrieve JSON for receiving SugarCRM marketing content.
     * @param ServiceBase $api The REST API instance.
     * @param array $args REST API arguments.
     * @return array Information on how to receive SugarCRM marketing content.
     */
    public function getMarketingExtras(ServiceBase $api, array $args): array
    {
        $marketingExtras = $this->getMarketingExtrasService();
        $url = '';
        if ($marketingExtras->areMarketingExtrasEnabled()) {
            try {
                $options = $this->parseArgs($args);
                $lang = $options['language'];
                $url = $marketingExtras->getMarketingContentUrl($lang);
            } catch (Exception $e) {
                // deliberately swallow exceptions so we don't throw errors to the client
                LoggerManager::getLogger()->warn('Marketing Extras: ' . $e->getMessage());
            }
        }

        return array(
            'content_url' => $url,
        );
    }

    /**
     * Parse the REST API arguments to return desired options.
     * Also perform any necessary security checks.
     * @param array $args Associative array of REST API arguments.
     * @return array Associative array of options.
     */
    public function parseArgs(array $args): array
    {
        if (isset($args['selected_language'])) {
            $langConstraints = $this->getLanguageConstraints();
            $validator = $this->getValidator();
            $errors = $validator->validate($args['selected_language'], $langConstraints);
            if (count($errors) === 0) {
                $lang = $args['selected_language'];
            }
        }
        return array(
            'language' => $lang ?? null,
        );
    }

    /**
     * Retrieves the Symfony validator service.
     * @return \Symfony\Component\Validator\Validator\ValidatorInterface The
     *   validator service.
     */
    private function getValidator()
    {
        $container = Container::getInstance();
        return $container->get(Validator::class);
    }

    /**
     * Creates a Constraint enforcing that an argument is a valid language.
     * @return \Symfony\Component\Validator\Constraint[] The created constraints.
     */
    private function getLanguageConstraints()
    {
        $langConstraintBuilder = new ConstraintBuilder();
        return $langConstraintBuilder->build(
            array(
                'Assert\Language',
            )
        );
    }

    public function getMarketingExtrasService()
    {
        return new MarketingExtras();
    }
}
