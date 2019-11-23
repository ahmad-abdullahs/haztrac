<?php
// created: 2019-11-23 17:29:37
$dictionary["waste_composition"]["fields"]["waste_composition_wpm_waste_profile_module"] = array (
  'name' => 'waste_composition_wpm_waste_profile_module',
  'type' => 'link',
  'relationship' => 'waste_composition_wpm_waste_profile_module',
  'source' => 'non-db',
  'module' => 'WPM_Waste_Profile_Module',
  'bean_name' => 'WPM_Waste_Profile_Module',
  'side' => 'right',
  'vname' => 'LBL_WASTE_COMPOSITION_WPM_WASTE_PROFILE_MODULE_FROM_WASTE_COMPOSITION_TITLE',
  'id_name' => 'waste_comp1299_module_ida',
  'link-type' => 'one',
);
$dictionary["waste_composition"]["fields"]["waste_composition_wpm_waste_profile_module_name"] = array (
  'name' => 'waste_composition_wpm_waste_profile_module_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_WASTE_COMPOSITION_WPM_WASTE_PROFILE_MODULE_FROM_WPM_WASTE_PROFILE_MODULE_TITLE',
  'save' => true,
  'id_name' => 'waste_comp1299_module_ida',
  'link' => 'waste_composition_wpm_waste_profile_module',
  'table' => 'wpm_waste_profile_module',
  'module' => 'WPM_Waste_Profile_Module',
  'rname' => 'name',
);
$dictionary["waste_composition"]["fields"]["waste_comp1299_module_ida"] = array (
  'name' => 'waste_comp1299_module_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_WASTE_COMPOSITION_WPM_WASTE_PROFILE_MODULE_FROM_WASTE_COMPOSITION_TITLE_ID',
  'id_name' => 'waste_comp1299_module_ida',
  'link' => 'waste_composition_wpm_waste_profile_module',
  'table' => 'wpm_waste_profile_module',
  'module' => 'WPM_Waste_Profile_Module',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
