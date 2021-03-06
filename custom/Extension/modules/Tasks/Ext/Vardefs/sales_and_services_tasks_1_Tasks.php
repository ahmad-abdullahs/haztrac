<?php
// created: 2020-02-23 03:49:26
$dictionary["Task"]["fields"]["sales_and_services_tasks_1"] = array (
  'name' => 'sales_and_services_tasks_1',
  'type' => 'link',
  'relationship' => 'sales_and_services_tasks_1',
  'source' => 'non-db',
  'module' => 'sales_and_services',
  'bean_name' => 'sales_and_services',
  'side' => 'right',
  'vname' => 'LBL_SALES_AND_SERVICES_TASKS_1_FROM_TASKS_TITLE',
  'id_name' => 'sales_and_services_tasks_1sales_and_services_ida',
  'link-type' => 'one',
);
$dictionary["Task"]["fields"]["sales_and_services_tasks_1_name"] = array (
  'name' => 'sales_and_services_tasks_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_SALES_AND_SERVICES_TASKS_1_FROM_SALES_AND_SERVICES_TITLE',
  'save' => true,
  'id_name' => 'sales_and_services_tasks_1sales_and_services_ida',
  'link' => 'sales_and_services_tasks_1',
  'table' => 'sales_and_services',
  'module' => 'sales_and_services',
  'rname' => 'name',
);
$dictionary["Task"]["fields"]["sales_and_services_tasks_1sales_and_services_ida"] = array (
  'name' => 'sales_and_services_tasks_1sales_and_services_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_SALES_AND_SERVICES_TASKS_1_FROM_TASKS_TITLE_ID',
  'id_name' => 'sales_and_services_tasks_1sales_and_services_ida',
  'link' => 'sales_and_services_tasks_1',
  'table' => 'sales_and_services',
  'module' => 'sales_and_services',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
