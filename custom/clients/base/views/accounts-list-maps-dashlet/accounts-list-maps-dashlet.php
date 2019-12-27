<?php
$viewdefs['base']['view']['accounts-list-maps-dashlet'] = array(
    'dashlets' => array(
        array(
            'label' => 'LBL_ACCOUNTS_MAPS_DASHLET_VIEW',
            'description' => 'LBL_ACCOUNTS_MAPS_DASHLET_VIEW_DESCRIPTION',
            'config' => array(
                'module' => 'Accounts',
            ),
            'preview' => array(
                'module' => 'Accounts',
            ),
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_body',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'filter',
                    'label' => 'LBL_DASHLET_CONFIGURE_FILTERS',
                    'type' => 'enum',
                    'options' => 'sales_service_date_range_dom',
                ),
                array(
                    'name' => 'limit',
                    'label' => 'LBL_DASHLET_CONFIGURE_DISPLAY_ROWS',
                    'type' => 'enum',
                    'options' => 'sales_service_map_limit_dom',
                ),
                array(
                    'name' => 'auto_refresh',
                    'label' => 'Auto Refresh',
                    'type' => 'enum',
                    'options' => 'sugar7_dashlet_auto_refresh_options',
                ),
            ),
        ),
    ),
    'filter' => array(
        array(
            'name' => 'filter',
            'label' => 'LBL_FILTER',
            'type' => 'enum',
            'options' => 'sales_service_date_range_dom'
        ),
    ),
);
