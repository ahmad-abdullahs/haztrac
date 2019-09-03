<?php

// created: 2019-09-04 03:15:48
$dictionary["PNL_Permits_Licenses"]["fields"]["name"] = array(
    'name' => 'name',
    'vname' => 'LBL_NAME',
    'dbType' => 'varchar',
    'type' => 'name',
    'len' => '50',
    'unified_search' => true,
    'full_text_search' =>
    array(
        'enabled' => true,
        'searchable' => true,
        'boost' => 1.45,
    ),
    'importable' => 'required',
    'required' => true,
);

$dictionary['PNL_Permits_Licenses']['fields']['name']['audited'] = false;
$dictionary['PNL_Permits_Licenses']['fields']['name']['massupdate'] = false;
$dictionary['PNL_Permits_Licenses']['fields']['name']['importable'] = 'false';
$dictionary['PNL_Permits_Licenses']['fields']['name']['duplicate_merge'] = 'disabled';
$dictionary['PNL_Permits_Licenses']['fields']['name']['duplicate_merge_dom_value'] = 0;
$dictionary['PNL_Permits_Licenses']['fields']['name']['merge_filter'] = 'disabled';
$dictionary['PNL_Permits_Licenses']['fields']['name']['unified_search'] = false;
$dictionary['PNL_Permits_Licenses']['fields']['name']['full_text_search'] = array(
    'enabled' => true,
    'boost' => '1.45',
    'searchable' => true,
);
$dictionary['PNL_Permits_Licenses']['fields']['name']['calculated'] = 'true';
$dictionary['PNL_Permits_Licenses']['fields']['name']['formula'] = 'concat($document_name,"")';
$dictionary['PNL_Permits_Licenses']['fields']['name']['enforced'] = true;
?>