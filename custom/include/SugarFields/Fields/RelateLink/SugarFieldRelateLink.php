<?php

require_once 'include/SugarFields/Fields/RelateLink/SugarFieldRelateLink.php';

class CustomSugarFieldRelateLink extends SugarFieldRelateLink {

    /**
     * Return the data that should be returned for link or collection field
     *
     * @param SugarBean $bean Source bean
     * @param array $field Link or collection field definition
     * @param array $displayParams Field display parameters
     * @param ServiceBase $service
     *
     * @return array
     * @throws SugarApiExceptionError
     */
    protected function getBeanCollection(SugarBean $bean, array $field, array $displayParams, ServiceBase $service) {
        $args = array_merge(array(
            // make sure "fields" argument is always passed to the API
            // since otherwise it will return all fields by default
            'fields' => array('id', 'date_modified', 'name'),
                ), $displayParams, array(
            'module' => $bean->module_name,
            'record' => $bean->id,
            'link_name' => $field['name'],
        ));

        $response = $this->getRelateApi()->filterRelated($service, $args);

        return $response;
    }

}