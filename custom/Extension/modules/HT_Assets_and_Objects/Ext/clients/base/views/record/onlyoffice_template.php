<?php

$viewdefs['HT_Assets_and_Objects']['base']['view']['record']['buttons'][2]['buttons'][] = array(
    'type' => 'divider',
);

$viewdefs['HT_Assets_and_Objects']['base']['view']['record']['buttons'][2]['buttons'][] = array(
    'type' => 'onlyoffice-action',
    'name' => 'download-onlyoffice',
    'label' => 'LBL_DOWNLOAD_WORD_DOC',
    'action' => 'download',
    'acl_action' => 'view',
);
