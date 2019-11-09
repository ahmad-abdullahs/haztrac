<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

$viewdefs['sales_and_services']['portal']['view']['list'] = array(
    'panels' =>
    array(
        0 =>
        array(
            'label' => 'LBL_PANEL_DEFAULT',
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
                ),
                array(
                    'name' => 'ss_number',
                    'label' => 'LBL_SS_NUMBER',
                    'enabled' => true,
                    'readonly' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'mft_part_num',
                    'label' => 'LBL_MFT_PART_NUM',
                    'enabled' => true,
                    'default' => true,
                ),
                array(
                    'name' => 'status_c',
                    'label' => 'LBL_STATUS',
                    'enabled' => true,
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
                    'eye-icon' => false,
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
                    'name' => 'svc_days_c',
                    'label' => 'LBL_SVC_DAYS',
                    'enabled' => true,
                    'default' => true,
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
            ),
        ),
    ),
    'last_state' => array(
        'id' => 'list',
    ),
);



