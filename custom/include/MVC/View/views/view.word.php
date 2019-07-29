<?php
require_once('custom/include/php_word/vendor/autoload.php');

class ViewWord extends SugarView
{
    protected $templateProcessor = null;
    protected $templateBean = null;

    public function __construct() {
        global $sugar_config;

        parent::__construct();

        $template_file = "{$sugar_config['upload_dir']}/{$_REQUEST['template_id']}";

        $this->templateBean = BeanFactory::retrieveBean('word_templates', $_REQUEST['template_id']);
        $this->templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($template_file);
    }

    function preDisplay() {
        foreach ($this->bean->toArray() as $field => $value) {
            $this->templateProcessor->setValue($field, $value);
        }
    }

    function display() {
        ob_clean();

        if ($this->templateBean == null) {
            return;
        }

        $content = $this->getWordContent();

        header('Content-Type: ' . $this->templateBean->file_mime_type);
        header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
        header('Pragma: public');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header('Content-Length: ' . strlen($content));
        header('Content-Disposition: inline; filename="' . $this->templateBean->filename . '"');

        echo $content;
    }

    function getWordContent() {
        $temp_doc_name = $this->templateProcessor->save();
        return file_get_contents($temp_doc_name);
    }
}
