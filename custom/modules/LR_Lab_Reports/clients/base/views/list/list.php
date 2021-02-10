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
                'width' => '25',
              ),
              1 => 
              array (
                'name' => 'sample_date_time_c',
                'label' => 'LBL_SAMPLE_DATE_TIME',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'analysis_date_c',
                'label' => 'LBL_ANALYSIS_DATE',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'lab_date_c',
                'label' => 'LBL_LAB_DATE',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'sample_id_number_c',
                'label' => 'LBL_SAMPLE_ID_NUMBER',
                'enabled' => true,
                'default' => true,
                'width' => '12',
              ),
              5 => 
              array (
                'name' => 'lab_ref_number_c',
                'label' => 'LBL_LAB_REF_NUMBER',
                'enabled' => true,
                'default' => true,
                'width' => '15',
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
                'name' => 'manifest_galon_total',
                'label' => 'LBL_MANIFEST_GALON_TOTAL',
                'enabled' => true,
                'default' => true,
                'width' => 'xsmall',
              ),
              8 => 
              array (
                'name' => 'accounts_lr_lab_reports_1_name',
                'label' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_1_FROM_ACCOUNTS_TITLE_CST',
                'enabled' => true,
                'id' => 'ACCOUNTS_LR_LAB_REPORTS_1ACCOUNTS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
                'width' => '25',
              ),
              9 => 
              array (
                'name' => 'accounts_lr_lab_reports_2_name',
                'label' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_2_FROM_ACCOUNTS_TITLE_CST',
                'enabled' => true,
                'id' => 'ACCOUNTS_LR_LAB_REPORTS_2ACCOUNTS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              10 => 
              array (
                'name' => 'accounts_lr_lab_reports_3_name',
                'label' => 'LBL_ACCOUNTS_LR_LAB_REPORTS_3_FROM_ACCOUNTS_TITLE_CST',
                'enabled' => true,
                'link' => true,
                'default' => true,
              ),
              11 => 
              array (
                'name' => 'generator_c',
                'label' => 'LBL_GENERATOR',
                'enabled' => true,
                'id' => 'ACCOUNT_ID_C',
                'link' => true,
                'sortable' => false,
                'default' => true,
              ),
              12 => 
              array (
                'name' => 'commodity_c',
                'label' => 'LBL_COMMODITY',
                'enabled' => true,
                'default' => true,
                'width' => '25',
              ),
              13 => 
              array (
                'name' => 'category_id',
                'default' => false,
                'enabled' => true,
                'width' => '40',
                'label' => 'LBL_LIST_CATEGORY',
              ),
              14 => 
              array (
                'name' => 'subcategory_id',
                'default' => false,
                'enabled' => true,
                'width' => '40',
                'label' => 'LBL_LIST_SUBCATEGORY',
              ),
              15 => 
              array (
                'name' => 'active_date',
                'default' => false,
                'enabled' => true,
                'width' => '10',
                'label' => 'LBL_LIST_ACTIVE_DATE',
              ),
              16 => 
              array (
                'name' => 'exp_date',
                'default' => false,
                'enabled' => true,
                'width' => '10',
                'label' => 'LBL_LIST_EXP_DATE',
              ),
              17 => 
              array (
                'name' => 'lab_svc_request_c',
                'label' => 'LBL_LAB_SVC_REQUEST',
                'enabled' => true,
                'default' => false,
              ),
              18 => 
              array (
                'name' => 'analysis_templates_c',
                'label' => 'LBL_ANALYSIS_TEMPLATES',
                'enabled' => true,
                'default' => false,
              ),
              19 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_LIST_TEAM',
                'sortable' => false,
                'default' => false,
                'enabled' => true,
                'width' => '2',
              ),
              20 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'enabled' => true,
                'readonly' => true,
                'default' => false,
                'width' => '10',
              ),
              21 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_LIST_LAST_REV_CREATOR',
                'default' => false,
                'sortable' => false,
                'enabled' => true,
                'width' => '2',
              ),
              22 => 
              array (
                'name' => 'lab_analysis_c',
                'label' => 'LBL_LAB_ANALYSIS',
                'enabled' => true,
                'default' => false,
              ),
              23 => 
              array (
                'name' => 'object_number_c',
                'label' => 'LBL_OBJECT_NUMBER',
                'enabled' => true,
                'default' => false,
              ),
              24 => 
              array (
                'name' => 'project_lr_lab_reports_1_name',
                'label' => 'LBL_PROJECT_LR_LAB_REPORTS_1_FROM_PROJECT_TITLE',
                'enabled' => true,
                'id' => 'PROJECT_LR_LAB_REPORTS_1PROJECT_IDA',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              25 => 
              array (
                'name' => 'v_vendors_lr_lab_reports_1_name',
                'label' => 'LBL_V_VENDORS_LR_LAB_REPORTS_1_FROM_V_VENDORS_TITLE',
                'enabled' => true,
                'id' => 'V_VENDORS_LR_LAB_REPORTS_1V_VENDORS_IDA',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              26 => 
              array (
                'name' => 'manifests',
                'label' => 'LBL_MANIFESTS',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              27 => 
              array (
                'name' => 'wpm_waste_profile_module_lr_lab_reports_name',
                'label' => 'LBL_WPM_WASTE_PROFILE_MODULE_LR_LAB_REPORTS_FROM_WPM_WASTE_PROFILE_MODULE_TITLE',
                'enabled' => true,
                'id' => 'WPM_WASTE_470D_MODULE_IDA',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              28 => 
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
            ),
          ),
        ),
      ),
    ),
  ),
);
