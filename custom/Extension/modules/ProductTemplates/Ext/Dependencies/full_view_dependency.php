<?php

$dependencies['ProductTemplates']['full_view_dep_producttemplate_on_is_bundle_product_c'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('is_bundle_product_c'),
    'onload' => true,
    'actions' => array(
        // Business Card panels
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL3',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL7',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL9',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL5',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL1',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        //---------------------------------------------------------------
        // Inventory Info Tab
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL2',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        // Support Tab
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL4',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
        // Audit Tab
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL8',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
    ),
);

// This is specifically written separately in this because this was not working 
// as the collective defination for convert-create view only. 
$dependencies['ProductTemplates']['full_view_dep_producttemplate_on_is_bundle_product_c2'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('is_bundle_product_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL3',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
    ),
);

$dependencies['ProductTemplates']['full_view_dep_producttemplate_on_is_bundle_product_c3'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('is_bundle_product_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL7',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
    ),
);

$dependencies['ProductTemplates']['full_view_dep_producttemplate_on_is_bundle_product_c4'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('is_bundle_product_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL9',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
    ),
);

$dependencies['ProductTemplates']['full_view_dep_producttemplate_on_is_bundle_product_c5'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('is_bundle_product_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL5',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
    ),
);

$dependencies['ProductTemplates']['full_view_dep_producttemplate_on_is_bundle_product_c6'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('is_bundle_product_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL1',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
    ),
);

$dependencies['ProductTemplates']['full_view_dep_producttemplate_on_is_bundle_product_c7'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('is_bundle_product_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL2',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
    ),
);

$dependencies['ProductTemplates']['full_view_dep_producttemplate_on_is_bundle_product_c8'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('is_bundle_product_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL4',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
    ),
);

$dependencies['ProductTemplates']['full_view_dep_producttemplate_on_is_bundle_product_c9'] = array(
    'hooks' => array("edit", "view"),
    'trigger' => 'true',
    'triggerFields' => array('is_bundle_product_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL8',
                'value' => 'not(equal($is_bundle_product_c,"parent"))',
            ),
        ),
    ),
);
