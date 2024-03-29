<?php

$viewdefs['sales_and_services'] = array(
    'base' =>
    array(
        'view' =>
        array(
            'list' =>
            array(
                'panels' =>
                array(
                    0 =>
                    array(
                        'label' => 'LBL_PANEL_1',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'name',
                                'label' => 'LBL_NAME',
                                'default' => true,
                                'enabled' => true,
                                'link' => true,
                                'type' => 'open-in-drawer',
                                'related_fields' =>
                                array_merge(array(
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
                                'width' => 'medium',
                            ),
                            1 =>
                            array(
                                'name' => 'ss_number',
                                'label' => 'LBL_SS_NUMBER',
                                'enabled' => true,
                                'readonly' => true,
                                'default' => true,
                                'width' => 'xxsmall',
                            ),
                            2 =>
                            array(
                                'name' => 'mft_part_num',
                                'label' => 'LBL_MFT_PART_NUM',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'xsmall',
                            ),
                            3 =>
                            array(
                                'name' => 'status_c',
                                'label' => 'LBL_STATUS',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'xsmall',
                            ),
                            4 =>
                            array(
                                'name' => 'accounts_sales_and_services_1_name',
                                'label' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_ACCOUNTS_TITLE',
                                'enabled' => true,
                                'id' => 'ACCOUNTS_SALES_AND_SERVICES_1ACCOUNTS_IDA',
                                'link' => true,
                                'sortable' => false,
                                'default' => true,
                                'width' => 'xsmall',
                            ),
                            5 =>
                            array(
                                'name' => 'service_manifest_c',
                                'label' => 'LBL_SERVICE_MANIFEST',
                                'enabled' => true,
                                'id' => 'HT_MANIFEST_ID_C',
                                'link' => true,
                                'sortable' => false,
                                'default' => true,
                            ),
                            6 =>
                            array(
                                'name' => 'on_date_c',
                                'label' => 'LBL_ON_DATE',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'xsmall',
                            ),
                            7 =>
                            array(
                                'name' => 'on_time_c',
                                'label' => 'LBL_ON_TIME',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'xsmall',
                            ),
                            8 =>
                            array(
                                'name' => 'svc_days_c',
                                'label' => 'LBL_SVC_DAYS',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'xxsmall',
                            ),
                            9 =>
                            array(
                                'name' => 'estimated_rli_total',
                                'label' => 'LBL_ESTIMATED_RLI_TOTAL',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'xxsmall',
                            ),
                            10 =>
                            array(
                                'name' => 'rli_total_c',
                                'label' => 'LBL_RLI_TOTAL',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'xxsmall',
                            ),
                            11 =>
                            array(
                                'name' => 'payment_status_c',
                                'label' => 'LBL_PAYMENT_STATUS',
                                'enabled' => true,
                                'default' => true,
                                'width' => 'xsmall',
                            ),
                            12 =>
                            array(
                                'name' => 'complete_date_c',
                                'label' => 'LBL_COMPLETE_DATE',
                                'enabled' => true,
                                'default' => true,
                            ),
                            13 =>
                            array(
                                'name' => 'contracts_sales_and_services_1_name',
                                'label' => 'LBL_CONTRACTS_SALES_AND_SERVICES_1_FROM_CONTRACTS_TITLE',
                                'enabled' => true,
                                'id' => 'CONTRACTS_SALES_AND_SERVICES_1CONTRACTS_IDA',
                                'link' => true,
                                'sortable' => false,
                                'default' => false,
                            ),
                            14 =>
                            array(
                                'name' => 'date_entered',
                                'enabled' => true,
                                'default' => false,
                            ),
                            15 =>
                            array(
                                'name' => 'date_modified',
                                'enabled' => true,
                                'default' => false,
                            ),
                            16 =>
                            array(
                                'name' => 'quotes_sales_and_services_1_name',
                                'label' => 'LBL_QUOTES_SALES_AND_SERVICES_1_FROM_QUOTES_TITLE',
                                'enabled' => true,
                                'id' => 'QUOTES_SALES_AND_SERVICES_1QUOTES_IDA',
                                'link' => true,
                                'sortable' => false,
                                'default' => false,
                            ),
                            17 =>
                            array(
                                'name' => 'po_number_c',
                                'label' => 'LBL_PO_NUMBER',
                                'enabled' => true,
                                'default' => false,
                            ),
                            18 =>
                            array(
                                'name' => 'contacts_sales_and_services_1_name',
                                'label' => 'LBL_CONTACTS_SALES_AND_SERVICES_1_FROM_CONTACTS_TITLE',
                                'enabled' => true,
                                'id' => 'CONTACTS_SALES_AND_SERVICES_1CONTACTS_IDA',
                                'link' => true,
                                'sortable' => false,
                                'default' => false,
                            ),
                            19 =>
                            array(
                                'name' => 'svc_type_c',
                                'label' => 'LBL_SVC_TYPE',
                                'enabled' => true,
                                'default' => false,
                            ),
                            20 =>
                            array(
                                'name' => 'team_name',
                                'label' => 'LBL_TEAM',
                                'default' => false,
                                'enabled' => true,
                                'width' => '9',
                            ),
                        ),
                    ),
                ),
                'orderBy' =>
                array(
                    'field' => 'date_modified',
                    'direction' => 'desc',
                ),
            ),
        ),
    ),
);
