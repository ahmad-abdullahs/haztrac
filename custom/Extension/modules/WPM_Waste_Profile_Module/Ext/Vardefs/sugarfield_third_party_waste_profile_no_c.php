<?php

// created: 2020-06-25 23:19:25
$dictionary['WPM_Waste_Profile_Module']['fields']['third_party_waste_profile_no_c']['labelValue'] = 'External Profile No';
$dictionary['WPM_Waste_Profile_Module']['fields']['third_party_waste_profile_no_c']['full_text_search'] = array(
    'enabled' => '0',
    'boost' => '1',
    'searchable' => false,
);
$dictionary['WPM_Waste_Profile_Module']['fields']['third_party_waste_profile_no_c']['enforced'] = '';
$dictionary['WPM_Waste_Profile_Module']['fields']['third_party_waste_profile_no_c']['dependency'] = 'equal($third_party_waste_profile_c,true)';
