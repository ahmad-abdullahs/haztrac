<?php

require_once 'custom/include/EntryPointScripts/onlyOfficeAjaxHelper.php';
require_once 'include/Sugarpdf/SugarpdfHelper.php';
require_once 'modules/PdfManager/PdfManagerHelper.php';

class ViewOnlyoffice extends SugarView {

    public $script = "";
    public $phoneFieldsList = array(
        'phone_mobile',
        'phone_work',
        'phone_office',
        'phone_alternate',
    );
    public $specialAddressFields = array(
        'billingaddress_with_country',
        'billingaddress_without_country',
        'shippingaddress_with_country',
        'shippingaddress_without_country',
    );

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

//        $GLOBALS['log']->fatal('$fieldsArrList : ' . print_r($fieldsArrList, 1));

        $data = PdfManagerHelper::parseBeanFields($this->bean, true);

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
                // If the related bean exist, it will replace the fields with the value.
                // For example {$fields.contacts_sales_and_services_1.first_name} --> Perterson
                // if the related bean does not exist then we have to go in else case and replace 
                // the field {$fields.contacts_sales_and_services_1.first_name} with empty 
                if ($relatedBeans) {
                    foreach ($relatedBeans as $relatedBean) {
                        $relatedBean = PdfManagerHelper::parseBeanFields($relatedBean, false);

                        foreach ($value as $_key => $_value) {
                            $dataStr = $this->getCleanString($relatedBean[$_key]);
                            if (in_array($_key, $this->phoneFieldsList)) {
                                $dataStr = $this->formatPhone($dataStr);
                            }
                            $this->script .= 'oDocument.SearchAndReplace({"searchString": "{$fields.' . $link . '.' . $_key . '}", '
                                    . '"replaceString": "' . $dataStr . '"});' . PHP_EOL;
                        }
                    }
                } else {
                    foreach ($fieldsArrList['linksArr']['pdfManagerRelateLink_' . $link] as $key => $value) {
                        $this->script .= 'oDocument.SearchAndReplace({"searchString": "{$fields.' . $link . '.' . $key . '}", '
                                . '"replaceString": ""});' . PHP_EOL;
                    }
                }
            }
        }

        if ($this->bean->module_dir == 'sales_and_services') {
            // REVENUELINEITEMS
            $returnData = $this->getRevenueLineItemsData();
            $rliDataArr = $returnData['revenuelineitems'];

            $encodedDataArr = json_encode($rliDataArr);
            $this->script .= "var rliDataArr = {$encodedDataArr};" . PHP_EOL;
            $this->script .= $this->getRevenueLineItemScript();

            foreach ($returnData['certificates'] as $key => $value) {
                $dataStr = $this->getCleanString($value);
                $this->script .= 'oDocument.SearchAndReplace({"searchString": "{$fields.revenuelineitemsGroupFields.' . $key . '}", '
                        . '"replaceString": "' . $dataStr . '"});' . PHP_EOL;
            }

            $dataStr = $this->getCleanString($returnData['additionalInfoData']);
            $this->script .= 'oDocument.SearchAndReplace({"searchString": "{$fields.revenuelineitemsGroupFields.additional_info_ack_c}", '
                    . '"replaceString": "' . $dataStr . '"});' . PHP_EOL;

            // Transporter / Carrier
            $this->getTransporterData();
        }

        $saveFileName = "{$sugar_config['onlyoffice_upload_dir1']}/parsed_{$_REQUEST['onlyoffice_template_id']}.docx";

        $this->script .= 'builder.SaveFile("docx", "' . $saveFileName . '");' . PHP_EOL;
        $this->script .= "builder.CloseFile();" . PHP_EOL;

        $filePath = $this->generateDocument();
        $fileName = basename($filePath);
        $fileName = substr($fileName, 1 + strpos($fileName, ".", 7));

        $this->returnFile($filePath, $fileName);
    }

    function getTransporterData() {
        // For json field
        $data = array();
        $transporterDataArr = array();
        $fieldsArrList = array();

        if ($this->bean->module_dir == 'sales_and_services') {
            // Data List
            $salesAndServiceTransporterBeanList = array();
            $transporterDataArr = array();
            $count = 1;

            // Get fields List
            $onlyOfficeAjaxHelperObj = new onlyOfficeAjaxHelper("Accounts");
            $fieldsArrList = $onlyOfficeAjaxHelperObj->returnData();

            $transporterCarrier = $this->bean->transporter_carrier_c;
            // Decode the json Object and get the transporter ids
            if (!empty($transporterCarrier)) {
                $account_id_c = array();
                $transporter_carrier_c = json_decode(html_entity_decode($transporterCarrier), ENT_QUOTES);
                foreach ($transporter_carrier_c as $key => $transporter_carrier_obj) {
                    array_push($account_id_c, $transporter_carrier_obj['id']);
                }

                // Fetch the Beans
                if (!empty($account_id_c)) {
                    foreach ($account_id_c as $key => $value) {
                        $salesAndServiceTransporterBean = BeanFactory::getBean('Accounts', $value, array('disable_row_level_security' => true));
                        array_push($salesAndServiceTransporterBeanList, $salesAndServiceTransporterBean);
                    }
                }
            }

            foreach ($salesAndServiceTransporterBeanList as $transporterBean) {
                $data = PdfManagerHelper::parseBeanFields($transporterBean, false);

                foreach ($fieldsArrList['fieldsArr']['Fields'] as $key => $value) {
                    if (in_array($key, $this->specialAddressFields)) {
                        $data[$key] = $this->getCleanString($data[$key], true);
                    } else {
                        $data[$key] = $this->getCleanString($data[$key]);
                    }

                    if (in_array($key, $this->phoneFieldsList)) {
                        $data[$key] = $this->formatPhone($data[$key]);
                    }
                }

                $data['index'] = $count;

                array_push($transporterDataArr, $data);

                $count ++;
            }
        }

        $iterator = 0;
        while ($iterator < 4) {
            foreach ($fieldsArrList['fieldsArr']['Fields'] as $key => $value) {
                // If we have the transporter $iterator [1, 2, 3, 4] exist then get the data otherwise set it empty.
                if (is_array($transporterDataArr[$iterator])) {
                    $dataStr = $this->getCleanString($transporterDataArr[$iterator][$key]);
                } else {
                    $dataStr = '';
                }

                $this->script .= 'oDocument.SearchAndReplace({"searchString": "{$fields.transporter_carrier_c' . $iterator . '.' . $key . '}", '
                        . '"replaceString": "' . $dataStr . '"});' . PHP_EOL;
            }
            $iterator++;
        }
    }

    function getRevenueLineItemsData() {
        $checkboxFields = array(
            'shipping_hazardous_materia_c',
            'state_regulated_c',
            'manifest_required_c',
            'waste_profile_c',
            'consolidated_manifest',
        );

        // For multiline rows
        if ($this->bean->module_dir == 'sales_and_services') {
            global $locale;
            $certificatesList = array();
            $customerCertificatesList = array();
            $transporterCertificatesList = array();
            $consigneeCertificatesList = array();
            $shipperCertificatesList = array();

            // Data List
            $rliDataArr = array();
            $additionalInfoDataArr = array();
            $count = 1;

            // Get fields List
            $onlyOfficeAjaxHelperObj = new onlyOfficeAjaxHelper("RevenueLineItems");
            $fieldsArrList = $onlyOfficeAjaxHelperObj->returnData();

            // RevenueLineItems
            $this->bean->load_relationship('sales_and_services_revenuelineitems_1');
            $revenuelineitemsList = $this->bean->sales_and_services_revenuelineitems_1->getBeans();

            foreach ($revenuelineitemsList as $revenuelineitemsBean) {
                if ($revenuelineitemsBean->is_bundle_product_c == "parent") {
                    continue;
                }

                $data = PdfManagerHelper::parseBeanFields($revenuelineitemsBean, false);

                foreach ($fieldsArrList['fieldsArr']['Fields'] as $key => $value) {
//                    if ($key == "product_list_name_c") {
//                        $GLOBALS['log']->fatal('$key : ' . print_r($key, 1));
//                        $GLOBALS['log']->fatal('before : ' . print_r($data[$key], 1));
//                        $data[$key] = $data[$key];
//                    } else {
                    $data[$key] = $this->getCleanString($data[$key]);
//                    }
                    // Hide Price From Paperwork
                    if ($key == 'discount_price' && $data['hide_price_from_paperwork_c'] == 1) {
                        $data['discount_price'] = "TBD";
                    }

                    // Hazardous Material
                    if (in_array($key, $checkboxFields)) {
                        if ($data[$key] == 1) {
                            $data[$key] = "X";
                        } else {
                            $data[$key] = "";
                        }
                    }
                }

                $data['index'] = $count;

                // Additional Info
                array_push($additionalInfoDataArr, $data['additional_info_ack_c']);

                // Terms And Conditions
                $customerCertificatesList = array_merge($customerCertificatesList, unencodeMultienum($data['customer_certificates']));
                $transporterCertificatesList = array_merge($transporterCertificatesList, unencodeMultienum($data['transporter_certificates']));
                $consigneeCertificatesList = array_merge($consigneeCertificatesList, unencodeMultienum($data['consignee_certificates']));
                $shipperCertificatesList = array_merge($shipperCertificatesList, unencodeMultienum($data['shipper_certificates']));

                array_push($rliDataArr, $data);
                $count ++;
            }

            $customerCertificatesString = '';
            $customerCertificatesList = array_filter(array_unique(array_values($customerCertificatesList)));
            if (!empty($customerCertificatesList)) {
                foreach ($customerCertificatesList as $key => $certificateId) {
                    $certificateBean = BeanFactory::getBean('wp_terms_and_conditions', $certificateId, array('disable_row_level_security' => true));
                    if (!empty($certificateBean->description)) {
                        $customerCertificatesString .= $this->getCleanString(trim($certificateBean->description)) . '; ';
                    }
                }
            }

            $transporterCertificatesString = '';
            $transporterCertificatesList = array_filter(array_unique(array_values($transporterCertificatesList)));
            if (!empty($transporterCertificatesList)) {
                foreach ($transporterCertificatesList as $key => $certificateId) {
                    $certificateBean = BeanFactory::getBean('wp_terms_and_conditions', $certificateId, array('disable_row_level_security' => true));
                    if (!empty($certificateBean->description)) {
                        $transporterCertificatesString .= $this->getCleanString(trim($certificateBean->description)) . '; ';
                    }
                }
            }

            $consigneeCertificatesString = '';
            $consigneeCertificatesList = array_filter(array_unique(array_values($consigneeCertificatesList)));
            if (!empty($consigneeCertificatesList)) {
                foreach ($consigneeCertificatesList as $key => $certificateId) {
                    $certificateBean = BeanFactory::getBean('wp_terms_and_conditions', $certificateId, array('disable_row_level_security' => true));
                    if (!empty($certificateBean->description)) {
                        $consigneeCertificatesString .= $this->getCleanString(trim($certificateBean->description)) . '; ';
                    }
                }
            }

            $shipperCertificatesString = '';
            $shipperCertificatesList = array_filter(array_unique(array_values($shipperCertificatesList)));
            if (!empty($shipperCertificatesList)) {
                foreach ($shipperCertificatesList as $key => $certificateId) {
                    $certificateBean = BeanFactory::getBean('wp_terms_and_conditions', $certificateId, array('disable_row_level_security' => true));
                    if (!empty($certificateBean->description)) {
                        $shipperCertificatesString .= $this->getCleanString(trim($certificateBean->description)) . '; ';
                    }
                }
            }

            $additionalInfoDataArr = array_filter(array_unique(array_values($additionalInfoDataArr)));
            $additionalInfoDataStr = implode('. ', $additionalInfoDataArr);

            $certificatesList['customer_certificates'] = $customerCertificatesString;
            $certificatesList['transporter_certificates'] = $transporterCertificatesString;
            $certificatesList['consignee_certificates'] = $consigneeCertificatesString;
            $certificatesList['shipper_certificates'] = $shipperCertificatesString;
        }

        return array(
            'revenuelineitems' => $rliDataArr,
            'certificates' => $certificatesList,
            'additionalInfoData' => $additionalInfoDataStr,
        );
    }

    function formatPhone($phoneValue) {
        $phone = null;
        if (!empty($phoneValue)) {
            $piece1 = $piece2 = $piece3 = '';
            $phone = $phoneValue;

            $_phone = explode('(', $phone);
            if (!empty($_phone[1])) {
                $_phone = explode(')', $_phone[1]);
                $piece1 = $_phone[0];
            }

            $_phone = explode('-', $phone);
            $_phone = explode(' ', $_phone[0]);
            $piece2 = $_phone[count($_phone) - 1];

            $_phone = explode('-', $phone);
            $_phone = explode(' ', $_phone[1]);
            $piece3 = $_phone[0];

            $phone = '(' . trim($piece1) . ')' . trim($piece2) . '-' . trim($piece3);
            $phone = preg_replace('!\s+!', ' ', $phone);
        }
        return $phone;
    }

    function getTransporterScript() {
        return ' // Transporter / Carrier
fieldsList = [], fieldsListTemp = [];
var fieldsListcellElement = [], transporterFieldList = [];
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

                    for (var l = 0; l < oCell.GetContent().GetElementsCount(); l++) {
                        cellElement = oCell.GetContent().GetElement(l);
                        cellText = cellElement.GetText();

                        if (cellText.includes("{$fields.transporter_carrier_c.")) {
                            fieldsList.push({[k]: cellText.trim()});
                            fieldsListTemp.push(cellText.trim());
                            fieldsListcellElement.push(cellElement);
                        }
                    }
                }
            }
        }
    }
}

