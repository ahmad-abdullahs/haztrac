<?php

require_once('custom/include/php_word/vendor/autoload.php');

$templateBean = BeanFactory::retrieveBean('word_templates', $_REQUEST['template_id']);
$recordBean = BeanFactory::retrieveBean($_REQUEST['targetModule'], $_REQUEST['targetModuleId'], array('disable_row_level_security' => true));

if ($templateBean == null || $recordBean == null) {
	exit(0);
}

global $sugar_config;

$template_file = "{$sugar_config['upload_dir']}/{$_REQUEST['template_id']}";
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($template_file);

foreach ($recordBean->toArray() as $field => $value) {
    $templateProcessor->setValue($field, $value);
}

$temp_doc_name = $templateProcessor->save();
$content = file_get_contents($temp_doc_name);

ob_clean();
header('Content-Type: ' . $templateBean->file_mime_type);
header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Content-Length: ' . strlen($content));
header('Content-Disposition: inline; filename="' . $templateBean->filename . '"');

echo $content;
