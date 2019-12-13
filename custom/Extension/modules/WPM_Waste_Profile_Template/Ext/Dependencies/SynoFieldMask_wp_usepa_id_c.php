<?php
$dependencies["WPM_Waste_Profile_Template"]["wp_usepa_id_c_synofieldmask"] = 
array (
  'hooks' => 
  array (
    0 => 'edit',
    1 => 'save',
  ),
  'trigger' => 'true',
  'triggerFields' => 
  array (
    0 => 'wp_usepa_id_c',
  ),
  'onload' => true,
  'actions' => 
  array (
    0 => 
    array (
      'name' => 'SetSynoFieldMask',
      'params' => 
      array (
        'target' => 'wp_usepa_id_c',
        'label' => 'wp_usepa_id_c_label',
        'value' => 
        array (
          'mask' => 'AAA999999999',
          'greedy' => false,
        ),
      ),
    ),
  ),
);
