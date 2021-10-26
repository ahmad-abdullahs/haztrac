<?php

$dictionary["HRM_Employee_Info"]["fields"]["employee_id_num"] = array(
    'name' => 'employee_id_num',
    'vname' => 'LBL_EMPLOYEE_ID_NUM',
    'type' => 'varchar',
    'readonly' => true,
    'required' => false,
    'massupdate' => false,
    'no_default' => false,
    'duplicate_merge' => 'enabled',
    'duplicate_merge_dom_value' => 1,
    'audited' => false,
    'reportable' => true,
    'unified_search' => false,
    'merge_filter' => 'disabled',
    'len' => 9,
    'size' => '20',
    'full_text_search' => array(
        'enabled' => '0',
        'boost' => '1',
        'searchable' => false,
    ),
);
