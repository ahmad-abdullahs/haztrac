<?php
 // created: 2020-04-24 22:59:03
$dictionary['ProductTemplate']['fields']['vendor_product_svc_descrp_c']['labelValue']='Vendor Product Description (Buy)';
$dictionary['ProductTemplate']['fields']['vendor_product_svc_descrp_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['ProductTemplate']['fields']['vendor_product_svc_descrp_c']['enforced']='';
$dictionary['ProductTemplate']['fields']['vendor_product_svc_descrp_c']['dependency']='and(not(equal($is_bundle_product_c,"parent")),not(equal($is_group_item_c,true)))';

 ?>