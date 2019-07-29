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
$viewdefs['base']['view']['stage2-account-preview'] = array(
    'panels' => array(
        array(
            'name' => 'company_header',
            'labels' => false,
            'fields' => array(
                array (
                    'name' => 'hint_account_logo_c',
                    'type' => 'stage2_image',
                    'label' => 'LBL_HINT_COMPANY_LOGO',
                    'dismiss_label' => true,
                    'fields' => array(
                        'hint_account_logo_c'
                    ),
                ),
                array(
                    'name' => 'name',
                    'type' => 'text',
                    'dismiss_label' => true,
                    'fields' => array(
                        'name'
                    ),
                ),
                array(
                    'name' => 'website',
                    'type' => 'stage2_url',
                    'dismiss_label' => true,
                    'fields' => array(
                        'website'
                    ),
                ),
            ),
        ),
        array(
            'name' => 'company_info',
            'columns' => 1,
            'labels' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'hint_account_size_c',
                    'label' => 'LBL_HINT_COMPANY_SIZE',
                ),
                array(
                    'name' => 'hint_account_industry_c',
                    'label' => 'LBL_HINT_COMPANY_INDUSTRY',
                ),
                array(
                    'name' => 'hint_account_location_c',
                    'label' => 'LBL_HINT_COMPANY_LOCATION',
                ),
                array(
                    'name' => 'annual_revenue',
                    'label' => 'LBL_HINT_COMPANY_ANNUAL_REVENUE',
                ),
                array(
                    'name' => 'description',
                    'label' => 'LBL_HINT_COMPANY_DESCRIPTION',
                    'person_name' => 'hint_account_description_c',
                    'person_label' => 'LBL_HINT_COMPANY_DESCRIPTION',
                ),
                'lead_source'
            ),
        ),
        array(
            'name' => 'company_extended',
            'hide' => true,
            'fields' => array(
                array(
                    'name' => 'hint_account_naics_code_lbl_c',
                    'label' => 'LBL_HINT_COMPANY_NAICS_CODE_LABEL',
                ),
                array(
                    'name' => 'sic_code',
                    'label' => 'LBL_HINT_COMPANY_SIC_CODE_LABEL',
                    'person_name' => 'hint_account_sic_code_label_c',
                    'person_label' => 'LBL_HINT_COMPANY_SIC_CODE_LABEL',
                ),
                array(
                    'name' => 'hint_account_fiscal_year_end_c',
                    'label' => 'LBL_HINT_COMPANY_FISCAL_YEAR_END',
                ),
                array(
                    'name' => 'hint_account_founded_year_c',
                    'label' => 'LBL_HINT_COMPANY_FOUNDED_YEAR',
                ),
                array(
                    'name' => 'hint_account_facebook_handle_c',
                    'type' => 'stage2_url',
                    'label' => 'LBL_HINT_COMPANY_FACEBOOK',
                ),
                array(
                    'name' => 'twitter',
                    'type' => 'stage2_url',
                    'label' => 'LBL_HINT_COMPANY_TWITTER',
                    'person_name' => 'hint_account_twitter_handle_c',
                    'person_label' => 'LBL_HINT_COMPANY_TWITTER',
                ),
                array(
                    'name' => 'hint_account_industry_tags_c',
                    'label' => 'LBL_HINT_COMPANY_INDUSTRY_TAGS',
                    'person_name' => 'hint_industry_tags_c',
                    'person_label' => 'LBL_HINT_COMPANY_INDUSTRY_TAGS',
                ),
            ),
        ),
    ),
);
