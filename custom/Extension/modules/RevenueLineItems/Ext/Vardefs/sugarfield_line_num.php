<?php

$dictionary["RevenueLineItem"]["fields"]['line_number'] = array(
    'name' => 'line_number',
    'vname' => 'LBL_LINE_NUMBER',
    'type' => 'int',
    'len' => '4',
    'default' => 0,
    'comment' => 'Line number of the revenue line item while creation from the Sales and service, Accounts or Opportunities'
    . '. This line number will be further used for the printing in work orders or manifest',
);

$dictionary["RevenueLineItem"]["fields"]['account_line_number'] = array(
    'name' => 'account_line_number',
    'vname' => 'LBL_ACCOUNT_LINE_NUMBER',
    'type' => 'int',
    'len' => '4',
    'default' => 9999,
    'comment' => 'Line number of the revenue line item subpanel under Accounts module.',
);
