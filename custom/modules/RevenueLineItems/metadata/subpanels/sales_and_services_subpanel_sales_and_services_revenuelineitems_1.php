<?php

// created: 2019-08-26 15:47:54
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
    'unit_of_measure_c' =>
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
    'charge_c' =>
    array(
        'related_fields' =>
        array(
            0 => 'currency_id',
            1 => 'base_rate',
        ),
        'type' => 'currency',
        'default' => true,
        'vname' => 'LBL_CHARGE',
        'currency_format' => true,
        'width' => 10,
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
    'close_amount_c' =>
    array(
        'type' => 'decimal',
        'vname' => 'LBL_CLOSE_AMOUNT',
        'width' => 10,
        'default' => true,
    ),
);
