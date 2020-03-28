<?php

$dependencies["sales_and_services"]["on_time_c_synofieldmask"] = array(
    'hooks' =>
    array(
        0 => 'edit',
        1 => 'save',
    ),
    'trigger' => 'true',
    'triggerFields' =>
    array(
        0 => 'on_time_c',
    ),
    'onload' => true,
    'actions' =>
    array(
        0 =>
        array(
            'name' => 'SetSynoFieldMask',
            'params' =>
            array(
                'target' => 'on_time_c',
                'label' => 'on_time_c_label',
                'value' =>
                array(
                    'mask' => '00:00',
                    'greedy' => false,
                ),
            ),
        ),
    ),
);

$dependencies["sales_and_services"]["on_fly_manifest_number_synofieldmask"] = array(
    'hooks' =>
    array(
        0 => 'edit',
        1 => 'save',
    ),
    'trigger' => 'true',
    'triggerFields' =>
    array(
        0 => 'on_fly_manifest_number',
    ),
    'onload' => true,
    'actions' =>
    array(
        0 =>
        array(
            'name' => 'SetSynoFieldMask',
            'params' =>
            array(
                'target' => 'on_fly_manifest_number',
                'label' => 'on_fly_manifest_number_label',
                'value' =>
                array(
                    'mask' => '999999999EEE',
                    'greedy' => false,
                ),
            ),
        ),
    ),
);

