<?php
$viewdefs['Meetings'] = 
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
            'type' => 'actiondropdown',
            'name' => 'save_dropdown',
            'primary' => true,
            'switch_on_click' => true,
            'showOn' => 'edit',
            'buttons' => 
            array (
              0 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:save_button:click',
                'name' => 'save_button',
                'label' => 'LBL_SAVE_BUTTON_LABEL',
                'css_class' => 'btn btn-primary',
                'acl_action' => 'edit',
              ),
              1 => 
              array (
                'type' => 'save-and-send-invites-button',
                'event' => 'button:save_button:click',
                'name' => 'save_invite_button',
                'label' => 'LBL_SAVE_AND_SEND_INVITES_BUTTON',
                'acl_action' => 'edit',
              ),
            ),
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
                'type' => 'editrecurrencesbutton',
                'event' => 'button:edit_recurrence_button:click',
                'name' => 'edit_recurrence_button',
                'label' => 'LBL_EDIT_ALL_RECURRENCES',
                'acl_action' => 'edit',
              ),
              2 => 
              array (
                'type' => 'launchbutton',
                'name' => 'host_button',
                'host' => true,
                'acl_action' => 'view',
              ),
              3 => 
              array (
                'type' => 'launchbutton',
                'name' => 'join_button',
                'acl_action' => 'view',
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
                'acl_module' => 'Meetings',
                'acl_action' => 'create',
              ),
              9 => 
              array (
                'type' => 'divider',
              ),
              10 => 
              array (
                'type' => 'rowaction',
                'event' => 'button:delete_button:click',
                'name' => 'delete_button',
                'label' => 'LBL_DELETE_BUTTON_LABEL',
                'acl_action' => 'delete',
              ),
              11 => 
              array (
                'type' => 'deleterecurrencesbutton',
                'name' => 'delete_recurrence_button',
                'label' => 'LBL_REMOVE_ALL_RECURRENCES',
                'acl_action' => 'delete',
              ),
              12 => 
              array (
                'type' => 'closebutton',
                'name' => 'record-close-new',
                'label' => 'LBL_CLOSE_AND_CREATE_BUTTON_LABEL',
                'closed_status' => 'Held',
                'acl_action' => 'edit',
              ),
              13 => 
              array (
                'type' => 'closebutton',
                'name' => 'record-close',
                'label' => 'LBL_CLOSE_BUTTON_LABEL',
                'closed_status' => 'Held',
                'acl_action' => 'edit',
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
              4 => 
              array (
                'name' => 'status',
                'type' => 'event-status',
                'enum_width' => 'auto',
                'dropdown_width' => 'auto',
                'dropdown_class' => 'select2-menu-only',
                'container_class' => 'select2-menu-only',
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
                'name' => 'duration',
                'type' => 'duration',
                'label' => 'LBL_START_AND_END_DATE_DETAIL_VIEW',
                'dismiss_label' => true,
                'inline' => true,
                'show_child_labels' => true,
                'fields' => 
                array (
                  0 => 
                  array (
                    'name' => 'date_start',
                    'time' => 
                    array (
                      'step' => 15,
                    ),
                    'readonly' => false,
                  ),
                  1 => 
                  array (
                    'type' => 'label',
                    'default_value' => 'LBL_START_AND_END_DATE_TO',
                  ),
                  2 => 
                  array (
                    'name' => 'date_end',
                    'time' => 
                    array (
                      'step' => 15,
                      'duration' => 
                      array (
                        'relative_to' => 'date_start',
                      ),
                    ),
                    'readonly' => false,
                  ),
                ),
                'related_fields' => 
                array (
                  0 => 'duration_hours',
                  1 => 'duration_minutes',
                ),
                'span' => 9,
              ),
              1 => 
              array (
                'name' => 'repeat_type',
                'related_fields' => 
                array (
                  0 => 'repeat_parent_id',
                ),
                'span' => 3,
              ),
              2 => 
              array (
                'name' => 'recurrence',
                'type' => 'recurrence',
                'inline' => true,
                'show_child_labels' => true,
                'fields' => 
                array (
                  0 => 
                  array (
                    'label' => 'LBL_CALENDAR_REPEAT_INTERVAL',
                    'name' => 'repeat_interval',
                    'type' => 'enum',
                    'options' => 'repeat_interval_number',
                    'required' => true,
                    'default' => 1,
                  ),
                  1 => 
                  array (
                    'label' => 'LBL_CALENDAR_REPEAT_DOW',
                    'name' => 'repeat_dow',
                    'type' => 'repeat-dow',
                    'options' => 'dom_cal_day_of_week',
                    'isMultiSelect' => true,
                  ),
                  2 => 
                  array (
                    'label' => 'LBL_CALENDAR_CUSTOM_DATE',
                    'name' => 'repeat_selector',
                    'type' => 'enum',
                    'options' => 'repeat_selector_dom',
                    'default' => 'None',
                  ),
                  3 => 
                  array (
                    'name' => 'repeat_days',
                    'type' => 'repeat-days',
                    'options' => 
                    array (
                      '' => '',
                    ),
                    'isMultiSelect' => true,
                    'dropdown_class' => 'recurring-date-dropdown',
                    'container_class' => 'recurring-date-container select2-choices-pills-close',
                  ),
                  4 => 
                  array (
                    'label' => ' ',
                    'name' => 'repeat_ordinal',
                    'type' => 'enum',
                    'options' => 'repeat_ordinal_dom',
                  ),
                  5 => 
                  array (
                    'label' => ' ',
                    'name' => 'repeat_unit',
                    'type' => 'enum',
                    'options' => 'repeat_unit_dom',
                  ),
                  6 => 
                  array (
                    'label' => 'LBL_CALENDAR_REPEAT',
                    'name' => 'repeat_end_type',
                    'type' => 'enum',
                    'options' => 'repeat_end_types',
                    'default' => 'Until',
                  ),
                  7 => 
                  array (
                    'label' => 'LBL_CALENDAR_REPEAT_UNTIL_DATE',
                    'name' => 'repeat_until',
                    'type' => 'repeat-until',
                  ),
                  8 => 
                  array (
                    'label' => 'LBL_CALENDAR_REPEAT_COUNT',
                    'name' => 'repeat_count',
                    'type' => 'repeat-count',
                  ),
                ),
                'span' => 12,
              ),
              3 => 'location',
              4 => 
              array (
                'name' => 'reminders',
                'type' => 'fieldset',
                'inline' => true,
                'equal_spacing' => true,
                'show_child_labels' => true,
                'fields' => 
                array (
                  0 => 'reminder_time',
                  1 => 'email_reminder_time',
                ),
              ),
              5 => 
              array (
                'name' => 'description',
                'rows' => 3,
                'span' => 12,
              ),
              6 => 
              array (
                'name' => 'type',
              ),
              7 => 'parent_name',
              8 => 
              array (
                'name' => 'password',
                'span' => 12,
              ),
              9 => 
              array (
                'name' => 'invitees',
                'type' => 'participants',
                'label' => 'LBL_INVITEES',
                'fields' => 
                array (
                  0 => 'name',
                  1 => 'accept_status_meetings',
                  2 => 'picture',
                  3 => 'email',
                ),
                'related_fields' => 
                array (
                  0 => 'date_start',
                  1 => 'date_end',
                  2 => 'duration_hours',
                  3 => 'duration_minutes',
                ),
                'max_num' => 20,
                'span' => 12,
              ),
              10 => 'assigned_user_name',
              11 => 'team_name',
              12 => 
              array (
                'name' => 'tag',
                'span' => 12,
              ),
            ),
          ),
          2 => 
          array (
            'newTab' => false,
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
                'span' => 12,
              ),
            ),
          ),
          3 => 
          array (
            'name' => 'panel_hidden',
            'label' => 'LBL_RECORD_SHOWMORE',
            'columns' => 2,
            'hide' => true,
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => 
            array (
              0 => 
              array (
                'name' => 'date_entered_by',
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
              1 => 
              array (
                'name' => 'date_modified_by',
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
        ),
        'templateMeta' => 
        array (
          'useTabs' => false,
        ),
      ),
    ),
  ),
);
