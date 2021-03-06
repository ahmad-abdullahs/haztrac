<?php
$dependencies["Accounts"]["phone_alternate_synofieldmask"] = 
array (
  'hooks' => 
  array (
    0 => 'edit',
    1 => 'save',
  ),
  'trigger' => 'true',
  'triggerFields' => 
  array (
    0 => 'phone_alternate',
  ),
  'onload' => true,
  'actions' => 
  array (
    0 => 
    array (
      'name' => 'SetSynoFieldMask',
      'params' => 
      array (
        'target' => 'phone_alternate',
        'label' => 'phone_alternate_label',
        'value' => 
        array (
          'mask' => '+9[9[9]] (9[9[9]]) 999[9]-9999 \\\\E\\\\x\\\\t [9][9][9][9][9][9]',
          'greedy' => false,
        ),
      ),
    ),
  ),
);
