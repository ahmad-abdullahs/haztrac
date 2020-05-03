<?php

// created: 2019-09-09 06:08:43
$subpanel_layout['list_fields'] = array(
    'name' =>
    array(
        'vname' => 'LBL_LIST_NAME',
        'widget_class' => 'SubPanelDetailViewLink',
        'width' => 10,
        'default' => true,
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
    'sales_and_services_revenuelineitems_1_name' =>
    array(
        'type' => 'relate',
        'link' => true,
        'vname' => 'LBL_SALES_AND_SERVICES_REVENUELINEITEMS_1_FROM_SALES_AND_SERVICES_TITLE',
        'id' => 'SALES_AND_SERVICES_REVENUELINEITEMS_1SALES_AND_SERVICES_IDA',
        'width' => 10,
        'default' => true,
        'widget_class' => 'SubPanelDetailViewLink',
        'target_module' => 'sales_and_services',
        'target_record_key' => 'sales_and_services_revenuelineitems_1sales_and_services_ida',
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
    'date_closed' =>
    array(
        'type' => 'date',
        'related_fields' =>
        array(
            0 => 'date_closed_timestamp',
        ),
        'vname' => 'LBL_DATE_CLOSED',
        'width' => 10,
        'default' => true,
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
    'product_uom_c' =>
    array(
        'type' => 'enum',
        'default' => true,
        'vname' => 'LBL_UNIT_OF_MEASURE',
        'width' => 10,
    ),
//    'related_rli_total_c' =>
//    array(
//        'type' => 'decimal',
//        'vname' => 'LBL_RELATED_RLI_TOTAL',
//        'width' => 10,
//        'default' => true,
//    ),
    array(
        'name' => 'bundle_total_c',
        'label' => 'LBL_BUNDLE_TOTAL',
        'enabled' => true,
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
    'close_amount_c' =>
    array(
        'type' => 'decimal',
        'vname' => 'LBL_CLOSE_AMOUNT',
        'width' => 10,
        'default' => true,
    ),
    'quote_name' =>
    array(
        'type' => 'relate',
        'link' => true,
        'vname' => 'LBL_QUOTE_NAME',
        'id' => 'QUOTE_ID',
        'width' => 10,
        'default' => true,
        'widget_class' => 'SubPanelDetailViewLink',
        'target_module' => 'Quotes',
        'target_record_key' => 'quote_id',
    ),
    'category_name' =>
    array(
        'type' => 'relate',
        'link' => true,
        'studio' =>
        array(
            'editview' => false,
            'detailview' => false,
            'quickcreate' => false,
        ),
        'vname' => 'LBL_CATEGORY_NAME',
        'id' => 'CATEGORY_ID',
        'width' => 10,
        'default' => true,
        'widget_class' => 'SubPanelDetailViewLink',
        'target_module' => 'ProductCategories',
        'target_record_key' => 'category_id',
    ),
    'discount_usdollar' =>
    array(
        'usage' => 'query_only',
        'sortable' => false,
    ),
    'currency_id' =>
    array(
        'name' => 'currency_id',
        'usage' => 'query_only',
    ),
);
