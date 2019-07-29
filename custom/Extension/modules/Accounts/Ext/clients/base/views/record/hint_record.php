<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$module = 'Accounts';

$panels = $viewdefs[$module]['base']['view']['record']['panels'] ?? [];

$hintPanel = [
    'name' => 'panel_hint',
    'label' => 'LBL_HINT_PANEL',
    'columns' => 2,
    'labels' => true,
    'labelsOnTop' => true,
    'placeholders' => true,
    'fields' => [
        'hint_account_size_c',
        'hint_account_industry_c',
        'hint_account_location_c',
        'hint_account_founded_year_c',
        'hint_account_industry_tags_c',
        'hint_account_naics_code_lbl_c',
        'hint_account_fiscal_year_end_c',
        [
            'name' => 'hint_account_facebook_handle_c',
            'type' => 'stage2_url',
        ],
        [
            'name' => 'hint_account_logo_c',
            'type' => 'stage2_image',
            'readonly' => true,
            'dismiss_label' => true,
            'white_list' => true
        ],
    ],
];

$hintPanel['fields'] = \Sugarcrm\Sugarcrm\custom\Hint\Helper\ViewdefsParser::filterRecordFields(
    $module, $hintPanel
);
$panels[] = $hintPanel;

$viewdefs[$module]['base']['view']['record']['panels'] = $panels;
