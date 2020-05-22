<?php
$viewdefs['HT_Assets_and_Objects'] = 
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
                'name' => 'asset_object_marking_no_c',
                'label' => 'LBL_ASSET_OBJECT_MARKING_NO',
                'enabled' => true,
                'default' => true,
                'width' => 'xsmall',
              ),
              1 => 
              array (
                'name' => 'object_no_c',
                'label' => 'LBL_OBJECT_NO',
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
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
                'width' => 'medium',
              ),
              4 => 
              array (
                'name' => 'asset_type_c',
                'label' => 'LBL_ASSET_TYPE',
                'enabled' => true,
                'default' => true,
                'width' => 'small',
              ),
              5 => 
              array (
                'name' => 'model_year_c',
                'label' => 'LBL_MODEL_YEAR',
                'enabled' => true,
                'default' => true,
                'width' => 'xsmall',
              ),
              6 => 
              array (
                'name' => 'make_c',
                'label' => 'LBL_MAKE',
                'enabled' => true,
                'default' => true,
                'width' => 'small',
              ),
              7 => 
              array (
                'name' => 'model_c',
                'label' => 'LBL_MODEL',
                'enabled' => true,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'asset_location_c',
                'label' => 'LBL_ASSET_LOCATION',
                'enabled' => true,
                'id' => 'ACCOUNT_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              9 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => true,
                'enabled' => true,
                'width' => 'small',
              ),
              10 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
                'width' => 'small',
              ),
              11 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
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
