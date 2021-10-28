<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class DropDownFiller extends SugarApi {

    public function registerApiRest() {

        $dropDownApi = array(
            'dropdownListAddKey' => array(
                'reqType' => 'POST',
                'path' => array('DropdownListKey', 'add'),
                'pathVars' => array('', ''),
                'method' => 'addDropDownKeyValue',
                'shortHelp' => 'create a new item to an specific list',
                'longHelp' => 'custom/clients/base/api/help/MyEndPoint_MyGetEndPoint_help.html',
            ),
//            'dropdownListRemoveKey' => array(
//                'reqType' => 'POST',
//                'path' => array('DropdownListKey', 'delete'),
//                'pathVars' => array('', ''),
//                'method' => 'removeDropDownKeyValue',
//                'shortHelp' => 'Remove a key from an specific list',
//                'longHelp' => 'custom/clients/base/api/help/MyEndPoint_MyGetEndPoint_help.html',
//            ),
            'TakeSnapShotKey' => array(
                'reqType' => 'POST',
                'path' => array('TakeSnapShot', 'add'),
                'pathVars' => array('', ''),
                'method' => 'addSnapShot',
                'shortHelp' => 'Take the Snapshot of the Contact details',
                'longHelp' => 'custom/clients/base/api/help/MyEndPoint_MyGetEndPoint_help.html',
            ),
        );

        return $dropDownApi;
    }

    /**
     * Method to be used for rest/v10/DropdownListKey/add endpoint
     */
    public function addDropDownKeyValue($api, $args) {

        require_once('include/utils.php');
        require_once('modules/ModuleBuilder/MB/ModuleBuilder.php');
        require_once('modules/ModuleBuilder/parsers/parser.dropdown.php');

        $list_name = $args['list_name'];
        $item_key = $args['item_key'];
        $item_value = $args['item_value'];
        $lang = $args['lang'];

        $displayValue = translate($list_name, '', $item_key);

        if (!isset($displayValue)) {
            return "DropdownList not found";
        } else if (is_array($displayValue)) {
            $parser = new ParserDropDown();
            $params = array();
            $_REQUEST['view_package'] = 'studio';
            $params['view_package'] = 'studio';
            $params['dropdown_name'] = $list_name;
            $params['dropdown_lang'] = $lang;
            $_REQUEST['dropdown_lang'] = $lang;

            $displayValue[$item_key] = $item_value;

            foreach ($displayValue as $k => $v) {
                $drop_list[] = array($k, $v);
            }

            $json = getJSONobj();
            $params['list_value'] = $json->encode($drop_list);
            $parser->saveDropDown($params, true);
        } else {
            $displayValue = translate($list_name);

            $parser = new ParserDropDown();
            $params = array();
            $_REQUEST['view_package'] = 'studio';
            $params['view_package'] = 'studio';
            $params['dropdown_name'] = $list_name;
            $params['dropdown_lang'] = $lang;
            $_REQUEST['dropdown_lang'] = $lang;

            $displayValue[$item_key] = $item_value;

            foreach ($displayValue as $k => $v) {
                $drop_list[] = array($k, $v);
            }

            $json = getJSONobj();
            $params['list_value'] = $json->encode($drop_list);
            $parser->saveDropDown($params);
        }

        // Executing the Finalize stuff.
        if (!is_array($lang)) {
            $lang = [$lang => $lang];
        }
        SugarAutoLoader::requireWithCustom('ModuleInstall/ModuleInstaller.php');
        $moduleInstallerClass = SugarAutoLoader::customClass('ModuleInstaller');
        $mi = new $moduleInstallerClass();
        $mi->silent = true;
        $mi->rebuild_languages($lang);

//        sugar_cache_reset();
//        sugar_cache_reset_full();
        clearAllJsAndJsLangFilesWithoutOutput();

        // Clear out the api metadata languages cache for selected language
        MetaDataManager::refreshLanguagesCache($lang);
    }

    public function addSnapShot($api, $args) {
        global $db;
        $id = $args['id'];
        if (!empty($id)) {

            $field = array(
                'title' => 'Title',
                'department' => 'Department',
                'phone_mobile' => 'Mobile',
                'phone_work' => 'Office Phone',
                'phone_fax' => 'Fax',
                'emailAddress' => 'Email Address',
                'primary_address' => 'Primary Address',
                'alt_address' => 'Alternate Address',
            );

            $str = $primaryAddr = $altAddr = '';
            $emailAddressesArr = array();
            $contactBean = BeanFactory::retrieveBean('Contacts', $id, array('disable_row_level_security' => true));

            $GLOBALS['log']->fatal('$contactBean->id : ' . print_r($contactBean->id, 1));

            if (!empty($contactBean->id)) {
                foreach ($field as $key => $label) {
                    if ($key == 'emailAddress') {
                        foreach ($contactBean->emailAddress->addresses as $value) {
                            array_push($emailAddressesArr, $value['email_address']);
                        }
                    } else if ($key == 'primary_address') {
                        $primaryAddr = "[" . $label . "] : " . $contactBean->primary_address_street . PHP_EOL;
                        $primaryAddr .= $contactBean->primary_address_city . " " . $contactBean->primary_address_state . " " .
                                $contactBean->primary_address_postalcode . PHP_EOL;
                        $primaryAddr .= $contactBean->primary_address_country;
                    } else if ($key == 'alt_address') {
                        $altAddr = "[" . $label . "] : " . $contactBean->alt_address_street . PHP_EOL;
                        $altAddr .= $contactBean->alt_address_city . " " . $contactBean->alt_address_state . " " .
                                $contactBean->alt_address_postalcode . PHP_EOL;
                        $altAddr .= $contactBean->alt_address_country;
                    } else {
                        $str .= "[" . $label . "] : " . $contactBean->$key . PHP_EOL;
                    }
                }

                $emailStr = implode(", ", $emailAddressesArr);
                $str .= '[Email Address] : ' . $emailStr . PHP_EOL;
                $str .= $primaryAddr . PHP_EOL;
                $str .= $altAddr . PHP_EOL . PHP_EOL;

                $GLOBALS['log']->fatal('$str : ' . print_r($str, 1));

                $updateQuery = "UPDATE contacts_cstm 
                        SET 
                            contact_history_c = concat('{$str}', ifnull(contact_history_c,''))
                        WHERE
                            id_c = '{$id}';";
                $db->query($updateQuery);
            }

            return 'Details are successfully archived.';
        } else {
            return 'Details are not archived. Please check with you Administrator.';
        }
    }

    /**
     * Method to be used for rest/v10/DropdownListKey/delete endpoint
     */
    public function removeDropDownKeyValue($api, $args) {

        require_once('include/utils.php');
        require_once('modules/ModuleBuilder/MB/ModuleBuilder.php');
        require_once('modules/ModuleBuilder/parsers/parser.dropdown.php');

        $list_name = $args['list_name'];
        $item_key = $args['item_key'];
        $lang = $args['lang'];

        $displayValue = translate($list_name, '', $item_key);

        if (!isset($displayValue)) {
            return "DropdownList not found";
        } else if (is_array($displayValue)) {
            return "Key not found";
        } else {
            $parser = new ParserDropDown();
            $params = array();
            $_REQUEST['view_package'] = 'studio';
            $params['view_package'] = 'studio';
            $params['dropdown_name'] = $list_name;
            $params['dropdown_lang'] = $lang;
            $_REQUEST['dropdown_lang'] = $lang;

            $displayValue = translate($list_name);

            unset($displayValue[$item_key]);

            foreach ($displayValue as $k => $v) {
                $drop_list[] = array($k, $v);
            }

            $json = getJSONobj();
            $params['list_value'] = $json->encode($drop_list);
            $parser->saveDropDown($params);

            return "Key removed";
        }
    }

}
