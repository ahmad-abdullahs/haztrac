<?php

$viewdefs['HT_Manifest']['base']['view']['point-of-attention-list'] = array(
    'panels' => array(
        array(
            'name' => 'panel_header',
            'label' => 'LBL_PANEL_1',
            'fields' => array(
                array(
                    'name' => 'manifest_no_actual_c',
                    'label' => 'LBL_MANIFEST_NO_ACTUAL',
                    'sortable' => false,
                ),
                array(
                    'name' => 'status_c',
                    'label' => 'LBL_STATUS',
                    'width' => 'small',
                    'sortable' => false,
                ),
                array(
                    'name' => 'manifest_days',
                    'label' => 'LBL_MANIFEST_DAYS',
                    'width' => 'xsmall',
                    'sortable' => false,
                ),
                array(
                    'name' => 'manifest_tenth_day_date',
                    'label' => 'LBL_MANIFEST_TENTH_DAY_DATE',
                    'width' => 'small',
                    'sortable' => false,
                ),
                array(
                    'name' => 'rli_galon_total',
                    'label' => 'LBL_RLI_GALON_TOTAL',
                    'width' => 'small',
                    'sortable' => false,
                ),
                array(
                    'name' => 'team_name',
                    'label' => 'LBL_TEAM_BRANCH',
                    'sortable' => false,
                ),
            )
        ),
    ),
);
