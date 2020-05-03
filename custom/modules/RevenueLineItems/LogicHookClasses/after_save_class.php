<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class after_save_class {

    function after_save_method($bean, $event, $arguments) {
        // New record
        if (!isset($bean->fetched_row['id']) && $bean->createBundleLogic == 1) {
            global $db;
            $sql = "UPDATE revenue_line_items_cstm SET is_bundle_product_c='parent' WHERE id_c='{$bean->id}';";
            $db->query($sql, true);
        }
    }

}
