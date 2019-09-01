<?php

global $sugar_config;

$template_file = "{$sugar_config['upload_dir']}/{$_REQUEST['report_id']}";
$content = file_get_contents($template_file);

$lab_report = BeanFactory::retrieveBean('PNL_Permits_Licenses', $_REQUEST['report_id']);

ob_clean();
header('Content-Type: ' . $lab_report->file_mime_type);
header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Content-Length: ' . strlen($content));
header('Content-Disposition: inline; filename="' . $lab_report->filename . '"');

echo $content;
