<?php

$hook_array['before_delete'][] = Array(
    //Processing index. For sorting the array.
    1,
    //Label. A string value to identify the hook.
    'before_delete example',
    //The PHP file where your class is located.
    'custom/modules/ProductTemplates/LogicHookClasses/before_delete_class.php',
    //The class the method is in.
    'before_delete_class',
    //The method to call.
    'before_delete_method'
);
