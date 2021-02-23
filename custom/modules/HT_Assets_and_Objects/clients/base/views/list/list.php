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
                'width' => '32',
              ),
              4 => 
              array (
                'name' => 'asset_type_c',
                'label' => 'LBL_ASSET_TYPE',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'model_year_c',
                'label' => 'LBL_MODEL_YEAR',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'make_c',
                'label' => 'LBL_MAKE',
                'enabled' => true,
                'default' => true,
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
                'width' => '9',
              ),
              10 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
                'width' => '9',
              ),
              11 => 
              array (
                'name' => 'operational_status_c',
                'label' => 'LBL_OPERATIONAL_STATUS',
                'enabled' => true,
                'default' => true,
              ),
              12 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'weight_load_limit_c',
                'label' => 'LBL_WEIGHT_LOAD_LIMIT',
                'enabled' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'license_number_c',
                'label' => 'LBL_LICENSE_NUMBER',
                'enabled' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'volume_bbl_c',
                'label' => 'LBL_VOLUME_BBL',
                'enabled' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'serial_vin_c',
                'label' => 'LBL_SERIAL_VIN',
                'enabled' => true,
                'default' => false,
              ),
              17 => 
              array (
                'name' => 'weight_tare_lb_c',
                'label' => 'LBL_WEIGHT_TARE_LB',
                'enabled' => true,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'ins_exp_c',
                'label' => 'LBL_INS_EXP',
                'enabled' => true,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'volume_gallons_c',
                'label' => 'LBL_VOLUME_GALLONS',
                'enabled' => true,
                'default' => false,
              ),
              20 => 
              array (
                'name' => 'weight_gvw_lb_c',
                'label' => 'LBL_WEIGHT_GVW_LB',
                'enabled' => true,
                'default' => false,
              ),
              21 => 
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
