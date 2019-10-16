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

require_once('modules/LR_Lab_Reports_Templates/LR_Lab_Reports_Templates.php');

class LR_Lab_Reports_TemplatesDashlet extends DashletGeneric { 
    public function __construct($id, $def = null)
    {
		global $current_user, $app_strings;
		require('modules/LR_Lab_Reports_Templates/metadata/dashletviewdefs.php');

        parent::__construct($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'LR_Lab_Reports_Templates');

        $this->searchFields = $dashletData['LR_Lab_Reports_TemplatesDashlet']['searchFields'];
        $this->columns = $dashletData['LR_Lab_Reports_TemplatesDashlet']['columns'];

        $this->seedBean = new LR_Lab_Reports_Templates();        
    }
}