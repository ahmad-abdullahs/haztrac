<?php

//$dependencies['Accounts']['physical_address_visibility'] = array(
//    'hooks' => array("edit"),
//    'trigger' => 'true',
//    'triggerFields' => array('account_type'),
//    'onload' => true,
//    'actions' => array(
//        array(
//            'name' => 'SetVisibility',
//            'params' => array(
//                'target' => 'physical_address', 
//                'value' => 'contains($account_type, "3rd_Party")',
//            ),
//        ),
//    ),
//);