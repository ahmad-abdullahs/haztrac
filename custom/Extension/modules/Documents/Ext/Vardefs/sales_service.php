<?php

$dictionary['Document']['fields']['ht_quotes'] = array(
	'name' => 'ht_quotes',
    'type' => 'link',
    'vname' => 'LBL_SERVICES_QUOTES',
    'relationship' => 'documents_ht_quotes',
    'link_type' => 'one',
    'source' => 'non-db',
);