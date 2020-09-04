<?php
$viewdefs['KBContents'] = 
array (
  'base' => 
  array (
    'view' => 
    array (
      'record' => 
      array (
        'buttons' => 
        array (
          0 => 
          array (
            'type' => 'button',
            'name' => 'cancel_button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'showOn' => 'edit',
            'events' => 
            array (
              'click' => 'button:cancel_button:click',
            ),
          ),
          1 => 
          array (
            'type' => 'rowaction',
            'event' => 'button:save_button:click',
            'name' => 'save_button',
            'label' => 'LBL_SAVE_BUTTON_LABEL',
            'css_class' => 'btn btn-primary',
            'showOn' => 'edit',
            'acl_action' => 'edit',
          ),
          2 => 
          array (
            'type' => 'actiondropdown',
            'name' => 'main_dropdown',
            'primary' => true,
            'showOn' => 'view',
            'buttons' => 
            array (
              0 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:edit_button:click',
                'name' => 'edit_button',
                'label' => 'LBL_EDIT_BUTTON_LABEL',
                'acl_action' => 'edit',
              ),
              1 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:create_localization_button:click',
                'name' => 'create_localization_button',
                'label' => 'LBL_CREATE_LOCALIZATION_BUTTON_LABEL',
                'acl_action' => 'edit',
              ),
              2 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:create_revision_button:click',
                'name' => 'create_revision_button',
                'label' => 'LBL_CREATE_REVISION_BUTTON_LABEL',
                'acl_action' => 'edit',
              ),
              3 => 
              array (
                'type' => 'divider',
              ),
              4 => 
              array (
                'type' => 'shareaction',
                'name' => 'share',
                'label' => 'LBL_RECORD_SHARE_BUTTON',
                'acl_action' => 'view',
              ),
              5 => 
              array (
                'type' => 'pdfaction',
                'name' => 'download-pdf',
                'label' => 'LBL_PDF_VIEW',
                'action' => 'download',
                'acl_action' => 'view',
              ),
              6 => 
              array (
                'type' => 'pdfaction',
                'name' => 'email-pdf',
                'label' => 'LBL_PDF_EMAIL',
                'action' => 'email',
                'acl_action' => 'view',
              ),
              7 => 
              array (
                'type' => 'divider',
              ),
              8 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:duplicate_button:click',
                'name' => 'duplicate_button',
                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                'acl_module' => 'KBContents',
                'acl_action' => 'create',
              ),
              9 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              10 => 
              array (
                'type' => 'divider',
              ),
              11 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:delete_button:click',
                'name' => 'delete_button',
                'label' => 'LBL_DELETE_BUTTON_LABEL',
                'acl_action' => 'delete',
              ),
            ),
          ),
          3 => 
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
            'label' => 'LBL_PANEL_HEADER',
            'header' => true,
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
                  3 => 'kbdocument_id',
                ),
              ),
              2 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
                'dismiss_label' => true,
              ),
              3 => 
              array (
                'name' => 'follow',
                'label' => 'LBL_FOLLOW',
                'type' => 'follow',
                'readonly' => true,
                'dismiss_label' => true,
              ),
              'status' => 
              array (
                'name' => 'status',
                'type' => 'status',
                'enum_width' => 'auto',
                'dropdown_width' => 'auto',
                'dropdown_class' => 'select2-menu-only',
                'container_class' => 'select2-menu-only',
                'related_fields' => 
                array (
                  0 => 'active_date',
                  1 => 'exp_date',
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
                'name' => 'is_external',
                'type' => 'bool',
              ),
              1 => 
              array (
                'name' => 'enable_wireframe_c',
                'label' => 'LBL_ENABLE_WIREFRAME',
              ),
              2 => 
              array (
                'name' => 'link_only_c',
                'label' => 'LBL_LINK_ONLY',
              ),
              3 => 
              array (
                'name' => 'link_only_website_c',
                'label' => 'LBL_LINK_ONLY_WEBSITE',
              ),
              4 => 
              array (
                'name' => 'website_c',
                'label' => 'LBL_WEBSITE',
                'span' => 12,
              ),
              5 => 
              array (
                'name' => 'kbdocument_body_set',
                'type' => 'fieldset',
                'label' => 'LBL_TEXT_BODY',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'template',
                    'type' => 'template-button',
                    'icon' => 'fa-file-o',
                    'css_class' => 'pull-right load-template',
                    'label' => 'LBL_TEMPLATES',
                  ),
                  1 => 
                  array (
                    'name' => 'kbdocument_body',
                    'type' => 'htmleditable_tinymce',
                    'dismiss_label' => false,
                    'fieldSelector' => 'kbdocument_body',
                  ),
                ),
                'span' => 12,
              ),
              6 => 
              array (
                'name' => 'attachment_list',
                'label' => 'LBL_ATTACHMENTS',
                'type' => 'attachments',
                'link' => 'attachments',
                'module' => 'Notes',
                'modulefield' => 'filename',
                'bLabel' => 'LBL_ADD_ATTACHMENT',
                'span' => 12,
              ),
              7 => 
              array (
                'name' => 'tag',
                'span' => 6,
              ),
              8 => 
              array (
                'name' => 'hrm_employee_training_kbcontents_1_name',
                'span' => 6,
              ),
            ),
          ),
          2 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_SHOW_MORE',
            'hide' => true,
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'language',
                'type' => 'enum-config',
                'key' => 'languages',
                'readonly' => false,
              ),
              1 => 
              array (
                'name' => 'revision',
                'readonly' => true,
              ),
              2 => 
              array (
                'name' => 'category_name',
                'label' => 'LBL_CATEGORY_NAME',
                'initial_filter' => 'by_category',
                'initial_filter_label' => 'LBL_FILTER_CREATE_NEW',
                'filter_relate' => 
                array (
                  'category_id' => 'category_id',
                ),
              ),
              3 => 
              array (
                'name' => 'active_rev',
                'type' => 'bool',
              ),
              4 => 
              array (
                'name' => 'viewcount',
              ),
              5 => 
              array (
                'name' => 'team_name',
              ),
              6 => 
              array (
                'name' => 'assigned_user_name',
              ),
              7 => 
              array (
              ),
              8 => 
              array (
                'name' => 'date_entered',
              ),
              9 => 
              array (
                'name' => 'created_by_name',
              ),
              10 => 
              array (
                'name' => 'date_modified',
              ),
              11 => 
              array (
                'name' => 'kbsapprover_name',
              ),
              12 => 
              array (
                'name' => 'active_date',
              ),
              13 => 
              array (
                'name' => 'kbscase_name',
              ),
              14 => 
              array (
                'name' => 'exp_date',
              ),
              15 => 
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
