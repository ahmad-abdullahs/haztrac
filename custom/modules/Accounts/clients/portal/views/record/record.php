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

$viewdefs['Accounts']['portal']['view']['record'] = array(
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
                    'name' => 'tag',
                    'tabindex' => '2',
                    'span' => 6,
                ),
                array(
                    'name' => 'website',
                    'tabindex' => '6',
                    'span' => 6,
                ),
                array(
                    'name' => 'email',
                    'tabindex' => '7',
                ),
                array(
                    'name' => 'phone_office',
                    'tabindex' => '3',
                ),
                array(
                    'name' => 'account_type_cst_c',
                    'label' => 'LBL_ACCOUNT_TYPE_CST',
                ),
                array(
                    'name' => 'phone_alternate',
                    'label' => 'LBL_PHONE_ALT',
                    'tabindex' => '4',
                ),
                array(
                    'name' => 'parent_name',
                    'tabindex' => '8',
                    'link' => false,
                    'eye-icon' => false,
                ),
                array(
                    'name' => 'phone_fax',
                    'tabindex' => '5',
                ),
                array(
                    'name' => 'billing_address',
                    'type' => 'fieldset',
                    'css_class' => 'address',
                    'label' => 'LBL_BILLING_ADDRESS',
                    'fields' =>
                    array(
                        0 =>
                        array(
                            'name' => 'billing_address_street',
                            'css_class' => 'address_street',
                            'placeholder' => 'LBL_BILLING_ADDRESS_STREET',
                        ),
                        1 =>
                        array(
                            'name' => 'billing_address_city',
                            'css_class' => 'address_city',
                            'placeholder' => 'LBL_BILLING_ADDRESS_CITY',
                        ),
                        2 =>
                        array(
                            'name' => 'billing_address_state',
                            'css_class' => 'address_state',
                            'placeholder' => 'LBL_BILLING_ADDRESS_STATE',
                        ),
                        3 =>
                        array(
                            'name' => 'billing_address_postalcode',
                            'css_class' => 'address_zip',
                            'placeholder' => 'LBL_BILLING_ADDRESS_POSTALCODE',
                        ),
                        4 =>
                        array(
                            'name' => 'billing_address_country',
                            'css_class' => 'address_country',
                            'placeholder' => 'LBL_BILLING_ADDRESS_COUNTRY',
                        ),
                    ),
                    'tabindex' => '11',
                ),
                array(
                    'name' => 'shipping_address',
                    'type' => 'fieldset',
                    'css_class' => 'address',
                    'label' => 'LBL_SHIPPING_ADDRESS',
                    'fields' =>
                    array(
                        0 =>
                        array(
                            'name' => 'shipping_address_street',
                            'css_class' => 'address_street',
                            'placeholder' => 'LBL_SHIPPING_ADDRESS_STREET',
                        ),
                        1 =>
                        array(
                            'name' => 'shipping_address_city',
                            'css_class' => 'address_city',
                            'placeholder' => 'LBL_SHIPPING_ADDRESS_CITY',
                        ),
                        2 =>
                        array(
                            'name' => 'shipping_address_state',
                            'css_class' => 'address_state',
                            'placeholder' => 'LBL_SHIPPING_ADDRESS_STATE',
                        ),
                        3 =>
                        array(
                            'name' => 'shipping_address_postalcode',
                            'css_class' => 'address_zip',
                            'placeholder' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
                        ),
                        4 =>
                        array(
                            'name' => 'shipping_address_country',
                            'css_class' => 'address_country',
                            'placeholder' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
                        ),
                        5 =>
                        array(
                            'name' => 'copy',
                            'label' => 'NTC_COPY_BILLING_ADDRESS',
                            'type' => 'copy',
                            'mapping' =>
                            array(
                                'billing_address_street' => 'shipping_address_street',
                                'billing_address_city' => 'shipping_address_city',
                                'billing_address_state' => 'shipping_address_state',
                                'billing_address_postalcode' => 'shipping_address_postalcode',
                                'billing_address_country' => 'shipping_address_country',
                            ),
                        ),
                    ),
                    'tabindex' => '12',
                ),
                array(
                    'name' => 'physical_address',
                    'type' => 'fieldset',
                    'css_class' => 'address',
                    'label' => 'LBL_PHYSICAL_ADDRESS',
                    'fields' =>
                    array(
                        0 =>
                        array(
                            'name' => 'physical_address_account_name',
                            'css_class' => 'address_account',
                            'placeholder' => 'LBL_PHYSICAL_ADDRESS_ACCOUNT_NAME',
                        ),
                        1 =>
                        array(
                            'name' => 'physical_address_street',
                            'css_class' => 'address_street',
                            'placeholder' => 'LBL_PHYSICAL_ADDRESS_STREET',
                        ),
                        2 =>
                        array(
                            'name' => 'physical_address_city',
                            'css_class' => 'address_city',
                            'placeholder' => 'LBL_PHYSICAL_ADDRESS_CITY',
                        ),
                        3 =>
                        array(
                            'name' => 'physical_address_state',
                            'css_class' => 'address_state',
                            'placeholder' => 'LBL_PHYSICAL_ADDRESS_STATE',
                        ),
                        4 =>
                        array(
                            'name' => 'physical_address_postalcode',
                            'css_class' => 'address_zip',
                            'placeholder' => 'LBL_PHYSICAL_ADDRESS_POSTALCODE',
                        ),
                        5 =>
                        array(
                            'name' => 'physical_address_country',
                            'css_class' => 'address_country',
                            'placeholder' => 'LBL_PHYSICAL_ADDRESS_COUNTRY',
                        ),
                        6 =>
                        array(
                            'name' => 'copy',
                            'label' => 'NTC_COPY_BILLING_ADDRESS',
                            'type' => 'copy',
                            'mapping' =>
                            array(
                                'billing_address_street' => 'physical_address_street',
                                'billing_address_city' => 'physical_address_city',
                                'billing_address_state' => 'physical_address_state',
                                'billing_address_postalcode' => 'physical_address_postalcode',
                                'billing_address_country' => 'physical_address_country',
                            ),
                        ),
                    ),
                    'span' => 12,
                ),
            ),
        ),
    ),
);
