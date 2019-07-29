<?php
// created: 2019-06-29 11:40:32
$viewdefs['RevenueLineItems']['base']['menu']['quickcreate'] = array (
  'layout' => 'create',
  'label' => 'LNK_NEW_REVENUELINEITEM',
  'visible' => true,
  'icon' => 'fa-plus',
  'related' => 
  array (
    0 => 
    array (
      'module' => 'Accounts',
      'link' => 'revenuelineitems',
    ),
    1 => 
    array (
      'module' => 'Contacts',
      'link' => 'revenuelineitems',
    ),
    2 => 
    array (
      'module' => 'Opportunities',
      'link' => 'revenuelineitems',
    ),
  ),
  'order' => 11,
);