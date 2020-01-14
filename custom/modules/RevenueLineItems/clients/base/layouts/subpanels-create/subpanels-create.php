<?php

$viewdefs['RevenueLineItems']['base']['layout']['subpanels-create'] = array(
    'type' => 'subpanels',
    'components' => array(
        array(
            'layout' => 'subpanel-create',
            'label' => 'LBL_REVENUELINEITEMS_SUBPANEL_LIST_CREATE_FROM_REVENUELINEITEMS_TITLE',
            'override_subpanel_list_view' => 'subpanel-for-revenuelineitem-create',
            'context' => array(
                'link' => 'revenuelineitems_revenuelineitems_1',
            ),
        )
    ),
);
