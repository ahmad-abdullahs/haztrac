<?php
$dependencies["Contacts"]["assistant_phone_synofieldmask"] = 
array (
  'hooks' => 
  array (
    0 => 'edit',
    1 => 'save',
  ),
  'trigger' => 'true',
  'triggerFields' => 
  array (
    0 => 'assistant_phone',
  ),
  'onload' => true,
  'actions' => 
  array (
    0 => 
    array (
      'name' => 'SetSynoFieldMask',
      'params' => 
      array (
        'target' => 'assistant_phone',
        'label' => 'assistant_phone_label',
        'value' => 
        array (
          'mask' => '+9[9[9]] (9[9[9]]) 999[9]-9999 \\\\E\\\\x\\\\t [9][9][9][9][9][9]',
          'greedy' => false,
        ),
      ),
    ),
  ),
);
