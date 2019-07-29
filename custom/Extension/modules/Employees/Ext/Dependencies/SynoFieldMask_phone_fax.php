<?php
$dependencies["Employees"]["phone_fax_synofieldmask"] = 
array (
  'hooks' => 
  array (
    0 => 'edit',
    1 => 'save',
  ),
  'trigger' => 'true',
  'triggerFields' => 
  array (
    0 => 'phone_fax',
  ),
  'onload' => true,
  'actions' => 
  array (
    0 => 
    array (
      'name' => 'SetSynoFieldMask',
      'params' => 
      array (
        'target' => 'phone_fax',
        'label' => 'phone_fax_label',
        'value' => 
        array (
          'mask' => '+9[9[9]] (9[9[9]]) 999[9]-9999',
          'greedy' => false,
        ),
      ),
    ),
  ),
);
