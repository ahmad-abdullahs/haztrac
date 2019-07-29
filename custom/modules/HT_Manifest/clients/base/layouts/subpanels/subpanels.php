<?php

$viewdefs['HT_Manifest']['base']['layout']['subpanels'] = array (
    'components' => array (
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_HT_MANIFEST_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE',
            'context' => 
            array (
                'link' => 'ht_manifest_sales_and_services_1',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_REVENUELINEITEMS_TITLE',
            'override_paneltop_view' => 'panel-top-select-only',
            'context' => 
            array (
                'link' => 'ht_manifest_revenuelineitems_1',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_HT_MANIFEST_LR_LAB_REPORTS_1_FROM_LR_LAB_REPORTS_TITLE',
            'context' => 
            array (
                'link' => 'ht_manifest_lr_lab_reports_1',
            ),
        ),
    ),
);
