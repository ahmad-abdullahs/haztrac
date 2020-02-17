<?php

$dictionary['ProductTemplate']['fields']['customer_certificates'] = array(
    'name' => 'customer_certificates',
    'type' => 'multienum',
    'isMultiSelect' => true,
    'function' => 'getPTCertificatesForCustomer',
    'vname' => 'LBL_CUSTOMER_CERTIFICATES',
    'reportable' => false,
    'duplicate_merge' => 'disabled',
    'audited' => true,
);

$dictionary['ProductTemplate']['fields']['transporter_certificates'] = array(
    'name' => 'transporter_certificates',
    'type' => 'multienum',
    'isMultiSelect' => true,
    'function' => 'getPTCertificatesForTransporter',
    'vname' => 'LBL_TRANSPORTER_CERTIFICATES',
    'reportable' => false,
    'duplicate_merge' => 'disabled',
    'audited' => true,
);

$dictionary['ProductTemplate']['fields']['consignee_certificates'] = array(
    'name' => 'consignee_certificates',
    'type' => 'multienum',
    'isMultiSelect' => true,
    'function' => 'getPTCertificatesForConsignee',
    'vname' => 'LBL_CONSIGNEE_CERTIFICATES',
    'reportable' => false,
    'duplicate_merge' => 'disabled',
    'audited' => true,
);
