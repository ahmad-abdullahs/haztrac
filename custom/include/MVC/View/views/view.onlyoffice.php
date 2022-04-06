<?php

require_once 'custom/include/EntryPointScripts/onlyOfficeAjaxHelper.php';

class ViewOnlyoffice extends SugarView {

    public $script = "";

    public function __construct() {
        global $sugar_config;

        parent::__construct();
    }

    function preDisplay() {
        global $db, $current_user, $timedate, $sugar_config;

//        $e = new Exception();
//        $GLOBALS['log']->fatal("stack trace : " . print_r($e->getTraceAsString(), 1));
//        $GLOBALS['log']->fatal('Data : ' . print_r($_REQUEST, 1));

        $template_file_path = "{$sugar_config['onlyoffice_upload_dir1']}/{$_REQUEST['onlyoffice_template_id']}";

        $this->script = '';
        $this->script .= 'builder.OpenFile("' . $template_file_path . '.docx");' . PHP_EOL;
        $this->script .= 'var oDocument = Api.GetDocument();' . PHP_EOL;

        $onlyOfficeAjaxHelperObj = new onlyOfficeAjaxHelper($this->bean->module_dir);
        $fieldsArrList = $onlyOfficeAjaxHelperObj->returnData();
        $data = $this->bean->toArray();

        foreach ($fieldsArrList['fieldsArr']['Fields'] as $key => $value) {
            $dataStr = $this->getCleanString($data[$key]);
            $this->script .= 'oDocument.SearchAndReplace({"searchString": "{$fields.' . $key . '}", '
                    . '"replaceString": "' . $dataStr . '"});' . PHP_EOL;
        }

        foreach ($fieldsArrList['linksArr'] as $key => $value) {
            $link = str_replace("pdfManagerRelateLink_", "", $key);
            // Load relationship
            if ($this->bean->load_relationship($link)) {
                // Fetch related beans
                $relatedBeans = $this->bean->$link->getBeans();
                foreach ($relatedBeans as $relatedBean) {
                    foreach ($value as $_key => $_value) {
                        $dataStr = $this->getCleanString($relatedBean->$_key);
                        $this->script .= 'oDocument.SearchAndReplace({"searchString": "{$fields.' . $link . '.' . $_key . '}", '
                                . '"replaceString": "' . $dataStr . '"});' . PHP_EOL;
                    }
                }
            }
        }


        $rliDataArr = $this->getRevenueLineItemsData();
        $encodedDataArr = json_encode($rliDataArr);
        $this->script .= "var rliDataArr = {$encodedDataArr};" . PHP_EOL;
        $this->script .= $this->getRevenueLineItemScript();

//        $saveFileName = "{$db->quoted($sugar_config['onlyoffice_upload_dir'] . "/" . $this->bean->name . ".docx")}";

        $saveFileName = "{$sugar_config['onlyoffice_upload_dir1']}/parsed_{$_REQUEST['onlyoffice_template_id']}.docx";

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

        // This was working, but commented because they happen sometimes the exec command
        // gives lot of error but still generates the output file.
        // So we are not taking care of errors, if file is generated.
        // So, commented this piece of code.
//        if (count($output) !== 0) {
//            throw new Exception(json_encode($output));
//        }

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
        
    }

    function getCleanString($param) {
        $dataStr = from_html(html_entity_decode(htmlspecialchars_decode($param)));
        $dataStr = str_replace(array("\r", "\n"), ' ', $dataStr);
        $dataStr = str_replace('"', '\"', $dataStr);
        return $dataStr;
    }

    function getRelatedRLIs() {
        global $db;
        $query = "SELECT 
    revenue_line_items.id, revenue_line_items.name
FROM
    revenue_line_items
        LEFT JOIN
    revenue_line_items_cstm revenue_line_items_cstm ON revenue_line_items_cstm.id_c = revenue_line_items.id
        INNER JOIN
    sales_and_services_revenuelineitems_1_c sales_and_services_revenuelineitems_1 ON (revenue_line_items.id = sales_and_services_revenuelineitems_1.sales_and_services_revenuelineitems_1revenuelineitems_idb)
        AND (sales_and_services_revenuelineitems_1.deleted = 0)
        INNER JOIN
    sales_and_services jt4_sales_and_services_revenuelineitems_1 ON (jt4_sales_and_services_revenuelineitems_1.id = sales_and_services_revenuelineitems_1.sales_and_services_revenuelineitems_1sales_and_services_ida)
        AND (jt4_sales_and_services_revenuelineitems_1.deleted = 0)
        AND (jt4_sales_and_services_revenuelineitems_1.id = '{$_REQUEST["record"]}')
WHERE
    revenue_line_items.deleted = 0
ORDER BY revenue_line_items.line_number ASC , revenue_line_items.id ASC";
        $result = $db->query($query, false);
        return $result;
    }

