<?php

$dependencies["Accounts"]["ac_usepa_id_c_synofieldmask"] = array(
    'hooks' =>
    array(
        0 => 'edit',
        1 => 'save',
    ),
    'trigger' => 'true',
    'triggerFields' =>
    array(
        0 => 'ac_usepa_id_c',
    ),
    'onload' => true,
    'actions' =>
    array(
        0 =>
        array(
            'name' => 'SetSynoFieldMask',
            'params' =>
            array(
                'target' => 'ac_usepa_id_c',
                'label' => 'epa_id_c_label',
                'value' =>
                array(
                    'mask' => 'AAA999999999',
                    'greedy' => false,
                ),
            ),
        ),
    ),
);
