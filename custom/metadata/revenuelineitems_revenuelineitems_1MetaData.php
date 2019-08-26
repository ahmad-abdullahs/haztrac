<?php

// created: 2019-08-17 17:46:35
$dictionary["revenuelineitems_revenuelineitems_1"] = array(
    'true_relationship_type' => 'one-to-many',
    'from_studio' => true,
    'relationships' =>
    array(
        'revenuelineitems_revenuelineitems_1' =>
        array(
            'lhs_module' => 'RevenueLineItems',
            'lhs_table' => 'revenue_line_items',
            'lhs_key' => 'id',
            'rhs_module' => 'RevenueLineItems',
            'rhs_table' => 'revenue_line_items',
            'rhs_key' => 'id',
            'relationship_type' => 'many-to-many',
            'join_table' => 'revenuelineitems_revenuelineitems_1_c',
            'join_key_lhs' => 'revenuelineitems_revenuelineitems_1revenuelineitems_ida',
            'join_key_rhs' => 'revenuelineitems_revenuelineitems_1revenuelineitems_idb',
        ),
    ),
    'table' => 'revenuelineitems_revenuelineitems_1_c',
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
        'revenuelineitems_revenuelineitems_1revenuelineitems_ida' =>
        array(
            'name' => 'revenuelineitems_revenuelineitems_1revenuelineitems_ida',
            'type' => 'id',
        ),
        'revenuelineitems_revenuelineitems_1revenuelineitems_idb' =>
        array(
            'name' => 'revenuelineitems_revenuelineitems_1revenuelineitems_idb',
            'type' => 'id',
        ),
    ),
    'indices' =>
    array(
        0 =>
        array(
            'name' => 'idx_revenuelineitems_revenuelineitems_1_pk',
            'type' => 'primary',
            'fields' =>
            array(
                0 => 'id',
            ),
        ),
        1 =>
        array(
            'name' => 'idx_revenuelineitems_revenuelineitems_1_ida1_deleted',
            'type' => 'index',
            'fields' =>
            array(
                0 => 'revenuelineitems_revenuelineitems_1revenuelineitems_ida',
                1 => 'deleted',
            ),
        ),
        2 =>
        array(
            'name' => 'idx_revenuelineitems_revenuelineitems_1_idb2_deleted',
            'type' => 'index',
            'fields' =>
            array(
                0 => 'revenuelineitems_revenuelineitems_1revenuelineitems_idb',
                1 => 'deleted',
            ),
        ),
        3 =>
        array(
            'name' => 'revenuelineitems_revenuelineitems_1_alt',
            'type' => 'alternate_key',
            'fields' =>
            array(
                0 => 'revenuelineitems_revenuelineitems_1revenuelineitems_idb',
            ),
        ),
    ),
);