    function getRevenueLineItemsData() {
        global $db;
        // Get related RLIs
        $result = $this->getRelatedRLIs();

        // Get fields List
        $onlyOfficeAjaxHelperObj = new onlyOfficeAjaxHelper("RevenueLineItems");
        $fieldsArrList = $onlyOfficeAjaxHelperObj->returnData();

        // Data List
        $rliDataArr = array();

        $count = 1;
        while ($row = $db->fetchByAssoc($result)) {
            $rliBean = BeanFactory::getBean('RevenueLineItems', $row['id'], array('disable_row_level_security' => true));
            $data = $rliBean->toArray();

            foreach ($fieldsArrList['fieldsArr']['Fields'] as $key => $value) {
                $data[$key] = $this->getCleanString($data[$key]);
            }

            $data['index'] = $count;
            array_push($rliDataArr, $data);
            $count ++;
        }

        return $rliDataArr;
    }

    function getRevenueLineItemScript() {
        return ' // Paragraph Element for display
        oParagraph = oDocument.GetElement(1);
        // Desired table
        var desiredTable, tempTable;
        var fieldsList = [], fieldsListTemp = [];
        // Flag Variables
        var tableFound = false, cellFound = false;
        var desiredTableRow = -1;

        // Loop through all the elements to find the tables
        for (var i = 0; i < oDocument.GetElementsCount(); i++) {
            sClassType = oDocument.GetElement(i).GetClassType();

            // If element is table
            if (sClassType == "table") {
                // Table Element
                tempTable = oDocument.GetElement(i);

                if (tempTable.GetRowsCount() > 0) {
                    for (var j = 0; j < tempTable.GetRowsCount(); j++) {
                        for (var k = 0; k < tempTable.GetRow(j).GetCellsCount(); k++) {
                            oCell = tempTable.GetRow(j).GetCell(k);
                            cellElement = oCell.GetContent().GetElement(0);
                            cellText = cellElement.GetText();

                            if (cellText.includes("[RevenueLineitem dynamic table]") && tableFound == false) {
                                // This is the concerned table
                                tableFound = true;
                                break;
                            }

                            if (cellText.includes("{$fields.sales_and_services_revenuelineitems_1_c.") && tableFound == true) {
                                fieldsList.push({[k]: cellText.trim()});
                                fieldsListTemp.push(cellText.trim());

                                desiredTable = tempTable;
                                desiredTableRow = j;

                                cellFound = true;
                            } else if (tableFound == true && desiredTableRow == j) {
                                fieldsList.push({[k]: cellText.trim()});
                            }
                        }
                    }

                    tableFound = false;
                }

                tempTable = null;
            }
        }

        if (desiredTable) {
            oDocument.SearchAndReplace({"searchString": "[RevenueLineitem dynamic table]", "replaceString": ""});

            var additionalRowCounter = 0;

            for (var j = 0; j < rliDataArr.length; j++) {

                if (j != 0) {
                    desiredTable.AddRow();
                    additionalRowCounter++;
                }

                for (var k = 0; k < desiredTable.GetRow(desiredTableRow).GetCellsCount(); k++) {

                    oCell = desiredTable.GetRow(desiredTableRow + additionalRowCounter).GetCell(k);
                    cellElement = oCell.GetContent().GetElement(0);
                    cellText = cellElement.GetText();

                    if(cellText == ""){
                        cellText = fieldsList[k][k] || "";
                    }

                    var fieldName = "";
                    var pieces = cellText.split(".");
                    // Greater than 1 is purposefully added, if the field name ends with dot e.g. {$fields.sales_and_services_revenuelineitems_1_c.Index}.
                    // this check will handle
                    if(pieces.length > 1){
                        fieldName = pieces[2].replace("}", "");
                        fieldName = fieldName.replace(".", "").toLowerCase();
                    }

                    var value = rliDataArr[j][fieldName];
                    value = String(value);
                    if(fieldName != ""){
                        if (j == 0) {
                            cellElement.RemoveAllElements();
                            cellElement.AddText(value);
                        } else {
                            cellElement.AddText(value);
                        }
                    }
                }
            }
        }' . PHP_EOL;
    }

}
