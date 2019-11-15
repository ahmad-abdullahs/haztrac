<?php

$viewdefs['sales_and_services']['base']['view']['recordlist']['rowactions']['actions'][] = array(
    'type' => 'divider',
);

$viewdefs['sales_and_services']['base']['view']['recordlist']['rowactions']['actions'][] = array(
    'type' => 'complete-sale-rowaction',
    'name' => 'complete_sale_button',
    'label' => 'LBL_COMPLETE_SALE',
    'acl_action' => 'edit',
);
