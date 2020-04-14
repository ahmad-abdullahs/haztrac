<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$viewdefs['sales_and_services']['base']['view']['pdf-templates-to-printer-mapping'] = array(
    'template' => 'record',
    'buttons' => array(
        array(
            'name' => 'close_button',
            'type' => 'button',
            'label' => 'LBL_CLOSE_BUTTON_LABEL',
            'css_class' => 'btn-invisible btn-link',
            'events' => array(
                'click' => 'button:close_button:click',
            ),
        ),
        array(
            'name' => 'print_button',
            'type' => 'button',
            'label' => 'LBL_PRINT_BUTTON_LABEL',
            'primary' => true,
            'showOn' => 'create',
            'events' => array(
                'click' => 'button:print_button:click',
            ),
        ),
        array(
            'name' => 'print_queue_button',
            'type' => 'button',
            'label' => 'LBL_PRINT_QUEUE_BUTTON_LABEL',
            'primary' => true,
            'showOn' => 'create',
            'events' => array(
                'click' => 'button:print_queue_button:click',
            ),
        ),
        array(
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
        ),
    ),
    'panels' =>
    array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PRINT_PAPERWORK',
            'header' => true,
            'default_value' => 'LBL_PRINT_PAPERWORK',
            'dismiss_label' => true,
            'type' => 'title',
            'readonly' => true,
            'fields' =>
            array(
                0 =>
                array(
                    'name' => 'task_follow_label',
                    'label' => '',
                    'default_value' => 'LBL_PRINT_PAPERWORK',
                    'type' => 'label',
                ),
            ),
        ),
        array(
            'name' => 'panel_field_body',
            'columns' => 3,
            'label' => true,
            'title' => '',
            'labelsOnTop' => true,
            'placeholders' => true,
            'newTab' => false,
            'panelDefault' => 'expanded',
            'fields' => array(
                array(
                    'name' => 'pdf_template_printer_widget',
                    'type' => 'pdf_template_printer_widget',
                    'dismiss_label' => true,
                    'span' => 7,
                    'related_fields' => array(
                        'pdf_template_printer_widget',
                    ),
                    'fields' => array(
                        array(
                            'name' => 'pdf_template_printer_widget_name',
                            'css_class' => 'pdf_template_printer_widget_name',
                            'label' => 'LBL_PDF_TEMPLATE_PRINTER_WIDGET_NAME',
                            'rname' => 'name',
                            'type' => 'relate',
                            'id_name' => 'pdf_template_printer_widget_name_id',
                            'module' => 'PdfManager',
                            'link' => true,
                            'span' => 5,
                            'sortable' => false,
                            'default' => true,
                        ),
                        array(
                            'name' => 'pdf_template_printer_widget_printer',
                            'css_class' => 'pdf_template_printer_widget_printer',
                            'label' => 'LBL_PDF_TEMPLATE_PRINTER_WIDGET_PRINTER',
                            'type' => 'enum',
                            'options' => 'pdf_printers_list',
                            'span' => 4,
                            'default' => true,
                        ),
                        array(
                            'name' => 'pdf_template_printer_widget_quantity',
                            'css_class' => 'pdf_template_printer_widget_quantity',
                            'label' => 'LBL_PDF_TEMPLATE_PRINTER_WIDGET_QUANTITY',
                            'type' => 'int',
                            'span' => 2,
                            'default' => true,
                        ),
                        array(
                            'name' => 'pdf_template_printer_widget_pdf_template_type',
                            'css_class' => 'pdf_template_printer_widget_pdf_template_type',
                            'type' => 'text',
                            'default' => false,
                        ),
                        array(
                            'name' => 'pdf_template_printer_widget_line_number',
                            'css_class' => 'pdf_template_printer_widget_line_number',
                            'type' => 'text',
                            'default' => false,
                        ),
                    )
                ),
                array(
                    'name' => 'on_fly_manifest_name',
                    'id_name' => 'on_fly_manifest_id',
                    'type' => 'relate',
                    'module' => 'HT_Manifest',
                    'label' => 'LBL_ON_FLY_MANIFEST_NAME',
                    'span' => 3,
                ),
                array(
                    'name' => 'on_fly_manifest_number',
                    'type' => 'text',
                    'label' => 'LBL_ON_FLY_MANIFEST_NUMBER',
                    'span' => 2,
                ),
            ),
        ),
    ),
    'templateMeta' =>
    array(
        'useTabs' => true,
        'maxColumns' => '2',
    ),
);
