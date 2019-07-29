<?php
$module_name = 'word_templates';
$viewdefs[$module_name] = 
array (
  'mobile' => 
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
              ),
              2 => 
              array (
                'name' => 'category_id',
                'label' => 'LBL_LIST_CATEGORY',
                'default' => true,
                'enabled' => true,
              ),
              3 => 
              array (
                'name' => 'subcategory_id',
                'label' => 'LBL_LIST_SUBCATEGORY',
                'default' => true,
                'enabled' => true,
              ),
              4 => 
              array (
                'name' => 'created_by_name',
                'label' => 'LBL_LIST_LAST_REV_CREATOR',
                'default' => true,
                'sortable' => false,
                'enabled' => true,
              ),
              5 => 
              array (
                'name' => 'active_date',
                'label' => 'LBL_LIST_ACTIVE_DATE',
                'default' => true,
                'enabled' => true,
              ),
              6 => 
              array (
                'name' => 'exp_date',
                'label' => 'LBL_LIST_EXP_DATE',
                'default' => true,
                'enabled' => true,
              ),
            ),
          ),
        ),
      ),
    ),
  ),
);
