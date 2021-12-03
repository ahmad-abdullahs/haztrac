<?php
/**
 * Created by PhpStorm.
 * User: Abuzar
 * Date: 12/2/2021
 * Time: 6:54 PM
 */
$dictionary['Quote']['fields']['quote_num']['type'] = 'varchar';
$dictionary['Quote']['fields']['quote_num']['len'] = '150';
$dictionary['Quote']['fields']['quote_num']['required'] = false;
unset($dictionary['Quote']['fields']['quote_num']['auto_increment']);

$dictionary['Quote']['fields']['quote_num_internal'] = array(
    'name' => 'quote_num_internal',
    'vname' => 'LBL_QUOTE_NUM_INTERNAL',
    'type' => 'int',
    'comment' => 'Internal Quote Number',
    'readonly' => true,
    'unified_search' => true,
    'full_text_search' =>
        array (
            'enabled' => true,
            'searchable' => true,
            'type' => 'exact',
            'boost' => 1.17,
        ),
    'disable_num_format' => true,
    'enable_range_search' => true,
    'options' => 'numeric_range_search_dom',
);
