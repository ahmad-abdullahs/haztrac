<?php

$dictionary['HT_Manifest']['fields']['manifest_tenth_day_date'] = array(
    'name' => 'manifest_tenth_day_date',
    'vname' => 'LBL_MANIFEST_TENTH_DAY_DATE',
    'type' => 'date',
    'formula' => 'ifElse(not(equal($start_date_c,"")),addDays($start_date_c,9),"")',
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
    'size' => '20',
    'duplicate_merge_dom_value' => 0,
    'full_text_search' =>
    array(
        'enabled' => '0',
        'boost' => '1',
        'searchable' => false,
    ),
);
