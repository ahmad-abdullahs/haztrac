<?php

$module_name = 'PNL_Permits_Licenses';
$viewdefs[$module_name] = array(
    'base' =>
    array(
        'view' =>
        array(
            'minified-record' =>
            array(
                'buttons' =>
                array(
                    0 =>
                    array(
                        'type' => 'button',
                        'name' => 'cancel_button',
                        'label' => 'LBL_CANCEL_BUTTON_LABEL',
                        'css_class' => 'btn-invisible btn-link',
                        'showOn' => 'edit',
                        'events' =>
                        array(
                            'click' => 'button:cancel_button:click',
                        ),
                    ),
                    1 =>
                    array(
                        'type' => 'rowaction',
                        'event' => 'button:save_button:click',
                        'name' => 'save_button',
                        'label' => 'LBL_RENEW_LICENSE_BUTTON_LABEL',
                        'css_class' => 'btn btn-primary',
                        'showOn' => 'edit',
                        'acl_action' => 'edit',
                    ),
                    2 =>
                    array(
                        'type' => 'button',
                        'name' => 'close_drawer_button',
                        'label' => 'LBL_CLOSE_DRAWER_BUTTON_LABEL',
                        'css_class' => 'btn-invisible btn-link',
                        'showOn' => 'view',
                        'events' =>
                        array(
                            'click' => 'button:close_drawer_button:click',
                        ),
                    ),
                    3 =>
                    array(
                        'type' => 'actiondropdown',
                        'name' => 'main_dropdown',
                        'primary' => true,
                        'showOn' => 'view',
                        'buttons' =>
                        array(
                            0 =>
                            array(
                                'type' => 'rowaction',
                                'event' => 'button:edit_button:click',
                                'name' => 'edit_button',
                                'label' => 'LBL_EDIT_BUTTON_LABEL',
                                'acl_action' => 'edit',
                            ),
                        ),
                    ),
                    4 =>
                    array(
                        'name' => 'sidebar_toggle',
                        'type' => 'sidebartoggle',
                    ),
                ),
                'panels' =>
                array(
                    0 =>
                    array(
                        'name' => 'panel_header',
                        'label' => 'LBL_RECORD_HEADER',
                        'header' => true,
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'picture',
                                'type' => 'avatar',
                                'width' => 42,
                                'height' => 42,
                                'dismiss_label' => true,
                                'readonly' => true,
                            ),
                            1 =>
                            array(
                                'name' => 'document_name',
                                'readonly' => true,
                                'related_fields' =>
                                array_merge(array(), getViewFields('recordview', 'PNL_Permits_Licenses')),
                            ),
                            2 =>
                            array(
                                'name' => 'favorite',
                                'label' => 'LBL_FAVORITE',
                                'type' => 'favorite',
                                'readonly' => true,
                                'dismiss_label' => true,
                            ),
                            3 =>
                            array(
                                'name' => 'follow',
                                'label' => 'LBL_FOLLOW',
                                'type' => 'follow',
                                'readonly' => true,
                                'dismiss_label' => true,
                            ),
                        ),
                    ),
                    1 =>
                    array(
                        'name' => 'panel_body',
                        'label' => 'LBL_RECORD_BODY',
                        'columns' => 2,
                        'labelsOnTop' => true,
                        'placeholders' => true,
                        'newTab' => false,
                        'panelDefault' => 'expanded',
                        'fields' =>
                        array(
                            1 =>
                            array(
                                'name' => 'id_number_c',
                                'label' => 'LBL_ID_NUMBER',
                            ),
                            2 =>
                            array(
                                'name' => 'issuing_date_c',
                                'label' => 'LBL_ISSUING_DATE',
                            ),
                            3 =>
                            array(
                                'name' => 'exp_date',
                                'label' => 'LBL_DOC_EXP_DATE',
                            ),
                            4 =>
                            array(
                                'name' => 'renewal_date_c',
                                'label' => 'LBL_RENEWAL_DATE',
                            ),
                            5 =>
                            array(
                                'name' => 'uploadfile',
                                'required' => true,
                                'populate_list' =>
                                array(
                                    0 => 'document_name',
                                ),
                            ),
                        ),
                    ),
                ),
                'templateMeta' =>
                array(
                    'useTabs' => false,
                ),
            ),
        ),
    ),
);
