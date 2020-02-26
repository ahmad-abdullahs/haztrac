<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class before_save_class {

    function before_save_method($bean, $event, $arguments) {
//        $this->jumpWasteProfileNumBy3($bean, $event, $arguments);
        $this->handleCompositionField($bean, $event, $arguments);
        $this->handleConstituentField($bean, $event, $arguments, array(
            'name' => 'constituent_regulated',
            'type' => 'Regulated',
            'primary_field' => 'epa_waste_code',
            'updateList' => array(
                'epa_waste_code',
                'regulatory_level',
                'tclp',
                'uom',
                'not_applicable',
            ),
        ));
        $this->handleConstituentField($bean, $event, $arguments, array(
            'name' => 'constituent_volatile',
            'type' => 'Volatile',
            'primary_field' => 'epa_waste_code',
            'updateList' => array(
                'epa_waste_code',
                'regulatory_level',
                'tclp',
                'uom',
                'not_applicable',
            ),
        ));
        $this->handleConstituentField($bean, $event, $arguments, array(
            'name' => 'constituent_semivolatile',
            'type' => 'Semi-Volatile',
            'primary_field' => 'epa_waste_code',
            'updateList' => array(
                'epa_waste_code',
                'regulatory_level',
                'tclp',
                'uom',
                'not_applicable',
            ),
        ));
        $this->handleConstituentField($bean, $event, $arguments, array(
            'name' => 'constituent_pesticide_herbicide',
            'type' => 'Pesticides And Herbicides',
            'primary_field' => 'epa_waste_code',
            'updateList' => array(
                'epa_waste_code',
                'regulatory_level',
                'tclp',
                'uom',
                'not_applicable',
            ),
        ));
        $this->handleConstituentField($bean, $event, $arguments, array(
            'name' => 'constituent_other',
            'type' => 'Other Constituents',
            'primary_field' => 'epa_waste_code',
            'updateList' => array(
                'epa_waste_code',
                'regulatory_level',
                'tclp',
                'uom',
                'not_applicable',
            ),
        ));
    }

    function jumpWasteProfileNumBy3($bean, $event, $arguments) {
        // Check if its new record
        if (isset($arguments['isUpdate']) && $arguments['isUpdate'] == false) {
            $sql = <<<SQL
                    SELECT 
                        MAX(waste_profile_num_c) AS waste_profile_num_c
                    FROM
                        wpm_waste_profile_module_cstm;
SQL;
            global $db;

            $res = $db->query($sql);
            if ($res->num_rows > 0) {
                $row = $db->fetchByAssoc($res);
                // Get the number out of the string.
                preg_match_all('!\d+!', $row['waste_profile_num_c'], $matches);
                if (!empty($matches) && is_array($matches[0])) {
                    $bean->waste_profile_num_c = 'P-' . ((int) $matches[0][0] + 3);
                }
            }
        }
    }

    function handleCompositionField($bean, $event, $arguments) {
        if ($bean->composition != $bean->fetched_row['composition']) {
            // Fetch all the waste compositions linked to this waste profile and delete those.
            // We are going to add the new ones
            // Delete the relationship link between waste compositions and waste profile
            if ($bean->load_relationship('waste_composition_wpm_waste_profile_module')) {
                // Get all the related record Ids
                //$wasteCompositionIds = $bean->waste_composition_wpm_waste_profile_module->get();
                // Delete the relationship
                // $bean->waste_composition_wpm_waste_profile_module->delete($bean->id);
                // Hard delete the records.
                $wasteCompositionBeans = $bean->waste_composition_wpm_waste_profile_module->getBeans();
                foreach ($wasteCompositionBeans as $wasteCompositionBean) {
                    $wasteCompositionBean->mark_deleted($wasteCompositionBean->id);
                    $wasteCompositionBean->save();
                }
            }

            // Add the relationship
            $composition_decoded = json_decode($bean->composition);
            foreach ($composition_decoded as $key => $composition_obj) {
                if (!empty($composition_obj->composition_name)) {
                    $compositionBean = BeanFactory::newBean('waste_composition');
                    $compositionBean->new_with_id = true;
                    $compositionBean->name = $composition_obj->composition_name;
                    $compositionBean->min = $composition_obj->composition_min;
                    $compositionBean->max = $composition_obj->composition_max;
                    $compositionBean->uom = $composition_obj->composition_uom;
                    $compositionBean->waste_comp1299_module_ida = $bean->id;
                    $compositionBean->assigned_user_id = $GLOBALS['current_user']->id;
                    $compositionBean->save();
                }
            }
        }
    }

    function handleConstituentField($bean, $event, $arguments, $additionalParam = array()) {
        if ($bean->{$additionalParam['name']} != $bean->fetched_row[$additionalParam['name']]) {
            // Fetch all the waste constituents linked to this waste profile and delete those.
            // We are going to add the new ones
            // Delete the relationship link between waste constituents and waste profile
            if ($bean->load_relationship('waste_constituents_wpm_waste_profile_module')) {
                // Get all the related record Ids and delete the relationship
                $wasteConstituentBeans = $bean->waste_constituents_wpm_waste_profile_module->getBeans();
                foreach ($wasteConstituentBeans as $wasteConstituentBean) {
                    if (strtolower($wasteConstituentBean->type) == strtolower($additionalParam['type'])) {
                        $wasteConstituentBean->mark_deleted($wasteConstituentBean->id);
                        $wasteConstituentBean->save();
                    }
                }
            }

            // Add the relationship
            $constituent_decoded = json_decode($bean->{$additionalParam['name']});
            foreach ($constituent_decoded as $constituent_obj) {
                if (!empty($constituent_obj->{$additionalParam['name'] . '_' . $additionalParam['primary_field']})) {
                    $constituentBean = BeanFactory::newBean('waste_constituents');
                    $constituentBean->new_with_id = true;

                    foreach ($additionalParam['updateList'] as $value) {
                        $constituentBean->$value = $constituent_obj->{$additionalParam['name'] . '_' . $value};
                    }

                    $constituentBean->name = $constituent_obj->{$additionalParam['name'] . '_' . $additionalParam['primary_field']} . " (" . $additionalParam['type'] . ") " . $bean->waste_profile_num_c;
                    $constituentBean->type = $additionalParam['type'];
                    $constituentBean->waste_cons93c5_module_ida = $bean->id;
                    $constituentBean->assigned_user_id = $GLOBALS['current_user']->id;
                    $constituentBean->save();
                }
            }
        }
    }

}
