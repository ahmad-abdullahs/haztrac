<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$viewdefs['base']['view']['comment-log-dashlet'] = array(
    'dashlets' => array(
        array(
            'label' => 'LBL_DASHLET_COMMENT_LOG_NAME',
            'description' => 'LBL_DASHLET_COMMENT_LOG_DESC',
            'config' => array(
                'module' => 'CommentLog'
            ),
            'preview' => array(
            ),
        )
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
//                    array(
//                        "type" => "dashletaction",
//                        "action" => "refreshClicked",
//                        "label" => "LBL_DASHLET_REFRESH_LABEL",
//                        "name" => "refresh_button",
//                    ),
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
