<?php

$dictionary['ProductTemplate']['fields']['product_vendor_c'] = array(
    'labelValue' => 'Product Vendor / TSDF',
    'dependency' => '',
    'required' => false,
    'source' => 'non-db',
    'name' => 'product_vendor_c',
    'vname' => 'LBL_PRODUCT_VENDOR',
    'type' => 'relate',
    'link' => 'product_templates_accounts',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'audited' => true,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 255,
    'size' => '20',
    'id_name' => 'v_vendors_id_c',
    'module' => 'Accounts',
    'rname' => 'name',
    'studio' => 'visible',
);

$dictionary['ProductTemplate']['fields']['product_templates_accounts'] = array(
    'name' => 'product_templates_accounts',
    'type' => 'link',
    'relationship' => 'product_templates_accounts',
    'module' => 'Accounts',
    'bean_name' => 'Account',
    'source' => 'non-db',
    'vname' => 'LBL_ACCOUNTS',
);

$dictionary['ProductTemplate']['relationships']['product_templates_accounts'] = array(
    'lhs_module' => 'Accounts',
    'lhs_table' => 'accounts',
    'lhs_key' => 'id',
    'rhs_module' => 'ProductTemplates',
    'rhs_table' => 'product_templates',
    'rhs_key' => 'v_vendors_id_c',
    'relationship_type' => 'one-to-many',
);
