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
use Sugarcrm\Sugarcrm\custom\Hint\Logger\Logger as HintLogger;
use Sugarcrm\Sugarcrm\custom\modules\HintNotificationTargets\NotificationTargetTypes;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class HintNotificationTarget extends \Basic implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    const MODULE_NAME = 'HintNotificationTargets';

    public $id;
    public $assigned_user_id;
    public $type;
    public $credentials;
    public $name;
    public $description;
    public $date_entered;
    public $date_modified;
    public $deleted;

    public $module_dir = self::MODULE_NAME;
    public $module_name = self::MODULE_NAME;
    public $table_name = 'hint_notification_targets';
    public $object_name = 'HintNotificationTarget';


    /**
     * HintNotificationTarget constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setLogger(new HintLogger());
    }

    /**
     * @param $userId
     * @param $type
     * @param $credentials
     * @return HintNotificationTarget
     */
    public static function activateTarget($userId, $type, $credentials)
    {
        $logger = new HintLogger();

        // target didn't exist, have to manually create one
        $logger->debug("creating a new target $userId type $type");

        $target = new HintNotificationTarget();
        $target->assigned_user_id = $userId;
        $target->type = $type;
        $target->credentials = json_encode($credentials, JSON_UNESCAPED_SLASHES);
        $target->save();

        return $target;
    }

    /**
     * Activate Sugar target
     *
     * @param $userId
     * @return \HintNotificationTarget
     */
    public static function activateSugarTarget($userId)
    {
        $type = NotificationTargetTypes::SUGAR_TARGET_TYPE;

        return static::activateTarget($userId, $type, $userId);
    }

    /**
     * Activate Email target
     *
     * @param string $userId
     * @param $emailType
     * @return \HintNotificationTarget
     */
    public static function activateEmailTarget($userId, $emailType)
    {
        $user = \BeanFactory::retrieveBean('Users', $userId);
        $timezone = \TimeDate::userTimezone($user);
        $primaryEmail = '';
        foreach ($user->email as $email) {
            if (!empty($email['primary_address']) && !empty($email['email_address'])) {
                $primaryEmail = $email['email_address'];
                break;
            }
        }

        return static::activateTarget($userId, $emailType, [
            'email' => $primaryEmail,
            'timezone' => $timezone,
            'siteUrl' => \SugarConfig::getInstance()->get('site_url'),
        ]);
    }
}
