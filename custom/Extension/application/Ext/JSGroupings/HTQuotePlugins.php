<?php

foreach ($js_groupings as $key => $groupings)
{
    foreach  ($groupings as $file => $target)
    {
    	//if the target grouping is found
        if ($target == 'include/javascript/sugar_sidecar.min.js')
        {
            //append the custom JavaScript file
            $js_groupings[$key]['custom/include/javascript/sugar7/plugins/HTMassQuote.js'] = 'include/javascript/sugar_sidecar.min.js';
            $js_groupings[$key]['modules/HT_SS_Quotes/clients/base/plugins/HTQuotesLineNumHelper.js'] = 'include/javascript/sugar_sidecar.min.js';
            $js_groupings[$key]['modules/HT_SS_Quotes/clients/base/plugins/HTQuotesViewSaveHelper.js'] = 'include/javascript/sugar_sidecar.min.js';
        }
        break;
    }
}
