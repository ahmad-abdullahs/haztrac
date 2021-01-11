<?php

$dictionary["signdoc_annotations"] = array(
    'table' => 'signdoc_annotations',
    'fields' => array(
        0 => array(
            'name' => 'id',
            'type' => 'varchar',
            'len' => 36
        ),
        1 => array(
            'name' => 'annotation_id',
            'type' => 'int',
            'len' => 36
        ),
        2 => array(
            'name' => 'document_id',
            'type' => 'varchar',
            'len' => 36
        ),
        3 => array(
            'name' => 'annotation',
            'type' => 'json',
            'dbType' => 'longtext',
        ),
        4 => array(
            'name' => 'user_id',
            'type' => 'varchar',
            'len' => 36
        ),
        5 => array(
            'name' => 'date_entered',
            'type' => 'datetime'
        ),
        6 => array(
            'name' => 'date_modified',
            'type' => 'datetime'
        ),
        7 => array(
            'name' => 'deleted',
            'type' => 'bool',
            'len' => '1',
            'default' => '0',
        ),
    ),
    'indices' => array(
        0 => array(
            'name' => 'signdoc_annotations1',
            'type' => 'primary',
            'fields' => array(
                0 => 'id'
            )
        ),
        1 => array(
            'name' => 'signdoc_annotations2',
            'type' => 'index',
            'fields' => array(
                0 => 'document_id'
            )
        ),
        1 => array(
            'name' => 'signdoc_annotations3',
            'type' => 'index',
            'fields' => array(
                0 => 'annotation_id'
            )
        ),
    )
);
