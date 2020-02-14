<?PHP

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
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/WPM_Waste_Profile_Template/WPM_Waste_Profile_Template_sugar.php');

class WPM_Waste_Profile_Template extends WPM_Waste_Profile_Template_sugar {
    
}

function getCertificatesForWPT() {
    $query = new SugarQuery();
    $query->from(BeanFactory::getBean("wp_terms_and_conditions"), array(
        'team_security' => false
    ));
    $query->select(array('id', 'name'));
    $query->where()->equals('module_type_c', 'Waste Profile Certificate');
    $query->orderBy('name', 'ASC');
    $result = $query->execute();
    $allTermAndConditions = array('' => '');
    foreach ($result as $row) {
        $allTermAndConditions[$row['id']] = $row['name'];
    }
    return $allTermAndConditions;
}
