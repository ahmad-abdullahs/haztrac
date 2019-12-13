<?php
$dependencies["WPM_Waste_Profile_Template"]["waste_profile_num_c_synofieldmask"] = 
array (
  'hooks' => 
  array (
    0 => 'edit',
    1 => 'save',
  ),
  'trigger' => 'true',
  'triggerFields' => 
  array (
    0 => 'waste_profile_num_c',
  ),
  'onload' => true,
  'actions' => 
  array (
    0 => 
    array (
      'name' => 'SetSynoFieldMask',
      'params' => 
      array (
        'target' => 'waste_profile_num_c',
        'label' => 'waste_profile_num_c_label',
        'value' => 
        array (
          'mask' => 'P-999999999',
          'greedy' => false,
        ),
      ),
    ),
  ),
);
