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
namespace Sugarcrm\Sugarcrm\custom\modules\Users;

use Sugarcrm\Sugarcrm\custom\Hint\LogicHook\LogicHook;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\UserDeleteEvent;
use Sugarcrm\Sugarcrm\custom\Hint\Queue\Event\UserEmailUpdateEvent;
use Sugarcrm\Sugarcrm\custom\modules\HintNotificationTargets\NotificationTargetTypes;
use Sugarcrm\Sugarcrm\Security\InputValidation\InputValidation;

class HintUsersHook extends LogicHook
{
    /**
     * @param $user
     * @param $event
     * @param $arguments
     * @throws \Exception
     */
    public function afterSave($user, $event, $arguments)
    {
        // new user
        if (!$arguments['isUpdate']) {
            \HintAccountset::createUserAccountset($user);
            return;
        }

        // new email
        if (!empty($arguments['dataChanges']['email'])) {
            $email = $arguments['dataChanges']['email'];
            $oldPrimaryEmail = $this->getPrimaryEmail($email['before'] ?: []);
            $newPrimaryEmail = $this->getPrimaryEmail($email['after'] ?: []);
            if ($oldPrimaryEmail !== $newPrimaryEmail) {
                $this->updateEmailTargets($user, $newPrimaryEmail);
            }
            return;
        }

        // new email (legacy save)
        if (!empty($arguments['dataChanges']['email1'])) {
            $email = $arguments['dataChanges']['email1'];
            $before = $email['before'] ?: '';
            $after = $email['after'] ?: '';
            if ($before !== $after) {
                $this->updateEmailTargets($user, $after);
            }
            return;
        }

        /*
         * user was deleted from Employees detail view
         * NOTE: if "delete" is initiated from Users detail view
         * "beforeDelete" is triggered
         */
        if (!empty($arguments['dataChanges']['deleted']['after'])) {
            $request = InputValidation::getService();
            if ('Employees' === $request->getValidInputRequest('module', 'Assert\Mvc\ModuleName')
                && 'delete' === $request->getValidInputRequest('action')) {

                $this->eventQueue->recordEvent(new UserDeleteEvent([
                    'userId' => $user->id,
                ]));
                return;
            }
        }
    }

    /**
     * @param $user
     * @param $event
     * @param $arguments
     */
    public function beforeDelete($user, $event, $arguments)
    {
        $this->eventQueue->recordEvent(new UserDeleteEvent([
            'userId' => $user->id,
        ]));
    }

    /**
     * Find primary email in all user emails
     *
     * @param array $emails
     * @return string
     */
    private function getPrimaryEmail(array $emails)
    {
        foreach ($emails as $email) {
            if (!empty($email['primary_address']) && !empty($email['email_address'])) {
                return $email['email_address'];
            }
        }

        return '';
    }

    /**
     * Adds a record to the queue, finds and updates existing email targets
     *
     * @param $person
     * @param $email
     * @throws \Exception
     */
    private function updateEmailTargets($person, $email)
    {
        $user = $person;
        if ($person instanceof \Employee) {
            $user = \BeanFactory::retrieveBean('Users', $user->id);
        }

        $db = \DBManagerFactory::getInstance();
        $seed = \BeanFactory::newBean('HintNotificationTargets');

        // data
        $timezone = \TimeDate::userTimezone($user);
        $credentials = json_encode([
            'email' => $email,
            'timezone' => $timezone,
            'siteUrl' => \SugarConfig::getInstance()->get('site_url'),
        ], JSON_UNESCAPED_SLASHES);
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
            'userId' => $person->id,
            'newEmailAddress' => $email,
            'newTimezone' => $timezone,
        ]));
    }
}
