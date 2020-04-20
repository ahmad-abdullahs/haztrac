<?php

// created: 2019-05-16 00:59:17
$dictionary["RevenueLineItem"]["fields"]["ht_manifest_revenuelineitems_1"] = array(
    'name' => 'ht_manifest_revenuelineitems_1',
    'type' => 'link',
    'relationship' => 'ht_manifest_revenuelineitems_1',
    'source' => 'non-db',
    'module' => 'HT_Manifest',
    'bean_name' => 'HT_Manifest',
    'side' => 'right',
    'vname' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_REVENUELINEITEMS_TITLE',
    'id_name' => 'ht_manifest_revenuelineitems_1ht_manifest_ida',
    'link-type' => 'one',
);

$dictionary["RevenueLineItem"]["fields"]["ht_manifest_revenuelineitems_1_name"] = array(
    'name' => 'ht_manifest_revenuelineitems_1_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_HT_MANIFEST_TITLE',
    'save' => true,
    'id_name' => 'ht_manifest_revenuelineitems_1ht_manifest_ida',
    'link' => 'ht_manifest_revenuelineitems_1',
    'table' => 'ht_manifest',
    'module' => 'HT_Manifest',
    'rname' => 'manifest_no_actual_c',
    'dependency' => 'not(equal($is_bundle_product_c,"parent"))',
    'initial_filter' => 'filterByManifestStatus',
    'initial_filter_label' => 'LBL_FILTER_BY_MANIFEST_STATUS',
    'filter_relate' => array(
        'parent' => 'status_c'
    ),
);

$dictionary["RevenueLineItem"]["fields"]["ht_manifest_revenuelineitems_1ht_manifest_ida"] = array(
    'name' => 'ht_manifest_revenuelineitems_1ht_manifest_ida',
    'type' => 'id',
    'source' => 'non-db',
    'vname' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_REVENUELINEITEMS_TITLE_ID',
    'id_name' => 'ht_manifest_revenuelineitems_1ht_manifest_ida',
    'link' => 'ht_manifest_revenuelineitems_1',
    'table' => 'ht_manifest',
    'module' => 'HT_Manifest',
    'rname' => 'id',
    'reportable' => false,
    'side' => 'right',
    'massupdate' => false,
    'duplicate_merge' => 'disabled',
    'hideacl' => true,
    'dependency' => 'not(equal($is_bundle_product_c,"parent"))',
);
