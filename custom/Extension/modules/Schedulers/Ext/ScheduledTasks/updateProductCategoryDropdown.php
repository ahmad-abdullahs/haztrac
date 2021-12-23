<?php

function updateProductCategoryDropdown($job) {
    if (!empty($job->data)) {

        $data = html_entity_decode($job->data);
        $data = json_decode($data, true);

        require_once 'custom/clients/base/api/DropDownFiller.php';
        $dropDownUpdateHandler = new DropDownFiller();
        $dropDownUpdateHandler->addDropDownKeyValue(null, array(
            'list_name' => $data['list_name'],
            'item_key' => $data['item_key'],
            'item_value' => $data['item_value'],
            'lang' => $data['lang'],
        ));

        // return true for completed
        return true;
    }

    return false;
}
