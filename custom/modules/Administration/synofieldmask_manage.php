<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

global $current_user, $beanList, $sugar_config, $current_language, $mod_strings, $beanList;
if (!is_admin($current_user)) {
    sugar_die("Unauthorized access to administration.");
}

require_once 'modules/Configurator/Configurator.php';
// Compatibility 6.5/7
try {
    if (!@include_once ('include/Sugar_Smarty.php')) {
        throw new Exception('include/Sugar_Smarty.php does not exist');
    }
} catch (Exception $e) {
    require_once'include/SugarSmarty/Sugar_Smarty.php';
}
require_once'include/utils/sugar_file_utils.php';
require_once'custom/Synolia/SynoFieldMask/Helpers/DeployerImplementation.php';

$sugar_smarty   = new Sugar_Smarty();

echo get_module_title('', translate('LBL_SYNOFIELDMASK_TITLE'), false);

list($studioModules, $moduleNames) = Synolia_SynoFieldMask_Helpers_DeployerImplementation::getModulesAvailables();

$modules_fields = array();
$modulesDeployed = array();

foreach ($studioModules as $moduleName => $module) {
    // DeployerModule va charger les dependencies utilisées pour les mask
    // et gérer leur déploiement
    $deployerModule = new Synolia_SynoFieldMask_Helpers_DeployerImplementation($moduleName);

    // Traitements à la soumission du formulaire
    if (!empty($_REQUEST[$moduleName])) {
        $deployAction = false;

        foreach ($_REQUEST[$moduleName] as $kfield => $mask) {
            $deployerModule->setFieldMask($kfield, $mask);
            $deployAction = true;
        }

        if ($deployAction) {
            $deployerModule->deploy();
            $modulesDeployed[] = $moduleName;
        }
    }

    if (!isset($modules_fields[$moduleName])) {
        $modules_fields[$moduleName] = array();
    }

    foreach ($deployerModule->getFieldsdefs() as $kfield => $fielddefs) {
        // hacks pour l'affichage avec l'ancien template
        $fielddefs['help'] = $deployerModule->getFieldMask($kfield);
        $modules_fields[$moduleName] += $deployerModule->formatFieldDefsForAdmin($fielddefs);
    }
}

if (count($modulesDeployed) > 0) {
    // A ameliorer pour cibler les modules concernés et reduire le temps
    // de chargement de la page
    Synolia_SynoFieldMask_Helpers_DeployerImplementation::refreshMeta($modulesDeployed);
}

$sugar_smarty->assign('MODULES', $moduleNames);

//default values
//'0' : "[-+0-9]",        // LBL_MASK_CONFIG_1 Any digit or numeric sign
//'9' : "[0-9]",          // LBL_MASK_CONFIG_2 Any digit
//'a' : "[a-zA-Z]",       // LBL_MASK_CONFIG_3 Any letter without accent
//'E' : "[A-Z]",          // LBL_MASK_CONFIG_4 Any letter without accent UPPERCASE
//'e' : "[a-z]",          // LBL_MASK_CONFIG_5 Any letter without accent LOWERCASE
//'d' : "[a-z0-9]",       // LBL_MASK_CONFIG_6 Any letter without accent or digit LOWERCASE
//'D' : "[A-Z0-9]",       // LBL_MASK_CONFIG_7 Any letter without accent or digit UPPERCASE
//'~' : "[+-]",           // LBL_MASK_CONFIG_8 Any numeric sign (+/-)

//'à' : "[a-zA-ZçáàãäéèêëíìïóòõöúùüûñÇÁÀÃÄÉÈÊËÍÌÏÓÒÕÖÚÙÜÛÑ]",              // LBL_MASK_CONFIG_9 Any letter
//'ç' : "[a-zA-ZçáàãäéèêëíìïóòõöúùüûñÇÁÀÃÄÉÈÊËÍÌÏÓÒÕÖÚÙÜÛÑ()&]",           // LBL_MASK_CONFIG_10 Any letter or ()&
//'É' : "[A-ZÇÁÀÃÄÉÈÊËÍÌÏÓÒÕÖÚÙÜÛÑ]",                                      // LBL_MASK_CONFIG_11 Any letter UPPERCASE
//'Ñ' : "[A-ZÇÁÀÃÄÉÈÊËÍÌÏÓÒÕÖÚÙÜÛÑ()&]",                                   // LBL_MASK_CONFIG_12 Any letter UPPERCASE or ()&
//'é' : "[a-zçáàãäéèêëíìïóòõöúùüûñ]",                                      // LBL_MASK_CONFIG_13 Any letter LOWERCASE
//'ñ' : "[a-zçáàãäéèêëíìïóòõöúùüûñ()&]",                                   // LBL_MASK_CONFIG_14 Any letter LOWERCASE or ()&

//'*' : "[-A-Za-z0-9çáàãäéèêëíìïóòõöúùüûñÇÁÀÃÄÉÈÊËÍÌÏÓÒÕÖÚÙÜÛÑ()&]",       // LBL_MASK_CONFIG_15 Any letter or digit or ()& or + -

$maskConfig = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
$sugar_smarty->assign('MASKCONFIG', $maskConfig);
$aliasConfig = array(1,2,3);
$sugar_smarty->assign('ALIASCONFIG', $aliasConfig);

$sugar_smarty->assign('MODULES_FIELDS', $modules_fields);
$tpl = 'custom/modules/Administration/synofieldmask_manage.tpl';
$sugar_smarty->assign('MOD', $mod_strings);
$sugar_smarty->assign('APP', $app_strings);
$sugar_smarty->assign('APP_LIST', $app_list_strings);
$sugar_smarty->display($tpl);
