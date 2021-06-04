<?php

$hook_version = 1;
$hook_array['after_save'][] = array(
    1,
    'Hook description',
    'custom/modules/HT_Manifest/HookHandlers/HT_ManifestRelationshipHooks.php',
    'HT_ManifestRelationshipHooks',
    'after_save',
);
$hook_array['before_save'][] = array(
    1,
    'Hook description',
    'custom/modules/HT_Manifest/HookHandlers/HT_ManifestRelationshipHooks.php',
    'HT_ManifestRelationshipHooks',
    'before_save',
);
