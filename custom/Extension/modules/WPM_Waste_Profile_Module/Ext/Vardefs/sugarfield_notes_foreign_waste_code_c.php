<?php
 // created: 2019-12-09 18:30:39
$dictionary['WPM_Waste_Profile_Module']['fields']['notes_foreign_waste_code_c']['labelValue']='IS THIS A FOREIGN IMPORT/EXPORT WASTE?';
$dictionary['WPM_Waste_Profile_Module']['fields']['notes_foreign_waste_code_c']['full_text_search']=array (
  'enabled' => '0',
  'boost' => '1',
  'searchable' => false,
);
$dictionary['WPM_Waste_Profile_Module']['fields']['notes_foreign_waste_code_c']['enforced']='';
$dictionary['WPM_Waste_Profile_Module']['fields']['notes_foreign_waste_code_c']['dependency']='equal($quest_foreign_waste_code_c,"Yes")';

 ?>