<?php
$viewdefs['KBContents'] = 
array (
  'portal' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'buttons' => 
        array (
          0 => 
          array (
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
          ),
        ),
        'panels' => 
        array (
          0 => 
          array (
            'name' => 'panel_header',
            'header' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'label' => 'LBL_RECORD_HEADER',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'size' => 'large',
                'dismiss_label' => true,
                'readonly' => true,
              ),
              1 => 
              array (
                'name' => 'name',
                'related_fields' => 
                array (
                  0 => 'useful',
                  1 => 'notuseful',
                  2 => 'usefulness_user_vote',
                ),
              ),
            ),
          ),
          1 => 
          array (
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'kbdocument_body',
                'type' => 'html',
                'span' => 12,
              ),
              1 => 
              array (
                'name' => 'attachment_list',
                'label' => 'LBL_ATTACHMENTS',
                'type' => 'attachments',
                'link' => 'attachments',
                'module' => 'Notes',
                'modulefield' => 'filename',
                'bLable' => 'LBL_ADD_ATTACHMENT',
                'bIcon' => 'fa-paperclip',
                'span' => 12,
              ),
              2 => 
              array (
                'name' => 'category_name',
                'label' => 'LBL_CATEGORY_NAME',
              ),
              3 => 
              array (
                'name' => 'language',
                'type' => 'enum-config',
                'key' => 'languages',
              ),
              4 => 
              array (
                'name' => 'active_date',
              ),
              5 => 
              array (
              ),
            ),
          ),
        ),
        'moreLessInlineFields' => 
        array (
          'usefulness' => 
          array (
            'name' => 'usefulness',
            'type' => 'usefulness',
            'span' => 6,
            'cell_css_class' => 'pull-right usefulness',
            'readonly' => true,
            'fields' => 
            array (
              0 => 'usefulness_user_vote',
              1 => 'useful',
              2 => 'notuseful',
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => false,
        ),
      ),
    ),
  ),
);
