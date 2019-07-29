<?php
$viewdefs['LR_Lab_Reports'] = 
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
                'name' => 'document_name',
                'label' => 'LBL_NAME',
                'link' => true,
                'default' => true,
                'enabled' => true,
                'width' => '40',
              ),
              1 => 
              array (
                'name' => 'commodity_c',
                'label' => 'LBL_COMMODITY',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'status_id',
                'label' => 'LBL_DOC_STATUS',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'sample_id_number_c',
                'label' => 'LBL_SAMPLE_ID_NUMBER',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'lab_ref_number_c',
                'label' => 'LBL_LAB_REF_NUMBER',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'v_vendors_lr_lab_reports_1_name',
                'label' => 'LBL_V_VENDORS_LR_LAB_REPORTS_1_FROM_V_VENDORS_TITLE',
                'enabled' => true,
                'id' => 'V_VENDORS_LR_LAB_REPORTS_1V_VENDORS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'category_id',
                'default' => false,
                'enabled' => true,
                'width' => '40',
                'label' => 'LBL_LIST_CATEGORY',
              ),
              8 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED_USER',
                'id' => 'USERS_ID',
                'default' => false,
                'sortable' => false,
                'related_fields' => 
                array (
                  0 => 'modified_user_id',
                ),
                'enabled' => true,
                'width' => '10',
              ),
              9 => 
              array (
                'name' => 'subcategory_id',
                'default' => false,
                'enabled' => true,
                'width' => '40',
                'label' => 'LBL_LIST_SUBCATEGORY',
              ),
              10 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_LIST_LAST_REV_CREATOR',
                'default' => false,
                'sortable' => false,
                'enabled' => true,
                'width' => '2',
              ),
              11 => 
              array (
                'name' => 'active_date',
                'default' => false,
                'enabled' => true,
                'width' => '10',
                'label' => 'LBL_LIST_ACTIVE_DATE',
              ),
              12 => 
              array (
                'name' => 'exp_date',
                'default' => false,
                'enabled' => true,
                'width' => '10',
                'label' => 'LBL_LIST_EXP_DATE',
              ),
              13 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_LIST_TEAM',
                'sortable' => false,
                'default' => false,
                'enabled' => true,
                'width' => '2',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
