<?php
if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');
require_once 'custom/login_slider/slider_function.php';

use Sugarcrm\Sugarcrm\Security\Csrf\CsrfAuthenticator;
class AdministrationViewLoginpageslidergallery extends SugarView {

    function display() {
       
      //  ------------------------checking licence configuration status------------------------------
        require_once('custom/login_slider/login_plugin.php');
        $checkLoginSubscription = validateLoginSubscription();
        if (!$checkLoginSubscription['success']) {
            if (!empty($checkLoginSubscription['message'])) {
                echo '<div style="color: #F11147;text-align: center;background: #FAD7EC;padding: 10px;margin: 3% auto;width: 70%;top: 50%;left: 0;right: 0;border: 1px solid #F8B3CC;font-size : 14px;">' . $checkLoginSubscription['message'] . '</div>';
            }
        } else { //--------- module enabled--------
            if (!empty($checkLoginSubscription['message'])) {
                echo '<div style="color: #f11147;font-size: 14px;left: 0;text-align: center;top: 50%;">' . $checkLoginSubscription['message'] . '</div>';
            }
            
            parent::display();
            global $current_user, $db, $sugar_config;
            $dir = "custom/login_slider/images/slider/";
            $csrf = CsrfAuthenticator::getInstance();
            $current_listofImage = getImageListConfiguration();
            $fileNameArrayCount = $current_listofImage['imagelist_count'] != 0 ? $current_listofImage['imagelist_count'] : 1;

         
            $showMsg = "display:none";
            if (isset($_REQUEST['displayMsg']) ? $_REQUEST['displayMsg'] : '') {
                $showMsg = '';
            }

            $html = '';
            $html .= "<br/><h2>Upload Slider Images</h2><br/>"
                    . "<span style='color:blue; '><li>Please upload images with following extensions only ('gif', 'GIF', 'jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG').</li>
                                                   <li>Upload file size should be at max 2 MB.</li>
                                                   <li>Image dimension should be greater than 1000(width) X 700(height). </li>
                                                   </span><br/>";
            $html .= "<span style='position: relative;left: 40%;color:red;$showMsg'><b>Image upload failed, please make sure above conditions are met.</b></span><br><br>";
            $html .= "<table class=\"edit view\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                   <tbody>
                     <tr><td scope=\"row\" colspan=\"4\" align=\"left\"><input type='button' id='btn_add_image' onclick='addImage({$fileNameArrayCount})' value='Add New Image' /></td></tr>
                    <tr>
    	            <td scope=\"row\" colspan=\"4\" align=\"left\">
                    <div class='dashletPanelMenu wizard'>
                    <div class='bd'>
		            <div class='screen'>";


            if ($fileNameArrayCount > 0) {
                $class = '';
                for ($i = 1; $i <= $fileNameArrayCount; $i++) {
                    if (($i % 6) == 0) {
                        $class = 'last';
                    } else {
                        $class = '';
                    }

                    $custom_query = "select id,image_content from cl_custom_login";
                    $custom_result = $db->query($custom_query);
                    $get_cnt = $db->query("select count(id) as total_cnt from cl_custom_login");
                    $total_cnt = $db->fetchByAssoc($get_cnt);
                    $file = array();
                    $file_id = array();
                    $f = 0;
                    if ($total_cnt['total_cnt'] > 0) {
                        while ($rows = $db->fetchByAssoc($custom_result)) {
                            array_push($file, $rows['image_content']);
                             array_push($file_id, $rows['id']);
                            $f++;
                        }
                    } else {
                        array_push($file, 'custom/login_slider/images/no-image.png');
                    }
                    if (!array_key_exists($i - 1, $file)) {

                        for ($counter = $f; $counter <= $i - 1; $counter++) {
                            array_push($file, 'custom/login_slider/images/no-image.png');
                        }
                    }
               
                    $uniqe_id = $file_id[$i - 1];
                    $html .= "<div class='login-img-uploading {$class}' name='$uniqe_id'>";
                    $html .= "<form action='' method='post' enctype='multipart/form-data'>";
                     $html .= "<input type='hidden' name='csrf_token' value='" . $csrf->getFormToken() . "' />";
                    $html .= "<input type='hidden' id='uploadImage_content'  name='uploadImage_content'/>";
                    $html .= "<input type='hidden' name='module' value='Administration'>";
                    $html .= "<input type='hidden' name='action' value='loginslider'>";
                    $html .= "<input type='hidden' name='method' value='uploadImage'>";
                    if ($file[$i - 1] == 'custom/login_slider/images/no-image.png') {
                        $html .= "<p class'img'> <img src='{$file[$i - 1]}' name='img_{$i}' height='116px' width='110px'>";
                        $html.= "<script>$('[name=\"{$uniqe_id}\"]').removeClass('img-uploaded');</script>";
                    } else {
                        $html .= "<p class'img'> <img src='{$file[$i - 1]}' name='img_{$i}' height='140px' width='110px'>";
                         $html.= "<script> $('[name=\"{$uniqe_id}\"]').addClass('img-uploaded');</script>";
                    }
                    isset($_REQUEST['unid']) ? $uniq_id = $_REQUEST['unid'] : $uniq_id = '';
                    $html .= "</p>
                        <div class='btm-block'><p class='uploader'>
                        ";
                    if ($file[$i - 1] == 'custom/login_slider/images/no-image.png') {
                        $html.="<input style='width: 99%;' required='true' type='file' name='file' /></p><div class='bottm-btn'> "
                                . "<input type='submit' name='submit' value='Upload' />  <input type='hidden' id='hidden_noimage{$i}' value='{$file[$i - 1]}' />";
                    } else {
                        $html.="<div class='bottm-btn'> <input type='hidden' name='uploadImage_code' value='{$uniq_id}' />
                                <input type='button' value='Remove Image' onclick='if(confirm(\"Are you sure want to remove this image ? \")){ removeImage(\"{$uniqe_id}\")}'/>
                                <input type='hidden' id='hidden_noimage{$i}' value='{$file[$i - 1]}' />";
                         }
                    if ($fileNameArrayCount > 1) {
                        $html.= "<input type='button' title='Remove Image Section' class='remove-btn' id='removeBlock' onclick='removeblock(\"{$uniqe_id}\",\"{$i}\",\"{$file[$i - 1]}\",\"{$fileNameArrayCount}\")' value='' />";
                    }
                     $html.="</div>
                        </div> ";
                    $html .= "</form>";
                    $html .= "</div>";
                }
            } 
            $html .= "<div>
                   
                 </div>
                 </td>
                </tr>
                </tbody></table>";
            $html .= "</div></div></div>";
            
            $getConf = getSliderConfiguration();
            $html .= "<form action='' method='post' onsubmit='return validationNumber();'>
                <input type='hidden' name='module' value='Administration'>
                <input type='hidden' name='csrf_token' value='" . $csrf->getFormToken() . "' />
                <input type='hidden' name='action' value='loginslider'>
                <input type='hidden' name='method' value='storeConfigurationSetting'>
                <br/>
                <h2>Image Slider Configuration</h2><br/>
                <div  style=\"border:1px solid #d8d8d8; background-color:#f8f8f8; padding:5px; \" >
                
                <table class=\"edit view\" style='margin:2px;' cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                <tbody>
                <tr>
    	        <td colspan='2' scope=\"row\" valign=\"top\" width=\"10%\"><br/>No of images to be displayed on image slider:<br/><br/></td>";

            $html.= " <td valign=\"top\" width=\"30%\" >";

            $html.="<br/> <input type='text' name='image_count'  id='image_count_text' style=' width:20%;' value='{$getConf['image_count']}'>
    	        <br/><br/></td>
                </tr>
                </tbody></table>
                <br/>
                <div style=\"padding-top: 2px;\">
                <input title=\"Save [Alt+S]\" class=\"button primary\" name=\"submit_conf\" value=\" Save \" type=\"submit\">
		        &nbsp;<input title=\"Cancel\" onclick=\"document.location.href='index.php?module=Administration&action=index'\" class=\"button\" name=\"cancel\" value=\" Cancel \" type=\"button\">
                              
                </div>
                <br/>
                 <a href='index.php?module=Administration&action=index' style='text-decoration:none;'>
                        <input type='button' name='cancel' value='Return To Admin' />
                 </a>
                </div></form>";
            
            echo $html;
        }
    }

 }
