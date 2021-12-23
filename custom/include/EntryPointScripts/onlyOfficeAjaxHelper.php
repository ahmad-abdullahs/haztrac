<?php

//require_once 'modules/Doc_Manager/Doc_Manager.php';
//global $db, $current_user, $timedate;
//$current_user = BeanFactory::retrieveBean('Users', '1', array('disable_row_level_security' => true));
//$moduleList = getDocManagerAvailableModules();
////print '<pre>';
////print_r($moduleList);
//echo json_encode($moduleList);
//
//
//
// http://localhost/haztrac/#bwc/index.php?entryPoint=onlyOfficeAjaxHelper
// ********************************************************************************* 
// Change this file with care, becuase this file is called from two different places
// ********************************************************************************* 

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

header('Access-Control-Allow-Origin: *');
require_once 'modules/PdfManager/PdfManagerHelper.php';

class onlyOfficeAjaxHelper {

    public $fieldsForSelectedModule = array();
    public $fieldForLinks = array();

    public function __construct($base_module) {
        $this->execute($base_module);
    }

    public function execute($base_module) {
        global $db, $current_user, $timedate;

        if (!empty($base_module)) {
            $_GET['base_module'] = $base_module;
        }

        if (!empty($_GET['base_module'])) {
            $this->fieldsForSelectedModule = PdfManagerHelper::getFields($_GET['base_module'], true);
        }

        $this->fieldForLinks = array();
        foreach ($this->fieldsForSelectedModule['Links'] as $key => $value) {
            $fieldsForSubModule = array();
            if (!empty($key) && strpos($key, 'pdfManagerRelateLink_') === 0) {
                $linkName = substr($key, strlen('pdfManagerRelateLink_'));

                $focus = BeanFactory::newBean($_GET['base_module']);
                $focus->id = create_guid();
                $linksForSelectedModule = PdfManagerHelper::getLinksForModule($_GET['base_module']);

                if (isset($linksForSelectedModule[$linkName]) && $focus->load_relationship($linkName)) {
                    $fieldsForSubModule = PdfManagerHelper::getFields($focus->$linkName->getRelatedModuleName());
                    $this->fieldForLinks[$key] = $fieldsForSubModule;
                }
            }
        }
    }

    public function returnData() {
        return array(
            'fieldsArr' => $this->fieldsForSelectedModule,
            'linksArr' => $this->fieldForLinks
        );
    }

    public function echoData() {
        echo json_encode(array(
            'fieldsArr' => $this->fieldsForSelectedModule,
            'linksArr' => $this->fieldForLinks
        ));
    }

}

if (!empty($_GET['base_module'])) {
    $obj = new onlyOfficeAjaxHelper($_GET['base_module']);
    $obj->echoData();
}




