<?php

// created: 2019-08-17 17:46:35
$layout_defs["RevenueLineItems"]["subpanel_setup"]['revenuelineitems_revenuelineitems_1'] = array(
    'order' => 100,
    'module' => 'RevenueLineItems',
    'subpanel_name' => 'default',
    'sort_order' => 'asc',
    'sort_by' => 'id',
    'title_key' => 'LBL_REVENUELINEITEMS_REVENUELINEITEMS_1_FROM_REVENUELINEITEMS_R_TITLE',
    'get_subpanel_data' => 'revenuelineitems_revenuelineitems_1',
    'top_buttons' =>
    array(
        0 =>
        array(
            'widget_class' => 'SubPanelTopButtonQuickCreate',
        ),
        1 =>
        array(
            'widget_class' => 'SubPanelTopSelectButton',
            'mode' => 'MultiSelect',
        ),
    ),
);
