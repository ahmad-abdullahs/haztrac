<?php

$dependencies['Contracts_Template']['spot_oil_sale_dep'] = array(
    'hooks' => array("edit"),
    'triggerFields' => array('contract_type_c'),
    'onload' => true,
    'actions' => array(
        array(
            'name' => 'SetPanelVisibility',
            'params' => array(
                'target' => 'LBL_RECORDVIEW_PANEL1',
                'value' => 'equal($contract_type_c,"Spot Oil Sale")',
            ),
        ),
    ),
);
