<?php

// created: 2019-09-04 03:15:48
$dictionary["LR_Lab_Reports"]["fields"]["name"] = array(
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

$dictionary['LR_Lab_Reports']['fields']['name']['audited'] = false;
$dictionary['LR_Lab_Reports']['fields']['name']['massupdate'] = false;
$dictionary['LR_Lab_Reports']['fields']['name']['importable'] = 'false';
$dictionary['LR_Lab_Reports']['fields']['name']['duplicate_merge'] = 'disabled';
$dictionary['LR_Lab_Reports']['fields']['name']['duplicate_merge_dom_value'] = 0;
$dictionary['LR_Lab_Reports']['fields']['name']['merge_filter'] = 'disabled';
$dictionary['LR_Lab_Reports']['fields']['name']['unified_search'] = false;
$dictionary['LR_Lab_Reports']['fields']['name']['full_text_search'] = array(
    'enabled' => true,
    'boost' => '1.45',
    'searchable' => true,
);
$dictionary['LR_Lab_Reports']['fields']['name']['calculated'] = 'true';
$dictionary['LR_Lab_Reports']['fields']['name']['formula'] = 'concat($document_name,"")';
$dictionary['LR_Lab_Reports']['fields']['name']['enforced'] = true;
?>