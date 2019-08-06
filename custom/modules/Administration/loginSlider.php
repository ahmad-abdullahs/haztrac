<?php

require_once 'custom/login_slider/loginSliderController.php';

$ologinSlider = new loginSlider();
$method = $_REQUEST['method'];

switch ($method) {
    case "storeConfigurationSetting":
         $ologinSlider->storeConfigurationSetting();
         break;
    case "uploadImage":
         $ologinSlider->uploadImage($_REQUEST['uploadImage_content']);
         break;
    case "imagelistupdate":
         $ologinSlider->imagelistupdate();
         break;
    case "removeImage":
         $ologinSlider->removeImage();
         break;
    case "removeImageBlock":
         $ologinSlider->removeImageBlock();
         break;
    case "getImagesFromUpload":
        $image_array = $ologinSlider->getImagesFromUpload();

        if ($image_array != 'no-access') {
         ob_clean();
         echo json_encode($image_array);
        } else {
            echo $image_array;
        }
         break;
    case "validateLicence_DLS":
        $result = $ologinSlider->validateLicence_DLS();
         echo $result;
         break;
    case "enableDisableLogin_DLS":
         $ologinSlider->enableDisableLogin_DLS();
         break; 
    case "checkingModuleStatus":
        $result = $ologinSlider->checkingModuleStatus();
         echo $result;
         break;
}
if (isset($_REQUEST['main_method'])) {
    if ($_REQUEST['main_method'] == 'outfitters_license_DLS') {
        $ologinSlider->outfitters_license_DLS();
       //  ob_clean();
    }
}
