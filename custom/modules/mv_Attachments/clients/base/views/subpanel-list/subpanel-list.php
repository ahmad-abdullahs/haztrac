<?php

$viewdefs['mv_Attachments']['base']['view']['subpanel-list'] = array(
  'panels' => 
  array(
    array(
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' => 
      array(
        array(
          'name' => 'document_name',
          'label' => 'LBL_LIST_DOCUMENT_NAME',
          'enabled' => true,
          'default' => true,
          'link' => true,
        ),
        array (
          'name' => 'uploadfile',
          'type' => 'cstm-file',
          'label' => 'LBL_FILE_UPLOAD',
          'enabled' => true,
          'default' => true,
        ),
        array(
          'name' => 'active_date',
          'label' => 'LBL_DOC_ACTIVE_DATE',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
);
