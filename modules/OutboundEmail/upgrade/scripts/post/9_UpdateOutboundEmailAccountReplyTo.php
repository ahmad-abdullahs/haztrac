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
/**
 * Add reply-to fields to OutboundEmail.
 */
class SugarUpgradeUpdateOutboundEmailAccountReplyTo extends UpgradeDBScript
{
    public $order = 9901;

    /**
     *
     * Execute upgrade tasks
     * This script adds reply_to fields to existing OutboundEmail accounts.
     * @see UpgradeScript::run()
     */
    public function run()
    {
        if (version_compare($this->from_version, '9.0.0', '>=')) {
            // do nothing if upgrading from 9.0.0 or newer
            return;
        }

        $this->log('Updating reply-to fields in outbound_email for system-override accounts');

        $query = new SugarQuery();
        $bean = BeanFactory::newBean('OutboundEmail');

        $query->from($bean, array('team_security' => false, 'add_deleted' => false, 'alias' => 'oe'));

        // system-override accounts only
        $query->where()->equals('type', OutboundEmail::TYPE_SYSTEM_OVERRIDE);
  
        // retrieve users' reply-to addresses
        $query->joinTable('email_addr_bean_rel', ['alias' => 'ear'])
            ->on()->equals('ear.bean_module', 'Users')->equalsField('ear.bean_id', 'oe.user_id')
            ->equals('ear.reply_to_address', 1)->equals('ear.deleted', 0);

        $query->select(array(
            ['oe.id', 'oe_id'],
            ['oe.name', 'reply_to_name'],
            ['ear.email_address_id', 'reply_to_email_address_id'],
        ));

        $rows = $query->execute('array', true);

        foreach ($rows as $row) {
            if (!empty($row['reply_to_email_address_id'])) {
                $replyToName = $row['reply_to_name'] ?? '';

                // update reply-to fields
                $sql = "UPDATE outbound_email SET reply_to_name = ?, reply_to_email_address_id = ? WHERE id = ?";
                $this->executeUpdate($sql, [$replyToName, $row['reply_to_email_address_id'], $row['oe_id']]);
            }
        }
    }
}
