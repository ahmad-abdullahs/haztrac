<?php
$dependencies["Contacts"]["phone_mobile_synofieldmask"] = 
array (
  'hooks' => 
  array (
    0 => 'edit',
    1 => 'save',
  ),
  'trigger' => 'true',
  'triggerFields' => 
  array (
    0 => 'phone_mobile',
  ),
  'onload' => true,
  'actions' => 
  array (
    0 => 
    array (
      'name' => 'SetSynoFieldMask',
      'params' => 
      array (
        'target' => 'phone_mobile',
        'label' => 'phone_mobile_label',
        'value' => 
        array (
          'mask' => '+9[9[9]] (9[9[9]]) 999[9]-9999',
          'greedy' => false,
        ),
      ),
    ),
  ),
);
