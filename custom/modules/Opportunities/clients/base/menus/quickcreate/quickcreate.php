<?php
// created: 2019-09-15 20:47:45
$viewdefs['Opportunities']['base']['menu']['quickcreate'] = array (
  'layout' => 'create',
  'label' => 'LNK_NEW_OPPORTUNITY',
  'visible' => true,
  'order' => 5,
  'icon' => 'fa-plus',
  'related' => 
  array (
    0 => 
    array (
      'module' => 'Accounts',
      'link' => 'opportunities',
    ),
    1 => 
    array (
      'module' => 'Contacts',
      'link' => 'opportunities',
    ),
  ),
);