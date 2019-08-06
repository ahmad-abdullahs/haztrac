<?php

if(!class_exists('OutfittersLicense_DLS')) 
{
    class OutfittersLicense_DLS
    {
        /**
         * For validation via server-side. Whomever calls this should handle what to do in case of a failure.
         *
         * Check return for "!== true" as the error will be returned in the case that it didn't validate.
         *
         * returns true or else the error string
         */
        public static function isValid($thisModule=null,$user_id=null,$force_validation=false)
        {
            if(empty($thisModule)) {
                global $currentModule;
                $thisModule = $currentModule;
            
                //if still empty...then get out of here...in an odd spot in SugarCRM
                if(empty($thisModule)) {
                    return true;
                }
            }

            //load license validation config
            require('custom/login_slider/license/config.php');
            
            //check to see if the passed user is allowed to use the add-on
            //if not then return a message...otherwise continue with the normal license check
            //ignore a passed user id if manage_licensed_users is not enabled
            if(!empty($user_id) && $outfitters_config['validate_users'] == true)
            {
                global $db;
                $result = $db->query("SELECT id FROM so_users WHERE shortname = '".$db->quote($outfitters_config['shortname'])."' and user_id = '".$db->quote($user_id)."'",false);
                $row = $db->fetchByAssoc($result);
                if(empty($row)) {
                   return 'The user does not have access to this add-on.';
                }
            }
        
            //check last validation
            require_once('modules/Administration/Administration.php');
            $administration = new Administration();
            $administration->retrieveSettings();
            $last_validation = $administration->settings['SugarOutfitters_'.$outfitters_config['shortname']];
            $trimmed_last = trim($last_validation); //to be safe...
            
            //make sure serialized string is not empty
            if($force_validation == false && !empty($trimmed_last))
            {
                $last_validation = base64_decode($last_validation);
                $last_validation = unserialize($last_validation);
            
                //if enough time hasn't passed then just return the last result
                //even if the last result failed
                $frequency = $outfitters_config['validation_frequency'];
                $elapsed = (7 * 24 * 60 * 60); //default to weekly
                if($frequency == 'hourly') {
                    $elapsed = (60 * 60);
                } else if($frequency == 'daily') {
                    $elapsed = (24 * 60 * 60);
                }
            
                if(($last_validation['last_ran'] + $elapsed) >= time()) {
                    if($last_validation['last_result']['success'] === false) {
                        return $last_validation['last_result']['result'];
                    } else {
                        $validation_result = !empty($last_validation['last_result']['result']['validated']);
                        
                        if($outfitters_config['validate_users'] == true)
                        {
                            if(!empty($last_validation['last_result']['result']) && (empty($last_validation['last_result']['result']['validated_users']) || $last_validation['last_result']['result']['validated_users']!==true))
                            {
                                $validation_result = false;
                            }
                        }
                        
                        if($validation_result === false) {
                            return 'Insuffient number of user licenses. Please add additional user licenses and try again.';
                        } else {
                            return true;
                        }
                    }
                }
            }
            
            //otherwise continue with validation
            $validated = OutfittersLicense_DLS::doValidate($thisModule);
        
            $store = array(
                'last_ran' => time(),
                'last_result' => $validated,
            );
 
            $serialized = base64_encode(serialize($store));
            $administration->saveSetting('SugarOutfitters', $outfitters_config['shortname'], $serialized);
    
            if($validated['success'] === false) {
                return $validated['result'];
            } else {
                $validation_result = !empty($validated['result']['validated']);

                if($outfitters_config['validate_users'] == true)
                {
                    if(!empty($validated['result']) && (empty($validated['result']['validated_users']) || $validated['result']['validated_users']!==true))
                    {
                        $validation_result = false;
                    }
                }
                        
                if($validation_result === false) {
                    return 'Insuffient number of user licenses. Please add additional user licenses and try again.';
                } else {
                    return true;
                }
            }
        }
    
        /**
         * For validation via client-side (used by License Configuration form)
         *
         * Does NOT obey the validation_frequency setting. Validates every time.
         * This function is meant to be used only on the License Configuration screen for a specific add-on
         */
        public static function validate()
        {
            $json = getJSONobj();
            if(empty($_REQUEST['key'])) {
                header('HTTP/1.1 400 Bad Request');
                $response = "Key is required.";
                echo $json->encode($response);
                exit;
            }
        
            global $sugar_config, $currentModule;

            //load license validation config
            require('custom/login_slider/license/config.php');

            $validated = OutfittersLicense_DLS::doValidate($currentModule,$_REQUEST['key']);

            $store = array(
                'last_ran' => time(),
                'last_result' => $validated,
            );

            require_once('modules/Administration/Administration.php');
            $administration = new Administration();
            $serialized = base64_encode(serialize($store));
            $administration->saveSetting('SugarOutfitters', $outfitters_config['shortname'], $serialized);
        
            if($validated['success'] === false) {
                header('HTTP/1.1 400 Bad Request');
            } else {
                //use config_override.php...config.php has a higher chance of having rights restricted on servers
                global $currentModule;

                //load license validation config
                require('custom/login_slider/license/config.php');
            
                require('modules/Configurator/Configurator.php');
                $cfg = new Configurator();
                $cfg->config['outfitters_licenses'][$outfitters_config['shortname']] = $_REQUEST['key'];
                $cfg->handleOverride();     
            }

            $administration->retrieveSettings('LoginPlugin');

            
            $currDate = date("Y/m/d");
            if ($validated['success'] == 1) {
                $administration->saveSetting("LoginPlugin", "LastValidation", 1);
                $administration->saveSetting("LoginPlugin", "LastValidationDate", $currDate);
                $administration->saveSetting("LoginPlugin", "LastValidationMsg", '');
                $administration->saveSetting("LoginPlugin", "ModuleEnabled",1);
            } else {
                $administration->saveSetting("LoginPlugin", "LastValidation", 0);
                $administration->saveSetting("LoginPlugin", "LastValidationDate", $currDate);
                $administration->saveSetting("LoginPlugin", "LastValidationMsg", !empty($validated['success']) ? $validated['success'] : 'There seems some error while validating your license for Dynamic Login Screen module. Please try again later.');
            }


            echo $json->encode($validated['result']);
        }
    
        /**
         * Internal method that makes the actual API request
         *
         * returns array(
         *      success => true/false
         *      result    => result set returned by the server
         */
        public static function doValidate($thisModule,$key=null)
        {
            global $sugar_config;

            //load license validation config
            require('custom/login_slider/license/config.php');
        
            //if no key is provided then look for an existing key
            $data = array();
            if(!empty($key)) 
            {
                $data['key'] = $key;
            }

            $response = SugarOutfitters_API::call($thisModule,'key/validate',$data,'get');

            if(empty($response['success']) || $response['success']!==true) 
            {
                $GLOBALS['log']->fatal('OutfittersLicense_DLS::doValidate() failed: '.print_r($response,true));
            }
            if ($response['success'] === true && !empty($key)) {
                $site_url = $sugar_config['site_url'];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, sprintf('https://www.appjetty.com/extension/licence.php'));
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, 'key=' . $key . '&domains=' . $site_url . '&sec=dynamic-login-screen-pro&domain_change=1');
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_exec($ch);
                $administrationObj = new Administration();
                $administrationObj->saveSetting("LoginPlugin", "LicenceKey", $key);
            }
            return $response;
        }
            }
            }

