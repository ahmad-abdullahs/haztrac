<?php

$viewdefs['sales_and_services']['base']['view']['recordlist']['rowactions']['actions'][] = array(
    'type' => 'divider',
);

$viewdefs['sales_and_services']['base']['view']['recordlist']['rowactions']['actions'][] = array(
    'type' => 'wordaction',
    'name' => 'download-word',
    'label' => 'LBL_DOWNLOAD_WORD_DOC',
    'action' => 'download',
    'acl_action' => 'view',
);

$viewdefs['sales_and_services']['base']['view']['recordlist']['rowactions']['actions'][] = array(
    'type' => 'wordaction',
    'name' => 'view-word',
    'label' => 'LBL_VIEW_WORD_DOC',
    'action' => 'email',
    'acl_action' => 'view',
);
