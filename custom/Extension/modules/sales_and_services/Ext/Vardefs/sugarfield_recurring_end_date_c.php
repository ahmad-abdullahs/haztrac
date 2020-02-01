<?php

// created: 2019-10-11 18:37:09
$dictionary['sales_and_services']['fields']['recurring_end_date_c']['labelValue'] = 'End date';
$dictionary['sales_and_services']['fields']['recurring_end_date_c']['enforced'] = '';
$dictionary['sales_and_services']['fields']['recurring_end_date_c']['dependency'] = 'equal($end_date_option_c,"End date")';
$dictionary['sales_and_services']['fields']['recurring_end_date_c']['validation'] = array(
    'type' => 'isafter',
    'compareto' => 'recurring_start_date_c',
    'blank' => true,
);
