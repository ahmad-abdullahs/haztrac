<?php

// created: 2019-08-31 02:15:28
$viewdefs['sales_and_services']['base']['view']['subpanel-for-accounts-accounts_sales_and_services_1'] = array(
    'panels' =>
    array(
        0 =>
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' =>
            array(
                0 =>
                array(
                    'default' => true,
                    'label' => 'LBL_NAME',
                    'enabled' => true,
                    'name' => 'name',
                    'link' => true,
                    'type' => 'name',
                    'related_fields' =>
                    array_merge(array(
                        // These fields are written here because they are not in the record view.
                        0 => 'shipping_address_street_c',
                        1 => 'shipping_address_city_c',
                        2 => 'shipping_address_state_c',
                        3 => 'shipping_address_postalcode_c',
                        4 => 'shipping_address_country_c',
                        5 => 'lat_c',
                        6 => 'lon_c',
                        7 => 'service_site_address_name',
                        8 => 'service_site_address_street_c',
                        9 => 'service_site_address_city_c',
                        10 => 'service_site_address_state_c',
                        11 => 'service_site_address_postalcode_c',
                        12 => 'service_site_address_country_c',
                        13 => 'pdf_template_printer_widget',
                        14 => 'sales_and_services_revenuelineitems_1',
                            ), getViewFields('recordview', 'sales_and_services')),
                ),
                1 =>
                array(
                    'name' => 'estimated_rli_total',
                    'label' => 'LBL_ESTIMATED_RLI_TOTAL',
                    'enabled' => true,
                    'default' => true,
                ),
                2 =>
                array(
                    'name' => 'rli_total_c',
                    'label' => 'LBL_RLI_TOTAL',
                    'enabled' => true,
                    'default' => true,
                ),
                3 =>
                array(
                    'type' => 'varchar',
                    'default' => true,
                    'label' => 'LBL_PROFILE_NO',
                    'enabled' => true,
                    'name' => 'profile_no_c',
                ),
                4 =>
                array(
                    'type' => 'date',
                    'default' => true,
                    'label' => 'LBL_ON_DATE',
                    'enabled' => true,
                    'name' => 'on_date_c',
                ),
                5 =>
                array(
                    'type' => 'varchar',
                    'default' => true,
                    'label' => 'LBL_ON_TIME',
                    'enabled' => true,
                    'name' => 'on_time_c',
                ),
                6 =>
                array(
                    'type' => 'varchar',
                    'default' => true,
                    'label' => 'LBL_SVC_DAYS',
                    'enabled' => true,
                    'name' => 'svc_days_c',
                ),
                7 =>
                array(
                    'type' => 'enum',
                    'default' => true,
                    'label' => 'LBL_STATUS',
                    'enabled' => true,
                    'name' => 'status_c',
                ),
            ),
        ),
    ),
    'type' => 'subpanel-list',
);
