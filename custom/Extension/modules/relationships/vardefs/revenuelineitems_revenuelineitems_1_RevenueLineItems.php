<?php

// created: 2019-08-17 17:46:35
$dictionary["RevenueLineItem"]["fields"]["revenuelineitems_revenuelineitems_1"] = array(
    'name' => 'revenuelineitems_revenuelineitems_1',
    'type' => 'link',
    'relationship' => 'revenuelineitems_revenuelineitems_1',
    'source' => 'non-db',
    'module' => 'RevenueLineItems',
    'bean_name' => 'RevenueLineItem',
    'vname' => 'LBL_REVENUELINEITEMS_REVENUELINEITEMS_1_FROM_REVENUELINEITEMS_L_TITLE',
    'id_name' => 'revenuelineitems_revenuelineitems_1revenuelineitems_idb',
    'link-type' => 'many',
    'side' => 'left',
);
$dictionary["RevenueLineItem"]["fields"]["revenuelineitems_revenuelineitems_1_right"] = array(
    'name' => 'revenuelineitems_revenuelineitems_1_right',
    'type' => 'link',
    'relationship' => 'revenuelineitems_revenuelineitems_1',
    'source' => 'non-db',
    'module' => 'RevenueLineItems',
    'bean_name' => 'RevenueLineItem',
    'side' => 'right',
    'vname' => 'LBL_REVENUELINEITEMS_REVENUELINEITEMS_1_FROM_REVENUELINEITEMS_R_TITLE',
    'id_name' => 'revenuelineitems_revenuelineitems_1revenuelineitems_ida',
    'link-type' => 'one',
);
$dictionary["RevenueLineItem"]["fields"]["revenuelineitems_revenuelineitems_1_name"] = array(
    'name' => 'revenuelineitems_revenuelineitems_1_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_REVENUELINEITEMS_REVENUELINEITEMS_1_FROM_REVENUELINEITEMS_L_TITLE',
    'save' => true,
    'id_name' => 'revenuelineitems_revenuelineitems_1revenuelineitems_ida',
    'link' => 'revenuelineitems_revenuelineitems_1_right',
    'table' => 'revenue_line_items',
    'module' => 'RevenueLineItems',
    'rname' => 'name',
);
$dictionary["RevenueLineItem"]["fields"]["revenuelineitems_revenuelineitems_1revenuelineitems_ida"] = array(
    'name' => 'revenuelineitems_revenuelineitems_1revenuelineitems_ida',
    'type' => 'id',
    'source' => 'non-db',
    'vname' => 'LBL_REVENUELINEITEMS_REVENUELINEITEMS_1_FROM_REVENUELINEITEMS_R_TITLE_ID',
    'id_name' => 'revenuelineitems_revenuelineitems_1revenuelineitems_ida',
    'link' => 'revenuelineitems_revenuelineitems_1_right',
    'table' => 'revenue_line_items',
    'module' => 'RevenueLineItems',
    'rname' => 'id',
    'reportable' => false,
    'side' => 'right',
    'massupdate' => false,
    'duplicate_merge' => 'disabled',
    'hideacl' => true,
);
