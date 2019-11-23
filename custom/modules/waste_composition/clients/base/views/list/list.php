<?php
$module_name = 'waste_composition';
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
                'name' => 'waste_composition_wpm_waste_profile_module_name',
                'label' => 'LBL_WASTE_COMPOSITION_WPM_WASTE_PROFILE_MODULE_FROM_WPM_WASTE_PROFILE_MODULE_TITLE',
                'enabled' => true,
                'id' => 'WASTE_COMP1299_MODULE_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'min',
                'label' => 'LBL_MIN',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'max',
                'label' => 'LBL_MAX',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'uom',
                'label' => 'LBL_UOM',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
              ),
              8 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
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
