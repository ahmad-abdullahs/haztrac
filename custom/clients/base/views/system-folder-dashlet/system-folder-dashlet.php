<?php
$viewdefs['base']['view']['system-folder-dashlet'] = array(
    'dashlets' => array(
        array(
            'label' => 'LBL_SYSTEM_FOLDER_DASHLET_VIEW',
            'description' => 'LBL_SYSTEM_FOLDER_DASHLET_VIEW_DESCRIPTION',
            'config' => array(),
            'preview' => array(),
            'filter' => array(
                'view' => 'record',
            ),
        ),
    ),
    'custom_toolbar' => array(
        "buttons" => array(
            array(
                "type" => "dashletaction",
                "css_class" => "btn btn-invisible dashlet-toggle minify",
                "icon" => "fa-chevron-up",
                "action" => "toggleMinify",
                "tooltip" => "LBL_DASHLET_TOGGLE",
            ),
            array(
                "dropdown_buttons" => array(
                    array(
                        "type" => "dashletaction",
                        "action" => "editClicked",
                        "label" => "LBL_DASHLET_CONFIG_EDIT_LABEL",
                        "name" => "edit_button",
                    ),
                    array(
                        "type" => "dashletaction",
                        "action" => "removeClicked",
                        "label" => "LBL_DASHLET_REMOVE_LABEL",
                        "name" => "remove_button",
                    ),
                )
            )
        )
    ),
);
