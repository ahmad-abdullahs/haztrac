<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class before_save_class {

    //{$db->quoted($account_role_obj->composition_role)}
    function before_save_method($bean, $event, $arguments) {
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
                    $compositionBean->save();
                }
            }
        }
    }

}
