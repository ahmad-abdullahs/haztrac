<?php
$dependencies["HT_Manifest"]["manifest_no_actual_c_synofieldmask"] = 
array (
  'hooks' => 
  array (
    0 => 'edit',
    1 => 'save',
  ),
  'trigger' => 'true',
  'triggerFields' => 
  array (
    0 => 'manifest_no_actual_c',
  ),
  'onload' => true,
  'actions' => 
  array (
    0 => 
    array (
      'name' => 'SetSynoFieldMask',
      'params' => 
      array (
        'target' => 'manifest_no_actual_c',
        'label' => 'manifest_no_actual_c_label',
        'value' => 
        array (
          'mask' => '999999999EEE',
          'greedy' => false,
        ),
      ),
    ),
  ),
);
