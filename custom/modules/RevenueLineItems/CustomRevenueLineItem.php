<?php

require_once 'modules/RevenueLineItems/RevenueLineItem.php';

class CustomRevenueLineItem extends RevenueLineItem {

    public function __construct() {
        parent::__construct();
    }

    protected function mapFieldsFromProductTemplate() {
        
    }

}

function getCertificatesForCustomer() {
    $query = new SugarQuery();
    $query->from(BeanFactory::getBean("wp_terms_and_conditions"), array(
        'team_security' => false
    ));
    $query->select(array('id', 'name'));
    $query->where()->equals('module_type_c', 'Customer Certificate');
    $query->orderBy('name', 'ASC');
    $result = $query->execute();
    $allTermAndConditions = array('' => '');
    foreach ($result as $row) {
        $allTermAndConditions[$row['id']] = $row['name'];
    }
    return $allTermAndConditions;
}

function getCertificatesForTransporter() {
    $query = new SugarQuery();
    $query->from(BeanFactory::getBean("wp_terms_and_conditions"), array(
        'team_security' => false
    ));
    $query->select(array('id', 'name'));
    $query->where()->equals('module_type_c', 'Transporter Certificate');
    $query->orderBy('name', 'ASC');
    $result = $query->execute();
    $allTermAndConditions = array('' => '');
    foreach ($result as $row) {
        $allTermAndConditions[$row['id']] = $row['name'];
    }
    return $allTermAndConditions;
}

function getCertificatesForConsignee() {
    $query = new SugarQuery();
    $query->from(BeanFactory::getBean("wp_terms_and_conditions"), array(
        'team_security' => false
    ));
    $query->select(array('id', 'name'));
    $query->where()->equals('module_type_c', 'Consignee Certificate');
    $query->orderBy('name', 'ASC');
    $result = $query->execute();
    $allTermAndConditions = array('' => '');
    foreach ($result as $row) {
        $allTermAndConditions[$row['id']] = $row['name'];
    }
    return $allTermAndConditions;
}
