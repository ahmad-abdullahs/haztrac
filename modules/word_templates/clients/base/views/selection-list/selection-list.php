<?php
$viewdefs['word_templates']['base']['view']['selection-list'] = array (
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
        2 => 
        array (
          'name' => 'category_id',
          'default' => true,
          'enabled' => true,
          'width' => '40',
          'label' => 'LBL_LIST_CATEGORY',
        ),
        3 => 
        array (
          'name' => 'subcategory_id',
          'default' => true,
          'enabled' => true,
          'width' => '40',
          'label' => 'LBL_LIST_SUBCATEGORY',
        ),
        4 => 
        array (
          'name' => 'created_by_name',
          'default' => true,
          'enabled' => true,
          'width' => '2',
          'label' => 'LBL_LIST_LAST_REV_CREATOR',
          'sortable' => false,
        ),
        5 => 
        array (
          'name' => 'active_date',
          'default' => true,
          'enabled' => true,
          'width' => '10',
          'label' => 'LBL_LIST_ACTIVE_DATE',
        ),
        6 => 
        array (
          'name' => 'exp_date',
          'default' => true,
          'enabled' => true,
          'width' => '10',
          'label' => 'LBL_LIST_EXP_DATE',
        ),
      ),
    ),
  ),
);
