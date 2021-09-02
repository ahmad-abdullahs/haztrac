<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class Doc_ManagerSaveHooks {

    function after_save($bean, $event, $arguments) {
        
    }

    function before_save($bean, $event, $arguments) {
        // If record is new
        if (isset($arguments['isUpdate']) && $arguments['isUpdate'] == false) {
            $bean->new_with_id = true;
            // The reason to pass potential_id is to make the record id same as the 
            // document template id.
            $bean->id = $bean->potential_id;
        }
    }

}
