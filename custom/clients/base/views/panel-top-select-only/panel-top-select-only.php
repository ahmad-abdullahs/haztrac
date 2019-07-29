<?php

$viewdefs['base']['view']['panel-top-select-only'] = array(
    'buttons' => array(
        array(
            'type' => 'actiondropdown',
            'name' => 'panel_dropdown',
            'css_class' => 'pull-right',
            'buttons' => array(
                array(
                    'type' => 'link-action',
                    'name' => 'select_button',
                    'icon' => 'fa-link',
                    'label' => '',
                    'tooltip' => 'LBL_ASSOC_RELATED_RECORD',
                ),
            ),
        ),
    ),
    'fields' => array(
        array(
            'name' => 'collection-count',
            'type' => 'collection-count',
        ),
    ),
);
