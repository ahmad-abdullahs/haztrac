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

use Sugarcrm\Sugarcrm\Security\InputValidation\InputValidation;

require_once('soap/SoapHelperFunctions.php');
class MailMergeController extends SugarController{
    public function action_search(){
        //set ajax view
        $this->view = 'ajax';
        //get the module
        $module = InputValidation::getService()->getValidInputRequest(
            'qModule',
            'Assert\Mvc\ModuleName',
            ''
        );
        $bean = BeanFactory::newBean($module);
        if (empty($bean)) {
            throw new \InvalidArgumentException('Invalid module name');
        }
        $table = $bean->table_name;
        //get the search term
        $term = !empty($_REQUEST['term']) ? $GLOBALS['db']->quote($_REQUEST['term']) : '';
        //in the case of Campaigns we need to use the related module
        $relModule = InputValidation::getService()->getValidInputRequest(
            'rel_module',
            'Assert\Mvc\ModuleName',
            null
        );

        $max = !empty($_REQUEST['max']) ? (int)$_REQUEST['max'] : 10;
        $order_by = !empty($_REQUEST['order_by']) ? $_REQUEST['order_by'] : $table.".name";
        $offset = !empty($_REQUEST['offset']) ? (int)$_REQUEST['offset'] : 0;
        $response = array();
        
        if(!empty($module)){
            $where = '';
            $deleted = '0';
            $using_cp = false;

            if (!empty($term)) {
                if ($module == 'Contacts' || $module == 'Leads') {
                    $where = "{$table}.first_name LIKE '%{$term}%' OR {$table}.last_name LIKE '%{$term}%'";
                    $order_by = "{$table}.last_name";
                } else {
                    $where = "{$table}.name LIKE '{$term}%'";
                }
            }

            if ($module == 'CampaignProspects') {
                $using_cp = true;
                $module = 'Prospects';
                $relBean = BeanFactory::newBean($relModule);
                if (empty($relBean)) {
                    throw new \InvalidArgumentException('Invalid related module name');
                }
                $relTable = $relBean->table_name;
                $campaignWhere = $_SESSION['MAILMERGE_WHERE'];
                $where = "{$relTable}.first_name LIKE '%{$term}%' OR {$relTable}.last_name LIKE '%{$term}%'";

                if ($campaignWhere) {
                    $where .= " AND " . $campaignWhere;
                }
                $where .= " AND related_type = " . $relBean->db->quoted($relModule);
            }

            $seed = BeanFactory::newBean($module);

            if($using_cp){
                $fields = array('id', 'first_name', 'last_name');
                $dataList = $seed->retrieveTargetList($where, $fields, $offset,-1,$max,$deleted);

            }else{
                $dataList = $seed->get_list($order_by, $where, $offset,-1,$max,$deleted);
            }

            $list = $dataList['list'];
            $row_count = $dataList['row_count'];

            $output_list = array();
            foreach($list as $value)
            {
                $output_list[] = get_return_value($value, $module);
            }

            $response['result'] = array('result_count'=>$row_count,'entry_list'=>$output_list);
        }
        
        $json = getJSONobj();
        $json_response = $json->encode($response, true);
        print $json_response;
    }
}

