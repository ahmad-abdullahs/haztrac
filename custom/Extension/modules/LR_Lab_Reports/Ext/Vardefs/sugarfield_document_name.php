<?php
 // created: 2019-07-24 22:30:20
$dictionary['LR_Lab_Reports']['fields']['document_name']['required']=false;
$dictionary['LR_Lab_Reports']['fields']['document_name']['audited']=false;
$dictionary['LR_Lab_Reports']['fields']['document_name']['massupdate']=false;
$dictionary['LR_Lab_Reports']['fields']['document_name']['importable']='false';
$dictionary['LR_Lab_Reports']['fields']['document_name']['duplicate_merge']='disabled';
$dictionary['LR_Lab_Reports']['fields']['document_name']['duplicate_merge_dom_value']=0;
$dictionary['LR_Lab_Reports']['fields']['document_name']['merge_filter']='disabled';
$dictionary['LR_Lab_Reports']['fields']['document_name']['unified_search']=false;
$dictionary['LR_Lab_Reports']['fields']['document_name']['full_text_search']=array (
  'enabled' => true,
  'boost' => '0.82',
  'searchable' => true,
);
$dictionary['LR_Lab_Reports']['fields']['document_name']['calculated']='true';
$dictionary['LR_Lab_Reports']['fields']['document_name']['formula']='concat($commodity_c,"-",$sample_id_number_c)';
$dictionary['LR_Lab_Reports']['fields']['document_name']['enforced']=true;

 ?>