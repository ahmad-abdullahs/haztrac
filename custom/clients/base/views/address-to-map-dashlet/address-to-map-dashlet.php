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

$viewdefs['base']['view']['address-to-map-dashlet'] = array(
    'dashlets' => array(
        array(
            'label' => 'LBL_DASHLET_ADDRESS_TO_MAP',
            'description' => 'LBL_DASHLET_ADDRESS_TO_MAP_DESCRIPTION',
            'config' => array(),
            'preview' => array(),
        ),
    ),
    'panels' => array(
        array(
            'name' => 'dashlet_settings',
            'columns' => 2,
            'labelsOnTop' => true,
            'placeholders' => true,
            'fields' => array(
                array(
                    'name' => 'relate_field',
                    'label' => 'LBL_DASHLET_CONFIGURE_RELATE_FIELDS',
                    'type' => 'enum',
                    'required' => true,
                    'sort_alpha' => true,
                    'ordered' => true,
                ),
                array(
                    'name' => 'address_field',
                    'label' => 'LBL_DASHLET_CONFIGURE_ADDRESS_FIELDS',
                    'type' => 'enum',
                    'sort_alpha' => true,
                    'ordered' => true,
                    'required' => true,
                ),
            ),
        ),
    ),
);
