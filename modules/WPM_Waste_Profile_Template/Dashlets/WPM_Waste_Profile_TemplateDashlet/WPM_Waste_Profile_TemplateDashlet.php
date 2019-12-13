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
/*********************************************************************************
 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/WPM_Waste_Profile_Template/WPM_Waste_Profile_Template.php');

class WPM_Waste_Profile_TemplateDashlet extends DashletGeneric { 
    public function __construct($id, $def = null)
    {
		global $current_user, $app_strings;
		require('modules/WPM_Waste_Profile_Template/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'WPM_Waste_Profile_Template');

        $this->searchFields = $dashletData['WPM_Waste_Profile_TemplateDashlet']['searchFields'];
        $this->columns = $dashletData['WPM_Waste_Profile_TemplateDashlet']['columns'];

        $this->seedBean = new WPM_Waste_Profile_Template();        
    }
}