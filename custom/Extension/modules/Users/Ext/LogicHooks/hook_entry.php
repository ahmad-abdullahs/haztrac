<?php

$hook_array['before_save'][] = array(
    1,
    'Add non-admin user to non-admin role on its first creation',
    'custom/modules/Users/LogicHookClasses/before_save_class.php',
    'before_save_class',
    'before_save_method'
);

$hook_array['after_save'][] = array(
    1,
    'Add non-admin user to non-admin role on its first creation',
    'custom/modules/Users/LogicHookClasses/after_save_class.php',
    'after_save_class',
    'after_save_method'
);
