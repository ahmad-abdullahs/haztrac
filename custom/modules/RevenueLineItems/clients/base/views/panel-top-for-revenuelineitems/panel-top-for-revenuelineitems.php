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

$viewdefs['RevenueLineItems']['base']['view']['panel-top-for-revenuelineitems'] = array(
    // If we put the type panel-top-for-sales-and-service, it will call that js but use this meta.
    'type' => 'panel-top-for-sales-and-service',
    'buttons' => array(
        array(
            'type' => 'actiondropdown',
            'name' => 'panel_dropdown',
            'css_class' => 'pull-right',
            'buttons' => array(
                array(
                    'type' => 'sticky-rowaction',
                    'icon' => 'fa-plus',
                    'name' => 'create_button',
                    'label' => ' ',
                    'acl_action' => 'create',
                    'tooltip' => 'LBL_CREATE_BUTTON_LABEL',
                ),
                array(
                    'type' => 'link-action',
                    'name' => 'select_button',
                    'label' => 'LBL_ASSOC_RELATED_RECORD',
                    'initial_filter' => 'filterByAccountIdAndBundle',
                    'initial_filter_label' => 'LBL_FILTER_BY_ACCOUNT_ID_AND_BUNDLE',
                    //the dynamic filters to pass to the templates filter definition
                    //please note the index of the array will be for the field the data is being pulled from
                    'filter_relate' => array(
                        //'field_to_pull_data_from' => 'field_to_populate_data_to'
                        'account_id' => 'account_id',
                    )
                ),
                array(
                    'type' => 'copy-link-action',
                    'name' => 'copy_select_button',
                    'label' => 'LBL_COPY_RELATED_RECORD',
                    'initial_filter' => 'filterByBundle',
                    'initial_filter_label' => 'LBL_FILTER_BY_BUNDLE',
                    //the dynamic filters to pass to the templates filter definition
                    //please note the index of the array will be for the field the data is being pulled from
                    // To me it is really confusing, I believe there is no need of adding ('parent' => 'is_bundle_product_c')
                    // because parent is not any field, how Sugar will get the value of that and copy to is_bundle_product_c.
                    // If we remove this this filter does not work. 
                    'filter_relate' => array(
                        //'field_to_pull_data_from' => 'field_to_populate_data_to'
                        'parent' => 'is_bundle_product_c',
                    )
                ),
            ),
        ),
    ),
    'fields' => array(
        array(
            'name' => 'collection-count',
            'type' => 'collection-count',
        ),
    ),
);
