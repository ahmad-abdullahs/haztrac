<?php

$hook_array['before_save'][] = Array(
    //Processing index. For sorting the array.
    1,
    //Label. A string value to identify the hook.
    'Before Save Hook for managing the relationships between accout and contacts',
    //The PHP file where your class is located.
    'custom/modules/sales_and_services/HookHandlers/sales_and_services_before_save_class.php',
    //The class the method is in.
    'sales_and_services_before_save_class',
    //The method to call.
    'before_save_method'
);
