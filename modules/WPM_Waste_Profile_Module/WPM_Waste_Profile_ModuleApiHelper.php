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

class WPM_Waste_Profile_ModuleApiHelper extends SugarBeanApiHelper {

    public function formatForApi(\SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $data = parent::formatForApi($bean, $fieldList, $options);
//        $GLOBALS['log']->fatal('$fieldList : ' . print_r($fieldList, 1));
        if (empty($fieldList) || in_array('composition', $fieldList)) {
            // Pushing Waste Composition data in Waste Profile Model
            $data['composition'] = array();

            $sql = <<<SQL
                    SELECT 
                    -- waste_composition_wpm_waste_profile_module_c.waste_composition_wpm_waste_profile_modulewaste_composition_idb AS 'composition_name_id',
                    waste_composition.name AS 'composition_name',
                    waste_composition.min AS 'composition_min',
                    waste_composition.max AS 'composition_max',
                    waste_composition.uom AS 'composition_uom'
                FROM
                    waste_composition_wpm_waste_profile_module_c waste_composition_wpm_waste_profile_module_c
                        INNER JOIN
                    waste_composition waste_composition ON 
                        waste_composition_wpm_waste_profile_module_c.waste_composition_wpm_waste_profile_modulewaste_composition_idb = waste_composition.id
                        AND waste_composition_wpm_waste_profile_module_c.deleted = '0'
                        AND waste_composition.deleted = '0'
                WHERE
                    waste_composition_wpm_waste_profile_module_c.waste_comp1299_module_ida = '{$bean->id}' 
                ORDER BY waste_composition.name
SQL;
            global $db;

            $res = $db->query($sql);
            while ($row = $db->fetchByAssoc($res)) {
                $data['composition'][] = $row;
            }
        }

        $data['composition'] = json_encode($data['composition']);
        return $data;
    }

}
