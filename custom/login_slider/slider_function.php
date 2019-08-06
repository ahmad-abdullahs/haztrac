<?php

function getSliderConfiguration() {
    global $db;
    $getConfiguration_setting = "SELECT *
                                        FROM config
                                        WHERE category = 'image_slider_conf'";
    $query = $db->query($getConfiguration_setting);
    $getConf = array();
    while ($result = $db->fetchByAssoc($query)) {
        $getConf[$result['name']] = $result['value'];
    }
    return $getConf;
}

function getImageListConfiguration() {
    global $db;
    $getConfiguration_setting = "SELECT *
                                        FROM config
                                        WHERE category = 'upload_image_list'";
    $query = $db->query($getConfiguration_setting);
    $getListConf = array();
    while ($result = $db->fetchByAssoc($query)) {
        $getListConf[$result['name']] = $result['value'];
    }
    return $getListConf;
}

function getConvertedUploadImageSizeInMB($size) {
    $imageSize = round($size / pow(1024, 2));
    return $imageSize;
}


