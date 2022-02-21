<?php

$viewdefs['base']['view']['add-option-popup'] = array(
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
            'label' => 'Add Option',
            'value' => 'save',
            'css_class' => 'btn-primary',
        ),
    ),
    'panels' => array(
        array(
            'fields' => array(
                0 =>
                    array(
                        'name' => 'add_option_value',
                        'type' => 'varchar',
                        'label' => 'Option Text',
                    ),
                1 =>
                    array(
                        'name' => 'add_option_key',
                        'type' => 'varchar',
                        'label' => 'Option Key',
                    ),
            )
        )
    )
);