if (fieldsListcellElement) {
    for (var i = 0; i < fieldsListcellElement.length; i++) {
        var eachTransporterCell = fieldsListcellElement[i];
        if (eachTransporterCell) {
            var cellTransporterText = eachTransporterCell.GetText();
            var transporterFieldNames = cellTransporterText.match(/\{\$fields.transporter_carrier_c.[a-zA-Z0-9|.|_|$\}]+/ig);
            if (transporterFieldNames) {
                for (var j = 0; j < transporterFieldNames.length; j++) {
                    var pieces = transporterFieldNames[j].split(".");
                    // Greater than 1 is purposefully added, if the field name ends with dot e.g. {$fields.sales_and_services_revenuelineitems_1_c.Index}.
                    // this check will handle
                    if (pieces.length > 1) {
                        fieldName = pieces[2].replace("}", "");
                        fieldName = fieldName.replace(".", "").toLowerCase();
                        if (fieldName != "") {
                            transporterFieldList.push(fieldName);
                        }
                    }
                }

                cellTransporterTextString = "";
                for (var k = 0; k < transporterData.length; k++) {
                    var cellTransporterTextTemp = String(cellTransporterText);
                    for (var l = 0; l < transporterFieldList.length; l++) {
                        cellTransporterTextTemp = cellTransporterTextTemp.replace("{$fields.transporter_carrier_c." + transporterFieldList[l] + "}", transporterData[k][transporterFieldList[l]]);
                    }

                    if (k != 0) {
                        cellTransporterTextString += " \n";
                    }

                    cellTransporterTextString += cellTransporterTextTemp;
                }


                cellTransporterTextString = String(cellTransporterTextString);
                eachTransporterCell.RemoveAllElements();
oRun = Api.CreateRun();
oRun.AddText(cellTransporterTextString);
eachTransporterCell.AddElement(oRun);
//                eachTransporterCell.AddText(cellTransporterTextString);
            }
        }
    }
}' . PHP_EOL;
    }

    function getRevenueLineItemScript() {
        return ' // Paragraph Element for display
oParagraph = oDocument.GetElement(1);
//oParagraph.AddText("fieldsListcellElement : " + fieldsListcellElement + ".");
//oParagraph.AddLineBreak();
// Desired table
var desiredTable, tempTable;
var fieldsList = [], fieldsListTemp = [];
// Flag Variables
var tableFound = false, rowFound = false, addFillerRows = false, rowFlag = false;
var desiredTableRow = 0, cellText = "";
var cellElement = null, sClassType = null, oCell = null;
var rliTableStructure = [];
var constantRow = 0;

// Loop through all the elements to find the tables
for (var i = 0; i < oDocument.GetElementsCount(); i++) {
    sClassType = oDocument.GetElement(i).GetClassType();

    // If element is table
    if (sClassType == "table") {
        // Table Element
        tempTable = oDocument.GetElement(i);

        if (tempTable.GetRowsCount() > 0) {
            for (var j = 0; j < tempTable.GetRowsCount(); j++) {

                if (tableFound) {
                    if (addFillerRows) {
                        for (var x = 0; x < j; x++) {
                            rliTableStructure.push({"column": []});
                        }
                        addFillerRows = false;
                    }
                    rliTableStructure.push({"column": []});
                }

                for (var k = 0; k < tempTable.GetRow(j).GetCellsCount(); k++) {

                    if (tableFound) {
                        rliTableStructure[j]["column"].push([]);
                    }

                    oCell = tempTable.GetRow(j).GetCell(k);
                    // Here its for the header [RevenueLineitem dynamic table] text finding 
                    cellElement = oCell.GetContent().GetElement(0);
                    cellText = cellElement.GetText();

                    if (cellText.includes("[RevenueLineitem dynamic table]") && tableFound == false) {
                        // This is the concerned table
                        tableFound = true;
                        addFillerRows = true;
                        rliTableStructure = [];
                        break;
                    }

                    for (var l = 0; l < oCell.GetContent().GetElementsCount(); l++) {
                        cellElement = oCell.GetContent().GetElement(l);
                        cellText = cellElement.GetText();

                        var __key = "element" + l;
                        if (tableFound) {
                            desiredTable = tempTable;
                            rliTableStructure[j]["column"][k][__key] = cellElement;
                            if (cellText.includes("{$fields.sales_and_services_revenuelineitems_1_c.") && rowFound == false) {
                                desiredTableRow = j;
                                rowFound = true;
                            }
                        }
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
    var rowCount = 0;

    for (let row = desiredTableRow; row < rliTableStructure.length; row++) {

        if (rliDataArr[rowCount] != undefined) {
            for (let col = 0; col < rliTableStructure[row]["column"].length; col++) {

                for (const cellindex in rliTableStructure[row]["column"][col]) {
                    if (rliTableStructure[row]["column"][col] != undefined) {
                        var text = rliTableStructure[row]["column"][col][cellindex].GetText();
                        var rliFieldNames = text.match(/\{\$fields.sales_and_services_revenuelineitems_1_c.[a-zA-Z0-9|.|_|$\}]+/ig);
                        if (rliFieldNames) {
                            for (var j = 0; j < rliFieldNames.length; j++) {
                                var pieces = rliFieldNames[j].split(".");
                                // Greater than 1 is purposefully added, if the field name ends with dot e.g. {$fields.sales_and_services_revenuelineitems_1_c.Index}.
                                // this check will handle
                                if (pieces.length > 1) {
                                    fieldName = pieces[2].replace("}", "");
                                    fieldName = fieldName.replace(".", "").toLowerCase();
                                    if (fieldName != "") {
                                        if (rliDataArr[rowCount] != undefined) {
                                            var value = rliDataArr[rowCount][fieldName] || "";
                                            value = String(value);
                                            var rliEle = rliTableStructure[row]["column"][col][cellindex];
                                            var oSearch = rliEle.Search("{$fields.sales_and_services_revenuelineitems_1_c." + fieldName + "}");
                                            if(oSearch[0]) {
                                                oSearch[0].Select();
                                                var arr = [value];
                                                Api.ReplaceTextSmart(arr);
                                            }
//                                            var value = rliDataArr[rowCount][fieldName] || "";
//                                            value = String(value);
//                                            var rliEle = rliTableStructure[row]["column"][col][cellindex];
//                                            oRange1 = rliEle.GetRange();
//                                            oRange1.Select();
//                                            arr = [value];
//                                            Api.ReplaceTextSmart(arr);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            // This is technial, we have to keep the constantRow static, because everytime a row is deleted from the document
            // Number of rows in table reduce
            if (rowFlag == false) {
                constantRow = row;
                rowFlag = true;
            }
            var rowToRemove = desiredTable.GetRow(constantRow);
            if (rowToRemove) {
                var cello = rowToRemove.GetCell(0);
                desiredTable.RemoveRow(cello);
            }
        }

        rowCount++;
    }
}' . PHP_EOL;
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

    function getCleanString($param, $flag = false) {
        $dataStr = from_html(html_entity_decode(htmlspecialchars_decode($param)));

        // Specially added for Transfer / Carrier address, need to fix this \n problem
        if ($flag) {
            $dataStr = str_replace(array("\r", "\n"), ' ', $dataStr);
            $dataStr = str_replace(array("<br />"), ' ', $dataStr);
            $dataStr = str_replace('"', '\"', $dataStr);
        } else {
            $dataStr = str_replace(array("\r", "\n"), ' ', $dataStr);
            $dataStr = str_replace(array("<br />"), ' \n', $dataStr);
            $dataStr = str_replace('"', '\"', $dataStr);
        }
        return $dataStr;
    }

}
