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

require_once 'clients/portal/api/CurrentUserPortalApi.php';

class CustomCurrentUserPortalApi extends CurrentUserPortalApi {

    /**
     * Manipulates the ACLs for portal
     * 
     * @param array $acls
     * @return array
     */
    protected function verifyACLs(Array $acls) {
        $acls['admin'] = 'no';
        $acls['developer'] = 'no';
        // --
        // by commenting this it will allow the delete access
//         $acls['delete'] = 'no';
        $acls['import'] = 'no';
        $acls['export'] = 'no';
        $acls['massupdate'] = 'no';

        return $acls;
    }

    /**
     * Enforces module specific ACLs for users without accounts
     * 
     * @param array $acls
     * @return array
     */
    protected function enforceModuleACLs(Array $acls) {
        $apiPerson = $this->getPortalContact();
        // This is a change in the ACL's for users without Accounts
        $vis = new SupportPortalVisibility($apiPerson);

        $accounts = $vis->getAccountIds();
        if (count($accounts) == 0) {
            // This user has no accounts, modify their ACL's so that they match up with enforcement
            $acls['Accounts']['access'] = 'no';
            $acls['Cases']['access'] = 'no';
        }
        foreach ($acls as $modName => $modAcls) {
            // ++
            if ($modName === 'Contacts' || $modName === 'HT_PO')
                continue;

            $acls[$modName]['edit'] = 'no';
        }

        return $acls;
    }

}
