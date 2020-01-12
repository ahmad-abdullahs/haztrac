<?php

$dictionary['WPM_Waste_Profile_Template']['fields']['certificates'] = array(
    'name' => 'certificates',
    'type' => 'multienum',
    'isMultiSelect' => true,
    'function' => 'getCertificatesForWPT',
    'vname' => 'LBL_CERTIFICATES',
    'reportable' => false,
    'duplicate_merge' => 'disabled',
    'audited' => true,
);
