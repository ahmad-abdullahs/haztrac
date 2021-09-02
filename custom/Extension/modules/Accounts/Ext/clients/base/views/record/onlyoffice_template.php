<?php

$viewdefs['Accounts']['base']['view']['record']['buttons'][3]['buttons'][] = array(
    'type' => 'divider',
);

$viewdefs['Accounts']['base']['view']['record']['buttons'][3]['buttons'][] = array(
    'type' => 'onlyoffice-action',
    'name' => 'download-onlyoffice',
    'label' => 'LBL_DOWNLOAD_WORD_DOC',
    'action' => 'download',
    'acl_action' => 'view',
);
