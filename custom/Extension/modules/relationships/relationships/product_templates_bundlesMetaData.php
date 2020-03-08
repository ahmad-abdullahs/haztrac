<?php

// created: 2019-08-11 19:09:20
$dictionary["product_templates_product_templates_1"] = array(
    'true_relationship_type' => 'many-to-many',
    'from_studio' => true,
    'relationships' =>
    array(
        'product_templates_product_templates_1' =>
        array(
            'lhs_module' => 'ProductTemplates',
            'lhs_table' => 'product_templates',
            'lhs_key' => 'id',
            'rhs_module' => 'ProductTemplates',
            'rhs_table' => 'product_templates',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'product_templates_product_templates_1_c',
            'join_key_lhs' => 'product_templates_product_templates_1product_templates_ida',
            'join_key_rhs' => 'product_templates_product_templates_1product_templates_idb',
        ),
    ),
    'table' => 'product_templates_product_templates_1_c',
    'fields' =>
    array(
        'id' =>
        array(
            'name' => 'id',
            'type' => 'id',
        ),
        'date_modified' =>
        array(
            'name' => 'date_modified',
            'type' => 'datetime',
        ),
        'deleted' =>
        array(
            'name' => 'deleted',
            'type' => 'bool',
            'default' => 0,
        ),
        'product_templates_product_templates_1product_templates_ida' =>
        array(
            'name' => 'product_templates_product_templates_1product_templates_ida',
            'type' => 'id',
        ),
        'product_templates_product_templates_1product_templates_idb' =>
        array(
            'name' => 'product_templates_product_templates_1product_templates_idb',
            'type' => 'id',
        ),
    ),
    'indices' =>
    array(
        0 =>
        array(
            'name' => 'idx_product_templates_product_templates_1_pk',
            'type' => 'primary',
            'fields' =>
            array(
                0 => 'id',
            ),
        ),
        1 =>
        array(
            'name' => 'idx_product_templates_product_templates_1_ida1_deleted',
            'type' => 'index',
            'fields' =>
            array(
                0 => 'product_templates_product_templates_1product_templates_ida',
                1 => 'deleted',
            ),
        ),
        2 =>
        array(
            'name' => 'idx_product_templates_product_templates_1_idb2_deleted',
            'type' => 'index',
            'fields' =>
            array(
                0 => 'product_templates_product_templates_1product_templates_idb',
                1 => 'deleted',
            ),
        ),
        3 =>
        array(
            'name' => 'product_templates_product_templates_1_alt',
            'type' => 'alternate_key',
            'fields' =>
            array(
                0 => 'product_templates_product_templates_1product_templates_idb',
            ),
        ),
    ),
);
