<?php

$hook_array['before_save'][] = Array(
    1,
    'Description',
    'custom/modules/mv_Attachments/LogicHooks/LogicHookClass.php',
    'mv_AttachmentsLogicHookClass',
    'before_save'
);

$hook_array['after_save'][] = array(
    1,
    'Whenever a relation is linked with Attachments',
    'custom/modules/mv_Attachments/LogicHooks/LogicHookClass.php',
    'mv_AttachmentsLogicHookClass',
    'after_save'
);
