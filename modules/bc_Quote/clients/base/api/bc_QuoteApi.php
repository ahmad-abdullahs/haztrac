<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

require_once 'clients/base/api/ModuleApi.php';
require_once 'data/BeanFactory.php';
require_once 'custom/login_slider/slider_function.php';
require_once 'custom/login_slider/login_plugin.php';

class bc_QuoteApi extends ModuleApi {

    public function registerApiRest() {
        return array(
            'checkingModuleStatus' => array(
                'reqType' => 'GET',
                'path' => array('bc_Quote', 'checkingModuleStatus'),
                'pathVars' => array('module', ''),
                'method' => 'checkingModuleStatus',
                'longHelp' => '',
            ),
            'storeConfigurationSetting' => array(
                'reqType' => 'GET',
                'path' => array('bc_Quote', 'storeConfigurationSetting'),
                'pathVars' => array('', ''),
                'method' => 'storeConfigurationSetting',
                'shortHelp' => 'store Configuration Setting',
                'longHelp' => '',
            ),
            'getImagesFromUpload' => array(
                'reqType' => 'GET',
                'path' => array('bc_Quote', 'getImagesFromUpload'),
                'pathVars' => array('', ''),
                'method' => 'getImagesFromUpload',
                'shortHelp' => 'Enable or Disable Survey Rocket Plugin',
                'longHelp' => '',
            ),
            'validateLicense_DLS' => array(
                'reqType' => 'GET',
                'path' => array('bc_Quote', 'validateLicense_DLS'),
                'pathVars' => array('', ''),
                'method' => 'validateLicense_DLS',
                'shortHelp' => 'Validate License for Survey Rocket Plugin',
                'longHelp' => '',
            ),
            'enableDisableLogin_DLS' => array(
                'reqType' => 'GET',
                'path' => array('bc_Quote', 'enableDisableLogin_DLS'),
                'pathVars' => array('', ''),
                'method' => 'enableDisableLogin_DLS',
                'shortHelp' => 'Enable or Disable Plugin',
                'longHelp' => '',
            ),
        );
    }

    public function checkingModuleStatus($api, $args) {
        global $current_user;
        require_once('custom/login_slider/login_plugin.php');
        $checkLoginSubscription = validateLoginSubscription();
        if (is_admin($current_user)) {
            if (!$checkLoginSubscription['success']) {
                if (!empty($checkLoginSubscription['message'])) {

                    return '<div style="color: #F11147;text-align: center;background: #FAD7EC;padding: 10px;margin: 3% auto;width: 70%;top: 50%;left: 0;right: 0;border: 1px solid #F8B3CC;font-size : 14px;">' . $checkLoginSubscription['message'] . '</div>';
                }
            } else { //--------- module enabled--------
                if (!empty($checkLoginSubscription['message'])) {

                    return '<div style="color: #f11147;font-size: 14px;left: 0;text-align: center;top: 50%;">' . $checkLoginSubscription['message'] . '</div>';
                }
                return 'success';
            }
        } else {
            return 'false';
        }
    }

    public function storeConfigurationSetting($api, $args) {

        global $db;
        $image_count = $args['image_count'];
        $getConf = getSliderConfiguration();



        if (!empty($getConf)) {
            $updateConf_2 = "Update config set value = '{$image_count}'
                                                            where name = 'image_count'";
            $db->query($updateConf_2);
        } else {
            $storeConf = "Insert into config (category,
                                          name,
                                          value) 
                                  Values                                              
                                          ('image_slider_conf',
                                           'image_count',
                                           '{$image_count}') ";
            $db->query($storeConf);
        }

