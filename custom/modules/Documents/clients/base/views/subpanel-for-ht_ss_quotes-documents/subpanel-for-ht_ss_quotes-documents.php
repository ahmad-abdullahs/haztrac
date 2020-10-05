<?php

// created: 2020-10-02 16:18:24
$viewdefs['Documents']['base']['view']['subpanel-for-ht_ss_quotes-documents'] = array(
    'panels' =>
    array(
        0 =>
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
                    'related_fields' =>
                    array(
//                        'document_revision_id',
                        'filename',
                        'document_name',
                        'status',
                        'revision',
                        'template_type',
                        'is_template',
                        'active_date',
                        'category_id',
                        'exp_date',
                        'subcategory_id',
                        'description',
                        'related_doc_name',
                        'related_doc_rev_number',
                        'assigned_user_name',
                        'team_name',
                        'last_rev_created_name',
                    ),
                ),
                array(
                    'name' => 'category_id',
                    'label' => 'LBL_LIST_CATEGORY',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'doc_type',
                    'label' => 'LBL_LIST_DOC_TYPE',
                    'enabled' => true,
                    'default' => true,
                    'readonly' => true,
                ),
                array(
                    'name' => 'status_id',
                    'label' => 'LBL_LIST_STATUS',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'active_date',
                    'label' => 'LBL_LIST_ACTIVE_DATE',
                    'enabled' => true,
                    'default' => true,
                ),
            ),
        ),
    ),
    'rowactions' =>
    array(
        'actions' =>
        array(
            array(
                'type' => 'rowaction',
                'css_class' => 'btn',
                'tooltip' => 'LBL_PREVIEW',
                'event' => 'list:preview:fire',
                'icon' => 'fa-eye',
                'acl_action' => 'view',
            ),
            array(
                'type' => 'rowaction',
                'name' => 'edit_button',
                'icon' => 'fa-pencil',
                'label' => 'LBL_EDIT_BUTTON',
                'event' => 'list:editrow:fire',
                'acl_action' => 'edit',
            ),
            array(
                'type' => 'unlink-action',
                'name' => 'unlink_button',
                'icon' => 'fa-chain-broken',
                'label' => 'LBL_UNLINK_BUTTON',
            ),
        ),
    ),
    'type' => 'subpanel-list',
);
