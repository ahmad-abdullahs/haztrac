<?php

$hook_array['before_save'][] = Array(
    //Processing index. For sorting the array.
    1,
    //Label. A string value to identify the hook.
    'Before Save Hook for managing the relationships between accout and contacts',
    //The PHP file where your class is located.
    'custom/modules/Contacts/HookHandlers/before_save_class.php',
    //The class the method is in.
    'before_save_class',
    //The method to call.
    'before_save_method'
);
?>