<?php
$viewdefs['HT_PO'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'selection-list' => 
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
                'name' => 'po_date',
                'label' => 'LBL_PO_DATE',
                'enabled' => true,
                'default' => true,
                'width' => 'xsmall',
              ),
              1 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
                'width' => '45',
              ),
              2 => 
              array (
                'name' => 'po_amount_c',
                'label' => 'LBL_PO_AMOUNT',
                'enabled' => true,
                'related_fields' => 
                array (
                  0 => 'currency_id',
                  1 => 'base_rate',
                ),
                'currency_format' => true,
                'default' => true,
                'width' => '35',
              ),
              3 => 
              array (
                'name' => 'account_issuer_c',
                'label' => 'LBL_ACCOUNT_ISSUER',
                'enabled' => true,
                'id' => 'ACCOUNT_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
                'width' => 'medium',
              ),
              4 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
                'width' => 'xsmall',
              ),
              5 => 
              array (
                'name' => 'expire_date',
                'label' => 'LBL_EXPIRE_DATE',
                'enabled' => true,
                'default' => true,
                'width' => 'xsmall',
              ),
              6 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => true,
                'enabled' => true,
                'width' => '25',
              ),
              7 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => true,
                'width' => 'large',
              ),
              8 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
                'width' => '9',
                'id' => 'ASSIGNED_USER_ID',
              ),
              9 => 
              array (
                'name' => 'po_status',
                'label' => 'LBL_PO_STATUS',
                'enabled' => true,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'sales_and_svs_c',
                'label' => 'LBL_SALES_AND_SVS',
                'enabled' => true,
                'id' => 'SALES_AND_SERVICES_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'my_favorite',
                'label' => 'LBL_FAVORITE',
                'enabled' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'base_rate',
                'label' => 'LBL_CURRENCY_RATE',
                'enabled' => true,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
