<?php

/**
 * The $objectList array, maps the module name to the Vardef property
 * By default only a few core modules have this defined, since their Class/Object names differs from their Vardef Property
 * */
$objectList['RevenueLineItems'] = 'RevenueLineItem';

// $beanList maps the Bean/Module name to the Class name
$beanList['RevenueLineItems'] = 'CustomRevenueLineItem';

// $beanFiles maps the Class name to the PHP Class file
$beanFiles['CustomRevenueLineItem'] = 'custom/modules/RevenueLineItems/CustomRevenueLineItem.php';
