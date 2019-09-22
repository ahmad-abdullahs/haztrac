<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class before_delete_class {

    function before_delete_method($bean, $event, $arguments) {
        // If RLI is going to be deleted, check if its the bundle,
        // get the related items and delete those items as well...
        $bean->load_relationship('revenuelineitems_revenuelineitems_1');
        $relatedRLIS = $bean->revenuelineitems_revenuelineitems_1->getBeans();
        foreach ($relatedRLIS as $rli) {
            $rli->mark_deleted($rli->id);
            $rli->save();
        }
    }

}
