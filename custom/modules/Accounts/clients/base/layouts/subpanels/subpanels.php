<?php

$viewdefs['Accounts']['base']['layout']['subpanels'] = array(
    'components' => array(
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_CONTACTS_SUBPANEL_TITLE',
            'override_subpanel_list_view' => 'subpanel-for-accounts',
            'context' => array(
                'link' => 'contacts',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_CALLS_SUBPANEL_TITLE',
            'context' => array(
                'link' => 'calls',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_TASKS_SUBPANEL_TITLE',
            'context' => array(
                'link' => 'tasks',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_ACCOUNTS_SALES_AND_SERVICES_1_FROM_SALES_AND_SERVICES_TITLE',
            'context' =>
            array(
                'link' => 'accounts_sales_and_services_1',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_LR_LAB_REPORTS_ACCOUNTS_FROM_LR_LAB_REPORTS_TITLE',
            'context' =>
            array(
                'link' => 'lr_lab_reports_accounts',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_PRODUCT_TEMPLATE_ACCOUNT_SUBPANEL',
            'override_subpanel_list_view' => 'subpanel-for-product_templates_accounts',
            'context' =>
            array(
                'link' => 'product_templates_accounts',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_RLI_SUBPANEL_TITLE',
            'override_subpanel_list_view' => 'subpanel-for-accounts',
            'context' => array(
                'link' => 'revenuelineitems',
            ),
            'override_paneltop_view' => 'panel-top-for-accounts',
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_EMAILS_SUBPANEL_TITLE',
            'override_subpanel_list_view' => 'subpanel-for-accounts-archived-emails',
            'context' => array(
                'link' => 'archived_emails',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_CASES_SUBPANEL_TITLE',
            'override_subpanel_list_view' => 'subpanel-for-accounts',
            'context' => array(
                'link' => 'cases',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_QUOTES_BILLTO',
            'override_paneltop_view' => 'panel-top-for-accounts',
            'override_subpanel_list_view' => 'subpanel-for-accounts',
            'context' => array(
                'link' => 'quotes',
                'ignore_role' => 0,
            ),
        ),
//        array(
//            'layout' => 'subpanel',
//            'label' => 'LBL_QUOTES_SHIPTO',
//            'override_paneltop_view' => 'panel-top-for-accounts',
//            'override_subpanel_list_view' => 'subpanel-for-accounts',
//            'context' => array(
//                'link' => 'quotes_shipto',
//                'ignore_role' => 0,
//            ),
//        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_MEETINGS_SUBPANEL_TITLE',
            'context' => array(
                'link' => 'meetings',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_NOTES_SUBPANEL_TITLE',
            'context' => array(
                'link' => 'notes',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_OPPORTUNITIES_SUBPANEL_TITLE',
            'override_subpanel_list_view' => 'subpanel-for-accounts',
            'context' => array(
                'link' => 'opportunities',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_MEMBER_ORG_SUBPANEL_TITLE',
            'context' => array(
                'link' => 'members',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_LEADS_SUBPANEL_TITLE',
            'context' => array(
                'link' => 'leads',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_BUGS_SUBPANEL_TITLE',
            'context' => array(
                'link' => 'bugs',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_PRODUCTS_SUBPANEL_TITLE',
            'context' => array(
                'link' => 'products',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_DOCUMENTS_SUBPANEL_TITLE',
            'context' => array(
                'link' => 'documents',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_CAMPAIGN_LIST_SUBPANEL_TITLE',
            'context' => array(
                'link' => 'campaigns',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_CONTRACTS_SUBPANEL_TITLE',
            'override_subpanel_list_view' => 'subpanel-for-accounts',
            'context' => array(
                'link' => 'contracts',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_PROJECTS_SUBPANEL_TITLE',
            'context' => array(
                'link' => 'project',
            ),
        ),
        array(
            'layout' => 'subpanel',
            'label' => 'LBL_DATAPRIVACY_SUBPANEL_TITLE',
            'context' => array(
                'link' => 'dataprivacy',
            ),
        ),
    ),
);
