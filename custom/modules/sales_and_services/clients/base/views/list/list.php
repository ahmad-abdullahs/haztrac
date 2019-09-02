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
                            array(
                                'name' => 'name',
                                'label' => 'LBL_NAME',
                                'default' => true,
                                'enabled' => true,
                                'link' => true,
                                'related_fields' =>
                                array(
                                    0 => 'shipping_address_street_c',
                                    1 => 'shipping_address_city_c',
                                    2 => 'shipping_address_state_c',
                                    3 => 'shipping_address_postalcode_c',
                                    4 => 'shipping_address_country_c',
                                    5 => 'lat_c',
                                    6 => 'lon_c',
                                ),
                                'width' => '32',
                            ),
                            array(
                                'name' => 'ss_number',
                                'label' => 'LBL_SS_NUMBER',
                                'enabled' => true,
                                'readonly' => true,
                                'default' => true,
                            ),
                            array(
                                'name' => 'accounts_sales_and_services_1_name',
                                'label' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_ACCOUNTS_TITLE',
                                'enabled' => true,
                                'id' => 'ACCOUNTS_SALES_AND_SERVICES_1ACCOUNTS_IDA',
                                'link' => true,
                                'sortable' => false,
                                'default' => true,
                            ),
                            array(
                                'name' => 'on_date_c',
                                'label' => 'LBL_ON_DATE',
                                'enabled' => true,
                                'default' => true,
                            ),
                            array(
                                'name' => 'on_time_c',
                                'label' => 'LBL_ON_TIME',
                                'enabled' => true,
                                'default' => true,
                            ),
                            array(
                                'name' => 'svc_type_c',
                                'label' => 'LBL_SVC_TYPE',
                                'enabled' => true,
                                'default' => true,
                            ),
                            array(
                                'name' => 'svc_days_c',
                                'label' => 'LBL_SVC_DAYS',
                                'enabled' => true,
                                'default' => true,
                            ),
                            array(
                                'name' => 'rli_total_c',
                                'label' => 'LBL_RLI_TOTAL',
                                'enabled' => true,
                                'default' => true,
                            ),
                            array(
                                'name' => 'contracts_sales_and_services_1_name',
                                'label' => 'LBL_CONTRACTS_SALES_AND_SERVICES_1_FROM_CONTRACTS_TITLE',
                                'enabled' => true,
                                'id' => 'CONTRACTS_SALES_AND_SERVICES_1CONTRACTS_IDA',
                                'link' => true,
                                'sortable' => false,
                                'default' => false,
                            ),
                            array(
                                'name' => 'date_entered',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'date_modified',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'quotes_sales_and_services_1_name',
                                'label' => 'LBL_QUOTES_SALES_AND_SERVICES_1_FROM_QUOTES_TITLE',
                                'enabled' => true,
                                'id' => 'QUOTES_SALES_AND_SERVICES_1QUOTES_IDA',
                                'link' => true,
                                'sortable' => false,
                                'default' => false,
                            ),
                            array(
                                'name' => 'po_number_c',
                                'label' => 'LBL_PO_NUMBER',
                                'enabled' => true,
                                'default' => false,
                            ),
                            array(
                                'name' => 'contacts_sales_and_services_1_name',
                                'label' => 'LBL_CONTACTS_SALES_AND_SERVICES_1_FROM_CONTACTS_TITLE',
                                'enabled' => true,
                                'id' => 'CONTACTS_SALES_AND_SERVICES_1CONTACTS_IDA',
                                'link' => true,
                                'sortable' => false,
                                'default' => false,
                            ),
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
