<?php

$viewdefs['sales_and_services']['base']['view']['record']['buttons'][2]['buttons'][] = array(
    'type' => 'divider',
);

$viewdefs['sales_and_services']['base']['view']['record']['buttons'][2]['buttons'][] = array(
    'type' => 'wordaction',
    'name' => 'download-word',
    'label' => 'LBL_DOWNLOAD_WORD_DOC',
    'action' => 'download',
    'acl_action' => 'view',
);

$viewdefs['sales_and_services']['base']['view']['record']['buttons'][2]['buttons'][] = array(
    'type' => 'wordaction',
    'name' => 'view-word',
    'label' => 'LBL_VIEW_WORD_DOC',
    'action' => 'email',
    'acl_action' => 'view',
);
