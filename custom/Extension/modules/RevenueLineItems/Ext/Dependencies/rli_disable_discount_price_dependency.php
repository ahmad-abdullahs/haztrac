<?php

if (isset($dependencies['RevenueLineItems'])) {
    $fields = array(
        'discount_price',
        'weight',
        'probability',
        'category_name',
    );
    if (isset($dependencies['RevenueLineItems']['read_only_fields']['actions'])) {
        foreach ($fields as $field) {
            foreach ($dependencies['RevenueLineItems']['read_only_fields']['actions'] as $key => $value) {
                if (is_array($value)) {
                    if ($value['name'] == 'ReadOnly') {
                        if (is_array($value['params'])) {
                            if ($value['params']['target'] == $field)
                                unset($dependencies['RevenueLineItems']['read_only_fields']['actions'][$key]);
                        }
                    }
                }
            }
        }
    }
}