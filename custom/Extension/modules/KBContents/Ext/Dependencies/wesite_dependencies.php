<?php

$dependencies['KBContents']['link_only_website_c_setvalue_dep_save'] = array(
    'hooks' => array("save"),
    'triggerFields' => array('is_external', 'link_only_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'link_only_website_c',
                'label' => 'link_only_website_c_label',
                'value' => 'ifElse(and(equal($is_external,true),equal($link_only_c,true)),$link_only_website_c,"")',
            ),
        ),
    ),
);

$dependencies['KBContents']['link_only_c_setvalue_dep_save'] = array(
    'hooks' => array("save"),
    'triggerFields' => array('is_external'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetValue',
            'params' => array(
                'target' => 'link_only_c',
                'label' => 'link_only_c_label',
                'value' => 'ifElse(equal($is_external,true),$link_only_c,"")',
            ),
        ),
    ),
);
