<?php

$viewdefs['ProductTemplates']['base']['layout']['subpanels-create'] = array(
    'type' => 'subpanels',
    'components' => array(
        array(
            'layout' => 'subpanel-create',
            'label' => 'LBL_PRODUCTTEMPLATES_PANEL_TITLE',
            'override_subpanel_list_view' => 'subpanel-for-producttemplates-create',
            'context' => array(
                'link' => 'product_templates_product_templates_1',
            ),
        )
    ),
);
