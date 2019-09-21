<?php

$dictionary['Activity']['fields']['revenuelineitems']['workflow'] = true;

$dictionary['Activity']['fields']['sales_and_services'] = array(
    'name' => 'sales_and_services',
    'type' => 'link',
    'relationship' => 'sales_and_services_activities',
    'source' => 'non-db',
    'vname' => 'LBL_SALES_AND_SERVICES'
);
