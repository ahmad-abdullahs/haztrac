<?php

$dictionary["signdoc_user_signatures"] = array(
    'table' => 'signdoc_user_signatures',
    'fields' => array(
        0 => array(
            'name' => 'id',
            'type' => 'varchar',
            'len' => 36
        ),
        1 => array(
            'name' => 'sugar_user_id',
            'type' => 'varchar',
            'len' => 36
        ),
        2 => array(
            'name' => 'date_entered',
            'type' => 'datetime'
        ),
        3 => array(
            'name' => 'date_modified',
            'type' => 'datetime'
        ),
        4 => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
        ),
        5 => array(
            'name' => 'width',
            'type' => 'varchar',
            'len' => 36
        ),
        6 => array(
            'name' => 'height',
            'type' => 'varchar',
            'len' => 36
        ),
        7 => array(
            'name' => 'signature',
            'type' => 'json',
            'dbType' => 'longtext',
        ),
        8 => array(
            'name' => 'signature_id',
            'type' => 'int',
            'auto_increment' => true,
        ),
    ),
    'indices' => array(
        0 => array(
            'name' => 'signdoc_user_signatures1',
            'type' => 'primary',
            'fields' => array(
                0 => 'signature_id'
            )
        ),
        1 => array(
            'name' => 'signdoc_user_signatures2',
            'type' => 'index',
            'fields' => array(
                0 => 'sugar_user_id'
            )
        ),
    )
);
