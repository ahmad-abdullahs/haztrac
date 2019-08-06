<?php

function validateLoginSubscription() {
    //load license validation config
    global $db;
    require_once('custom/login_slider/license/OutfittersLicense_DLS.php');
    require_once('custom/login_slider/login_plugin.php');
    global $current_user;
    $user_id = $current_user->id;
    $checkLoginSubscription = OutfittersLicense_DLS::isValid('bc_Quote', $user_id, true);
    $response = array();
    if ($checkLoginSubscription === true) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['message'] = html_entity_decode($checkLoginSubscription);
    }
    $qry = "SELECT * FROM upgrade_history WHERE id_name = 'SugarCRMDynamicLoginScreen' ";
    $result = $db->query($qry);
    while ($row = $db->fetchByAssoc($result)) {
        if ($row['enabled'] == 0) {
            $response['success'] = false;
            $response['message'] = 'The plugin is disabled. Please contact your administrator.';
        }
    }
    return $response;
}