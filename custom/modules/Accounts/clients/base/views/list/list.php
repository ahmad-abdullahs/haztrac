<?php

$viewdefs['Accounts'] = array(
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
                        'name' => 'panel_header',
                        'label' => 'LBL_PANEL_1',
                        'fields' =>
                        array(
                            0 =>
                            array(
                                'name' => 'name',
                                'link' => true,
                                'label' => 'LBL_LIST_ACCOUNT_NAME',
                                'enabled' => true,
                                'default' => true,
                                'related_fields' =>
                                array_merge(array(
                                    0 => 'shipping_address_street',
                                    1 => 'shipping_address_city',
                                    2 => 'shipping_address_state',
                                    3 => 'shipping_address_postalcode',
                                    4 => 'shipping_address_country',
                                    5 => 'lat_c',
                                    6 => 'lon_c',
                                    7 => 'service_site_address_name',
                                    8 => 'service_site_address_street_c',
                                    9 => 'service_site_address_city_c',
                                    10 => 'service_site_address_state_c',
                                    11 => 'service_site_address_postalcode_c',
                                    12 => 'service_site_address_country_c',
                                        ), getViewFields('recordview', 'Accounts')),
                                'width' => 'xlarge',
                            ),
                            1 =>
                            array(
                                'name' => 'shipping_address_city',
                                'label' => 'LBL_SHIPPING_ADDRESS_CITY',
                                'enabled' => true,
                                'default' => true,
                            ),
                            2 =>
                            array(
                                'name' => 'shipping_address_state',
                                'label' => 'LBL_SHIPPING_ADDRESS_STATE',
                                'enabled' => true,
                                'default' => true,
                            ),
                            3 =>
                            array(
                                'name' => 'phone_office',
                                'label' => 'LBL_LIST_PHONE',
                                'enabled' => true,
                                'default' => true,
                            ),
                            4 =>
                            array(
                                'name' => 'ac_usepa_id_c',
                                'label' => 'LBL_AC_USEPA_ID',
                                'enabled' => true,
                                'default' => true,
                            ),
                            5 =>
                            array(
                                'name' => 'assigned_user_name',
                                'label' => 'LBL_LIST_ASSIGNED_USER',
                                'id' => 'ASSIGNED_USER_ID',
                                'enabled' => true,
                                'default' => true,
                            ),
                            6 =>
                            array(
                                'name' => 'email',
                                'label' => 'LBL_EMAIL_ADDRESS',
                                'enabled' => true,
                                'default' => true,
                            ),
                            7 =>
                            array(
                                'name' => 'team_name',
                                'label' => 'LBL_TEAMS',
                                'enabled' => true,
                                'id' => 'TEAM_ID',
                                'link' => true,
                                'sortable' => false,
                                'default' => true,
                            ),
                            8 =>
                            array(
                                'name' => 'date_modified',
                                'enabled' => true,
                                'default' => true,
                            ),
                            9 =>
                            array(
                                'name' => 'date_entered',
                                'type' => 'datetime',
                                'label' => 'LBL_DATE_ENTERED',
                                'enabled' => true,
                                'default' => true,
                                'readonly' => true,
                            ),
                            10 =>
                            array(
                                'name' => 'billing_address_city',
                                'label' => 'LBL_LIST_CITY',
                                'enabled' => true,
                                'default' => false,
                            ),
                            11 =>
                            array(
                                'name' => 'billing_address_country',
                                'label' => 'LBL_BILLING_ADDRESS_COUNTRY',
                                'enabled' => true,
                                'default' => false,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
