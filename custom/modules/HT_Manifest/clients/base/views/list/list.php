<?php
$module_name = 'HT_Manifest';
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
                'name' => 'manifest_no_actual_c',
                'type' => 'manifest-no',
                'label' => 'LBL_MANIFEST_NO_ACTUAL',
                'enabled' => true,
                'default' => true,
                'related_fields' => 
                array (
                  0 => 'rli_galon_total',
                ),
              ),
              1 => 
              array (
                'name' => 'rli_galon_total',
                'label' => 'LBL_RLI_GALON_TOTAL',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'default' => true,
                'enabled' => true,
                'link' => true,
              ),
              3 => 
              array (
                'name' => 'accounts_ht_manifest_1_name',
                'label' => 'LBL_ACCOUNTS_HT_MANIFEST_1_FROM_ACCOUNTS_TITLE',
                'enabled' => true,
                'id' => 'ACCOUNTS_HT_MANIFEST_1ACCOUNTS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'consolidate_c',
                'label' => 'LBL_CONSOLIDATE',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'state_codes_c',
                'label' => 'LBL_STATE_CODES',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'epa_codes_c',
                'label' => 'LBL_EPA_CODES',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'status_c',
                'label' => 'LBL_STATUS',
                'enabled' => true,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'start_date_c',
                'label' => 'LBL_START_DATE',
                'enabled' => true,
                'default' => true,
              ),
              9 => 
              array (
                'name' => 'manifest_days',
                'label' => 'LBL_MANIFEST_DAYS',
                'type' => 'base-colorcoded',
                'enabled' => true,
                'default' => true,
              ),
              10 => 
              array (
                'name' => 'designated_facility_c',
                'label' => 'LBL_DESIGNATED_FACILITY',
                'enabled' => true,
                'id' => 'ACCOUNT_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              11 => 
              array (
                'name' => 'manifest_tenth_day_date',
                'label' => 'LBL_MANIFEST_TENTH_DAY_DATE',
                'enabled' => true,
                'default' => true,
              ),
              12 => 
              array (
                'name' => 'complete_date_c',
                'label' => 'LBL_COMPLETE_DATE',
                'enabled' => true,
                'default' => true,
              ),
              13 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'default' => false,
                'enabled' => true,
              ),
              14 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'default' => false,
                'enabled' => true,
                'link' => true,
              ),
              15 => 
              array (
                'name' => 'manifest_number',
                'label' => 'LBL_MANIFEST_NUMBER',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => false,
              ),
              17 => 
              array (
                'name' => 'transporter',
                'label' => 'LBL_TRANSPORTER',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'ht_manifest_v_vendors_name',
                'label' => 'LBL_HT_MANIFEST_V_VENDORS_FROM_V_VENDORS_TITLE',
                'enabled' => true,
                'id' => 'HT_MANIFEST_V_VENDORSHT_MANIFEST_IDA',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'date_modified',
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
