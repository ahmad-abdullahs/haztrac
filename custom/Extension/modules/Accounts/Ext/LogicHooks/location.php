<?php

$hook_version = 1;

$hook_array['before_save'][] = array(
	1,
	'Find Location of the Shipping address',
	'custom/modules/Accounts/AccountsHooks.php',
	'AccountsHooks',
	'beforeSave',
);