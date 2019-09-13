<?php
$viewdefs['HT_PO'] = 
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
            'label' => 'LBL_PANEL_DEFAULT',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'po_date',
                'label' => 'LBL_PO_DATE',
                'enabled' => true,
                'default' => true,
              ),
              1 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
                'width' => '32',
              ),
              2 => 
              array (
                'name' => 'account_issuer_c',
                'label' => 'LBL_ACCOUNT_ISSUER',
                'enabled' => true,
                'id' => 'ACCOUNT_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'po_status',
                'label' => 'LBL_PO_STATUS',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
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
              ),
              5 => 
              array (
                'name' => 'expire_date',
                'label' => 'LBL_EXPIRE_DATE',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'sales_and_svs_c',
                'label' => 'LBL_SALES_AND_SVS',
                'enabled' => true,
                'id' => 'SALES_AND_SERVICES_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => true,
                'enabled' => true,
                'width' => '9',
              ),
              9 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
                'id' => 'ASSIGNED_USER_ID',
                'width' => '9',
              ),
              10 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_CREATED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'CREATED_BY',
                'link' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'id' => 'MODIFIED_USER_ID',
                'link' => true,
                'default' => false,
              ),
              13 => 
              array (
                'name' => 'base_rate',
                'label' => 'LBL_CURRENCY_RATE',
                'enabled' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
                'enabled' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'date_modified',
                'label' => 'LBL_DATE_MODIFIED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
