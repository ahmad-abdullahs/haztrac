<?php

$dictionary['WPM_Waste_Profile_Module']['fields']['proper_shipping_name'] = array(
    'labelValue' => 'DOT/TDG Proper Shipping Name',
    'full_text_search' =>
    array(
        'enabled' => '0',
        'boost' => '1',
        'searchable' => false,
    ),
    'required' => false,
    'name' => 'proper_shipping_name',
    'vname' => 'LBL_PROPER_SHIPPING_NAME',
    'type' => 'text',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'calculated' => false,
    'size' => '20',
    'studio' => 'visible',
    'rows' => '4',
    'cols' => '20',
);

$dictionary['WPM_Waste_Profile_Module']['fields']['erg_no'] = array(
    'labelValue' => 'ERG No',
    'required' => false,
    'name' => 'erg_no',
    'vname' => 'LBL_ERG_NO',
    'type' => 'varchar',
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
    'pii' => false,
    'calculated' => false,
    'len' => 4,
    'size' => '20',
);

$dictionary['WPM_Waste_Profile_Module']['fields']['manifest_additional_info'] = array(
    'labelValue' => 'Additional Info',
    'full_text_search' =>
    array(
        'enabled' => '0',
        'boost' => '1',
        'searchable' => false,
    ),
    'required' => false,
    'name' => 'manifest_additional_info',
    'vname' => 'LBL_MANIFEST_ADDITIONAL_INFO',
    'type' => 'varchar',
    'massupdate' => false,
    'no_default' => false,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'pii' => false,
    'calculated' => false,
    'len' => 50,
    'size' => '20',
);
