<?php

$dictionary["queue_workorder"]["fields"]["pdf_template_name"] = array(
    'name' => 'pdf_template_name',
    'type' => 'relate',
    'source' => 'non-db',
    'vname' => 'LBL_PDF_TEMPLATE_NAME',
    'save' => true,
    'id_name' => 'pdf_template_id',
    'table' => 'pdfmanager',
    'module' => 'PdfManager',
    'rname' => 'name',
);

$dictionary["queue_workorder"]["fields"]["pdf_template_id"] = array(
    'name' => 'pdf_template_id',
    'type' => 'id',
    'vname' => 'LBL_PDF_TEMPLATE_ID',
    'id_name' => 'pdf_template_id',
    'table' => 'pdfmanager',
    'module' => 'PdfManager',
    'rname' => 'id',
    'reportable' => false,
    'massupdate' => false,
    'duplicate_merge' => 'disabled',
    'hideacl' => true,
);
