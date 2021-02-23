<?php
$viewdefs['HT_Assets_and_Objects'] = 
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
                'acl_module' => 'HT_Assets_and_Objects',
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
              1 => 'name',
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
                'name' => 'asset_number',
                'readonly' => true,
                'comment' => 'Visual unique identifier',
                'studio' => 
                array (
                  'quickcreate' => false,
                ),
                'label' => 'LBL_ASSET_NUMBER',
              ),
              1 => 
              array (
                'name' => 'operational_status_c',
                'label' => 'LBL_OPERATIONAL_STATUS',
              ),
              2 => 
              array (
                'name' => 'asset_object_marking_no_c',
                'label' => 'LBL_ASSET_OBJECT_MARKING_NO',
              ),
              3 => 
              array (
                'name' => 'fuel_type_c',
                'label' => 'LBL_FUEL_TYPE',
              ),
              4 => 
              array (
                'name' => 'asset_type_c',
                'label' => 'LBL_ASSET_TYPE',
              ),
              5 => 
              array (
                'name' => 'make_c',
                'label' => 'LBL_MAKE',
              ),
              6 => 
              array (
                'name' => 'model_year_c',
                'label' => 'LBL_MODEL_YEAR',
              ),
              7 => 
              array (
                'name' => 'model_c',
                'label' => 'LBL_MODEL',
              ),
              8 => 
              array (
                'name' => 'serial_vin_c',
                'label' => 'LBL_SERIAL_VIN',
              ),
              9 => 
              array (
                'name' => 'license_number_c',
                'label' => 'LBL_LICENSE_NUMBER',
              ),
              10 => 
              array (
                'name' => 'object_no_c',
                'label' => 'LBL_OBJECT_NO',
              ),
              11 => 
              array (
                'name' => 'ins_exp_c',
                'label' => 'LBL_INS_EXP',
              ),
              12 => 'assigned_user_name',
              13 => 'team_name',
              14 => 
              array (
                'name' => 'weight_gvw_lb_c',
                'label' => 'LBL_WEIGHT_GVW_LB',
              ),
              15 => 
              array (
                'name' => 'weight_tare_lb_c',
                'label' => 'LBL_WEIGHT_TARE_LB',
              ),
              16 => 
              array (
                'name' => 'weight_load_limit_c',
                'label' => 'LBL_WEIGHT_LOAD_LIMIT',
              ),
              17 => 
              array (
                'name' => 'asset_location_c',
                'studio' => 'visible',
                'label' => 'LBL_ASSET_LOCATION',
              ),
              18 => 
              array (
                'name' => 'volume_gallons_c',
                'label' => 'LBL_VOLUME_GALLONS',
              ),
              19 => 
              array (
                'name' => 'volume_bbl_c',
                'label' => 'LBL_VOLUME_BBL',
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
                'name' => 'description',
                'span' => 12,
              ),
              1 => 
              array (
                'name' => 'commentlog',
                'displayParams' => 
                array (
                  'type' => 'commentlog',
                  'fields' => 
                  array (
                    0 => 'entry',
                    1 => 'date_entered',
                    2 => 'created_by_name',
                  ),
                  'max_num' => 100,
                ),
                'studio' => 
                array (
                  'listview' => false,
                  'recordview' => true,
                ),
                'label' => 'LBL_COMMENTLOG',
              ),
              2 => 
              array (
              ),
              3 => 
              array (
                'name' => 'tag',
                'span' => 12,
              ),
              4 => 
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
              5 => 
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
          3 => 
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
                'name' => 'picture_c',
                'studio' => 'visible',
                'label' => 'LBL_PICTURE',
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
