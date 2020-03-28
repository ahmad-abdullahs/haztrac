<?php
// created: 2020-03-28 03:12:02
$dictionary["queue_workorder"]["fields"]["sales_and_services_queue_workorder_1"] = array (
  'name' => 'sales_and_services_queue_workorder_1',
  'type' => 'link',
  'relationship' => 'sales_and_services_queue_workorder_1',
  'source' => 'non-db',
  'module' => 'sales_and_services',
  'bean_name' => 'sales_and_services',
  'side' => 'right',
  'vname' => 'LBL_SALES_AND_SERVICES_QUEUE_WORKORDER_1_FROM_QUEUE_WORKORDER_TITLE',
  'id_name' => 'sales_and_services_queue_workorder_1sales_and_services_ida',
  'link-type' => 'one',
);
$dictionary["queue_workorder"]["fields"]["sales_and_services_queue_workorder_1_name"] = array (
  'name' => 'sales_and_services_queue_workorder_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_SALES_AND_SERVICES_QUEUE_WORKORDER_1_FROM_SALES_AND_SERVICES_TITLE',
  'save' => true,
  'id_name' => 'sales_and_services_queue_workorder_1sales_and_services_ida',
  'link' => 'sales_and_services_queue_workorder_1',
  'table' => 'sales_and_services',
  'module' => 'sales_and_services',
  'rname' => 'name',
);
$dictionary["queue_workorder"]["fields"]["sales_and_services_queue_workorder_1sales_and_services_ida"] = array (
  'name' => 'sales_and_services_queue_workorder_1sales_and_services_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_SALES_AND_SERVICES_QUEUE_WORKORDER_1_FROM_QUEUE_WORKORDER_TITLE_ID',
  'id_name' => 'sales_and_services_queue_workorder_1sales_and_services_ida',
  'link' => 'sales_and_services_queue_workorder_1',
  'table' => 'sales_and_services',
  'module' => 'sales_and_services',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
