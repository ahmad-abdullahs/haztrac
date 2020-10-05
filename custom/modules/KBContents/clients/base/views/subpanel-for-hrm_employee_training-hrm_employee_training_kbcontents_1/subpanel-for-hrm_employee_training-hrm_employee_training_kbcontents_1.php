<?php

// created: 2020-10-05 20:39:22
$viewdefs['KBContents']['base']['view']['subpanel-for-hrm_employee_training-hrm_employee_training_kbcontents_1'] = array(
    'panels' =>
    array(
        0 =>
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                0 =>
                array(
                    'name' => 'name',
                    'label' => 'LBL_NAME',
                    'default' => true,
                    'enabled' => true,
                    'link' => true,
                    'related_fields' =>
                    array(
                        0 => 'kbdocument_id',
                        1 => 'kbarticle_id',
                        2 => 'kbdocument_body',
                    ),
                ),
                1 =>
                array(
                    'name' => 'language',
                    'label' => 'LBL_LANG',
                    'default' => true,
                    'enabled' => true,
                    'link' => true,
                    'type' => 'enum-config',
                    'key' => 'languages',
                ),
                2 =>
                array(
                    'name' => 'revision',
                    'label' => 'LBL_DOCUMENT_REVISION',
                    'default' => true,
                    'enabled' => true,
                    'link' => false,
                    'readonly' => true,
                ),
                3 =>
                array(
                    'name' => 'active_rev',
                    'label' => 'LBL_ACTIVE_REV',
                    'type' => 'bool',
                    'default' => true,
                    'enabled' => true,
                    'link' => false,
                ),
                4 =>
                array(
                    'label' => 'LBL_DATE_ENTERED',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'date_entered',
                    'readonly' => true,
                ),
                5 =>
                array(
                    'label' => 'LBL_DATE_MODIFIED',
                    'enabled' => true,
                    'default' => true,
                    'name' => 'date_modified',
                    'readonly' => true,
                ),
                6 =>
                array(
                    'name' => 'status',
                    'label' => 'LBL_STATUS',
                    'enabled' => true,
                    'default' => true,
                    'type' => 'status',
                    'related_fields' =>
                    array(
                        0 => 'active_date',
                        1 => 'exp_date',
                    ),
                ),
            ),
        ),
    ),
    'type' => 'subpanel-list',
);
