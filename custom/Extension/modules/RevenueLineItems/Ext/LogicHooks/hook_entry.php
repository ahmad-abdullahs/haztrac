<?php

$hook_array['before_save'][] = Array(
    //Processing index. For sorting the array.
    1,
    //Label. A string value to identify the hook.
    'before_save example',
    //The PHP file where your class is located.
    'custom/modules/RevenueLineItems/LogicHookClasses/before_save_class.php',
    //The class the method is in.
    'before_save_class',
    //The method to call.
    'before_save_method'
);

$hook_array['after_save'][] = Array(
    //Processing index. For sorting the array.
    1,
    //Label. A string value to identify the hook.
    'after_save example',
    //The PHP file where your class is located.
    'custom/modules/RevenueLineItems/LogicHookClasses/after_save_class.php',
    //The class the method is in.
    'after_save_class',
    //The method to call.
    'after_save_method'
);

$hook_array['before_delete'][] = Array(
    //Processing index. For sorting the array.
    1,
    //Label. A string value to identify the hook.
    'before_delete example',
    //The PHP file where your class is located.
    'custom/modules/RevenueLineItems/LogicHookClasses/before_delete_class.php',
    //The class the method is in.
    'before_delete_class',
    //The method to call.
    'before_delete_method'
);
