<?php

$hook_version = 1;
$hook_array['after_save'][] = array(
    1,
    'Hook description',
    'custom/modules/LR_Lab_Reports/HookHandlers/LR_Lab_ReportsRelationshipHooks.php',
    'LR_Lab_ReportsRelationshipHooks',
    'after_save',
);

$hook_array['after_relationship_add'][] = [
    1,
    'Hook description',
    'custom/modules/LR_Lab_Reports/HookHandlers/LR_Lab_ReportsRelationshipHooks.php',
    'LR_Lab_ReportsRelationshipHooks',
    'after_relationship_add'
];

$hook_array['after_relationship_delete'][] = [
    1,
    'Hook description',
    'custom/modules/LR_Lab_Reports/HookHandlers/LR_Lab_ReportsRelationshipHooks.php',
    'LR_Lab_ReportsRelationshipHooks',
    'after_relationship_delete'
];
