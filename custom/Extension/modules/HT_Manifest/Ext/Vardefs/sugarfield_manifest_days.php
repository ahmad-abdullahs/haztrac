<?php

$dictionary['HT_Manifest']['fields']['manifest_days'] = array(
    'name' => 'manifest_days',
    'vname' => 'LBL_MANIFEST_DAYS',
    'type' => 'varchar',
    'formula' => 'ifElse(equal($complete_date_c,""),floor(multiply(daysUntil($start_date_c),-1)),$manifest_days)',
    'labelValue' => 'Days',
    'calculated' => '1',
    'enforced' => '1',
    'dependency' => '',
    'required' => false,
    'massupdate' => false,
    'no_default' => false,
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 255,
    'size' => '20',
    'duplicate_merge_dom_value' => 0,
    'full_text_search' =>
    array(
        'enabled' => '0',
        'boost' => '1',
        'searchable' => false,
    ),
);
