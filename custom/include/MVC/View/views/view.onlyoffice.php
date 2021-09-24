<?php

class ViewOnlyoffice extends SugarView {

    public $script = "";

    public function __construct() {
        global $sugar_config;

        parent::__construct();
    }

    function preDisplay() {
        global $db, $current_user, $timedate, $sugar_config;

        $template_file_path = "{$sugar_config['onlyoffice_upload_dir']}/{$_REQUEST['onlyoffice_template_id']}";

        $this->script = '';
        $this->script .= 'builder.OpenFile("' . $template_file_path . '.docx");' . PHP_EOL;
        $this->script .= 'var oDocument = Api.GetDocument();' . PHP_EOL;

        require_once 'custom/include/EntryPointScripts/onlyOfficeAjaxHelper.php';
        $onlyOfficeAjaxHelperObj = new onlyOfficeAjaxHelper($this->bean->module_dir);
        $fieldsArrList = $onlyOfficeAjaxHelperObj->returnData();
        $data = $this->bean->toArray();

        foreach ($fieldsArrList['fieldsArr']['Fields'] as $key => $value) {
            $dataStr = str_replace(array("\r", "\n"), ' ', $data[$key]);
            $this->script .= 'oDocument.SearchAndReplace({"searchString": "{$fields.' . $key . '}", "replaceString": "' . $dataStr . '"});' . PHP_EOL;
        }

        foreach ($fieldsArrList['linksArr'] as $key => $value) {
            $link = str_replace("pdfManagerRelateLink_", "", $key);
            // Load relationship
            if ($this->bean->load_relationship($link)) {
                // Fetch related beans
                $relatedBeans = $this->bean->$link->getBeans();
                foreach ($relatedBeans as $relatedBean) {
                    foreach ($value as $_key => $_value) {
                        $dataStr = str_replace(array("\r", "\n"), ' ', $relatedBean->$_key);
                        $this->script .= 'oDocument.SearchAndReplace({"searchString": "{$fields.' . $link . '.' . $_key . '}", "replaceString": "' . $dataStr . '"});' . PHP_EOL;
                    }
                }
            }
        }
//        $saveFileName = "{$db->quoted($sugar_config['onlyoffice_upload_dir'] . "/" . $this->bean->name . ".docx")}";

        $saveFileName = "{$sugar_config['onlyoffice_upload_dir']}/parsed_{$_REQUEST['onlyoffice_template_id']}.docx";

        $this->script .= 'builder.SaveFile("docx", "' . $saveFileName . '");' . PHP_EOL;
        $this->script .= "builder.CloseFile();" . PHP_EOL;

        $filePath = $this->generateDocument();
        $fileName = basename($filePath);
        $fileName = substr($fileName, 1 + strpos($fileName, ".", 7));

        $this->returnFile($filePath, $fileName);
    }

    function generateDocument() {
        global $sugar_config;

        preg_match('/builder.SaveFile\s*\(\s*"(.*)"\s*,\s*"(.*)"\s*\)/', $this->script, $matches);

        $pieces = explode('"', $matches[0]);
        $filePath = $matches[2];
        $fileName = basename($filePath);
        $doctype = $matches[1];

        $hash = rand();
        $inputFilePath = $sugar_config['onlyoffice_generator_inputfile_path'] . DIRECTORY_SEPARATOR . 'input.' . $hash . ".docbuilder";
        $outputFilePath = $sugar_config['onlyoffice_generator_outputfile_path'] . DIRECTORY_SEPARATOR . 'output.' . $hash . "." . $fileName;
//        $inputFilePath = '/var/www/html/onlyoffice_document_editor/temp' . DIRECTORY_SEPARATOR . 'input.' . $hash . ".docbuilder";
//        $outputFilePath = '/var/www/html/onlyoffice_document_editor/temp' . DIRECTORY_SEPARATOR . 'output.' . $hash . "." . $fileName;

        $this->script = str_replace($filePath, $outputFilePath, $this->script);

        $inputFile = fopen($inputFilePath, "w+");
        fwrite($inputFile, $this->script);
        fclose($inputFile);

        $this->buildFile($inputFilePath, $outputFilePath);

        return $outputFilePath;
    }

    function buildFile($inputFilePath, $outputFilePath) {
        global $sugar_config;

        if (!isset($inputFilePath) || !file_exists($inputFilePath)) {
            throw new Exception("An error has occurred. Source File not found");
        }

        $command = $sugar_config['builder_path'] . " " . $inputFilePath . " 2>&1";
        exec($command, $output);

        if (count($output) !== 0) {
            throw new Exception(json_encode($output));
        }

        if (!file_exists($outputFilePath)) {
            throw new Exception("An error has occurred. Result File not found :" . $outputFilePath);
        }
    }

    function returnFile($filePath, $fileName) {
        $docType = pathinfo($fileName, PATHINFO_EXTENSION);

        $doctypeHeader = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        if ($docType == 'xlsx') {
            $doctypeHeader = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        } else if ($docType == 'pdf') {
            $doctypeHeader = 'application/x-pdf';
        } else if ($docType == 'pptx') {
            $doctypeHeader = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
        }

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $doctypeHeader);
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($filePath));

        ob_clean();
        flush();
        readfile($filePath);
        exit;
    }

    function display() {
//        ob_clean();
//
//        if ($this->templateBean == null) {
//            return;
//        }
//
//        $content = $this->getWordContent();
//
//        header('Content-Type: ' . $this->templateBean->file_mime_type);
//        header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
//        header('Pragma: public');
//        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
//        header('Content-Length: ' . strlen($content));
//        header('Content-Disposition: inline; filename="' . $this->templateBean->filename . '"');
//
//        echo $content;
    }

//    function getWordContent() {
//        $temp_doc_name = $this->templateProcessor->save();
//        return file_get_contents($temp_doc_name);
//    }
}
