<?php
/**
 * Created by PhpStorm.
 * User: Abuzar
 * Date: 12/2/2021
 * Time: 7:36 PM
 */
$hook_version = 1;

$hook_array['before_save'][] = array(
    1,
    'update quote number',
    'custom/modules/Quotes/QuotesHooks.php',
    'QuotesHooks',
    'beforeSave',
);