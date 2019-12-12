<?php

$dependencies['WPM_Waste_Profile_Module']['transportation_type_c_visibility_dep'] = array(
    'hooks' => array("all"),
    'triggerFields' => array('transportation_type_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        // show these three if transportation_type_c = CONTAINERIZED
        // and set shipment_quantity_bulkliquid_c and shipment_quantity_bulksolid_c to empty.
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'shipment_quantity_c',
                'value' => 'equal($transportation_type_c,"CONTAINERIZED")',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'shipment_quantity_c',
                'label' => 'shipment_quantity_c_label',
                'value' => 'equal($transportation_type_c,"CONTAINERIZED")',
            ),
        ),
        //--------------------
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'storage_capacity_c',
                'value' => 'equal($transportation_type_c,"CONTAINERIZED")',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'container_type_c',
                'value' => 'equal($transportation_type_c,"CONTAINERIZED")',
            ),
        ),
        //--------------
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'shipment_quantity_bulkliquid_c',
                'value' => 'equal($transportation_type_c,"BULK LIQUID")',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'shipment_quantity_bulkliquid_c',
                'label' => 'shipment_quantity_bulkliquid_c_label',
                'value' => 'equal($transportation_type_c,"BULK LIQUID")',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'shipment_quantity_bulksolid_c',
                'value' => 'equal($transportation_type_c,"BULK SOLID")',
            ),
        ),
        array(
            'name' => 'SetRequired',
            'params' => array(
                'target' => 'shipment_quantity_bulksolid_c',
                'label' => 'shipment_quantity_bulksolid_c_label',
                'value' => 'equal($transportation_type_c,"BULK SOLID")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['transportation_type_c_setvalue_dep_save'] = array(
    'hooks' => array("save"),
    'triggerFields' => array('transportation_type_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        // show these three if transportation_type_c = CONTAINERIZED
        // and set shipment_quantity_bulkliquid_c and shipment_quantity_bulksolid_c to empty.
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'shipment_quantity_c',
                'label' => 'shipment_quantity_c_label',
                'value' => 'ifElse(equal($transportation_type_c,"CONTAINERIZED"),$shipment_quantity_c,"")',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'storage_capacity_c',
                'label' => 'storage_capacity_c_label',
                'value' => 'ifElse(equal($transportation_type_c,"CONTAINERIZED"),$storage_capacity_c,"")',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'container_type_c',
                'label' => 'container_type_c_label',
                'value' => 'ifElse(equal($transportation_type_c,"CONTAINERIZED"),$container_type_c,"")',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'shipment_quantity_bulkliquid_c',
                'label' => 'shipment_quantity_bulkliquid_c_label',
                'value' => 'ifElse(equal($transportation_type_c,"BULK LIQUID"),$shipment_quantity_bulkliquid_c,"")',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'shipment_quantity_bulksolid_c',
                'label' => 'shipment_quantity_bulksolid_c_label',
                'value' => 'ifElse(equal($transportation_type_c,"BULK SOLID"),$shipment_quantity_bulksolid_c,"")',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['container_type_c_visibility_dep'] = array(
    'hooks' => array("all"),
    'triggerFields' => array('container_type_c', 'transportation_type_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'shipment_container_type_drum_c',
                'value' => 'and(equal($container_type_c,"Drums"),equal($transportation_type_c,"CONTAINERIZED"))',
            ),
        ),
        array(
            'name' => 'SetVisibility',
            'params' => array(
                'target' => 'shipment_container_type_othe_c',
                'value' => 'and(equal($container_type_c,"Other"),equal($transportation_type_c,"CONTAINERIZED"))',
            ),
        ),
    ),
);

$dependencies['WPM_Waste_Profile_Module']['container_type_c_setvalue_dep_save'] = array(
    'hooks' => array("save"),
    'triggerFields' => array('container_type_c'),
    'onload' => true,
    //Actions is a list of actions to fire when the trigger is true
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'shipment_container_type_drum_c',
                'label' => 'shipment_container_type_drum_c_label',
                'value' => 'ifElse(equal($container_type_c,"Drums"),$shipment_container_type_drum_c,"")',
            ),
        ),
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'shipment_container_type_othe_c',
                'label' => 'shipment_container_type_othe_c_label',
                'value' => 'ifElse(equal($container_type_c,"Other"),$shipment_container_type_othe_c,"")',
            ),
        ),
    ),
);