        return true;
    }

    public function getImagesFromUpload($api, $args) {
        global $db;
        // get image configuration  
        $getConfiguration_setting = "SELECT * FROM config  WHERE category = 'image_slider_conf'";
        $query = $db->query($getConfiguration_setting);

        while ($result = $db->fetchByAssoc($query)) {
            $getConf = $result['value'];
        }
        // get images from folder
        $dir = 'custom/login_slider/images/slider/';
        $custom_query = "select id from cl_custom_login";
        $custom_result = $db->query($custom_query);
        $get_count = $db->query("select count(id) as total_cnt from cl_custom_login");
        $total_cnt = $db->fetchByAssoc($get_count);
        $image_ids = array();
        $sliderImages = array();
        if ($total_cnt['total_cnt'] != 0) {
            while ($rows = $db->fetchByAssoc($custom_result)) {
                array_push($image_ids, $dir . '' . $rows['id']);
            }
            shuffle($image_ids);

            for ($i = 0; $i <= $getConf - 1; $i++) {
                if (array_key_exists($i, $image_ids)) {
                    array_push($sliderImages, $image_ids[$i]);
                }
            }
        }
        // get random quote
        $quote = array();
        $get = "SELECT id FROM bc_quotecategory where availability=1";
        $query = $db->query($get);
        $get_cat_count = $db->query("SELECT count(id) as total_cat_cnt FROM bc_quotecategory where availability=1");
        $total_cat_cnt = $db->fetchByAssoc($get_cat_count);
        if ($total_cat_cnt['total_cat_cnt'] != 0) {
            while ($row = $db->fetchByassoc($query)) {
                $get_quote_id_query = "select "
                        . "bc_quotecategory_bc_quotebc_quote_idb "
                        . " from "
                        . "bc_quotecategory_bc_quote_c"
                        . " where "
                        . "bc_quotecategory_bc_quotebc_quotecategory_ida='{$row['id']}'";
                $get_quote_id_result = $db->query($get_quote_id_query);
                while ($row = $db->fetchByassoc($get_quote_id_result)) {
                    $get_quote_query = "select"
                            . " description from bc_quote where id='{$row['bc_quotecategory_bc_quotebc_quote_idb']}' and deleted='0'";
                    $get_quote_result = $db->query($get_quote_query);
                    while ($row = $db->fetchByassoc($get_quote_result)) {
                        array_push($quote, html_entity_decode($row['description'], ENT_QUOTES, 'utf-8'));
                    }
                }
            }
            $random = array_rand($quote);
        }
        if ($random >= 0) {
            $quote = nl2br($quote[$random]);
            $sliderImages['quote'] = $quote;
        }
        if (!isset($random)) {
            $sliderImages['quote'] = "no-access";
        }

        require_once('custom/login_slider/login_plugin.php');
        $checkLoginSubscription = validateLoginSubscription();
        if (!$checkLoginSubscription['success']) {
            if (!empty($checkLoginSubscription['message'])) {
                return 'no-access';
            }
        } else { //--------- module enabled--------
            if (!empty($checkLoginSubscription['message'])) {
                return 'no-access';
            }
            return $sliderImages;
        }
    }

    public function validateLicense_DLS($api, $args) {

        $key = $args['k'];
        $CheckResult = checkPluginLicence_DLS($key);
        return $CheckResult;
    }

    public function enableDisableLogin_DLS($api, $args) {
        require_once('modules/Administration/Administration.php');
        $enabled = $args['enabled'];
        $administrationObj = new Administration();
        $administrationObj->retrieveSettings('LoginPlugin');
        switch ($args['enabled']) {
            case '1':
                $administrationObj->saveSetting("LoginPlugin", "ModuleEnabled", 1);
                $administrationObj->saveSetting("LoginPlugin", "LastValidationMsg", "");
                break;
            case '0':
                $administrationObj->saveSetting("LoginPlugin", "ModuleEnabled", 0);
                $administrationObj->saveSetting("LoginPlugin", "LastValidationMsg", "This module is disabled, please contact Administrator.");
                break;
            default:
                $administrationObj->saveSetting("LoginPlugin", "ModuleEnabled", 0);
                $administrationObj->saveSetting("LoginPlugin", "LastValidationMsg", "This module is disabled, please contact Administrator.");
        }
        return true;
    }

}
