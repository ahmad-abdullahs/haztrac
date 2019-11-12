<?php
$viewdefs['WT_Waste_Tracking'] = 
array (
  'portal' => 
  array (
    'view' => 
    array (
      'list' => 
      array (
        'panels' => 
        array (
          0 => 
          array (
            'label' => 'LBL_PANEL_DEFAULT',
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
            ),
          ),
        ),
      ),
    ),
  ),
);
