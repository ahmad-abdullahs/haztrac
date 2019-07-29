<?php

$dictionary['Contact']['fields']['ht_quotes'] = array(
	'name' => 'ht_quotes',
	'type' => 'link',
	'relationship' => 'ht_quotes_contacts_billto',
	'source' => 'non-db',
	'module' => 'HT_SS_Quotes',
	'bean_name' => 'HT_SS_Quotes',
	'ignore_role' => true,
	'vname' => 'LBL_SERVICE_QUOTES_BILL_TO',
);
$dictionary['Contact']['fields']['ht_quotes_shipto'] = array(
	'name' => 'ht_quotes_shipto',
	'type' => 'link',
	'relationship' => 'ht_quotes_contacts_shipto',
	'module' => 'HT_SS_Quotes',
	'bean_name' => 'HT_SS_Quotes',
	'source' => 'non-db',
	'vname' => 'LBL_SERVICE_QUOTES_SHIP_TO',
);
