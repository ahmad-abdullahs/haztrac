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

use Sugarcrm\Sugarcrm\custom\Hint\LogicHook\LogicHook;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\TargetAddEvent;

class HintNotificationTargetsHook extends LogicHook
{
    /**
     * @param $bean
     * @param $event
     * @param $arguments
     */
    public function afterSave($bean, $event, $arguments)
    {
        // new record
        if (!$arguments['isUpdate']) {
            $credentials = json_decode($bean->credentials, true);
            $this->eventQueue->recordEvent(new TargetAddEvent([
                'targetId' => $bean->id,
                'type' => $bean->type,
                'credentials' => $credentials,
            ]));
        }
    }
}