?>
<style type="text/css">
    .login-img-uploading {
    border: 1px solid #ccc;
        display: inline-block;
    height: 186px;
    margin: 0 1% 2% 0;
        padding: 0.5%;
        position: relative;
    vertical-align: top;
    width: 14.6%;
    }

    .login-img-uploading.last {
        margin-right: 0px;
    }

    .login-img-uploading img {
        width: 100%;
    }

    .login-img-uploading .btm-block {
        border-top: 1px solid #ccc;
        padding: 5px;
    }

    .login-img-uploading .btm-block .bottm-btn {
        margin-top: 10px;
    }

    .login-img-uploading .btm-block .bottm-btn input {
        padding: 3px 16px 2px 17px;
    }
    
    input.remove-btn{background: url('custom/login_slider/images/btn_window_close.gif') no-repeat !important; position: absolute; right: 0; top: 0; border: none; width: 15px; height: 15px; padding: 0 !important;}

</style>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $("[name=file]").change(function (evt) {
            
            var files = evt.target.files; // FileList object
            
            // Loop through the FileList and render image files as thumbnails.
            for (var i = 0, f; f = files[i]; i++) {

                var reader = new FileReader();

                // Closure to capture the file information.
                reader.onload = (function (theFile) {
                    return function (e) {
                        
                        var image_data = new Object();
                        image_data['image_content'] = e.target.result;
                        if (theFile.type == 'image/png' || theFile.type == 'image/jpeg' || theFile.type == 'image/gif')
                        {
                            $(evt.currentTarget).parents('form').find('#uploadImage_content').val(e.target.result);
                        }
                    };
                })(f);

                // Read in the image file as a data URL.
                reader.readAsDataURL(f);
            }
        });
    });

    function addImage(i) {
        i++;
        var array_status = new Array();
        for (var count = 1; count < i; count++) {
            array_status.push($('#hidden_noimage' + count).val());
        }

        function include(arr, obj) {
            for (var i = 0; i < arr.length; i++) {
                if (arr[i] == obj)
                    return true;
            }
        }
        if (include(array_status, 'custom/login_slider/images/no-image.png') == true) {
            alert('Please upload image on empty section.');
        }
        else {
            var csrf_token = $("[name=csrf_token]").val();
            $.ajax({
                url: "index.php",
                type: "POST",
                data: {module: 'Administration', action: 'loginslider',method:'imagelistupdate', count: i,csrf_token: csrf_token},
                success: function (data)
                {
                    location.assign('index.php?module=Administration&action=loginpageslidergallery');
                },
                
            });
        }
    }
    function removeImage(file) {
         var csrf_token = $("[name=csrf_token]").val();
        $.ajax({
            url: "index.php",
            type: "POST",
            data: {module: 'Administration', action:'loginslider',method:'removeImage', file: file,csrf_token: csrf_token},
            success: function (data)
            {
                location.assign('index.php?module=Administration&action=loginpageslidergallery');
            },
            
        });

    }
    function removeblock(uid, i, file, count) {

        if (file == 'custom/login_slider/images/no-image.png') {
            var confirmMsg = 'Are you sure want to remove this section ?';
        }
        else {
            var confirmMsg = 'Are you sure want to remove this section with image ?';
        }
        if (confirm(confirmMsg)) {
            var csrf_token = $("[name=csrf_token]").val();
            $.ajax({
                url: "index.php",
                type: "POST",
                data: {module: 'Administration', action: 'loginslider',method: 'removeImageBlock', id: uid, imagecount: count, imageid: i,csrf_token: csrf_token},
                success: function (data)
                {
                    $('[name="' + uid + '"]').hide();
                    $('[name="' + uid + '"]').removeClass();
                    $('[name="' + uid + '"]').html('');
                    location.assign('index.php?module=Administration&action=loginpageslidergallery');
                },
                
            });
        }
    }
    function validationNumber() {
        var reg = new RegExp('^[0-9]+$');
        var textID = document.getElementById('image_count_text').value;
        var lengthOfImage = $('.login-img-uploading').length;
        if (textID == '') {
            alert("Please enter number of images.");
            return false;
        }
        else if (!reg.test(textID) && typeof reg != 'undefined') {
            alert("Please enter only positive integer number.");
            return false;
        }
        else if (textID != '' && textID <= 0) {
            alert("Allowed only greater than 0.");
            return false;
        } else if (textID != '' && textID > lengthOfImage) {
            alert("Allowed only less than or equal to "+lengthOfImage+".");
            return false;
        } else {
            var url = app.api.buildURL("bc_Quote", "storeConfigurationSetting", "", {image_count: textID});
            app.api.call("GET", url, {}, {
                success: function (result) {
                    location.href = "index.php?module=Administration&action=index";
                }
            });
        }
    }
</script>
