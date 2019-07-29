<?php
 // created: 2019-06-26 10:22:20
$dictionary['Account']['fields']['role_assigned'] = array(
    'massupdate' => false,
    'name' => 'role_assigned',
    'type' => 'enum',
    'studio' => 'false',
    'source' => 'non-db',
    'vname' => 'LBL_ROLE',
    'options' => 'account_role_list',
    'importable' => 'false',
    'link' => 'lr_lab_reports_accounts',
    'rname_link' => 'role',
);