<?php

$dictionary['mv_Attachments']['fields']['category_id'] = array(
    'name' => 'category_id',
    'vname' => 'LBL_SF_CATEGORY',
    'type' => 'enum',
    'len' => 100,
    'options' => 'cst_document_type_list',
    'reportable' => true,
    'duplicate_on_record_copy' => 'always',
    'audited' => false,
    'massupdate' => true,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => '1',
    'merge_filter' => 'disabled',
    'unified_search' => false,
    'calculated' => false,
    'dependency' => false,
    'required' => true,
);
