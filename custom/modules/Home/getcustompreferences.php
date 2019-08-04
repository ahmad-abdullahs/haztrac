<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $current_user;

$prefs = $current_user->getPreference('user_custom_prefs', 'user_custom_prefs');
$userPrefs = array(
    'prefs' => isset($prefs) && isset($prefs['prefs']) ? $prefs['prefs'] : array(),
    'timeStamp' => $prefs['user_custom_timestamp']
);
echo json_encode($userPrefs);
