<?php

$viewdefs['Accounts']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterByTransporterTag',
    'name' => 'LBL_FILTER_BY_TRANSPORTER_TAG',
    'filter_definition' => array(
        array(
            'tag' => array(
                '$in' => array(),
            ),
        )
    ),
    'editable' => true,
    'is_template' => true,
);

$viewdefs['Accounts']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterByCompetitor',
    'name' => 'LBL_FILTER_BY_COMPETITOR',
    'filter_definition' => array(
        array(
            'account_type_cst_c' => array(
                '$contains' => array(),
            ),
        )
    ),
    'editable' => true,
    'is_template' => true,
);
