<?php
 // created: 2020-01-26 20:14:19
$dictionary['KBContent']['fields']['link_only_website_c']['labelValue']='Link Only Website';
$dictionary['KBContent']['fields']['link_only_website_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['KBContent']['fields']['link_only_website_c']['dependency']='and(equal($link_only_c,true),equal($is_external,true))';

 ?>