<?php
/**
 * The file used to retrieve Images and Quotes for Login Slider
 *
 * LICENSE: The contents of this file are subject to the license agreement ("License") which is included
 * in the installation package (LICENSE.txt). By installing or using this file, you have unconditionally
 * agreed to the terms and conditions of the License, and you may not use this file except in compliance
 * with the License.
 *
 * @author     Biztech Consultancy
 */
if (!defined('sugarEntry') || !sugarEntry)
    define('sugarEntry', true);

require_once('include/entryPoint.php');

require_once 'custom/login_slider/loginSliderController.php';

$ologinSlider = new loginSlider();
$method = $_REQUEST['method'];

switch ($method) {
    // Get images for Login slider
    case "getImagesFromUpload":
        $image_array = $ologinSlider->getImagesFromUpload();
        
        if ($image_array != 'no-access') {
         ob_clean();
         echo json_encode($image_array);
        } else { // no access
            echo $image_array;
        }
         break;
    
    
}
