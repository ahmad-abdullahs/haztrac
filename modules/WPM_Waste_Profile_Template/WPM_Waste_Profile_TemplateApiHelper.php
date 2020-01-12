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

class WPM_Waste_Profile_TemplateApiHelper extends SugarBeanApiHelper {

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
                'uom',
                'not_applicable',
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
                'uom',
                'not_applicable',
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
                'uom',
                'not_applicable',
            ),
        ));
        $data = $this->formatForConstituent($bean, $fieldList, $data, array(
            'name' => 'constituent_other',
            'type' => 'Other Constituents',
            'orderBy' => 'name',
            'selectionList' => array(
                'epa_waste_code',
                'regulatory_level',
                'tclp',
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
                    waste_composition.name AS 'composition_name',
                    waste_composition.min AS 'composition_min',
                    waste_composition.max AS 'composition_max',
                    waste_composition.uom AS 'composition_uom'
                FROM
                    wpm_waste_profile_template_waste_composition_c wpm_waste_profile_template_waste_composition_c
                        INNER JOIN
                    waste_composition waste_composition ON 
                        wpm_waste_profile_template_waste_composition_c.wpm_waste_a412osition_idb = waste_composition.id
                        AND wpm_waste_profile_template_waste_composition_c.deleted = '0'
                        AND waste_composition.deleted = '0'
                WHERE
                    wpm_waste_profile_template_waste_composition_c.wpm_waste_90faemplate_ida = '{$bean->id}' 
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
                    wpm_waste_profile_template_waste_constituents_c wpm_waste_profile_template_waste_constituents_c
                        INNER JOIN
                    waste_constituents waste_constituents ON 
                        wpm_waste_profile_template_waste_constituents_c.wpm_waste_177fituents_idb = waste_constituents.id
                        AND wpm_waste_profile_template_waste_constituents_c.deleted = '0'
                        AND waste_constituents.deleted = '0'
                        AND waste_constituents.type = "{$additionalParam['type']}"
                WHERE
                    wpm_waste_profile_template_waste_constituents_c.wpm_waste_73d2emplate_ida = '{$bean->id}' 
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
