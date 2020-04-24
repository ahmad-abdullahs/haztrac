<?php

$dependencies['Accounts']['service_site_address_c_visibility_and_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('different_service_site_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'service_site_address_c',
                'value' => 'equal($different_service_site_c, true)',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'service_site_address_name',
                'label' => 'service_site_address_name_label',
                'value' => 'equal($different_service_site_c, true)',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'service_site_address_street_c',
                'label' => 'service_site_address_street_c_label',
                'value' => 'equal($different_service_site_c, true)',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'service_site_address_city_c',
                'label' => 'service_site_address_city_c_label',
                'value' => 'equal($different_service_site_c, true)',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'service_site_address_state_c',
                'label' => 'service_site_address_state_c_label',
                'value' => 'equal($different_service_site_c, true)',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'service_site_address_postalcode_c',
                'label' => 'service_site_address_postalcode_c_label',
                'value' => 'equal($different_service_site_c, true)',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'service_site_address_country_c',
                'label' => 'service_site_address_country_c_label',
                'value' => 'equal($different_service_site_c, true)',
            ),
        ),
    ),
);

$dependencies['Accounts']['service_site_address_plus_code_cb_required'] = array(
    'hooks' => array("all"),
    'trigger' => 'true',
    'triggerFields' => array('service_site_address_plus_code_cb'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'service_site_address_plus_code_val',
                'label' => 'service_site_address_plus_code_val_label',
                'value' => 'equal($service_site_address_plus_code_cb, true)',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'service_site_address_lat',
                'label' => 'service_site_address_lat_label',
                'value' => 'equal($service_site_address_plus_code_cb, true)',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'service_site_address_lon',
                'label' => 'service_site_address_lon_label',
                'value' => 'equal($service_site_address_plus_code_cb, true)',
            ),
        ),
    ),
);

$dependencies['Accounts']['service_site_address_c_setvalue'] = array(
    'hooks' => array("save"),
    'trigger' => 'true',
    'triggerFields' => array('different_service_site_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'service_site_address_name',
                'label' => 'service_site_address_name_label',
                'value' => 'ifElse(not(equal($different_service_site_c, true)),"",$service_site_address_name)',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'service_site_address_street_c',
                'label' => 'service_site_address_street_c_label',
                'value' => 'ifElse(not(equal($different_service_site_c, true)),"",$service_site_address_street_c)',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'service_site_address_city_c',
                'label' => 'service_site_address_city_c_label',
                'value' => 'ifElse(not(equal($different_service_site_c, true)),"",$service_site_address_city_c)',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'service_site_address_state_c',
                'label' => 'service_site_address_state_c_label',
                'value' => 'ifElse(not(equal($different_service_site_c, true)),"",$service_site_address_state_c)',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'service_site_address_postalcode_c',
                'label' => 'service_site_address_postalcode_c_label',
                'value' => 'ifElse(not(equal($different_service_site_c, true)),"",$service_site_address_postalcode_c)',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'service_site_address_country_c',
                'label' => 'service_site_address_country_c_label',
                'value' => 'ifElse(not(equal($different_service_site_c, true)),"",$service_site_address_country_c)',
            ),
        ),
    ),
);
