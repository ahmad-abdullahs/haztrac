<?php

$dictionary['LR_Lab_Reports']['fields']['lr_lab_reports_test_method'] = array(
    'name' => 'lr_lab_reports_test_method',
    'type' => 'multienum',
    'isMultiSelect' => true,
    'function' => 'getLabReportTestMethods',
    'vname' => 'LBL_LR_LAB_REPORTS_TEST_METHOD',
    'reportable' => false,
    'duplicate_merge' => 'disabled',
    'audited' => true,
    'module' => 'Test_Method',
);
