<?PHP

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/Doc_Manager/Doc_Manager_sugar.php');

function getDocManagerAvailableModules() {
    return Doc_Manager::getAvailableModules();
}

class Doc_Manager extends Doc_Manager_sugar {

    /**
     * Returns a list of available modules for PdfManager
     *
     * @return array
     */
    public static function getAvailableModules() {

        $bannedModules = PdfManagerHelper::getBannnedModules();
        $module_names = array_change_key_case($GLOBALS['app_list_strings']['moduleList']);
        $studio_browser = new StudioBrowser();
        $studio_browser->loadModules();
        $studio_modules = array_keys($studio_browser->modules);
        foreach ($studio_modules as $module_name) {
            if (!in_array($module_name, $bannedModules)) {
                $available_modules[$module_name] = isset($module_names[strtolower($module_name)]) ? $module_names[strtolower($module_name)] : strtolower($module_name);
            }
        }
        asort($available_modules);

        return $available_modules;
    }

    /**
     * Returns a list of banned modules for PdfManager
     *
     * @return array
     */
    public static function getBannnedModules() {

        $bannedPdfManagerModules = array();

        foreach (SugarAutoLoader::existingCustom('modules/PdfManager/metadata/pdfmanagermodulesdefs.php') as $file) {
            include $file;
        }

        return $bannedPdfManagerModules;
    }

}
