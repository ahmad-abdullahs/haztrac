<?php

$dictionary["Account"]["fields"]["po_required"] = array(
    'name' => 'po_required',
    'vname' => 'LBL_PO_REQUIRED',
    'type' => 'bool',
    'default' => '0',
);

$dictionary["Account"]["fields"]["name"]['full_text_search'] = array(
    'enabled' => true,
    'boost' => 3,
);
