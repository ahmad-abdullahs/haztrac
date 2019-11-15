<?php

$dictionary["sales_and_services"]["fields"]["po_required"] = array(
    'name' => 'po_required',
    'vname' => 'LBL_PO_REQUIRED',
    'type' => 'bool',
    'default' => '0',
    'formula' => 'related($accounts_sales_and_services_1,"po_required")',
    'enforced' => true,
    'calculated' => true,
);
