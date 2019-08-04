<?php

require_once "clients/base/api/CurrentUserApi.php";

class CustomCurrentUserApi extends CurrentUserApi {

    public function registerApiRest() {
        return array(
            'savecustompreferences' => array(
                'reqType' => 'POST',
                'path' => array('?', 'savecustompreferences'),
                'pathVars' => array(),
                'method' => 'updateUserCustomPreferences',
                'shortHelp' => 'save user preferences',
                'longHelp' => '',
            ),
        );
    }

    /**
     * Save current user information
     * @param $api
     * @param $args
     */
    public function updateUserCustomPreferences($api, $args) {
        $user_preferences = array(
            'prefs' => array(),
            'user_custom_timestamp' => '',
        );

        $current_user = $this->getUserBean();

        foreach ($args as $key => $value) {
            if (strpos($key, $current_user->id . ':' . 'last-state') !== false) {
                $user_preferences['prefs'][$key] = $args[$key];
            }
        }

        $user_preferences['user_custom_timestamp'] = $args['user_custom_timestamp'];

        $current_user->setPreference('user_custom_prefs', $user_preferences, 0, 'user_custom_prefs');
        $current_user->save();
    }

}
