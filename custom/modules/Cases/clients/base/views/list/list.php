<?php
$viewdefs['Cases'] = 
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
                'name' => 'case_number',
                'label' => 'LBL_LIST_NUMBER',
                'default' => true,
                'enabled' => true,
                'readonly' => true,
                'width' => 'xsmall',
              ),
              1 => 
              array (
                'name' => 'name',
                'label' => 'LBL_LIST_SUBJECT',
                'link' => true,
                'default' => true,
                'enabled' => true,
                'width' => 'small',
              ),
              2 => 
              array (
                'name' => 'account_name',
                'label' => 'LBL_LIST_ACCOUNT_NAME',
                'module' => 'Accounts',
                'id' => 'ACCOUNT_ID',
                'ACLTag' => 'ACCOUNT',
                'related_fields' => 
                array (
                  0 => 'account_id',
                ),
                'link' => true,
                'default' => true,
                'enabled' => true,
                'width' => 'small',
              ),
              3 => 
              array (
                'name' => 'priority',
                'label' => 'LBL_LIST_PRIORITY',
                'default' => true,
                'enabled' => true,
                'width' => 'xsmall',
              ),
              4 => 
              array (
                'name' => 'status',
                'label' => 'LBL_STATUS',
                'default' => true,
                'enabled' => true,
                'width' => 'small',
              ),
              5 => 
              array (
                'name' => 'assigned_user_name',
                'label' => 'LBL_ASSIGNED_TO_NAME',
                'id' => 'ASSIGNED_USER_ID',
                'default' => true,
                'enabled' => true,
                'width' => 'small',
              ),
              6 => 
              array (
                'name' => 'date_modified',
                'enabled' => true,
                'default' => true,
                'width' => 'xsmall',
              ),
              7 => 
              array (
                'name' => 'date_entered',
                'label' => 'LBL_DATE_ENTERED',
                'default' => true,
                'enabled' => true,
                'readonly' => true,
              ),
              8 => 
              array (
                'name' => 'team_name',
                'label' => 'LBL_LIST_TEAM',
                'default' => false,
                'enabled' => true,
              ),
              9 => 
              array (
                'name' => 'work_log',
                'label' => 'LBL_WORK_LOG',
                'enabled' => true,
                'sortable' => false,
                'default' => false,
              ),
              10 => 
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
