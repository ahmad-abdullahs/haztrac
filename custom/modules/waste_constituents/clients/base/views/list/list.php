<?php
$module_name = 'waste_constituents';
$viewdefs[$module_name] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              1 => 
              array (
                'name' => 'waste_constituents_wpm_waste_profile_module_name',
                'label' => 'LBL_WASTE_CONSTITUENTS_WPM_WASTE_PROFILE_MODULE_FROM_WPM_WASTE_PROFILE_MODULE_TITLE',
                'enabled' => true,
                'id' => 'WASTE_CONS93C5_MODULE_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'type',
                'label' => 'LBL_TYPE',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'epa_waste_code',
                'label' => 'LBL_EPA_WASTE_CODE',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'rcra',
                'label' => 'LBL_RCRA',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'regulated_metals',
                'label' => 'LBL_REGULATED_METALS',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'regulatory_level',
                'label' => 'LBL_REGULATORY_LEVEL',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'tclp',
                'label' => 'LBL_TCLP',
                'enabled' => true,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'max',
                'label' => 'LBL_MAX',
                'enabled' => true,
                'default' => true,
              ),
              9 => 
              array (
                'name' => 'uom',
                'label' => 'LBL_UOM',
                'enabled' => true,
                'default' => true,
              ),
              10 => 
              array (
                'name' => 'other',
                'label' => 'LBL_CONSTITUENT_OTHER_NAME',
                'enabled' => true,
                'default' => true,
              ),
              11 => 
              array (
                'name' => 'not_applicable',
                'label' => 'LBL_NOT_APPLICABLE',
                'enabled' => true,
                'default' => true,
              ),
              12 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              13 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
              ),
              14 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => true,
              ),
              15 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
              ),
            ),
          ),
        ),
        'orderBy' => 
        array (
          'field' => 'date_modified',
          'direction' => 'desc',
        ),
      ),
    ),
  ),
);
