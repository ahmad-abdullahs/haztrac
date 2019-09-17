<?php
// created: 2019-09-15 20:47:45
$viewdefs['Contacts']['base']['menu']['quickcreate'] = array (
  'layout' => 'create',
  'label' => 'LNK_NEW_CONTACT',
  'visible' => true,
  'order' => 4,
  'icon' => 'fa-plus',
  'related' => 
  array (
    0 => 
    array (
      'module' => 'Accounts',
      'link' => 'contacts',
    ),
    1 => 
    array (
      'module' => 'Opportunities',
      'link' => 'contacts',
    ),
  ),
);