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
$module_name = 'sales_and_services';
$viewdefs[$module_name]['base']['view']['subpanel-list'] = array(
  'panels' => 
  array(
    array(
      'name' => 'panel_header',
      'label' => 'LBL_PANEL_1',
      'fields' =>
      array(
        0 => 
        array (
          'label' => 'LBL_NAME',
          'enabled' => true,
          'default' => true,
          'name' => 'name',
          'link' => true,
        ),
        1 => 
        array (
          'name' => 'profile_no_c',
          'label' => 'LBL_PROFILE_NO',
          'enabled' => true,
          'default' => true,
        ),
        2 => 
        array (
          'name' => 'on_date_c',
          'label' => 'LBL_ON_DATE',
          'enabled' => true,
          'default' => true,
        ),
        3 => 
        array (
          'name' => 'on_time_c',
          'label' => 'LBL_ON_TIME',
          'enabled' => true,
          'default' => true,
        ),
        4 => 
        array (
          'name' => 'svc_days_c',
          'label' => 'LBL_SVC_DAYS',
          'enabled' => true,
          'default' => true,
        ),
        5 => 
        array (
          'name' => 'status_c',
          'label' => 'LBL_STATUS',
          'enabled' => true,
          'default' => true,
        ),
      ),
    ),
  ),
    'orderBy' => array(
        'field' => 'date_modified',
        'direction' => 'desc',
    ),
);
