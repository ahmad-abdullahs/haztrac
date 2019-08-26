<?php

$viewdefs['sales_and_services']['base']['layout']['subpanels-create'] = array(
    'type' => 'subpanels',
    'components' => array(
        array(
            'layout' => 'subpanel-create',
            'label' => 'LBL_SALES_AND_SERVICES_REVENUELINEITEMS_1_FROM_REVENUELINEITEMS_TITLE',
            'override_subpanel_list_view' => 'subpanel-for-rli-create',
            'context' => array(
                'link' => 'sales_and_services_revenuelineitems_1',
            ),
        )
    ),
);
