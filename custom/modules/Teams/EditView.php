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
/* * *******************************************************************************

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 * ****************************************************************************** */




require_once('modules/Teams/Forms.php');

global $app_strings;
global $app_list_strings;
global $mod_strings;
global $current_user;

$GLOBALS['log']->info("Team edit view");

if (!$GLOBALS['current_user']->isAdminForModule('Users'))
    sugar_die("Unauthorized access to administration.");

$focus = BeanFactory::newBean('Teams');

if (isset($_REQUEST['record']) && isset($_REQUEST['record'])) {
    $focus->retrieve($_REQUEST['record']);
}


echo getClassicModuleTitle($mod_strings['LBL_MODULE_NAME'], array($mod_strings['LBL_MODULE_NAME'], $focus->get_summary_text()), true);

$xtpl = new XTemplate("custom/modules/Teams/EditView.html");
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);

$return_id = isset($_REQUEST['return_id']) ? $_REQUEST['return_id'] : '';
$return_module = isset($_REQUEST['return_module']) ? $_REQUEST['return_module'] : '';
$return_action = isset($_REQUEST['return_action']) ? $_REQUEST['return_action'] : '';
if (empty($return_id)) {
    $return_action = 'index';
}
if (isset($_REQUEST['error_string']))
    $xtpl->assign("ERROR_STRING", "<span class='error'>Error: " . $_REQUEST['error_string'] . "</span>");
$xtpl->assign("RETURN_MODULE", $return_module);
$xtpl->assign("RETURN_ID", $return_id);
$xtpl->assign("RETURN_ACTION", $return_action);

if (isset($_REQUEST['isDuplicate']))
    $xtpl->assign("IS_DUPLICATE", $_REQUEST['isDuplicate']);
$xtpl->assign("ID", $focus->id);
$xtpl->assign("NAME", Team::getDisplayName($focus->name, $focus->name_2));
$xtpl->assign("DESCRIPTION", $focus->description);
$xtpl->assign("ACTIVE_MANIFEST_NUMBER", $focus->active_manifest_number);
$xtpl->assign("TRANSPORTER_CARRIER_C", $focus->transporter_carrier_c);
$xtpl->assign("ACCOUNT_ID_C", $focus->account_id_c);

global $current_user;
if ($current_user->isAdminForModule('Users') && $_REQUEST['module'] != 'DynamicLayout' && !empty($_SESSION['editinplace'])) {
    $record = '';
    if (!empty($_REQUEST['record'])) {
        $record = $_REQUEST['record'];
    }
    $xtpl->assign("ADMIN_EDIT", "<a href='index.php?action=index&module=DynamicLayout&from_action=" . $_REQUEST['action'] . "&from_module=" . $_REQUEST['module'] . "&record=" . $record . "'>" . SugarThemeRegistry::current()->getImage("EditLayout", "border='0' align='bottom'", null, null, '.gif', $mod_strings['LBL_EDITLAYOUT']) . "</a>");
}


$javascript = new javascript();
$javascript->setFormName("EditView");

$javascript->addFieldGeneric("name", "varchar", $mod_strings['LBL_NAME'], TRUE, "");


$xtpl->parse("main");
$xtpl->out("main");

global $db;
$selectAllPdfTemplateTypesList = array('' => '');
$selectAllPdfTemplateTypes = "SELECT 
                                *
                            FROM
                                pdf_template_types
                            WHERE
                                deleted = 0
                            ORDER BY order_number;";
$result = $db->query($selectAllPdfTemplateTypes);
// Format the return data, id as the key name as value.
while ($row = $db->fetchByAssoc($result)) {
    $selectAllPdfTemplateTypesList[$row['id']] = $row['name'];
}

echo $javascript->getScript();
echo '<input type="hidden" name="pdf_printers_list" id="pdf_printers_list" value="' . get_select_options_with_id($app_list_strings['pdf_printers_list'], '') . '">
<input type="hidden" name="pdf_template_type_list" id="pdf_template_type_list" value="' . get_select_options_with_id($selectAllPdfTemplateTypesList, '') . '">';

$loadPrinterSettings = '<script>';
$printer_setting = $focus->printer_setting;
$printer_settingArr = json_decode(html_entity_decode($printer_setting), ENT_QUOTES);
foreach ($printer_settingArr as $pSetting) {
    $loadPrinterSettings .= "load_printerSetting('0','" . $pSetting['pdf_template_type'] . "','" . $pSetting['pdf_printer'] . "');";
}
$loadPrinterSettings .= '</script>';
echo $loadPrinterSettings;
