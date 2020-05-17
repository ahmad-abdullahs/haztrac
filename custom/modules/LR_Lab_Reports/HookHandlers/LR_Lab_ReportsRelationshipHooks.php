<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class LR_Lab_ReportsRelationshipHooks {

    function after_save($bean, $event, $arguments) {
        if (isset($bean->manifests) && !empty($bean->manifests)) {
            global $db;
            $bean->manifest_galon_total = $this->fetchAndRecalculateManifestGalonTotal($bean->manifests);
            $updateQuery = "UPDATE lr_lab_reports 
                    SET 
                        manifest_galon_total = '{$bean->manifest_galon_total}'
                    WHERE
                        id = '{$bean->id}'";
            $db->query($updateQuery);
        }
    }

    function after_relationship_add($bean, $event, $arguments) {
        $this->updateManifestGalonTotal($bean, $event, $arguments);
    }

    function after_relationship_delete($bean, $event, $arguments) {
        $this->updateManifestGalonTotal($bean, $event, $arguments);
    }

    function updateManifestGalonTotal($bean, $event, $arguments) {
        global $db;
        if ($arguments['module'] == 'LR_Lab_Reports' && $arguments['related_module'] == 'HT_Manifest' &&
                $arguments['link'] == 'ht_manifest_lr_lab_reports_1') {
            // loop prevention check
            if (!isset($bean->ignore_update_c) || $bean->ignore_update_c === false) {
                // update
                $bean->ignore_update_c = true;
                $bean->manifest_galon_total = $this->recalculateManifestGalonTotal($bean);
                $updateQuery = "UPDATE lr_lab_reports 
                    SET 
                        manifest_galon_total = '{$bean->manifest_galon_total}'
                    WHERE
                        id = '{$bean->id}'";
                $db->query($updateQuery);
            }
        }
    }

    function recalculateManifestGalonTotal($bean) {
        $rli_galon_total = 0.00;
        // Load related manifest beans ...
        if ($bean->load_relationship('ht_manifest_lr_lab_reports_1')) {
            $relatedManifests = $bean->ht_manifest_lr_lab_reports_1->getBeans(array(), array('disable_row_level_security' => true));
            foreach ($relatedManifests as $manifestBean) {
                $rli_galon_total += $manifestBean->rli_galon_total;
            }
        } else {
            $GLOBALS['log']->fatal('Relationship is not loaded.');
        }
        return $rli_galon_total;
    }

    function fetchAndRecalculateManifestGalonTotal($manifests) {
        $rli_galon_total = 0.00;
        // Load related manifest beans ...
        foreach ($manifests as $manifestEntry) {
            if (isset($manifestEntry['id'])) {
                $manifestBean = BeanFactory::getBean("HT_Manifest", $manifestEntry['id']);
                $rli_galon_total += $manifestBean->rli_galon_total;
            }
        }
        return $rli_galon_total;
    }

}
