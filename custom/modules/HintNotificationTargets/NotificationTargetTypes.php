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
namespace Sugarcrm\Sugarcrm\custom\modules\HintNotificationTargets;

class NotificationTargetTypes
{
    const SUGAR_TARGET_TYPE = 'sugar';
    const BROWSER_TARGET_TYPE = 'browser';
    const EMAIL_IMMEDIATE_TARGET_TYPE = 'email-immediate';
    const EMAIL_DAILY_TARGET_TYPE = 'email-daily';
    const EMAIL_WEEKLY_TARGET_TYPE = 'email-weekly';

    /**
     * All available target types
     * @return array
     */
    public static function getAllTypes()
    {
        return [
            self::SUGAR_TARGET_TYPE, self::BROWSER_TARGET_TYPE,
            self::EMAIL_IMMEDIATE_TARGET_TYPE, self::EMAIL_DAILY_TARGET_TYPE, self::EMAIL_WEEKLY_TARGET_TYPE
        ];
    }

    /**
     * All available email target types
     * @return array
     */
    public static function getEmailTypes()
    {
        return [
            self::EMAIL_IMMEDIATE_TARGET_TYPE,
            self::EMAIL_DAILY_TARGET_TYPE,
            self::EMAIL_WEEKLY_TARGET_TYPE
        ];
    }
}
