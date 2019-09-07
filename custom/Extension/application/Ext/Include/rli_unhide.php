<?php

$moduleList[] = 'RevenueLineItems';
$moduleList[] = 'ProductTemplates';
if (isset($modInvisList) && is_array($modInvisList)) {
    foreach ($modInvisList as $key => $mod) {
        if ($mod === 'RevenueLineItems' || $mod === 'ProductTemplates') {
            unset($modInvisList[$key]);
        }
    }
}