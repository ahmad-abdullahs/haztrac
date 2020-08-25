<?php

$dependencies["HRM_Employee_Info"]["ssn_synofieldmask"] = array(
    'hooks' =>
    array(
        0 => 'edit',
    ),
    'trigger' => 'true',
    'triggerFields' =>
    array(
        0 => 'ssn',
    ),
    'onload' => true,
    'actions' =>
    array(
        0 =>
        array(
            'name' => 'SetSynoFieldMask',
            'params' =>
            array(
                'target' => 'ssn',
                'label' => 'ssn_label',
                'value' =>
                array(
                    'mask' => 'ddd-dd-9999',
                    'greedy' => false,
                ),
            ),
        ),
    ),
);
