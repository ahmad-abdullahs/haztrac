<?php

$dictionary['mv_Attachments']['fields']['file_ext'] = array(
    'name' => 'file_ext',
    'vname' => 'LBL_FILE_EXTENSION',
    'type' => 'varchar',
    'len' => '100',
    'duplicate_on_record_copy' => 'always',
    'audited' => false,
    'massupdate' => false,
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'merge_filter' => 'disabled',
    'unified_search' => false,
    'full_text_search' =>
    array(
        'enabled' => '0',
        'boost' => '1',
        'searchable' => false,
    ),
    'calculated' => false,
);
