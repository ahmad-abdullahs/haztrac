<?php
// created: 2021-06-05 00:24:08
$subpanel_layout['list_fields'] = array (
  'manifest_no_actual_c' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_MANIFEST_NO_ACTUAL',
    'width' => 10,
    'default' => true,
  ),
  'rli_galon_total' => 
  array (
    'type' => 'decimal',
    'vname' => 'LBL_RLI_GALON_TOTAL',
    'width' => 10,
    'default' => true,
  ),
  'name' => 
  array (
    'vname' => 'LBL_NAME',
    'widget_class' => 'SubPanelDetailViewLink',
    'width' => 10,
    'default' => true,
  ),
  'consolidate_c' => 
  array (
    'type' => 'bool',
    'default' => true,
    'vname' => 'LBL_CONSOLIDATE',
    'width' => 10,
  ),
  'state_codes_c' => 
  array (
    'type' => 'multienum',
    'default' => true,
    'vname' => 'LBL_STATE_CODES',
    'width' => 10,
  ),
  'epa_codes_c' => 
  array (
    'type' => 'multienum',
    'default' => true,
    'vname' => 'LBL_EPA_CODES',
    'width' => 10,
  ),
  'status_c' => 
  array (
    'type' => 'enum',
    'default' => true,
    'vname' => 'LBL_STATUS',
    'width' => 10,
  ),
  'start_date_c' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_START_DATE',
    'width' => 10,
    'default' => true,
  ),
  'manifest_days' => 
  array (
    'type' => 'varchar',
    'vname' => 'LBL_MANIFEST_DAYS',
    'width' => 10,
    'default' => true,
  ),
  'manifest_tenth_day_date' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_MANIFEST_TENTH_DAY_DATE',
    'width' => 10,
    'default' => true,
  ),
  'complete_date_c' => 
  array (
    'type' => 'date',
    'vname' => 'LBL_COMPLETE_DATE',
    'width' => 10,
    'default' => true,
  ),
  'date_entered' => 
  array (
    'type' => 'datetime',
    'studio' => 
    array (
      'portaleditview' => false,
    ),
    'readonly' => true,
    'vname' => 'LBL_DATE_ENTERED',
    'width' => 10,
    'default' => true,
  ),
);