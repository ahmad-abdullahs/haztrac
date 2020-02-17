<?php

/**
 * The $objectList array, maps the module name to the Vardef property
 * By default only a few core modules have this defined, since their Class/Object names differs from their Vardef Property
 * */
$objectList['ProductTemplates'] = 'ProductTemplate';

// $beanList maps the Bean/Module name to the Class name
$beanList['ProductTemplates'] = 'CustomProductTemplate';

// $beanFiles maps the Class name to the PHP Class file
$beanFiles['CustomProductTemplate'] = 'custom/modules/ProductTemplates/CustomProductTemplate.php';
