<?php

global $sugar_config;
if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
    require_once 'include/upload_file.php';
    $uploadDir = 'pdfs/';
    $filename = $_REQUEST['id'] . '.pdf';

    $f = new UploadFile();
    $f->temp_file_location = $uploadDir . $_REQUEST['id'] . '.pdf';

    if (!empty($_REQUEST['module']) && !empty($_REQUEST['id'])) {
        $record = BeanFactory::retrieveBean($_REQUEST['module'], $_REQUEST['id']);
        $filename = $record->filename;
        $filename = str_replace(' ', '', $filename);
        $filename = str_replace(',', '-', $filename);
    }

    $contents = $f->get_file_contents();

    if (strlen($contents) > 0) {
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename=' . $filename);
        header('Content-Transfer-Encoding: binary');
        header('Content-Length:' . strlen($contents));
        header('Accept-Ranges: bytes');
        echo $contents;
    } else {
        echo 'File not found or corrupted';
    }
}
