<?php
$viewdefs['Bugs'] = 
array (
  'portal' => 
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
                'name' => 'bug_number',
                'label' => 'LBL_BUG_NUMBER',
                'enabled' => true,
                'default' => true,
                'readonly' => true,
              ),
              1 => 
              array (
                'name' => 'name',
                'link' => true,
                'label' => 'LBL_LIST_SUBJECT',
                'enabled' => true,
                'default' => true,
              ),
              2 => 
              array (
                'name' => 'status',
                'label' => 'LBL_LIST_STATUS',
                'enabled' => true,
                'default' => true,
              ),
              3 => 
              array (
                'name' => 'priority',
                'label' => 'LBL_LIST_PRIORITY',
                'enabled' => true,
                'default' => true,
              ),
              4 => 
              array (
                'name' => 'type',
                'label' => 'LBL_LIST_TYPE',
                'enabled' => true,
                'default' => true,
              ),
              5 => 
              array (
                'name' => 'product_category',
                'label' => 'LBL_PRODUCT_CATEGORY',
                'enabled' => true,
                'default' => true,
              ),
              6 => 
              array (
                'name' => 'resolution',
                'label' => 'LBL_RESOLUTION',
                'enabled' => true,
                'default' => true,
              ),
            ),
          ),
        ),
        'last_state' => 
        array (
          'id' => 'list',
        ),
      ),
    ),
  ),
);
