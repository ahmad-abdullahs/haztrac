<?php

require_once 'modules/ProductTemplates/ProductTemplate.php';

class CustomProductTemplate extends ProductTemplate {

    public function __construct() {
        parent::__construct();
    }

}

function getPTCertificatesForCustomer() {
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

function getPTCertificatesForTransporter() {
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

function getPTCertificatesForConsignee() {
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

function getPTCertificatesForShipper() {
    $query = new SugarQuery();
    $query->from(BeanFactory::getBean("wp_terms_and_conditions"), array(
        'team_security' => false
    ));
    $query->select(array('id', 'name'));
    $query->where()->equals('module_type_c', 'Shipper Certificate');
    $query->orderBy('name', 'ASC');
    $result = $query->execute();
    $allTermAndConditions = array('' => '');
    foreach ($result as $row) {
        $allTermAndConditions[$row['id']] = $row['name'];
    }
    return $allTermAndConditions;
}
