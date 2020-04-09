<?php

/*
 *                              *****IMPORTANT NOTE*****
 * This file is used when the bean is fetched it will call this file to format 
 * the bean before send to view for rendering.
 * ------This file does not help in saving etc. its like using the process_record hook.------
 * This is overriden because of two reasons:
 * 
 * 1- This widget field uses the relate fields, sa the (name, id) both are saved in JSON, When user change 
 * the name of record, it is not updated in the widget field because it has the name saved in DB in JSON. 
 * Because of this reason we have to write the queries to pull the name each time and send it to the view 
 * so that if the name is changed, it will not use the DB JSON data, despite it get the fresh name.
 * 
 * 2- Let say the record is deleted, but it still exist in the JSON (because JSON does not know 
 * the record is deleted or not), So it is overridden to remove the data from JSON
 * where relate field record is deleted.
 */
require_once 'custom/include/ModuleApiHelper/contractUtils.php';

class Contracts_TemplateApiHelper extends SugarBeanApiHelper {

    // Mimic the SugarBeanApiHelper->formatForApi() class
    public function formatForApi(SugarBean $bean, array $fieldList = array(), array $options = array()) {
        $data = parent::formatForApi($bean, $fieldList, $options);
        $data = customFormatForApiHelper($bean, $fieldList, $options, $data);
        return $data;
    }

}
