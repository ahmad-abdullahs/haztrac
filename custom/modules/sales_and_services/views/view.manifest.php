<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('vendor/tcpdf/tcpdf.php');
require_once('include/MVC/View/views/view.list.php');

class sales_and_servicesViewmanifest extends ViewList {

    var $fontSize = 10.5;
    var $smallfontSize = 9.5;
    var $verysmallfontSize = 9;
    var $veryVerysmallfontSize = 7;

    function display() {
        $this->ProcessPDF();
    }

    function getPDFObj($bean) {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LEGAL', true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Haztrac');
        $pdf->SetTitle($bean->name . ' Manifest');
        $pdf->SetSubject('Haztrac');
        $pdf->SetKeywords('Haztrac, Manifest, PDF');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        return $pdf;
    }

    function ProcessPDF() {
        $salesAndServiceBean = BeanFactory::getBean($_REQUEST['module'], $_REQUEST['record'], array('disable_row_level_security' => true));

        $pdf = $this->getPDFObj($salesAndServiceBean);

        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('courier', 'B', $this->fontSize);

        // add a page
        $pdf->AddPage();

        $pdf->SetXY(0, 0);
        if ($_REQUEST['putToDir']) {
            $pdf->Image('custom/modules/sales_and_services/tpls/background3.png', 8, 17.5, 199, 250, '', '', '', true, 300, '', false, true, 0, true);
        }
//        $pdf->Image('custom/modules/sales_and_services/tpls/background.jpg', 0, 0, 216, 279, '', '', '', true, 300, '', false, true, 0, true);

        $startXIndex = empty($_REQUEST['x']) ? 52 : $_REQUEST['x']; // 50, 49
        $startYIndex = empty($_REQUEST['y']) ? 22 : $_REQUEST['y']; // 19, 31
        // Default CellHeightRatio is 1.25. We have reduced it to 1.10, 
        // so that it takes less space and we can write more. 
        $pdf->setCellHeightRatio(0.9);

        $salesAndServiceAccountBean = null;
        if (!empty($salesAndServiceBean->accounts_sales_and_services_1accounts_ida)) {
            // Sales and Service related account.
            $salesAndServiceAccountBean = BeanFactory::getBean('Accounts', $salesAndServiceBean->accounts_sales_and_services_1accounts_ida, array('disable_row_level_security' => true));

            // Generator ID Number
            $pdf->SetXY(0, 0);
            $generatorId = array('x' => $startXIndex, 'y' => $startYIndex, 'text' => $salesAndServiceAccountBean->ac_usepa_id_c); // 50, 19
            $pdf->MultiCell(40, 5, $generatorId['text'], 0, '', 0, 1, $generatorId['x'], $generatorId['y'], true);

            // Page Of
            $pdf->SetXY(0, 0);
            $pageOf = array('x' => $startXIndex + 47, 'y' => $startYIndex, 'text' => '1 / 1'); // 97, 19
            $pdf->MultiCell(40, 5, $pageOf['text'], 0, '', 0, 1, $pageOf['x'], $pageOf['y'], true);

            // Emergency Response Phone
            $pdf->SetXY(0, 0);
            $emergencyContact = '(800) 424-9300';
            $phone = $this->formatPhone($salesAndServiceAccountBean);
            if (!is_null($phone) && !empty($phone)) {
                $emergencyContact = trim($phone);
            }
            $emergencyResponsePhone = array('x' => $startXIndex + 63, 'y' => $startYIndex, 'text' => $emergencyContact); // 110, 19
            $pdf->MultiCell(40, 5, $emergencyResponsePhone['text'], 0, '', 0, 1, $emergencyResponsePhone['x'], $emergencyResponsePhone['y'], true);

            // Generator Name + Generator Mailing Address + Generator Phone
            $pdf->SetXY(0, 0);
            $accountTypesList = unencodeMultienum($salesAndServiceAccountBean->account_type_cst_c);

            if (in_array('Separate Svc Site', $accountTypesList) && $salesAndServiceAccountBean->different_service_site_c == 1) {
                $mailingAddress = $this->getFormatedAddress($salesAndServiceAccountBean, 'service_site', true, '_address_name', '_c');
            } else {
                $mailingAddress = $this->getFormatedAddress($salesAndServiceAccountBean);
            }

            $generatorMailingAddress = array('x' => $startXIndex - 28, 'y' => $startYIndex + 7
                , 'text' => $mailingAddress); // 22, 26
            $pdf->MultiCell(88, 5, $generatorMailingAddress['text'], 0, '', 0, 1, $generatorMailingAddress['x'], $generatorMailingAddress['y'], true);

            // Generator Name + Generator Site Address
            $pdf->SetXY(0, 0);
            $shippingAddress = $this->getFormatedAddress($salesAndServiceAccountBean, 'shipping', false);
            $generatorSiteAddress = array('x' => $startXIndex + 62, 'y' => $startYIndex + 7
                , 'text' => $shippingAddress); // 112, 26
            $pdf->MultiCell(89, 5, $generatorSiteAddress['text'], 0, '', 0, 1, $generatorSiteAddress['x'], $generatorSiteAddress['y'], true);
        }

//        transporter_carrier_c
        if (!empty($salesAndServiceBean->account_id_c)) {
            $salesAndServiceTransporterBean = BeanFactory::getBean('Accounts', $salesAndServiceBean->account_id_c, array('disable_row_level_security' => true));

            // Transporter 1 Company Name
            $pdf->SetXY(0, 0);
            $transporter1CompanyName = array('x' => $startXIndex - 28, 'y' => $startYIndex + 25
                , 'text' => htmlspecialchars_decode($salesAndServiceTransporterBean->shipping_address_third_party_name)); // 22, 43
            $pdf->MultiCell(70, 5, $transporter1CompanyName['text'], 0, '', 0, 1, $transporter1CompanyName['x'], $transporter1CompanyName['y'], true);

            // EPA ID Number
            $pdf->SetXY(0, 0);
            $epaIdNumber1 = array('x' => $startXIndex + 110, 'y' => $startYIndex + 25
                , 'text' => $salesAndServiceTransporterBean->ac_usepa_id_c); // 160, 43
            $pdf->MultiCell(70, 5, $epaIdNumber1['text'], 0, '', 0, 1, $epaIdNumber1['x'], $epaIdNumber1['y'], true);
        }

        if (!empty($salesAndServiceBean->account_id1_c)) {
            $salesAndServiceDesignatedFacilityBean = BeanFactory::getBean(
                            'Accounts', $salesAndServiceBean->account_id1_c, array('disable_row_level_security' => true)
            );

            // Designated Facility Name + Designated Facility Site Address + Designated Facility Phone
            $pdf->SetXY(0, 0);
            $shippingAddress = $this->getFormatedAddress($salesAndServiceDesignatedFacilityBean, 'shipping');
            $designatedFacilitySiteAddress = array('x' => $startXIndex - 28, 'y' => $startYIndex + 42
                , 'text' => $shippingAddress); // 22, 59
            $pdf->MultiCell(110, 5, $designatedFacilitySiteAddress['text'], 0, '', 0, 1, $designatedFacilitySiteAddress['x'], $designatedFacilitySiteAddress['y'], true);

            // EPA ID Number
            $pdf->SetXY(0, 0);
            $epaIdNumber3 = array('x' => $startXIndex + 110, 'y' => $startYIndex + 49
                , 'text' => $salesAndServiceDesignatedFacilityBean->ac_usepa_id_c); // 160, 68
            $pdf->MultiCell(70, 5, $epaIdNumber3['text'], 0, '', 0, 1, $epaIdNumber3['x'], $epaIdNumber3['y'], true);
        }

        // ---------------------------------------------------------
        // ---------------Revenue Line Items Stuff------------------
        // ---------------------------------------------------------
        global $db;
        $rliYScailing = 2;
        $rowCount = 0;
        $result = $this->getRelatedRLIs($salesAndServiceBean);

        $manifest_hazmat_handle_code_list = array();
        $additional_info_ack_list = array();
        while ($row = $db->fetchByAssoc($result)) {
            if ($rowCount > 3)
                continue;

            $rliBean = BeanFactory::getBean('RevenueLineItems', $row['id'], array('disable_row_level_security' => true));
            if (!$rliBean->manifest_required_c)
                continue;

            $manifest_hazmat_handle_code_list[$rowCount] = $rliBean->manifest_hazmat_handle_code_c;

            // Get Special Handling Instructions and Additional Info 
            $this->getAdditionalInfo($rliBean, $additional_info_ack_list[$rowCount]);
//            $additional_info_ack_list[$rowCount]['waste_state_codes_c'] = array_slice(unencodeMultienum($rliBean->waste_state_codes_c), 2);
//            $additional_info_ack_list[$rowCount]['epa_waste_codes_c'] = array_slice(unencodeMultienum($rliBean->epa_waste_codes_c), 2);
//            $additional_info_ack_list[$rowCount]['erg_no_c'] = htmlspecialchars_decode($rliBean->erg_no_c);
//
//            if (!empty($rliBean->wpm_waste_profile_module_id_c)) {
//                $wasteProfileBean = BeanFactory::getBean('WPM_Waste_Profile_Module', $rliBean->wpm_waste_profile_module_id_c, array('disable_row_level_security' => true));
//                $additional_info_ack_list[$rowCount]['waste_profile_num_c'] = htmlspecialchars_decode($wasteProfileBean->waste_profile_num_c);
//            }

            $rowCount += 1;

            // Line Number 1
            // HM Hazardeous Material
            $pdf->SetXY(0, 0);
            $pdf->SetFont('courier', 'B', $this->fontSize);
            $hm1 = array('x' => $startXIndex - 38, 'y' => $startYIndex + $rliYScailing + 67
                , 'text' => 'X'); // 14, 86
            if ($rliBean->shipping_hazardous_materia_c && $rliBean->manifest_required_c) {
                $pdf->MultiCell(5, 5, $hm1['text'], 0, '', 0, 1, $hm1['x'], $hm1['y'], true);
            }

            // 9.b RLI Proper shipping name 
            $pdf->SetFont('courier', 'B', $this->smallfontSize);
            $pdf->SetXY(0, 0);
            $rli1 = array('x' => $startXIndex - 28, 'y' => $startYIndex + $rliYScailing + 63
                , 'text' => htmlspecialchars_decode(trim($rliBean->proper_shipping_name_c))); // 22, 82
            $pdf->MultiCell(95, 5, $rli1['text'], 0, '', 0, 1, $rli1['x'], $rli1['y'], true);

            // Set Font
            $pdf->SetFont('courier', 'B', $this->fontSize);

            // 10.b Container Type 
            $pdf->SetXY(0, 0);
            $containerType1 = array('x' => $startXIndex + 85.75, 'y' => $startYIndex + $rliYScailing + 67
                , 'text' => $rliBean->manifest_container_type_c); // 135, 86
            $pdf->MultiCell(95, 5, $containerType1['text'], 0, '', 0, 1, $containerType1['x'], $containerType1['y'], true);

            // 12 Unit of Measure 
            $pdf->SetXY(0, 0);
            $unitOfMeasure1 = array('x' => $startXIndex + 113.75, 'y' => $startYIndex + $rliYScailing + 67
                , 'text' => $rliBean->manifest_uom_c); // 162, 86
            $pdf->MultiCell(95, 5, $unitOfMeasure1['text'], 0, '', 0, 1, $unitOfMeasure1['x'], $unitOfMeasure1['y'], true);

            // waste_state_codes_c , epa_waste_codes_c
            $waste_state_codes_c = unencodeMultienum($rliBean->waste_state_codes_c);
            $wasteStateCodeXScailing = 0;

            // set font
            $pdf->SetFont('courier', 'B', $this->verysmallfontSize);
            foreach ($waste_state_codes_c as $key => $value) {
                if ($key > 2)
                    continue;
                $pdf->SetXY(0, 0);
                $wasteCode1 = array('x' => ($startXIndex + $wasteStateCodeXScailing + 122) - ($key == 0 ? 1 : 0), 'y' => $startYIndex + $rliYScailing + 64
                    , 'text' => $value); // 171, 82
                $pdf->MultiCell(12, 5, $wasteCode1['text'], 0, '', 0, 1, $wasteCode1['x'], $wasteCode1['y'], true);

                $wasteStateCodeXScailing += 10.75;
            }

            // waste_state_codes_c , epa_waste_codes_c
            $epa_waste_codes_c = unencodeMultienum($rliBean->epa_waste_codes_c);
            $epaWasteCodeXScailing = 0;

            // set font
            $pdf->SetFont('courier', 'B', $this->smallfontSize);
            foreach ($epa_waste_codes_c as $key => $value) {
                if ($key > 2)
                    continue;
                $pdf->SetXY(0, 0);
                $wasteCode1 = array('x' => ($startXIndex + $epaWasteCodeXScailing + 122) - ($key == 0 ? 1 : 0), 'y' => $startYIndex + $rliYScailing + 70
                    , 'text' => $value); // 171, 82
                $pdf->MultiCell(12, 5, $wasteCode1['text'], 0, '', 0, 1, $wasteCode1['x'], $wasteCode1['y'], true);

                $epaWasteCodeXScailing += 11;
            }

            $rliYScailing += 12.75;
        }

        $lineNum = 1;
        $additionaInformation = '';
        foreach ($additional_info_ack_list as $key => $value) {
            $index = '9b.' . $lineNum . '.) ';
            $lineNum++;
            if (!empty($value['text'])) {
                $additionaInformation .= $index . $value['text'] . utf8_decode(chr(10));
            }
        }
        $pdf->SetFont('courier', 'B', $this->veryVerysmallfontSize);
        $pdf->SetXY(0, 0);
        $additional_info_ack = array('x' => $startXIndex - 37, 'y' => $startYIndex + 118
            , 'text' => $additionaInformation); // 13, 142
        $pdf->MultiCell(120, 5, $additional_info_ack['text'], 0, '', 0, 1, $additional_info_ack['x'], $additional_info_ack['y'], true);


        $pdf->SetFont('courier', 'B', $this->fontSize);
        $pdf->SetXY(0, 0);
        $phone = $this->formatPhone($salesAndServiceAccountBean);
        if (!is_null($phone) && !empty($phone)) {
            $regulatoryText = 'WEAR APPROPRIATE PROTECTIVE EQUIPMENT IN CASE OF EMERGENCY CALL ' . trim($phone);
        } else {
            $regulatoryText = 'WEAR APPROPRIATE PROTECTIVE EQUIPMENT IN CASE OF EMERGENCY CALL ' . 'CHEMTREC: (800)424-9300';
//            $regulatoryText = 'WEAR APPROPRIATE PROTECTIVE EQUIPMENT IN CASE OF EMERGENCY CALL' . '  ' . 'OR' . 'CHEMTREC: (800)424-9300';
        }
        $regulatoryInfo = array('x' => $startXIndex + 85, 'y' => $startYIndex + 118
            , 'text' => $regulatoryText); // 135, 139
        $pdf->MultiCell(70, 5, $regulatoryInfo['text'], 0, '', 0, 1, $regulatoryInfo['x'], $regulatoryInfo['y'], true);


        $pdf->SetFont('courier', 'B', $this->fontSize);
        $manifestHazmatXScailing = 5;
        foreach ($manifest_hazmat_handle_code_list as $value) {
            $pdf->SetXY(0, 0);
            $manifest_hazmat_handle_code = array('x' => ($startXIndex - 28) + $manifestHazmatXScailing, 'y' => $startYIndex + 226
                , 'text' => $value); // 27, 238
            $pdf->MultiCell(30, 5, $manifest_hazmat_handle_code['text'], 0, '', 0, 1, $manifest_hazmat_handle_code['x'], $manifest_hazmat_handle_code['y'], true);
            $manifestHazmatXScailing += 45;
        }

        // Download PDF
        ob_clean();
        $name = htmlspecialchars_decode(trim($salesAndServiceBean->name . ' Manifest.pdf'));
        $flag = 'D';
        if ($_REQUEST['putToDir']) {
            $name = 'pdfs/' . $salesAndServiceBean->id . '.pdf';
            $flag = 'F';
        }
        $pdf->Output($name, $flag);
    }

    function getRelatedRLIs($salesAndServiceBean) {
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
    revenue_line_items.deleted = 0 AND revenue_line_items_cstm.manifest_required_c = 1
ORDER BY revenue_line_items.line_number ASC , revenue_line_items.id ASC";
        $result = $db->query($query, false);
        return $result;
    }

    function getFormatedAddress($bean, $type = 'billing', $isPhone = true, $addressNameField = '_address_third_party_name', $suffix = '') {
        $addressFieldsList = array(
            $type . $addressNameField => 'EOL',
            $type . '_address_street' . $suffix => 'EOL',
            $type . '_address_city' . $suffix => 'commaCheck',
            $type . '_address_state' . $suffix => '',
            $type . '_address_postalcode' . $suffix => '',
        );
        $address = array();

        foreach ($addressFieldsList as $key => $value) {
            $_val = htmlspecialchars_decode($bean->$key);
            // replace multiple white spaces from the string
            // and trim the last space
            $_val = trim(preg_replace('!\s+!', ' ', $_val));
            if ($value == 'EOL') {
                $_val = $_val . utf8_decode(chr(10));
            } else if ($value == 'commaCheck') {
                $_val = !empty($_val) ? $_val . ', ' : '';
                $_val = preg_replace('!\s+!', ' ', $_val);
            } else if (empty($value)) {
                $_val = $_val . ' ';
                $_val = preg_replace('!\s+!', ' ', $_val);
            }
            array_push($address, $_val);
        }

        if (!empty($bean->phone_office) && $isPhone) {
            $phone = $this->formatPhone($bean);
            array_push($address, $phone);
        }

        $dataStr = implode('', $address);

        return $dataStr;
    }

    function formatPhone($bean) {
        $phone = null;
        if (!is_null($bean) && !empty($bean->phone_office)) {
            $piece1 = $piece2 = $piece3 = '';
            $phone = $bean->phone_office;

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

    function getAdditionalInfo($rliBean, &$additional_info_ack_list) {
        $additional_info_ack_list['waste_state_codes_c'] = array_slice(unencodeMultienum($rliBean->waste_state_codes_c), 3);
        $additional_info_ack_list['epa_waste_codes_c'] = array_slice(unencodeMultienum($rliBean->epa_waste_codes_c), 3);

        if (!empty($rliBean->wpm_waste_profile_module_id_c)) {
            $wasteProfileBean = BeanFactory::getBean('WPM_Waste_Profile_Module', $rliBean->wpm_waste_profile_module_id_c, array(
                        'disable_row_level_security' => true)
            );
            $additional_info_ack_list['waste_profile_num_c'] = htmlspecialchars_decode($wasteProfileBean->waste_profile_num_c);
        }

        if (!empty($rliBean->erg_no_c)) {
            $additional_info_ack_list['erg_no_c'] = 'ERG# ' . htmlspecialchars_decode($rliBean->erg_no_c);
        }

        $additional_info_ack_list['manifest_additional_info_c'] = htmlspecialchars_decode($rliBean->manifest_additional_info_c);


        $additional_info_ack_list['text'] = implode(' ', array_merge(
                        $additional_info_ack_list['waste_state_codes_c'], $additional_info_ack_list['epa_waste_codes_c'])
        );

        $additional_info_ack_list['text'] = implode(', ', array_filter(array(
            $additional_info_ack_list['text'],
            $additional_info_ack_list['waste_profile_num_c'],
            $additional_info_ack_list['erg_no_c'],
            $additional_info_ack_list['manifest_additional_info_c'],
        )));

        $additional_info_ack_list['text'] = trim(preg_replace('!\s+!', ' ', $additional_info_ack_list['text']));
    }

}
