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

class OutboundEmailVisibility extends SugarVisibility
{
    /**
     * The system and system-override accounts are included and excluded based on whether or not the
     * "Allow users to use this account for outgoing email" checkbox is checked in System Email Settings.
     *
     * {@inheritdoc}
     */
    public function addVisibilityWhere(&$query)
    {
        global $current_user;

        $db = DBManagerFactory::getInstance();
        $where = '';
        $alias = $this->getOption('table_alias');

        if (empty($alias)) {
            $alias = $this->bean->getTableName();
        }

        if ($this->bean->isAllowUserAccessToSystemDefaultOutbound()) {
            // Show the system account but not the system-override account.
            $where = "{$alias}.type<>" . $db->quoted(OutboundEmail::TYPE_SYSTEM_OVERRIDE);
        } else {
            // Show the user accounts and the user's own system-override account
            $where = $this->bean->getOwnerWhere($current_user->id, $alias);
            if ($current_user->isAdmin()) {
                // for admins, we want to show system account as well
                $where = "({$where} AND {$alias}.type="  .  $db->quoted(OutboundEmail::TYPE_SYSTEM_OVERRIDE) .
                    ") OR {$alias}.type=" . $db->quoted(OutboundEmail::TYPE_USER) .
                    " OR {$alias}.type=" . $db->quoted(OutboundEmail::TYPE_SYSTEM);
            } else {
                $where = "({$where} AND {$alias}.type="  .  $db->quoted(OutboundEmail::TYPE_SYSTEM_OVERRIDE) .
                    ") OR {$alias}.type=" . $db->quoted(OutboundEmail::TYPE_USER);
            }
        }

        $query = empty($query) ? $where : "{$query} AND {$where}";

        return $query;
    }

    /**
     * OutboundEmail records can only be seen by their owner. When the admin allows users to use the system default
     * outbound account, all users can also see the system default outbound account.
     *
     * {@inheritdoc}
     */
    public function addVisibilityWhereQuery(SugarQuery $query)
    {
        $where = null;
        $this->addVisibilityWhere($where);

        if (!empty($where)) {
            $query->where()->queryAnd()->addRaw($where);
        }

        return $query;
    }
}
