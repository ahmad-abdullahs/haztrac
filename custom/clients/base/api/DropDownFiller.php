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
