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

class CustomAuditApi extends AuditApi {

    public function registerApiRest() {
        return array(
            'view_change_log' => array(
                'reqType' => 'GET',
                'path' => array('RevenueLineItems', '?', 'audit'),
                'pathVars' => array('module', 'record', 'audit'),
                'method' => 'viewChangeLog',
                'shortHelp' => 'View audit log in record view',
                'longHelp' => 'include/api/help/audit_get_help.html',
            ),
        );
    }

    public function viewChangeLog(ServiceBase $api, array $args) {
        global $focus, $current_user;

        $this->requireArgs($args, array('module', 'record'));

        $focus = BeanFactory::getBean($args['module'], $args['record']);

        if (!$focus->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('no access to the bean');
        }

        $auditBean = BeanFactory::newBean('Audit');
        $data = $auditBean->getAuditLog($focus);

        foreach ($data as $key => $value) {
            if ($value['field_name'] == 'sales_rep') {
                $data[$key] = $this->beautifySalesRepField($value);
            }
        }

        return array(
            'next_offset' => -1,
            'records' => $data,
        );
    }

    public function beautifySalesRepField($obj) {
        $fields = array(
            "sales_rep_type",
            "sales_rep_name",
            "sales_rep_comission_type",
            "sales_rep_comission_value",
            "sales_rep_comission_subtype",
            "sales_rep_comission_subtype_uom",
            "sales_rep_comission_text",
        );

        $beforeStr = '';
        $beforeValue = json_decode($obj['before']);
        foreach ($beforeValue as $key => $bValue) {
            $tempArr = array();
            foreach ($fields as $value) {
                array_push($tempArr, $bValue->$value);
            }
            $beforeStr .= implode(' | ', array_filter($tempArr));
            $beforeStr .= '
';
        }

        $afterStr = '';
        $afterValue = json_decode($obj['after']);
        foreach ($afterValue as $key => $aValue) {
            $tempArr = array();
            foreach ($fields as $value) {
                array_push($tempArr, $aValue->$value);
            }
            $afterStr .= implode(' | ', array_filter($tempArr));
            $afterStr .= '
';
        }

        $obj['before'] = $beforeStr;
        $obj['after'] = $afterStr;

        return $obj;
    }

}
