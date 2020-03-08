<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class before_delete_class {

    function before_delete_method($bean, $event, $arguments) {
        // If product template is going to be deleted, check if its the bundle,
        // get the related product templates and delete those items as well...
        $bean->load_relationship('product_templates_product_templates_1');
        $relatedRLIS = $bean->product_templates_product_templates_1->getBeans();
        foreach ($relatedRLIS as $rli) {
            // We have added this check for the case:
            // when user delete the bundle which is linked to any group (Since a bundle has relationship with its group)
            // So that group will also come when above relationship is loaded, and that group will be wrongly deleted.
            // We intend to delete the bundle only not the group it is associated to, that's why this check is added to avoid that.
            if ($rli->is_group_item_c != 1) {
                $rli->mark_deleted($rli->id);
                $rli->save();
            }
        }
    }

}
