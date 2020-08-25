<?php
 // created: 2020-08-25 23:27:15
$dictionary['HRM_Employee_Training']['fields']['renewal_days_c']['labelValue']='Renewal Days';
$dictionary['HRM_Employee_Training']['fields']['renewal_days_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['HRM_Employee_Training']['fields']['renewal_days_c']['enforced']='false';
$dictionary['HRM_Employee_Training']['fields']['renewal_days_c']['dependency']='and(equal($renewal_refresher_c,true),equal($frequency_c,"Other"))';

 ?>