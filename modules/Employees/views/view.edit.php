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

use Sugarcrm\Sugarcrm\IdentityProvider\Authentication;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Config as IdmConfig;
use Sugarcrm\IdentityProvider\Srn;

class EmployeesViewEdit extends ViewEdit {
    var $useForSubpanel = true;

    public function display()
    {
        $idpConfig = new IdmConfig(\SugarConfig::getInstance());

        if (is_admin($GLOBALS['current_user'])) {
            if ($idpConfig->isIDMModeEnabled() && !$this->bean->isUpdate()) {
                $this->showRedirectToCloudConsole($idpConfig->buildCloudConsoleUrl('userCreate'));
            }

            $json = getJSONobj();
            $qsd = QuickSearchDefaults::getQuickSearchDefaults();
            $sqs_objects = array('EditView_reports_to_name' => $qsd->getQSUser());
            $sqs_objects['EditView_reports_to_name']['populate_list'] = array('reports_to_name', 'reports_to_id');
            $quicksearch_js = '<script type="text/javascript" language="javascript">sqs_objects = ' . $json->encode($sqs_objects) . '; enableQS();</script>';

            $this->ss->assign('REPORTS_TO_JS', $quicksearch_js);
			$this->ss->assign('EDIT_REPORTS_TO', true);
        }


       //retrieve employee bean if it is not already in focus
         if(empty($this->bean->id)  && !empty($_REQUEST['record'])){
            $this->bean->retrieve($_REQUEST['record']);
         }
         //populate values for non admin users
        if(!empty($this->bean->id)) {
            global $app_list_strings;
            if( !empty($this->bean->status) ) {
                $this->ss->assign('STATUS_READONLY',$app_list_strings['user_status_dom'][$this->bean->status]); }
            if( !empty($this->bean->employee_status) ) {
                $this->ss->assign('EMPLOYEE_STATUS_READONLY', $app_list_strings['employee_status_dom'][$this->bean->employee_status]);
            }
            if( !empty($this->bean->reports_to_id) ) {
                $reportsToUserField = "<input type='text' name='reports_to_name' id='reports_to_name' value='{$this->bean->reports_to_name}' disabled>\n";
                $reportsToUserField .= "<input type='hidden' name='reports_to_id' id='reports_to_id' value='{$this->bean->reports_to_id}'>";
                $this->ss->assign('REPORTS_TO_READONLY', $reportsToUserField);
            }
            if( !empty($this->bean->title) ) {
                $this->ss->assign('TITLE_READONLY', $this->bean->title);
            }
            if( !empty($this->bean->department) ) {
                $this->ss->assign('DEPT_READONLY', $this->bean->department);
            }
        }

        // Check for IDM mode.
        $isIDMModeEnabled = (new Authentication\Config(\SugarConfig::getInstance()))->isIDMModeEnabled();
        $this->ss->assign('SHOW_NON_EDITABLE_FIELDS_ALERT', $isIDMModeEnabled);
        if ($isIDMModeEnabled) {
            if ($GLOBALS['current_user']->isAdminForModule('Users')) {
                $tenantSrn = Srn\Converter::fromString($idpConfig->getIDMModeConfig()['tid']);
                $srnManager = new Srn\Manager([
                    'partition' => $tenantSrn->getPartition(),
                    'region' => $tenantSrn->getRegion(),
                ]);
                $userSrn = $srnManager->createUserSrn($tenantSrn->getTenantId(), $this->bean->id);
                $msg = sprintf(
                    translate('LBL_IDM_MODE_NON_EDITABLE_FIELDS_FOR_ADMIN_USER', 'Users'),
                    $idpConfig->buildCloudConsoleUrl('userProfile', [Srn\Converter::toString($userSrn)])
                );
            } else {
                $msg = translate('LBL_IDM_MODE_NON_EDITABLE_FIELDS_FOR_REGULAR_USER', 'Users');
            }
            $this->ss->assign('NON_EDITABLE_FIELDS_MSG', $msg);
        }

 		parent::display();
 	}

    /**
     * Show redirect to cloud console
     * @param string $url cloud console url
     */
    protected function showRedirectToCloudConsole($url)
    {
        $ss = new Sugar_Smarty();
        $error = string_format($GLOBALS['mod_strings']['ERR_CREATE_EMPLOYEE_FOR_IDM_MODE'], [$url]);
        $ss->assign("error", $error);
        $ss->display('modules/Users/tpls/errorMessage.tpl');
        sugar_cleanup(true);
    }
}
