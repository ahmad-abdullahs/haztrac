<?php

$dictionary["HT_Manifest"]['fields']['ht_manifest_mv_attachments'] = array(
    'name' => 'ht_manifest_mv_attachments',
    'type' => 'link',
    'relationship' => 'ht_manifest_mv_attachments',
    'module' => 'mv_Attachments',
    'bean_name' => 'mv_Attachments',
    'source' => 'non-db',
    'vname' => 'LBL_MV_ATTACHMENTS',
);

$dictionary["HT_Manifest"]['relationships']['ht_manifest_mv_attachments'] = array(
    'lhs_module' => 'HT_Manifest',
    'lhs_table' => 'ht_manifest',
    'lhs_key' => 'id',
    'rhs_module' => 'mv_Attachments',
    'rhs_table' => 'mv_attachments',
    'rhs_key' => 'parent_id',
    'relationship_type' => 'one-to-many',
    'relationship_role_column' => 'parent_type',
    'relationship_role_column_value' => 'HT_Manifest',
);

$dictionary["HT_Manifest"]["fields"]["multi_files"] = array(
    'name' => 'multi_files',
    'type' => 'multi_file_widget',
    'source' => 'non-db',
);
