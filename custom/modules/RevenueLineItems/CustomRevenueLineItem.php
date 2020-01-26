<?php

require_once 'modules/RevenueLineItems/RevenueLineItem.php';

class CustomRevenueLineItem extends RevenueLineItem {

    public function __construct() {
        parent::__construct();
    }

    protected function mapFieldsFromProductTemplate() {
        
    }

}
