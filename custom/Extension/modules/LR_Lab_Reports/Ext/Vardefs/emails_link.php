<?php
// created: 2019-07-02 05:26:30
$dictionary["LR_Lab_Reports"]["fields"]["report_emails"] = array (
    'name' => 'report_emails',
    'type' => 'link',
    'link_file' => 'custom/modules/LR_Lab_Reports/LabReportEmailsLink.php',
    'link_class' => 'LabReportEmailsLink',
    'source' => 'non-db',
    'vname' => 'LBL_EMAILS',
    'module' => 'Emails',
    'link_type' => 'many',
    'relationship' => '',
    'hideacl' => true,
    'readonly' => true,
);
