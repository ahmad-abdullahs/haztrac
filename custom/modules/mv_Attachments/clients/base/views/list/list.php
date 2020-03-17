<?php
$module_name = 'mv_Attachments';
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
              ),
              1 => 
              array (
                'name' => 'analysis_date',
                'label' => 'LBL_ANALYSIS_DATE',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'lab_ref_number',
                'label' => 'LBL_LAB_REF_NUMBER',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'category_id',
                'label' => 'LBL_LIST_CATEGORY',
                'default' => true,
                'enabled' => true,
              ),
              4 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_TEAM',
                'sortable' => false,
                'default' => true,
                'enabled' => true,
              ),
              5 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_LIST_LAST_REV_CREATOR',
                'default' => true,
                'sortable' => false,
                'enabled' => true,
              ),
              6 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'enabled' => true,
                'default' => true,
              ),
              8 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO',
                'enabled' => true,
                'id' => 'ASSIGNED_USER_ID',
                'link' => true,
                'default' => false,
              ),
              9 => 
              array (
                'name' => 'description',
                'label' => 'LBL_DESCRIPTION',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              10 => 
              array (
                'name' => 'file_ext',
                'label' => 'LBL_FILE_EXTENSION',
                'enabled' => true,
                'default' => false,
              ),
              11 => 
              array (
                'name' => 'uploadfile',
                'type' => 'cstm-file',
                'label' => 'LBL_FILE_UPLOAD',
                'enabled' => true,
                'default' => false,
              ),
              12 => 
              array (
                'name' => 'modified_by_name',
                'label' => 'LBL_MODIFIED_USER',
                'module' => 'Users',
                'id' => 'USERS_ID',
                'default' => false,
                'sortable' => false,
                'related_fields' => 
                array (
                  0 => 'modified_user_id',
                ),
                'enabled' => true,
              ),
              13 => 
              array (
                'name' => 'name',
                'label' => 'LBL_NAME',
                'enabled' => true,
                'default' => false,
              ),
              14 => 
              array (
                'name' => 'parent_type',
                'label' => 'LBL_PARENT_TYPE',
                'enabled' => true,
                'default' => false,
              ),
              15 => 
              array (
                'name' => 'parent_name',
                'label' => 'LBL_FLEX_RELATE',
                'enabled' => true,
                'id' => 'PARENT_ID',
                'link' => true,
                'sortable' => false,
                'default' => false,
              ),
              16 => 
              array (
                'name' => 'tag',
                'label' => 'LBL_TAGS',
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
