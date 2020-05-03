<?php

$dependencies['RevenueLineItems']['full_view_dep_rli_on_is_bundle_product_c'] = array(
    'hooks' => array("edit"),
    'triggerFields' => array('is_bundle_product_c'),
    'onload' => true,
    'actions' => array(
        // Business Card panels
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL3',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL7',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL9',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL5',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL1',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        //---------------------------------------------------------------
        // Sales Rep Tab
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL6',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        // Old Fields Tab
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL2',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        // Show More Tab
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'panel_hidden',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        // Audit Tab
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL8',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        // Specs Tab
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL10',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
    ),
);
