<?php

$dictionary['Opportunity']['fields']['ht_quotes'] = array(
	'name' => 'ht_quotes',
    'type' => 'link',
    'vname' => 'LBL_SERVICES_QUOTES',
    'relationship' => 'ht_quotes_opportunities',
    'link_type' => 'one',
    'source' => 'non-db',
);