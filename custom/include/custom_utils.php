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
        array_push($fieldsList, $key);
    }
    return $fieldsList;
}
