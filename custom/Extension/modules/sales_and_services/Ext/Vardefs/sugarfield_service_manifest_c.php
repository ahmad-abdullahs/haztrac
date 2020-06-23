<?php

// created: 2020-06-14 14:45:35
$dictionary['sales_and_services']['fields']['service_manifest_c']['labelValue'] = 'Manifest';
$dictionary['sales_and_services']['fields']['service_manifest_c']['rname'] = 'manifest_no_actual_c';
$dictionary['sales_and_services']['fields']['ht_manifest_id_c']['calculated'] = true;
$dictionary['sales_and_services']['fields']['ht_manifest_id_c']['enforced'] = true;
$dictionary['sales_and_services']['fields']['ht_manifest_id_c']['formula'] = 'relatedValueIfExist($sales_and_services_revenuelineitems_1, "ht_manifest_revenuelineitems_1ht_manifest_ida")';
