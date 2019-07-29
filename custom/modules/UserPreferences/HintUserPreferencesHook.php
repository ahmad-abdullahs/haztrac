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
namespace Sugarcrm\Sugarcrm\custom\modules\UserPreferences;

use Sugarcrm\Sugarcrm\custom\Hint\LogicHook\LogicHook;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\UserEmailUpdateEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Queue;
use Sugarcrm\Sugarcrm\custom\modules\HintNotificationTargets\NotificationTargetTypes;

class HintUserPreferencesHook extends LogicHook
{
    /**
     * @param \UserPreference $bean
     * @param $event
     * @param $arguments
     * @throws \Exception
     */
    public function afterSave(\UserPreference $bean, $event, $arguments)
    {
        if ($arguments['isUpdate']) {
            if (array_key_exists('contents', $arguments['dataChanges'])) {
                $before = unserialize(base64_decode($arguments['dataChanges']['contents']['before']));
                $after = unserialize(base64_decode($arguments['dataChanges']['contents']['after']));

                if (array_key_exists('timezone', $before)) {
                    if ($before['timezone'] !== $after['timezone']) {
                        if ($user = \BeanFactory::retrieveBean('Users', $bean->assigned_user_id)) {
                            // data
                            $email = $user->emailAddress->getPrimaryAddress($user);
                            $credentials = json_encode([
                                'email' => $email,
                                'timezone' => $after['timezone'],
                                'siteUrl' => \SugarConfig::getInstance()->get('site_url'),
                            ], JSON_UNESCAPED_SLASHES);

                            $db = \DBManagerFactory::getInstance();
                            $seed = \BeanFactory::newBean('HintNotificationTargets');

                            // quote types
                            $types = [];
                            foreach (NotificationTargetTypes::getEmailTypes() as $type) {
                                $types[] = $db->quoted($type);
                            }

                            $builder = $db->getConnection()->createQueryBuilder();
                            $query = $builder->update($seed->getTableName())
                                ->set('credentials', $db->quoted($credentials))
                                ->where($builder->expr()->eq('assigned_user_id', $db->quoted($user->id)))
                                ->andWhere($builder->expr()->in('type', $types))
                                ->andWhere('deleted = 0');
                            $query->execute();

                            // add a record to the queue
                            $this->eventQueue->recordEvent(new UserEmailUpdateEvent([
                                'userId' => $bean->assigned_user_id,
                                'newEmailAddress' => $email,
                                'newTimezone' => $after['timezone'],
                            ]));
                        }
                    }
                }
            }
        }
    }
}
