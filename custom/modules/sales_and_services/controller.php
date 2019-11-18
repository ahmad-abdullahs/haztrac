<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class sales_and_servicesController extends SugarController {

    public function action_manifest() {
        $this->view = 'manifest';
    }

}
