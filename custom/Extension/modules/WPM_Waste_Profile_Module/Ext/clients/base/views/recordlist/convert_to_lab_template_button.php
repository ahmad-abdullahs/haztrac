<?php

$viewdefs['WPM_Waste_Profile_Module']['base']['view']['recordlist']['rowactions']['actions'][] = array(
    'type' => 'divider',
);

$viewdefs['WPM_Waste_Profile_Module']['base']['view']['recordlist']['rowactions']['actions'][] = array(
    'type' => 'convert-to-lab-template',
    'name' => 'convert_to_lab_template',
    'label' => 'LBL_CONVERT_TO_LAB_TEMPLATE',
    'acl_action' => 'edit',
);
