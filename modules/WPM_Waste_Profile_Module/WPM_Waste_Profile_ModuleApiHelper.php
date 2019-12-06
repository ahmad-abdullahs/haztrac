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
        $data = $this->formatForComposition($bean, $fieldList, $data);
        $data = $this->formatForConstituent($bean, $fieldList, $data, array(
            'name' => 'constituent_regulated',
            'type' => 'Regulated',
            'orderBy' => 'name',
            'selectionList' => array(
                'epa_waste_code',
                'regulatory_level',
                'tclp',
                'uom',
                'not_applicable',
            ),
        ));
        $data = $this->formatForConstituent($bean, $fieldList, $data, array(
            'name' => 'constituent_volatile',
            'type' => 'Volatile',
            'orderBy' => 'name',
            'selectionList' => array(
                'epa_waste_code',
                'regulatory_level',
                'tclp',
            ),
        ));
        $data = $this->formatForConstituent($bean, $fieldList, $data, array(
            'name' => 'constituent_semivolatile',
            'type' => 'Semi-Volatile',
            'orderBy' => 'name',
            'selectionList' => array(
                'epa_waste_code',
                'regulatory_level',
                'tclp',
            ),
        ));
        $data = $this->formatForConstituent($bean, $fieldList, $data, array(
            'name' => 'constituent_pesticide_herbicide',
            'type' => 'Pesticides And Herbicides',
            'orderBy' => 'name',
            'selectionList' => array(
                'epa_waste_code',
                'regulatory_level',
                'tclp',
            ),
        ));
        $data = $this->formatForConstituent($bean, $fieldList, $data, array(
            'name' => 'constituent_other',
            'type' => 'Other Constituents',
            'orderBy' => 'name',
            'selectionList' => array(
                'other',
                'max',
                'uom',
                'not_applicable',
            ),
        ));
        return $data;
    }

    public function formatForComposition($bean, $fieldList, $data) {
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

            $data['composition'] = json_encode($data['composition']);
        }

        return $data;
    }

    public function formatForConstituent($bean, $fieldList, $data, $additionalParam = array()) {
        if (empty($fieldList) || in_array($additionalParam['name'], $fieldList)) {
            // Pushing Waste Constituent data in Waste Profile Model
            $data[$additionalParam['name']] = array();

            $selectionArr = array();
            foreach ($additionalParam['selectionList'] as $value) {
                array_push($selectionArr, "waste_constituents.{$value} AS {$additionalParam['name']}_{$value}");
            }

            $selectionStr = implode(',', $selectionArr);

            $sql = <<<SQL
                    SELECT 
                    $selectionStr
                FROM
                    waste_constituents_wpm_waste_profile_module_c waste_constituents_wpm_waste_profile_module_c
                        INNER JOIN
                    waste_constituents waste_constituents ON 
                        waste_constituents_wpm_waste_profile_module_c.waste_cons8758ituents_idb = waste_constituents.id
                        AND waste_constituents_wpm_waste_profile_module_c.deleted = '0'
                        AND waste_constituents.deleted = '0'
                        AND waste_constituents.type = "{$additionalParam['type']}"
                WHERE
                    waste_constituents_wpm_waste_profile_module_c.waste_cons93c5_module_ida = '{$bean->id}' 
                ORDER BY waste_constituents.{$additionalParam['orderBy']}
SQL;
            global $db;

            $res = $db->query($sql);
            while ($row = $db->fetchByAssoc($res)) {
                $data[$additionalParam['name']][] = $row;
            }

            $data[$additionalParam['name']] = json_encode($data[$additionalParam['name']]);
        }

        return $data;
    }

}
