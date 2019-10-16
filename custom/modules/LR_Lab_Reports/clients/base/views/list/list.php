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
                'name' => 'sample_id_number_c',
                'label' => 'LBL_SAMPLE_ID_NUMBER',
                'enabled' => true,
                'default' => true,
                'width' => '12',
              ),
              1 => 
              array (
                'name' => 'lab_ref_number_c',
                'label' => 'LBL_LAB_REF_NUMBER',
                'enabled' => true,
                'default' => true,
                'width' => '15',
              ),
              2 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => true,
                'width' => '10',
              ),
              3 => 
              array (
                'name' => 'document_name',
                'label' => 'LBL_NAME',
                'link' => true,
                'default' => true,
                'enabled' => true,
                'width' => '25',
              ),
              4 => 
              array (
                'name' => 'accounts_lr_lab_reports_3_name',
                'label' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_3_FROM_ACCOUNTS_TITLE',
                'enabled' => true,
                'link' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'commodity_c',
                'label' => 'LBL_COMMODITY',
                'enabled' => true,
                'default' => true,
                'width' => '25',
              ),
              6 => 
              array (
                'name' => 'status_id',
                'label' => 'LBL_DOC_STATUS',
                'enabled' => true,
                'default' => true,
                'width' => 'small',
              ),
              7 => 
              array (
                'name' => 'accounts_lr_lab_reports_1_name',
                'label' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_1_FROM_ACCOUNTS_TITLE',
                'enabled' => true,
                'id' => 'ACCOUNTS_LR_LAB_REPORTS_1ACCOUNTS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
                'width' => '25',
              ),
              8 => 
              array (
                'name' => 'analysis_templates_c',
                'label' => 'LBL_ANALYSIS_TEMPLATES',
                'enabled' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'category_id',
                'default' => false,
                'enabled' => true,
                'width' => '40',
                'label' => 'LBL_LIST_CATEGORY',
              ),
              10 => 
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
              11 => 
              array (
                'name' => 'subcategory_id',
                'default' => false,
                'enabled' => true,
                'width' => '40',
                'label' => 'LBL_LIST_SUBCATEGORY',
              ),
              12 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_LIST_LAST_REV_CREATOR',
                'default' => false,
                'sortable' => false,
                'enabled' => true,
                'width' => '2',
              ),
              13 => 
              array (
                'name' => 'active_date',
                'default' => false,
                'enabled' => true,
                'width' => '10',
                'label' => 'LBL_LIST_ACTIVE_DATE',
              ),
              14 => 
              array (
                'name' => 'exp_date',
                'default' => false,
                'enabled' => true,
                'width' => '10',
                'label' => 'LBL_LIST_EXP_DATE',
              ),
              15 => 
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
