<?php
// created: 2019-12-12 19:42:36
$dictionary["waste_composition"]["fields"]["wpm_waste_profile_template_waste_composition"] = array (
  'name' => 'wpm_waste_profile_template_waste_composition',
  'type' => 'link',
  'relationship' => 'wpm_waste_profile_template_waste_composition',
  'source' => 'non-db',
  'module' => 'WPM_Waste_Profile_Template',
  'bean_name' => false,
  'side' => 'right',
  'vname' => 'LBL_WPM_WASTE_PROFILE_TEMPLATE_WASTE_COMPOSITION_FROM_WASTE_COMPOSITION_TITLE',
  'id_name' => 'wpm_waste_90faemplate_ida',
  'link-type' => 'one',
);
$dictionary["waste_composition"]["fields"]["wpm_waste_profile_template_waste_composition_name"] = array (
  'name' => 'wpm_waste_profile_template_waste_composition_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_TEMPLATE_WASTE_COMPOSITION_FROM_WPM_WASTE_PROFILE_TEMPLATE_TITLE',
  'save' => true,
  'id_name' => 'wpm_waste_90faemplate_ida',
  'link' => 'wpm_waste_profile_template_waste_composition',
  'table' => 'wpm_waste_profile_template',
  'module' => 'WPM_Waste_Profile_Template',
  'rname' => 'name',
);
$dictionary["waste_composition"]["fields"]["wpm_waste_90faemplate_ida"] = array (
  'name' => 'wpm_waste_90faemplate_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_WPM_WASTE_PROFILE_TEMPLATE_WASTE_COMPOSITION_FROM_WASTE_COMPOSITION_TITLE_ID',
  'id_name' => 'wpm_waste_90faemplate_ida',
  'link' => 'wpm_waste_profile_template_waste_composition',
  'table' => 'wpm_waste_profile_template',
  'module' => 'WPM_Waste_Profile_Template',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
