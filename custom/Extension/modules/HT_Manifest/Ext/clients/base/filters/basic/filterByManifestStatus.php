<?php

$viewdefs['HT_Manifest']['base']['filter']['basic']['filters'][] = array(
    'id' => 'filterByManifestStatus',
    'name' => 'LBL_FILTER_BY_MANIFEST_STATUS',
    'filter_definition' => array(
        array(
            'status_c' => array(
                '$in' => array(
                    'Active'
                ),
            ),
        )
    ),
    'editable' => true,
    'is_template' => true,
);
