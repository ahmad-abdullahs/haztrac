<?php
$module_name = 'WT_Waste_Tracking';
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
                'name' => 'waste_type',
                'label' => 'LBL_WASTE_TYPE',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'tracking_number',
                'label' => 'LBL_TRACKING_NUMBER',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'start_date',
                'label' => 'LBL_START_DATE',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'transfer_date',
                'label' => 'LBL_TRANSFER_DATE',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'accumulation_period',
                'label' => 'LBL_ACCUMULATION_PERIOD',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'ship_date',
                'label' => 'LBL_SHIP_DATE',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'total_days',
                'label' => 'LBL_TOTAL_DAYS',
                'enabled' => true,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              9 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => false,
              ),
              11 => 
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
