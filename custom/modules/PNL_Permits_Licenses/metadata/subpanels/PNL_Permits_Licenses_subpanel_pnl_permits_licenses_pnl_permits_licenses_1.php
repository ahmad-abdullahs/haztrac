<?php
// created: 2020-07-11 22:46:42
$subpanel_layout['list_fields'] = array (
  'name' => 
  array (
    'type' => 'name',
    'vname' => 'LBL_NAME',
    'width' => 10,
    'default' => true,
  ),
  'document_name' => 
  array (
    'name' => 'document_name',
    'vname' => 'LBL_LIST_DOCUMENT_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'status_id' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_DOC_STATUS',
    'width' => 10,
    'default' => true,
  ),
  'category_id' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_SF_CATEGORY',
    'width' => 10,
    'default' => true,
  ),
  'subcategory_id' => 
  array (
    'type' => 'enum',
    'vname' => 'LBL_SF_SUBCATEGORY',
    'width' => 10,
    'default' => true,
  ),
  'active_date' => 
  array (
    'name' => 'active_date',
    'vname' => 'LBL_DOC_ACTIVE_DATE',
    'width' => 10,
    'default' => true,
  ),
  'exp_date' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_DOC_EXP_DATE',
    'width' => 10,
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
);