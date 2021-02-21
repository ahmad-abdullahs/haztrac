<?php

function getViewColumns($module, $view = 'listview') {
    $fieldsList = array();
    // Default, Available, Hidden
    $colTypes = array(
        'LBL_DEFAULT' => 'Default',
        'LBL_AVAILABLE' => 'Available',
        'LBL_HIDDEN' => 'Hidden',
    );
    $parser = ParserFactory::getParser($view, $module);
    foreach ($parser->columns as $column => $function) {
        // call the parser functions to populate the list view columns, 
        // by default 'default', 'available' and 'hidden'
        $groups [$colTypes[$column]] = $parser->$function();
    }
    foreach ($groups['Default'] as $key => $value) {
        // Bool is excluded, otherwise it was not letting anything to filter
        if ($value['type'] != 'bool') {
            array_push($fieldsList, $key);
        }
    }
    return $fieldsList;
}

function getViewFields($view, $module) {
    $finalFieldsList = array();
    $viewFieldsList = array();
    $fieldSetFields = array();
    $relatedFieldsList = array();
    $bannedFieldsList = array(
        'picture', 'favorite', 'follow', 'team_name', 'campaign_name',
//        'date_entered_by', 'date_modified_by', 'date_entered', 'date_modified', 'created_by_name',
//        'modified_by_name'
    );

    try {
        $parser = ParserFactory::getParser($view, $module);

        if (isset($parser->_viewdefs['panels'])) {
            $viewDefFullForm = $parser->convertToCanonicalForm($parser->_viewdefs['panels'], $parser->_fielddefs);
            $fieldsFromPanels = $parser->getFieldsFromPanels($viewDefFullForm);

            // Also push related fields to fields list
            foreach ($fieldsFromPanels as $key => $value) {
                if (is_array($value) && isset($value['related_fields'])) {
                    $relatedFieldsList = array_merge($relatedFieldsList, $value['related_fields']);
                }
                if (is_array($value) && isset($value['fields'])) {
                    foreach ($value['fields'] as $_key => $_value) {
                        if (is_array($_value)) {
                            $fieldSetFields = array_merge($fieldSetFields, (array) $_value['name']);
                        } else {
                            $fieldSetFields = array_merge($fieldSetFields, (array) $_value);
                        }
                    }
                }
                array_push($viewFieldsList, $key);
            }

            // Merge view fields, fieldset fields and related fields
            $finalFieldsList = array_merge($viewFieldsList, $relatedFieldsList, $fieldSetFields);
            // Remove the banned fields
            $finalFieldsList = array_diff($finalFieldsList, $bannedFieldsList);
            // Remove the duplicate entries
            $finalFieldsList = array_unique($finalFieldsList);
        }
    } catch (Exception $e) {
        $GLOBALS['log']->fatal("Caught exception in getViewFields custom_utils: " . $e->getMessage());
    }

    return $finalFieldsList;
}
