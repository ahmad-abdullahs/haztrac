<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class before_save_class {

    function before_save_method($bean, $event, $arguments) {
//        $this->handleConstituentField($bean, $event, $arguments, array(
//            'name' => 'constituent_volatile',
//            'type' => 'Volatile',
//            'primary_field' => 'epa_waste_code',
//            'updateList' => array(
//                'epa_waste_code',
//                'regulatory_level',
//                'tclp',
//                'uom',
//                'not_applicable',
//            ),
//        ));
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
