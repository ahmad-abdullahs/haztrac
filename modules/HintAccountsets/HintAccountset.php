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
use Sugarcrm\Sugarcrm\custom\Hint\Initializer;
use Sugarcrm\Sugarcrm\custom\modules\HintAccountsets\HintAccountsetCategories;
use Sugarcrm\Sugarcrm\custom\modules\HintAccountsets\HintAccountsetTypes;
use Sugarcrm\Sugarcrm\custom\modules\HintNotificationTargets\NotificationTargetTypes;
use Sugarcrm\Sugarcrm\Util\Uuid;

class HintAccountset extends \Basic
{
    const MODULE_NAME = 'HintAccountsets';

    public $id;
    public $type;
    public $assigned_user_id;
    public $category;
    public $name;
    public $description;
    public $date_entered;
    public $date_modified;
    public $deleted;

    public $module_dir = self::MODULE_NAME;
    public $module_name = self::MODULE_NAME;
    public $table_name = 'hint_accountsets';
    public $object_name = 'HintAccountset';

    const FIELD_NAMES = [
        'type',
        'assigned_user_id',
        'category',
    ];

    // Helper method
    static function createAccountset($args)
    {
        $bean = \BeanFactory::newBean(self::MODULE_NAME);
        foreach (self::FIELD_NAMES as $fieldName) {
            $bean->$fieldName = $args[$fieldName];
        }
        $bean->save();

        return $bean;
    }

    // Helper for testing.
    static function deleteAccountset($args)
    {
        $accountsetId = $args['accountsetId'];

        $bean = \BeanFactory::retrieveBean(self::MODULE_NAME, $accountsetId);
        if (!empty($bean)) {
            $bean->mark_deleted($accountsetId);
            $bean->save();
        }
    }

    // Helper for testing
    static function updateAccountset($args)
    {
        $accountsetId = $args['accountsetId'];
        $category = $args['category'];
        $type = $args['type'];

        $bean = \BeanFactory::retrieveBean(self::MODULE_NAME, $accountsetId);
        if (!empty($bean)) {
            $bean->type = $type;
            $bean->category = $category;
            $bean->save();
        }
    }

    // Test scaffolding
    public static function createAccountsetTagRelation($args)
    {
        $bean = \BeanFactory::retrieveBean(self::MODULE_NAME, $args['accountsetId']);
        if (!empty($bean)) {
            $tagName = $args['tagName'];

            // Get the tag bean by tag value
            $tagBean = \BeanFactory::getBean('Tags')->retrieve_by_string_fields([
                'name_lower' => mb_strtolower($args['tagName'])
            ]);

            if (empty($tagBean)) {
                // need to create one instead
                $tagBean = \BeanFactory::newBean('Tags');
                $tagBean->name = $tagName;
                $tagBean->save();
            }

            if ($bean->load_relationship('tag_link')) {
                $bean->tag_link->add($tagBean);
            }
        }
    }

    // Test scaffolding
    public static function deleteAccountsetTagRelation($args)
    {
        $bean = \BeanFactory::retrieveBean(self::MODULE_NAME, $args['accountsetId']);
        if (!empty($bean)) {
            // Get the tag bean by tag value
            $tag = \BeanFactory::getBean('Tags')->retrieve_by_string_fields([
                'name_lower' => mb_strtolower($args['tagName'])
            ]);

            // Load the relationship
            if ($bean->load_relationship('tag_link') && $tag) {
                $bean->tag_link->delete($bean->id, $tag);
            }
        }

    }

    /**
     * Creates a new accountset with default targets for given user
     *
     * HintAccountset save results to EventTypes::ACCOUNTSET_ADD event being
     * recorded. If we add relationships (targets) after that the code will
     * record some EventTypes::ACCOUNTSET_ADD_TARGET events resulting to something
     * like that in the queue:
     * - ACCOUNTSET_ADD
     * - TARGET_ADD
     * - ACCOUNTSET_ADD_TARGET
     * - TARGET_ADD
     * - ACCOUNTSET_ADD_TARGET
     *
     * Precreating bean id (and setting "new_with_id" to true) allows us to use
     * this bean in relationship operations (add / delete) and to postpone "save".
     * This way we know target ids in advance and can move ACCOUNTSET_ADD_TARGET
     * logic to HintAccountset after_save logic hook making the queue look like this:
     * - TARGET_ADD
     * - TARGET_ADD
     * - ACCOUNTSET_ADD
     *
     * @param \Person $person
     * @return \HintAccountset
     */
    public static function createUserAccountset(\Person $person)
    {
        $accountset = new static();
        $accountset->assigned_user_id = $person->id;
        $accountset->type = HintAccountsetTypes::OWNER;
        $accountset->category = HintAccountsetCategories::CATEGORY_ALL;

        // to create relationships before bean itself
        $accountset->id = Uuid::uuid1();
        $accountset->new_with_id = true;

        if (!$accountset->load_relationship('notification_targets')) {
            $accountset->save();

            return $accountset;
        }

        // create and add sugar target
        $sugarTarget = \HintNotificationTarget::activateTarget(
            $person->id,
            NotificationTargetTypes::SUGAR_TARGET_TYPE,
            $person->id
        );
        $accountset->notification_targets->add($sugarTarget);

        // ensure user emails are populated
        $emails = [];
        if (!empty($person->emailAddress)) {
            $emails = $person->emailAddress->addresses ?: $person->email;
            if (!$emails) {
                $person->populateFetchedEmail('bean_field');
                $emails = $person->email;
            }
        }

        foreach ($emails as $email) {
            if (!empty($email['primary_address']) && !empty($email['email_address'])) {
                /* @var $user \User */
                $user = $person;
                if ($person instanceof \Employee) {
                    $user = \BeanFactory::retrieveBean('Users', $person->id);
                }

                // create and add email target
                $emailTarget = \HintNotificationTarget::activateTarget(
                    $user->id,
                    NotificationTargetTypes::EMAIL_WEEKLY_TARGET_TYPE,
                    [
                        'email' => $email['email_address'],
                        'timezone' => \TimeDate::userTimezone($user),
                        // just "site" url, as there's no path for dashlet preferences
                        'siteUrl' => \SugarConfig::getInstance()->get('site_url'),
                    ]
                );
                $accountset->notification_targets->add($emailTarget);
                break;
            }
        }

        $accountset->save();

        return $accountset;
    }

    /**
     * {@inheritdoc}
     */
    public function create_tables()
    {
        parent::create_tables();

        // we need to be sure the table exist
        (new Initializer())->init();
    }
}
