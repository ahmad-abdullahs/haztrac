<?php

$dictionary["mv_Attachments"]["fields"]["signed_copy"] = array(
    'name' => 'signed_copy',
    'vname' => 'LBL_SIGNED_COPY',
    'type' => 'bool',
    'default' => '0',
    'reportable' => true,
    'readonly' => true,
);

$dictionary["mv_Attachments"]["fields"]["analysis_date"] = array(
    'name' => 'analysis_date',
    'vname' => 'LBL_ANALYSIS_DATE',
    'type' => 'date',
    'importable' => false,
);

$dictionary["mv_Attachments"]["fields"]["lab_ref_number"] = array(
    'name' => 'lab_ref_number',
    'vname' => 'LBL_LAB_REF_NUMBER',
    'type' => 'varchar',
    'len' => '100',
    'duplicate_on_record_copy' => 'always',
);
