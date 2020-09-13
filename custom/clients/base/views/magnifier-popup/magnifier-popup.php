<?php

$viewdefs['base']['view']['magnifier-popup'] = array(
    'buttons' => array(
        array(
            'name' => 'cancel_button',
            'type' => 'button',
            'label' => 'LBL_CANCEL_BUTTON_LABEL',
            'value' => 'cancel',
            'css_class' => 'btn-invisible btn-link',
        ),
        array(
            'name' => 'save_button',
            'type' => 'button',
            'label' => 'LBL_UPDATE_BUTTON_LABEL',
            'value' => 'save',
            'css_class' => 'btn-primary',
        ),
    ),
    'panels' => array(
        array(
            'fields' => array(
                0 =>
                array(
                    // Name and label will be changed in the magnifier-text.js file
                    'name' => 'vendor_product_svc_descrp_c',
                    'type' => 'textarea',
                    'showButton' => false,
                    'label' => 'LBL_VENDOR_PRODUCT_SVC_DESCRP',
                    'default' => true,
                    'enabled' => true,
                    'span' => 9,
                    'width' => '80%',
                    'rows' => 20,
                    'cols' => 40,
                ),
            )
        )
    )
);
