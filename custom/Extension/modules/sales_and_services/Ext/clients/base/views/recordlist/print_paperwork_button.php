<?php

$viewdefs['sales_and_services']['base']['view']['recordlist']['rowactions']['actions'][] = array(
    'type' => 'divider',
);

$viewdefs['sales_and_services']['base']['view']['recordlist']['rowactions']['actions'][] = array(
    'type' => 'print-paperwork-rowaction',
    'name' => 'print_paperwork_button',
    'label' => 'LBL_PRINT_PAPERWORK',
    'acl_action' => 'edit',
);
