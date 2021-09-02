<?php

$viewdefs['sales_and_services']['base']['view']['record']['buttons'][3]['buttons'][] = array(
    'type' => 'divider',
);

$viewdefs['sales_and_services']['base']['view']['record']['buttons'][3]['buttons'][] = array(
    'type' => 'divider',
);

$viewdefs['sales_and_services']['base']['view']['record']['buttons'][3]['buttons'][] = array(
    'type' => 'onlyoffice-action',
    'name' => 'download-onlyoffice',
    'label' => 'LBL_DOWNLOAD_WORD_DOC',
    'action' => 'download',
    'acl_action' => 'view',
);
