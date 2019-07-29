<?php
$viewdefs['HT_SS_Quotes']['base']['view']['list'] = array (
  'panels' => 
  array (
    0 => 
    array (
      'label' => 'LBL_PANEL_DEFAULT',
      'fields' => 
      array (
        0 => 
        array (
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => true,
          'width' => '32',
        ),
        1 => 
        array (
          'name' => 'team_name',
          'default' => false,
          'enabled' => true,
          'width' => '9',
          'label' => 'LBL_TEAM',
        ),
        2 => 
        array (
          'name' => 'assigned_user_name',
          'target_record_key' => 'assigned_user_id',
          'target_module' => 'Employees',
          'label' => 'LBL_ASSIGNED_TO_NAME',
          'enabled' => true,
          'default' => true,
          'sortable' => false,
          'width' => '9',
          'id' => 'ASSIGNED_USER_ID',
        ),
      ),
    ),
  ),
);
