<?php

$hook_version = 1;
$hook_array['after_save'][] = array(
    1,
    'Hook description',
    'custom/modules/Doc_Manager/HookHandlers/Doc_ManagerSaveHooks.php',
    'Doc_ManagerSaveHooks',
    'after_save',
);
$hook_array['before_save'][] = array(
    1,
    'Hook description',
    'custom/modules/Doc_Manager/HookHandlers/Doc_ManagerSaveHooks.php',
    'Doc_ManagerSaveHooks',
    'before_save',
);
