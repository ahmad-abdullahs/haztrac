<?php

$dictionary["LR_Lab_Reports"]['fields']['lr_lab_reports_mv_attachments'] = array(
    'name' => 'lr_lab_reports_mv_attachments',
    'type' => 'link',
    'relationship' => 'lr_lab_reports_mv_attachments',
    'module' => 'mv_Attachments',
    'bean_name' => 'mv_Attachments',
    'source' => 'non-db',
    'vname' => 'LBL_MV_ATTACHMENTS',
);

$dictionary["LR_Lab_Reports"]['relationships']['lr_lab_reports_mv_attachments'] = array(
    'lhs_module' => 'LR_Lab_Reports',
    'lhs_table' => 'lr_lab_reports',
    'lhs_key' => 'id',
    'rhs_module' => 'mv_Attachments',
    'rhs_table' => 'mv_attachments',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'LR_Lab_Reports',
);

$dictionary["LR_Lab_Reports"]["fields"]["multi_files"] = array(
    'name' => 'multi_files',
    'type' => 'multi_file_widget',
    'source' => 'non-db',
);
