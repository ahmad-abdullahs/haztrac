<?php

/**
 * JS Grouping File
 * To Include the library
 */
//creates the file cache/include/javascript/newGrouping.js
foreach ($js_groupings as $key => $groupings) {
    foreach ($groupings as $file => $target) {
        //if the target grouping is found
        if ($target == 'include/javascript/sugar_grp7.min.js') {
            //append the custom JavaScript file
            $js_groupings[$key]['custom/include/javascript/sugar7/plugins/ListControlPagination.js'] = 'include/javascript/sugar_grp7.min.js';
            break;
        }
    }
}
