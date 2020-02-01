<?php

// http://localhost/haztrac/#bwc/index.php?entryPoint=TestCodeEntryPointRegistry

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

$views = array('recordview');
$finalFieldsList = array();
$viewFieldsList = array();
$relatedFieldsList = array();
$bannedFieldsList = array(
    'picture', 'favorite', 'follow', 'team_name', 'campaign_name',
    'date_entered_by', 'date_modified_by', 'date_entered', 'date_modified', 'created_by_name',
    'modified_by_name'
);

foreach ($views as $view) {
    try {
        $parser = ParserFactory::getParser($view, 'RevenueLineItems');
    } catch (Exception $e) {
        $GLOBALS['log']->fatal("Caught exception in RepairFieldCasing script: " . $e->getMessage());
        continue;
    }

    if (isset($parser->_viewdefs['panels'])) {
        $viewDefFullForm = $parser->convertToCanonicalForm($parser->_viewdefs['panels'], $parser->_fielddefs);
        $fieldsFromPanels = $parser->getFieldsFromPanels($viewDefFullForm);

        // Also push related fields to fields list
        foreach ($fieldsFromPanels as $key => $value) {
            if (is_array($value) && isset($value['related_fields'])) {
                $relatedFieldsList = array_merge($relatedFieldsList, $value['related_fields']);
            }
            array_push($viewFieldsList, $key);
        }

        // Merge view fields and related fields
        $finalFieldsList = array_merge($viewFieldsList, $relatedFieldsList);
        // Remove the banned fields
        $finalFieldsList = array_diff($finalFieldsList, $bannedFieldsList);
        // Remove the duplicate entries
        $finalFieldsList = array_unique($finalFieldsList);
    }
}

return $finalFieldsList;
