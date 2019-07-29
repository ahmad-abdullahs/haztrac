<?php
$dependencies["Contacts"]["phone_other_synofieldmask"] = 
array (
  'hooks' => 
  array (
    0 => 'edit',
    1 => 'save',
  ),
  'trigger' => 'true',
  'triggerFields' => 
  array (
    0 => 'phone_other',
  ),
  'onload' => true,
  'actions' => 
  array (
    0 => 
    array (
      'name' => 'SetSynoFieldMask',
      'params' => 
      array (
        'target' => 'phone_other',
        'label' => 'phone_other_label',
        'value' => 
        array (
          'mask' => '+9[9[9]] (9[9[9]]) 999[9]-9999 \\\\E\\\\x\\\\t [9][9][9][9][9][9]',
          'greedy' => false,
        ),
      ),
    ),
  ),
);
