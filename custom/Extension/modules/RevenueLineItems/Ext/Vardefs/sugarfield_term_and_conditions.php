<?php

$dictionary['RevenueLineItem']['fields']['customer_certificates'] = array(
    'name' => 'customer_certificates',
    'type' => 'multienum',
    'isMultiSelect' => true,
    'function' => 'getCertificatesForCustomer',
    'vname' => 'LBL_CUSTOMER_CERTIFICATES',
    'reportable' => false,
    'duplicate_merge' => 'disabled',
    'audited' => true,
);

$dictionary['RevenueLineItem']['fields']['transporter_certificates'] = array(
    'name' => 'transporter_certificates',
    'type' => 'multienum',
    'isMultiSelect' => true,
    'function' => 'getCertificatesForTransporter',
    'vname' => 'LBL_TRANSPORTER_CERTIFICATES',
    'reportable' => false,
    'duplicate_merge' => 'disabled',
    'audited' => true,
);

$dictionary['RevenueLineItem']['fields']['consignee_certificates'] = array(
    'name' => 'consignee_certificates',
    'type' => 'multienum',
    'isMultiSelect' => true,
    'function' => 'getCertificatesForConsignee',
    'vname' => 'LBL_CONSIGNEE_CERTIFICATES',
    'reportable' => false,
    'duplicate_merge' => 'disabled',
    'audited' => true,
);
