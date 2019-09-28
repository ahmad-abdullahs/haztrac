<?php

// created: 2019-09-23 13:06:59
$subpanel_layout['list_fields'] = array(
    'name' =>
    array(
        'vname' => 'LBL_LIST_NAME',
        'widget_class' => 'SubPanelDetailViewLink',
        'width' => 10,
        'default' => true,
        'related_fields' =>
        array(
            0 => 'is_bundle_product_c',
            1 => 'rli_as_template_c',
            2 => 'sales_and_services_revenuelineitems_1_name',
        ),
    ),
    'mft_part_num' =>
    array(
        'type' => 'varchar',
        'vname' => 'LBL_MFT_PART_NUM',
        'width' => 10,
        'default' => true,
    ),
    'estimated_quantity_c' =>
    array(
        'type' => 'decimal',
        'default' => true,
        'vname' => 'LBL_ESTIMATED_QUANTITY',
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
    'pricing_formula' =>
    array(
        'type' => 'varchar',
        'vname' => 'LBL_PRICING_FORMULA',
        'width' => 10,
        'default' => true,
    ),
    'product_uom_c' =>
    array(
        'type' => 'enum',
        'default' => true,
        'vname' => 'LBL_PRODUCT_UOM',
        'width' => 10,
    ),
    'related_rli_total_c' =>
    array(
        'type' => 'decimal',
        'vname' => 'LBL_RELATED_RLI_TOTAL',
        'width' => 10,
        'default' => true,
    ),
    'product_vendor_c' =>
    array(
        'type' => 'relate',
        'studio' => 'visible',
        'vname' => 'LBL_PRODUCT_VENDOR',
        'id' => 'V_VENDORS_ID_C',
        'link' => true,
        'width' => 10,
        'default' => true,
        'widget_class' => 'SubPanelDetailViewLink',
        'target_module' => 'Accounts',
        'target_record_key' => 'v_vendors_id_c',
        'related_fields' =>
        array(
            "v_vendors_id_c",
        ),
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
