<?php

$dictionary['WPM_Waste_Profile_Module']['fields']['certificates'] = array(
    'name' => 'certificates',
    'type' => 'multienum',
    'isMultiSelect' => true,
    'function' => 'getCertificatesForWP',
    'vname' => 'LBL_CERTIFICATES',
    'reportable' => false,
    'duplicate_merge' => 'disabled',
    'audited' => true,
);
