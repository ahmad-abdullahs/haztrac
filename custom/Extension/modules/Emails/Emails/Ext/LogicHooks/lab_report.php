<?php

$hook_version = 1;

$hook_array['after_save'][] = array(
	1,
	'Attachment Processing of Lab Report from Email',
	'custom/modules/Emails/EmailsHooks.php',
	'EmailsHooks',
	'afterSave',
);