<?php

$viewdefs['Accounts']['base']['layout']['subpanels-create'] = array(
    'type' => 'subpanels',
    'components' => array(
        array(
            'layout' => 'subpanel-create',
            'label' => 'LBL_RLI_SUBPANEL_TITLE',
            'override_subpanel_list_view' => 'subpanel-for-opportunities-create',
//            'override_subpanel_list_view' => 'subpanel-for-rli-create',
            'context' => array(
                'link' => 'revenuelineitems',
            ),
        )
    ),
);
