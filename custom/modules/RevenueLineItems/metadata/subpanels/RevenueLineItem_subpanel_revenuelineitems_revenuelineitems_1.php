<?php

// created: 2019-08-26 15:41:42
$subpanel_layout['list_fields'] = array(
    'name' =>
    array(
        'vname' => 'LBL_LIST_NAME',
        'widget_class' => 'SubPanelDetailViewLink',
        'width' => 10,
        'default' => true,
        'related_fields' => array(
            'discount_usdollar',
            'currency_id',
        ),
    ),
    'ht_manifest_revenuelineitems_1_name' =>
    array(
        'type' => 'relate',
        'link' => true,
        'vname' => 'LBL_HT_MANIFEST_REVENUELINEITEMS_1_FROM_HT_MANIFEST_TITLE',
        'id' => 'HT_MANIFEST_REVENUELINEITEMS_1HT_MANIFEST_IDA',
        'width' => 10,
        'default' => true,
        'widget_class' => 'SubPanelDetailViewLink',
        'target_module' => 'HT_Manifest',
        'target_record_key' => 'ht_manifest_revenuelineitems_1ht_manifest_ida',
    ),
    'account_name' =>
    array(
        'type' => 'relate',
        'link' => true,
        'vname' => 'LBL_ACCOUNT_NAME',
        'id' => 'ACCOUNT_ID',
        'width' => 10,
        'default' => true,
        'widget_class' => 'SubPanelDetailViewLink',
        'target_module' => 'Accounts',
        'target_record_key' => 'account_id',
    ),
    'estimated_quantity_c' =>
    array(
        'type' => 'decimal',
        'default' => true,
        'vname' => 'LBL_ESTIMATED_QUANTITY',
        'width' => 10,
    ),
    'quantity' =>
    array(
        'vname' => 'LBL_QUANTITY',
        'width' => 10,
        'default' => true,
    ),
    'product_uom_c' =>
    array(
        'type' => 'enum',
        'default' => true,
        'vname' => 'LBL_UNIT_OF_MEASURE',
        'width' => 10,
    ),
    'discount_price' =>
    array(
        'type' => 'currency',
        'related_fields' =>
        array(
            0 => 'currency_id',
            1 => 'base_rate',
        ),
        'vname' => 'LBL_DISCOUNT_PRICE',
        'currency_format' => true,
        'width' => 10,
        'default' => true,
    ),
    'total_amount' =>
    array(
        'type' => 'currency',
        'related_fields' =>
        array(
            0 => 'currency_id',
            1 => 'base_rate',
        ),
        'vname' => 'LBL_CALCULATED_LINE_ITEM_AMOUNT',
        'currency_format' => true,
        'width' => 10,
        'default' => true,
    ),
    'assigned_user_name' =>
    array(
        'link' => true,
        'type' => 'relate',
        'vname' => 'LBL_ASSIGNED_TO',
        'id' => 'ASSIGNED_USER_ID',
        'width' => 10,
        'default' => true,
        'widget_class' => 'SubPanelDetailViewLink',
        'target_module' => 'Users',
        'target_record_key' => 'assigned_user_id',
    ),
);
