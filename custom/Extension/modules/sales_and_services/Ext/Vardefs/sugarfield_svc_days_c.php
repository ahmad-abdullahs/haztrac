<?php
 // created: 2019-10-25 01:48:57
$dictionary['sales_and_services']['fields']['svc_days_c']['duplicate_merge_dom_value']=0;
$dictionary['sales_and_services']['fields']['svc_days_c']['labelValue']='Svc Days';
$dictionary['sales_and_services']['fields']['svc_days_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['sales_and_services']['fields']['svc_days_c']['calculated']='1';
$dictionary['sales_and_services']['fields']['svc_days_c']['formula']='ifElse(equal($status_c,"Scheduled"),daysUntil($on_date_c),$svc_days_c)';
$dictionary['sales_and_services']['fields']['svc_days_c']['enforced']='1';
$dictionary['sales_and_services']['fields']['svc_days_c']['dependency']='';

 ?>