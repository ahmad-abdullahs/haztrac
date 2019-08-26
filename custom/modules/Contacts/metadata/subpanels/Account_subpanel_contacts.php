<?php
// created: 2019-08-06 12:13:09
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'name' => 'name',
    'vname' => 'LBL_LIST_NAME',
    'sort_by' => 'last_name',
    'sort_order' => 'asc',
    'widget_class' => 'SubPanelDetailViewLink',
    'module' => 'Contacts',
    'width' => 10,
    'default' => true,
  ),
  'title' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_TITLE',
    'width' => 10,
    'default' => true,
  ),
  'phone_work' => 
  array (
    'name' => 'phone_work',
    'vname' => 'LBL_LIST_PHONE',
    'width' => 10,
    'default' => true,
  ),
  'phone_mobile' => 
  array (
    'type' => 'phone',
    'vname' => 'LBL_MOBILE_PHONE',
    'width' => 10,
    'default' => true,
  ),
  'email' => 
  array (
    'name' => 'email',
    'vname' => 'LBL_LIST_EMAIL',
    'widget_class' => 'SubPanelEmailLink',
    'width' => 10,
    'sortable' => false,
    'default' => true,
  ),
  'team_name' => 
  array (
    'type' => 'relate',
    'link' => true,
    'studio' => 
    array (
      'portallistview' => false,
      'portalrecordview' => false,
    ),
    'vname' => 'LBL_TEAMS',
    'id' => 'TEAM_ID',
    'width' => 10,
    'default' => true,
    'widget_class' => 'SubPanelDetailViewLink',
    'target_module' => 'Teams',
    'target_record_key' => 'team_id',
  ),
  'first_name' => 
  array (
    'name' => 'first_name',
    'usage' => 'query_only',
  ),
  'last_name' => 
  array (
    'name' => 'last_name',
    'usage' => 'query_only',
  ),
  'salutation' => 
  array (
    'name' => 'salutation',
    'usage' => 'query_only',
  ),
  'account_id' => 
  array (
    'usage' => 'query_only',
  ),
);