if (!class_exists('SugarOutfitters_API'))
{
    class SugarOutfitters_API
    {
        private function get_default_payload($module,$custom_data = array())
        {
            global $sugar_config, $sugar_flavor, $db;
            $not_set_value = 'not set';
            $data = array();

            //load license validation config
            require('custom/login_slider/license/config.php');

            // set the key, check custom data first in case developer wants to explicitly set a key
            if (empty($custom_data['key'])){
                $data['key'] = empty($sugar_config['outfitters_licenses'][$outfitters_config['shortname']]) ? false : $sugar_config['outfitters_licenses'][$outfitters_config['shortname']];
            }else{
                $data['key'] = $custom_data['key'];
            }
            
            // set public key, check custom data first in case developer wants to explicitly set a public key
            if (empty($custom_data['public_key'])){
                $data['public_key'] = empty($outfitters_config['public_key']) ? $not_set_value : $outfitters_config['public_key'];
            }else{
                $data['public_key'] = $custom_data['public_key'];
            }
            
            // set user counts, check custom data first in case developer wants to explicitly set a user count
            if(!empty($custom_data['user_count'])){
                $data['user_count'] = $custom_data['user_count'];
            }else if(isset($outfitters_config['manage_licensed_users']) && $outfitters_config['manage_licensed_users'] == true) {
                //using built-in user license management
                $licensed_users = 0;
                $sql = "SELECT count(*) as the_count FROM so_users WHERE shortname = '".$db->quote($outfitters_config['shortname'])."'";
                $result = $db->query($sql,false,'Unable to reset licensed users for '.$outfitters_config['shortname']);
                $row = $db->fetchByAssoc($result);
                if(!empty($row)) {
                    $licensed_users = $row['the_count'];
                }
                $data['user_count'] = $licensed_users;
            }else{
                $active_users = get_user_array(false,'Active','',false,'',' AND portal_only=0 AND is_group=0');
                $data['user_count'] = empty($active_users) ? 0 : count($active_users);
            }
            
            // other user count types
            $active_group_users = get_user_array(false,'Active','',false,'',' AND portal_only=0 AND is_group=1');
            $data['group_user_count'] = empty($active_group_users) ? 0 : count($active_group_users);
            $active_admin_users = get_user_array(false,'Active','',false,'',' AND portal_only=0 AND is_group=0 AND is_admin=1');
            $data['admin_user_count'] = empty($active_admin_users) ? 0 : count($active_admin_users);
            
            // get sugar edition from global far
            $data['sugar_edition'] = empty($sugar_flavor) ? $not_set_value : $sugar_flavor;
            
            // get sugar_config data
            $data['db_type'] = empty($sugar_config['dbconfig']['db_type']) ? $not_set_value : $sugar_config['dbconfig']['db_type'];
            $data['developerMode'] = (!empty($sugar_config['developerMode']) && $sugar_config['developerMode']===true ? 'true' : 'false');
            $data['host_name'] = empty($sugar_config['host_name']) ? $not_set_value : $sugar_config['host_name'];
            $data['package_scan'] = (!empty($sugar_config['moduleInstaller']) && !empty($sugar_config['moduleInstaller']['packageScan']) && $sugar_config['moduleInstaller']['packageScan']===true ? 'true' : 'false');
            $data['sugar_version'] = empty($sugar_config['sugar_version']) ? $not_set_value : $sugar_config['sugar_version'];
            $data['site_url'] = empty($sugar_config['site_url']) ? $not_set_value : $sugar_config['site_url'];
        
            // attempt to get addon version
            $data['addon_version'] = $not_set_value;
            if (!empty($outfitters_config['name']))
            {
                $result = $db->query("select version from upgrade_history where id_name = '".$db->quote($outfitters_config['name'])."' order by date_entered DESC");
                $row = $db->fetchByAssoc($result);
                if (!empty($row))
                {
                    $data['addon_version'] = empty($row['version']) ? $not_set_value : $row['version'];
                }
                else
                {
                    $data['addon_version'] = "No Versions Found";
                }
            }
            else
            {
                $data['addon_version'] = "Error: 'name' not set in outfitters_config.";
            }
            
            return $data;
        }
        
        public static function tag($action,$payload)
        {
            return true;
        }
        
        public static function call($module,$path,$custom_data=array(),$method='post')
        {
            if (empty($module))
            {
                return array(
                    'success' => false,
                    'result' => 'Module is not defined.'
                );
            }
            
            if (empty($path))
            {
                return array(
                    'success' => false,
                    'result' => 'API Call Path is not defined.'
                );
            }
            
            if (!is_array($custom_data))
            {
                return array(
                    'success' => false,
                    'result' => 'Data for API Call must be an array.'
                );
            }
            
            //load license validation config and generate url from config
            require('custom/login_slider/license/config.php');
            $url = $outfitters_config['api_url'] . '/' . $path;
            
            // get default payload data
            $data = static::get_default_payload($module,$custom_data);
        
            if(empty($data['key']))
            {
                return array(
                    'success' => false,
                    'result' => 'Key could not be found locally. Please go to the license configuration tool and enter your key.'
                );
            }
            
            $ch = curl_init();

            // setup data based on type of request
            if ($method === 'post')
            {
                curl_setopt($ch, CURLOPT_POST, 1); 
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
            }
            else
            {
                $url .= '?' . http_build_query($data);
            }
            
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_FAILONERROR, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  

            $response = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);

            $json = getJSONobj();
            $result = $json->decode($response);

            //if it is not a 200 response assume a 400. Good enough for this purpose.
            if($info['http_code'] == 0)
            {
                $GLOBALS['log']->fatal('SugarOutfitters_API::call(): Unable to validate license. Please configure the firewall to allow requests to '.$outfitters_config['api_url'].'/key/validate and make sure that SSL certs are up to date on the server.');
                return array(
                        'success' => false,
                        'result' => 'SugarOutfitters_API::call(): Unable to validate the license key. Please configure the firewall to allow requests to '.$outfitters_config['api_url'].'/key/validate and make sure that SSL certs are up to date on the server.'
                    );
            }
            else if($info['http_code'] != 200)
            {
                $GLOBALS['log']->fatal('SugarOutfitters_API::call(): HTTP Request failed: '.print_r($info,true));
                return array(
                    'success' => false,
                    'result' => $result
                );
            } 
            else 
            {
                return array(
                    'success' => true,
                    'result' => $result
                );
            }
        }
    }
}