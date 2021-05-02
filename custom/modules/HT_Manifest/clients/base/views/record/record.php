<?php
$module_name = 'HT_Manifest';
$viewdefs[$module_name] = 
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
                'type' => 'shareaction',
                'name' => 'share',
                'label' => 'LBL_RECORD_SHARE_BUTTON',
                'acl_action' => 'view',
              ),
              2 => 
              array (
                'type' => 'pdfaction',
                'name' => 'download-pdf',
                'label' => 'LBL_PDF_VIEW',
                'action' => 'download',
                'acl_action' => 'view',
              ),
              3 => 
              array (
                'type' => 'pdfaction',
                'name' => 'email-pdf',
                'label' => 'LBL_PDF_EMAIL',
                'action' => 'email',
                'acl_action' => 'view',
              ),
              4 => 
              array (
                'type' => 'divider',
              ),
              5 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:find_duplicates_button:click',
                'name' => 'find_duplicates_button',
                'label' => 'LBL_DUP_MERGE',
                'acl_action' => 'edit',
              ),
              6 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:duplicate_button:click',
                'name' => 'duplicate_button',
                'label' => 'LBL_DUPLICATE_BUTTON_LABEL',
                'acl_module' => 'HT_Manifest',
                'acl_action' => 'create',
              ),
              7 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:audit_button:click',
                'name' => 'audit_button',
                'label' => 'LNK_VIEW_CHANGE_LOG',
                'acl_action' => 'view',
              ),
              8 => 
              array (
                'type' => 'divider',
              ),
              9 => 
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
            'label' => 'LBL_RECORD_HEADER',
            'header' => true,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'picture',
                'type' => 'avatar',
                'width' => 42,
                'height' => 42,
                'dismiss_label' => true,
                'readonly' => true,
              ),
              1 => 
              array (
                'name' => 'name',
                'related_fields' => 
                array (
                  0 => 'commentlog',
                ),
              ),
              2 => 
              array (
                'name' => 'favorite',
                'label' => 'LBL_FAVORITE',
                'type' => 'favorite',
                'readonly' => true,
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
            ),
          ),
          1 => 
          array (
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => true,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'status_c',
                'label' => 'LBL_STATUS',
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'manifest_no_actual_c',
                'label' => 'LBL_MANIFEST_NO_ACTUAL',
                'type' => 'manifest-no',
              ),
              3 => 
              array (
                'name' => 'consolidate_c',
                'label' => 'LBL_CONSOLIDATE',
              ),
              4 => 
              array (
                'name' => 'accounts_ht_manifest_1_name',
              ),
              5 => 
              array (
                'name' => 'start_date_c',
                'label' => 'LBL_START_DATE',
              ),
              6 => 
              array (
                'name' => 'state_codes_c',
                'label' => 'LBL_STATE_CODES',
              ),
              7 => 
              array (
                'name' => 'epa_codes_c',
                'label' => 'LBL_EPA_CODES',
              ),
              8 => 
              array (
                'name' => 'manifest_days',
                'label' => 'LBL_MANIFEST_DAYS',
              ),
              9 => 
              array (
                'name' => 'manifest_tenth_day_date',
                'label' => 'LBL_MANIFEST_TENTH_DAY_DATE',
              ),
              10 => 
              array (
                'name' => 'transporter',
                'type' => 'transporter',
                'label' => 'LBL_TRANSPORTER',
                'dismiss_label' => true,
                'span' => 12,
              ),
              11 => 
              array (
                'name' => 'designated_facility_c',
                'studio' => 'visible',
                'label' => 'LBL_DESIGNATED_FACILITY',
              ),
              12 => 
              array (
                'name' => 'complete_date_c',
                'label' => 'LBL_COMPLETE_DATE',
              ),
              13 => 'assigned_user_name',
              14 => 'team_name',
              15 => 
              array (
                'name' => 'accounts_ht_manifest_2_name',
              ),
              16 => 
              array (
                'name' => 'rli_galon_total',
                'comment' => 'Rollup of all RevenueLineItems linked to the manifest where product_uom_c is each galon (ea Gal)',
                'label' => 'LBL_RLI_GALON_TOTAL',
              ),
            ),
          ),
          2 => 
          array (
            'newTab' => false,
            'panelDefault' => 'collapsed',
            'name' => 'panel_preview',
            'label' => 'LBL_PANEL_PREVIEW',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'ht_manifest_preview_c',
                'label' => 'LBL_HT_MANIFEST_PREVIEW',
                'span' => 12,
              ),
            ),
          ),
          3 => 
          array (
            'newTab' => false,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL2',
            'label' => 'LBL_RECORDVIEW_PANEL2',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'multi_files',
                'label' => 'Attachments',
                'dismiss_label' => true,
                'type' => 'multi_file_widget',
                'linkField' => 'ht_manifest_mv_attachments',
                'relatedModule' => 'mv_Attachments',
                'columns' => 
                array (
                  0 => 
                  array (
                    'name' => 'uploadfile',
                    'label' => 'LBL_FILE_NAME_HEADER',
                    'type' => 'file',
                    'span' => 5,
                  ),
                  1 => 
                  array (
                    'name' => 'category_id',
                    'label' => 'LBL_FILE_TYPE_HEADER',
                    'type' => 'enum',
                    'span' => 2,
                  ),
                  2 => 
                  array (
                    'name' => 'description',
                    'label' => 'LBL_NOTES',
                    'type' => 'text',
                    'span' => 4,
                  ),
                ),
                'span' => 12,
              ),
            ),
          ),
          4 => 
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
                'name' => 'manifest_number',
                'readonly' => true,
                'label' => 'LBL_MANIFEST_NUMBER',
              ),
              1 => 
              array (
              ),
              2 => 
              array (
                'name' => 'description',
                'span' => 12,
              ),
              3 => 
              array (
                'name' => 'date_modified_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_MODIFIED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_modified',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'modified_by_name',
                  ),
                ),
              ),
              4 => 
              array (
                'name' => 'date_entered_by',
                'readonly' => true,
                'inline' => true,
                'type' => 'fieldset',
                'label' => 'LBL_DATE_ENTERED',
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_entered',
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_BY',
                  ),
                  2 => 
                  array (
                    'name' => 'created_by_name',
                  ),
                ),
              ),
            ),
          ),
          5 => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
            'name' => 'LBL_RECORDVIEW_PANEL1',
            'label' => 'LBL_RECORDVIEW_PANEL1',
            'columns' => 2,
            'labelsOnTop' => 1,
            'placeholders' => 1,
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'audit',
                'label' => 'Audit',
                'type' => 'audit-list-field',
                'relatedModule' => 'HT_Manifest',
                'readonly' => true,
                'columns' => 
                array (
                  0 => 
                  array (
                    'type' => 'field-name',
                    'name' => 'field_name',
                    'label' => 'Field',
                    'sortable' => true,
                    'width' => '20%',
                  ),
                  1 => 
                  array (
                    'type' => 'base',
                    'name' => 'before',
                    'label' => 'Old Value',
                    'sortable' => false,
                    'width' => '20%',
                  ),
                  2 => 
                  array (
                    'type' => 'base',
                    'name' => 'after',
                    'label' => 'New Value',
                    'sortable' => false,
                    'width' => '20%',
                  ),
                  3 => 
                  array (
                    'type' => 'base',
                    'name' => 'created_by_username',
                    'label' => 'Changed By',
                    'sortable' => true,
                    'width' => '10%',
                  ),
                  4 => 
                  array (
                    'type' => 'source',
                    'name' => 'source',
                    'label' => 'Source',
                    'sortable' => false,
                    'width' => '10%',
                    'module' => 'Users',
                    'link' => true,
                  ),
                  5 => 
                  array (
                    'type' => 'datetimecombo',
                    'name' => 'date_created',
                    'label' => 'Change Date',
                    'options' => 'date_range_search_dom',
                    'sortable' => true,
                    'width' => '20%',
                  ),
                ),
                'relatedFields' => 
                array (
                ),
                'allowedFieldList' => 
                array (
                ),
                'span' => 12,
              ),
            ),
          ),
        ),
        'templateMeta' => 
        array (
          'useTabs' => true,
        ),
      ),
    ),
  ),
);
