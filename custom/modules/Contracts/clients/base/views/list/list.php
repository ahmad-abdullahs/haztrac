<?php
$viewdefs['Contracts'] = 
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
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'name',
                'label' => 'LBL_LIST_CONTRACT_NAME',
                'link' => true,
                'default' => true,
                'enabled' => true,
              ),
              1 => 
              array (
                'name' => 'account_name',
                'label' => 'LBL_LIST_ACCOUNT_NAME',
                'link' => true,
                'default' => true,
                'enabled' => true,
              ),
              2 => 
              array (
                'name' => 'contract_number_c',
                'label' => 'LBL_CONTRACT_NUMBER',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'status',
                'label' => 'LBL_STATUS',
                'link' => false,
                'default' => true,
                'enabled' => true,
              ),
              4 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'start_date',
                'label' => 'LBL_LIST_START_DATE',
                'link' => false,
                'default' => true,
                'enabled' => true,
              ),
              6 => 
              array (
                'name' => 'end_date',
                'label' => 'LBL_LIST_END_DATE',
                'link' => false,
                'default' => true,
                'enabled' => true,
              ),
              7 => 
              array (
                'name' => 'total_contract_value',
                'label' => 'LBL_TOTAL_CONTRACT_VALUE',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'total_contract_value_usdollar',
                'label' => 'LBL_TOTAL_CONTRACT_VALUE_USDOLLAR',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'readonly' => true,
                'currency_format' => true,
                'default' => true,
              ),
              9 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_LIST_ASSIGNED_TO_USER',
                'default' => true,
                'enabled' => true,
              ),
              10 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_LIST_TEAM',
                'default' => false,
                'enabled' => true,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
