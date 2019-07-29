<?php
$module_name = 'HT_Assets_and_Objects';
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
                'name' => 'asset_type_c',
                'label' => 'LBL_ASSET_TYPE',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'asset_number',
                'label' => 'LBL_ASSET_NUMBER',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'model_year_c',
                'label' => 'LBL_MODEL_YEAR',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'make_c',
                'label' => 'LBL_MAKE',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'model_c',
                'label' => 'LBL_MODEL',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'object_no_c',
                'label' => 'LBL_OBJECT_NO',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
              ),
              8 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
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
