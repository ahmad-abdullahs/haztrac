<?php

$hook_array['before_save'][] = Array(
    //Processing index. For sorting the array.
    1,
    //Label. A string value to identify the hook.
    'before_delete example',
    //The PHP file where your class is located.
    'custom/modules/Contracts/LogicHookClasses/before_save_class.php',
    //The class the method is in.
    'before_save_class',
    //The method to call.
    'before_save_method'
);
