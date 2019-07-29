<?php

global $sugar_config;

$file_path = $sugar_config['folder_base_path'] . '/' . urldecode($_REQUEST['base']);
$content = file_get_contents($file_path);
$fileInfo = pathinfo($file_path);

ob_clean();
if (!empty($_REQUEST['force_download'])) {
    header('Content-Type: application/force-download');

    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename="' . $fileInfo['filename']. '.' . $fileInfo['extension'] . '"');
    header('Content-Transfer-Encoding: binary');
} else {
    header('Content-Disposition: inline; filename="' . $fileInfo['filename']. '.' . $fileInfo['extension'] . '"');
}

header('Content-Type: ' . mime_content_type($file_path));
header('Cache-Control: public, must-revalidate, max-age=0');
header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Content-Length: ' . strlen($content));

echo $content;
