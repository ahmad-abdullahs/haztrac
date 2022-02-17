<?php
// Commented because:
// 1- These buttons were not appearing on the list view.
// 2- they were making 2 API calls per record on the list view (40 calls for default 20 record).
// 3- It make the list view too slow, unstable and logout problem often.
 
//$viewdefs['sales_and_services']['base']['view']['recordlist']['rowactions']['actions'][] = array(
//    'type' => 'divider',
//);
//
//$viewdefs['sales_and_services']['base']['view']['recordlist']['rowactions']['actions'][] = array(
//    'type' => 'wordaction',
//    'name' => 'download-word',
//    'label' => 'LBL_DOWNLOAD_WORD_DOC',
//    'action' => 'download',
//    'acl_action' => 'view',
//);
//
//$viewdefs['sales_and_services']['base']['view']['recordlist']['rowactions']['actions'][] = array(
//    'type' => 'wordaction',
//    'name' => 'view-word',
//    'label' => 'LBL_VIEW_WORD_DOC',
//    'action' => 'email',
//    'acl_action' => 'view',
//);
