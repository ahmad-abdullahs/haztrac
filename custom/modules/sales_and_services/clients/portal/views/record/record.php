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

$viewdefs['sales_and_services']['portal']['view']['record'] = array(
    'buttons' => array(
        array(
            'name' => 'sidebar_toggle',
            'type' => 'sidebartoggle',
        ),
    ),
    'panels' => array(
        array(
            'name' => 'panel_header',
            'header' => true,
            'fields' => array(
                array(
                    'name' => 'picture',
                    'type' => 'avatar',
                    'size' => 'large',
                    'dismiss_label' => true,
                    'readonly' => true,
                ),
                'name',
                'status_c',
            ),
        ),
        array(
            'name' => 'panel_body',
            'label' => 'LBL_RECORD_BODY',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' =>
            array(
                array(
                    'name' => 'accounts_sales_and_services_1_name',
                    'label' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_ACCOUNTS_TITLE',
                    'type' => 'relate-autopopulate-team-related',
                ),
                array(
                    'name' => 'status_c',
                    'label' => 'LBL_STATUS',
                ),
                array(
                    'name' => 'contacts_sales_and_services_1_name',
                    'label' => 'LBL_CONTACTS_SALES_AND_SERVICES_1_FROM_CONTACTS_TITLE',
                    'initial_filter' => 'filterAccountsTemplate',
                    'initial_filter_label' => 'LBL_FILTER_ACCOUNTS_TEMPLATE',
                    'filter_relate' =>
                    array(
                        'accounts_sales_and_services_1accounts_ida' => 'account_id',
                    ),
                ),
                array(
                    'name' => 'po_number_c',
                    'label' => 'LBL_PO_NUMBER',
                    'initial_filter' => 'filterByAccountId',
                    'initial_filter_label' => 'LBL_FILTER_BY_ACCOUNT_ID',
                    'link' => false,
                    'eye-icon' => false,
                    'filter_relate' =>
                    array(
                        'accounts_sales_and_services_1accounts_ida' => 'account_id_c',
                    ),
                ),
                array(
                    'name' => 'account_terms_c',
                    'label' => 'LBL_ACCOUNT_TERMS',
                ),
                array(
                    'name' => 'on_date_c',
                    'label' => 'LBL_ON_DATE',
                ),
                array(
                    'name' => 'on_time_c',
                    'label' => 'LBL_ON_TIME',
                ),
                array(
                    'name' => 'instructions_notes_c',
                    'studio' => 'visible',
                    'label' => 'LBL_INSTRUCTIONS_NOTES',
                ),
                array(
                    'name' => 'internal_notes_c',
                    'studio' => 'visible',
                    'label' => 'LBL_INTERNAL_NOTES',
                ),
                array(
                    'name' => 'transporter_carrier_c',
                    'studio' => 'visible',
                    'label' => 'LBL_TRANSPORTER_CARRIER',
                    'link' => false,
                    'eye-icon' => false,
                ),
                array(
                    'name' => 'destination_ship_to_c',
                    'studio' => 'visible',
                    'label' => 'LBL_DESTINATION_SHIP_TO',
                    'link' => false,
                    'eye-icon' => false,
                ),
                array(
                    'name' => 'date_entered_by',
                    'readonly' => true,
                    'inline' => true,
                    'type' => 'fieldset',
                    'label' => 'LBL_DATE_ENTERED',
                    'fields' => array(
                        array(
                            'name' => 'date_entered',
                        ),
                    ),
                ),
                array(
                    'name' => 'date_modified_by',
                    'readonly' => true,
                    'inline' => true,
                    'type' => 'fieldset',
                    'label' => 'LBL_DATE_MODIFIED',
                    'fields' => array(
                        array(
                            'name' => 'date_modified',
                        ),
                    ),
                ),
                array(
                    'name' => 'assigned_user_name',
                    'link' => false,
                ),
            ),
        ),
    ),
);
