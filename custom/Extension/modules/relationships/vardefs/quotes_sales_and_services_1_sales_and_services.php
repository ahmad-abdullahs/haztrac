<?php
// created: 2019-02-18 04:46:18
$dictionary["sales_and_services"]["fields"]["quotes_sales_and_services_1"] = array (
  'name' => 'quotes_sales_and_services_1',
  'type' => 'link',
  'relationship' => 'quotes_sales_and_services_1',
  'source' => 'non-db',
  'module' => 'Quotes',
  'bean_name' => 'Quote',
  'side' => 'right',
  'vname' => 'LBL_QUOTES_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE',
  'id_name' => 'quotes_sales_and_services_1quotes_ida',
  'link-type' => 'one',
);
$dictionary["sales_and_services"]["fields"]["quotes_sales_and_services_1_name"] = array (
  'name' => 'quotes_sales_and_services_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_QUOTES_SALES_AND_SERVICES_1_FROM_QUOTES_TITLE',
  'save' => true,
  'id_name' => 'quotes_sales_and_services_1quotes_ida',
  'link' => 'quotes_sales_and_services_1',
  'table' => 'quotes',
  'module' => 'Quotes',
  'rname' => 'name',
);
$dictionary["sales_and_services"]["fields"]["quotes_sales_and_services_1quotes_ida"] = array (
  'name' => 'quotes_sales_and_services_1quotes_ida',
  'type' => 'id',
  'source' => 'non-db',
  'vname' => 'LBL_QUOTES_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE_ID',
  'id_name' => 'quotes_sales_and_services_1quotes_ida',
  'link' => 'quotes_sales_and_services_1',
  'table' => 'quotes',
  'module' => 'Quotes',
  'rname' => 'id',
  'reportable' => false,
  'side' => 'right',
  'massupdate' => false,
  'duplicate_merge' => 'disabled',
  'hideacl' => true,
);
