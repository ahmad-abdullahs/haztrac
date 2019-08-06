<?php

require_once 'custom/login_slider/slider_function.php';

class loginSlider {

    public function storeConfigurationSetting() {
        global $db;
        $image_count = $_REQUEST['image_count'];
        $getConf = getSliderConfiguration();

        if (isset($_REQUEST['submit_conf'])) {

            if (!empty($getConf)) {
                $updateConf_2 = "Update config set value = '{$image_count}'
                                                            where name = 'image_count'";
                $db->query($updateConf_2);
                header("Location:index.php?module=Administration&action=index");
            } else {
                $storeConf = "Insert into config (category,
                                          name,
                                          value) 
                                  Values                                              
                                          ('image_slider_conf',
                                           'image_count',
                                           '{$image_count}') ";
                $db->query($storeConf);
                header("Location:index.php?module=Administration&action=index");
            }
        }
    }

    public function uploadImage($image_content) {
        global $db, $current_user;
        require_once 'custom/login_slider/slider_function.php';
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }

        $allowedExts = array("gif", "GIF", "jpeg", "JPEG", "jpg", "JPG", "png", "PNG");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);


       // list($width_uploadImage, $height_uploadImage) = getimagesize($_FILES["file"]["tmp_name"]);

        $displayMsg = false;
        $validImageTypes = array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png");
        $imgSize = getConvertedUploadImageSizeInMB($_FILES["file"]["size"]);
        if (isset($_REQUEST['submit'])) {
            if (in_array($_FILES["file"]["type"], $validImageTypes) &&
                    $imgSize <= 2 &&
                    in_array($extension, $allowedExts)//&&
            //    $width_uploadImage >= 1000 &&
            //    $height_uploadImage >= 700
            ) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {
                    $id = create_guid();
                    $query = "insert into cl_custom_login(id,name,image_content) values('$id','{$_FILES["file"]["name"]}','{$image_content}')";

                    if(!$db->query($query))
                    {
                        $displayMsg = true;
                }
                }
            } else {
                $displayMsg = true;
            }
        }
        header("Location:index.php?module=Administration&action=loginpageslidergallery&displayMsg=" . $displayMsg . "&unid=" . $id);
    }

    public function imagelistupdate() {
        global $db;

        $list_query = "SELECT value FROM config WHERE name='imagelist_count'";
        $list_result = $db->query($list_query);
        $count_of_listImage = 0;
        while ($row = $db->fetchByAssoc($list_result)) {
            $count_of_listImage = $_REQUEST['count'];
        }
        if ($count_of_listImage == 0) {
            $count = $_REQUEST['count'];
            $addImageInList_query = "INSERT INTO config  VALUES('upload_image_list','imagelist_count','$count','')";
            $db->query($addImageInList_query);
        } else {
            $addImageInList_query = "UPDATE config SET  value='$count_of_listImage' WHERE name='imagelist_count'";
            $db->query($addImageInList_query);
        }
    }

    public function removeImage() {
        global $db;
        $image_id = $_REQUEST['file'];

        if ($image_path != 'custom/login_slider/images/no-image.png') {
            $delete_query = 'delete from cl_custom_login where id="' . $image_id . '"';
            $db->query($delete_query);
        }

        exit;
    }

    public function removeImageBlock() {
        global $db;
        $c = $_REQUEST['imagecount'];
        $count = $c - 1;
        $image_id = $_REQUEST['id'];
        if ($image_id != 'custom/login_slider/images/no-image.png') {
            $delete_query = 'delete from cl_custom_login where id="' . $image_id . '"';
            $db->query($delete_query);
        }
        $ImageInList_query = "UPDATE  config 
                              SET 
                                    value='$count'
                              WHERE
                                    name='imagelist_count'
                                                      ";
        $db->query($ImageInList_query);

        exit;
    }

    public function getImagesFromUpload() {
        global $db;
        // get image configuration  
        $getConfiguration_setting = "SELECT * FROM config  WHERE category = 'image_slider_conf'";
        $query = $db->query($getConfiguration_setting);

        while ($result = $db->fetchByAssoc($query)) {
            $getConf = $result['value'];
        }
        if(empty($getConf) || $getConf == 0)
        {
            $getConf = 1;
        }
        // get images from folder
        $dir = 'custom/login_slider/images/slider/';
        $custom_query = "select id,image_content from cl_custom_login";
        $custom_result = $db->query($custom_query);
        $get_count = $db->query("select count(id) as total_cnt from cl_custom_login");
        $total_cnt = $db->fetchByAssoc($get_count);
        $image_ids = array();
        $sliderImages = array();
        if ($total_cnt['total_cnt'] != 0) {
            while ($rows = $db->fetchByAssoc($custom_result)) {
                array_push($image_ids, $rows['image_content']);
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

    public function validateLicence_DLS() {
        //load license validation config
        require_once('custom/login_slider/license/OutfittersLicense_DLS.php');
        require_once('custom/login_slider/login_plugin.php');
        global $current_user;
        $user_id = $current_user->id;
        $checkLoginSubscription = OutfittersLicense_DLS::isValid('bc_Quote', $user_id, true);
        if ($checkLoginSubscription) {
            return 1;
        } else {
            return 0;
        }
    }

    public function enableDisableLogin_DLS() {
        require_once('modules/Administration/Administration.php');
        $enabled = $_REQUEST['enabled'];
        $administrationObj = new Administration();
        $administrationObj->retrieveSettings('LoginPlugin');
        switch ($_REQUEST['enabled']) {
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
    }

    public function checkingModuleStatus() {

        require_once('custom/login_slider/login_plugin.php');
        global $current_user;
        $user_id = $current_user->id;
        $checkLoginSubscription = OutfittersLicense_DLS::isValid('bc_Quote', $user_id, true);
        if ($checkLoginSubscription !== true) {

            $result = '<div style="color: #F11147;text-align: center;background: #FAD7EC;padding: 10px;margin: 3% auto;width: 70%;top: 50%;left: 0;right: 0;border: 1px solid #F8B3CC;font-size : 14px;">License expired. Please contact admin.' . $checkLoginSubscription . '</div>';
        }
        return $result;
    }

    public function outfitters_license_DLS() {
        if (empty($_REQUEST['method'])) {
            header('HTTP/1.1 400 Bad Request');
            $response = "method is required.";
            $json = getJSONobj();
            echo $json->encode($response);
        }

        //load license validation config

        require_once('custom/login_slider/license/OutfittersLicense_DLS.php');

        if ($_REQUEST['method'] == 'validate') {
            OutfittersLicense_DLS::validate();
        } else if ($_REQUEST['method'] == 'change') {
            OutfittersLicense_DLS::change_DLS();
        } else if ($_REQUEST['method'] == 'add') {
            OutfittersLicense_DLS::add_DLS();
        } else if ($_REQUEST['method'] == 'test') {
            //optional param: user_id - test if a specific user has access to the add-on
            //Sugar 6: /index.php?module=SampleLicenseAddon&action=outfitterscontroller&method=test&to_pdf=1
            //Sugar 7: #bwc/index.php?module=SampleLicenseAddon&action=outfitterscontroller&method=test&to_pdf=1

            $user_id = null;
            if (!empty($_REQUEST['user_id'])) {
                $user_id = $_REQUEST['user_id'];
            }
            $validate_license = OutfittersLicense_DLS::isValid($currentModule, $user_id, true);

            if ($validate_license !== true) {

                echo "License did NOT validate.<br/><br/>Reason: " . $validate_license;


                $validated = OutfittersLicense_DLS::doValidate($currentModule);

                if (is_array($validated['result'])) {
                    echo "<br/><br/>Key validation = " . !empty($validated['result']['validated']);
                    require('custom/login_slider/license/config.php');

                    if ($outfitters_config['validate_users'] == true) {
                        echo "<br/>User validation = " . !empty($validated['result']['validated_users']);
                        echo "<br/>Licensed User Count = " . $validated['result']['licensed_user_count'];
                        echo "<br/>Current User Count = " . $validated['result']['user_count'];

                        if ($validated['result']['user_count'] > $validated['result']['licensed_user_count']) {
                            echo "<br/><br/>Additional Users Required = " . ($validated['result']['user_count'] - $validated['result']['licensed_user_count']);
                        }
                    }
                }
            } else {
                echo "License validated";
            }
        }
    }

}
