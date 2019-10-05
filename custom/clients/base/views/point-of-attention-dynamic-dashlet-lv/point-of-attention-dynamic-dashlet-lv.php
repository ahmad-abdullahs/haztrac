<?php

$viewdefs['base']['view']['point-of-attention-dynamic-dashlet-lv'] = array(
    'template' => 'list',
    'dashlets' => array(
        array(
            'label' => 'LBL_RECORD_DETAILS',
            'description' => 'LBL_RECORD_DETAILS',
            'config' => array(
                'module' => 'sales_and_services',
            ),
            'preview' => array(
                'module' => 'sales_and_services',
                'label' => 'LBL_MODULE_NAME',
                'display_columns' => array(
                    'name',
                    'ss_number',
                    'status_c',
                ),
            ),
            //Filter array decides where this dashlet is allowed to appear
            'filter' => array(
                //Modules where this dashlet can appear
//                'module' => array(
//                    'Cases',
//                ),
                //Views where this dashlet can appear
                'view' => array(
                    'record',
                )
            )
        ),
    ),
    'panels' => array(
        array(
            'name' => 'dashlet_settings',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'module',
                    'label' => 'LBL_MODULE',
                    'type' => 'enum',
                    'span' => 12,
                    'sort_alpha' => true,
                ),
                array(
                    'name' => 'display_columns',
                    'label' => 'LBL_COLUMNS',
                    'type' => 'enum',
                    'isMultiSelect' => true,
                    'ordered' => true,
                    'span' => 12,
                    'hasBlank' => true,
                    'options' => array('' => ''),
                ),
            ),
        ),
    ),
);
