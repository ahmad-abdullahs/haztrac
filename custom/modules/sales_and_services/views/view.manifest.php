<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('vendor/tcpdf/tcpdf.php');
require_once('include/MVC/View/views/view.list.php');

class sales_and_servicesViewmanifest extends ViewList {

    function display() {
        $this->ProcessPDF();
    }

    function ProcessPDF() {
        $salesAndServiceBean = BeanFactory::getBean($_REQUEST['module'], $_REQUEST['record'], array('disable_row_level_security' => true));

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Haztrac');
        $pdf->SetTitle($salesAndServiceBean->name . ' Manifest');
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

        $fontSize = 11;
        $smallfontSize = 10;
        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('courier', 'B', $fontSize);

        // add a page
        $pdf->AddPage();

        $pdf->SetXY(0, 0);
//        $pdf->Image('custom/modules/sales_and_services/tpls/background.jpg', '', '', 210, 270, '', '', '', false, 300, '', false, false, 1, false, false, false);

        $startXIndex = empty($_REQUEST['x']) ? 50 : $_REQUEST['x']; // 50, 49
        $startYIndex = empty($_REQUEST['y']) ? 19 : $_REQUEST['y']; // 19, 31
        // Default CellHeightRatio is 1.25. We have reduced it to 1.10, 
        // so that it takes less space and we can write more. 
        $pdf->setCellHeightRatio(1.10);

        if (!empty($salesAndServiceBean->accounts_sales_and_services_1accounts_ida)) {
            // Sales and Service related account.
            $salesAndServiceAccountBean = BeanFactory::getBean('Accounts', $salesAndServiceBean->accounts_sales_and_services_1accounts_ida, array('disable_row_level_security' => true));

            // Generator ID Number
            $pdf->SetXY(0, 0);
            $generatorId = array('x' => $startXIndex, 'y' => $startYIndex, 'text' => $salesAndServiceAccountBean->ac_usepa_id_c); // 50, 19
            // 'CAD9841667891'
            $pdf->MultiCell(40, 5, $generatorId['text'], 0, '', 0, 1, $generatorId['x'], $generatorId['y'], true);

            // Page Of
            $pdf->SetXY(0, 0);
            $pageOf = array('x' => $startXIndex + 47, 'y' => $startYIndex, 'text' => '1 / 1'); // 97, 19
            $pdf->MultiCell(40, 5, $pageOf['text'], 0, '', 0, 1, $pageOf['x'], $pageOf['y'], true);

            // Emergency Response Phone
            $pdf->SetXY(0, 0);
            $emergencyResponsePhone = array('x' => $startXIndex + 60, 'y' => $startYIndex, 'text' => ''); // 110, 19
            // '(800) 424-9300'
            $pdf->MultiCell(40, 5, $emergencyResponsePhone['text'], 0, '', 0, 1, $emergencyResponsePhone['x'], $emergencyResponsePhone['y'], true);

            // Generator Name
            $pdf->SetXY(0, 0);
            // Check if the account is of third party type use the Third party billing name
            // otherwise use the account name...
            $generatorNameText = htmlspecialchars_decode($salesAndServiceAccountBean->name);
            if (strpos($salesAndServiceAccountBean->account_type_cst_c, '3rd Party') !== false) {
                $generatorNameText = htmlspecialchars_decode($salesAndServiceAccountBean->billing_address_third_party_name);
            }
            $generatorName = array('x' => $startXIndex - 28, 'y' => $startYIndex + 7
                , 'text' => $generatorNameText); // 22, 26
            $pdf->MultiCell(88, 5, $generatorName['text'], 0, '', 0, 1, $generatorName['x'], $generatorName['y'], true);

            $mailingAddress = '';
            $mailingAddress = $salesAndServiceAccountBean->billing_address_street;
            $mailingAddress .= ' ' . !empty(trim($salesAndServiceAccountBean->billing_address_city)) ? $salesAndServiceAccountBean->billing_address_city . ',' : '';
            $mailingAddress .= ' ' . $salesAndServiceAccountBean->billing_address_state;
            $mailingAddress .= ' ' . $salesAndServiceAccountBean->billing_address_postalcode;
//            $mailingAddress .= ' ' . $salesAndServiceAccountBean->billing_address_country;
            $mailingAddress = trim(preg_replace('/\s+/', ' ', preg_replace('/\s+/', ' ', preg_replace('/\s+/', ' ', $mailingAddress))));
            $mailingAddress = htmlspecialchars_decode($mailingAddress);

            // Generator Mailing Address
            $pdf->SetXY(0, 0);
            $generatorMailingAddress = array('x' => $startXIndex - 28, 'y' => $startYIndex + 10
                , 'text' => $mailingAddress); // 22, 29
            $pdf->MultiCell(88, 5, $generatorMailingAddress['text'], 0, '', 0, 1, $generatorMailingAddress['x'], $generatorMailingAddress['y'], true);

            // Generator Phone
            $pdf->SetXY(0, 0);
            $generatorPhone = array('x' => $startXIndex + 16, 'y' => $startYIndex + 16
                , 'text' => $salesAndServiceAccountBean->phone_office); // 66, 35
            // '(800) 424-9300'
            $pdf->MultiCell(70, 5, $generatorPhone['text'], 0, '', 0, 1, $generatorPhone['x'], $generatorPhone['y'], true);

            // Generator Name
            $pdf->SetXY(0, 0);
            // Check if the account is of third party type use the Third party shipping name
            // otherwise use the account name...
            $generatorNameText = htmlspecialchars_decode($salesAndServiceAccountBean->name);
            if (strpos($salesAndServiceAccountBean->account_type_cst_c, '3rd Party') !== false) {
                $generatorNameText = htmlspecialchars_decode($salesAndServiceAccountBean->shipping_address_third_party_name);
            }
            $generatorName = array('x' => $startXIndex + 62, 'y' => $startYIndex + 7
                , 'text' => $generatorNameText); // 112, 26
            $pdf->MultiCell(88, 5, $generatorName['text'], 0, '', 0, 1, $generatorName['x'], $generatorName['y'], true);

            $shippingAddress = '';
            $shippingAddress = $salesAndServiceAccountBean->shipping_address_street;
            $shippingAddress .= ' ' . !empty(trim($salesAndServiceAccountBean->shipping_address_city)) ? $salesAndServiceAccountBean->shipping_address_city . ',' : '';
            $shippingAddress .= ' ' . $salesAndServiceAccountBean->shipping_address_state;
            $shippingAddress .= ' ' . $salesAndServiceAccountBean->shipping_address_postalcode;
//            $shippingAddress .= ' ' . $salesAndServiceAccountBean->shipping_address_country;
            $shippingAddress = trim(preg_replace('/\s+/', ' ', preg_replace('/\s+/', ' ', preg_replace('/\s+/', ' ', $shippingAddress))));
            $shippingAddress = htmlspecialchars_decode($shippingAddress);

            // Generator Site Address
            $pdf->SetXY(0, 0);
            $generatorSiteAddress = array('x' => $startXIndex + 62, 'y' => $startYIndex + 10
                , 'text' => $shippingAddress); // 112, 29
            // '19528 Ventura Blvd Tarzana, CA 91356 United States'
            $pdf->MultiCell(88, 5, $generatorSiteAddress['text'], 0, '', 0, 1, $generatorSiteAddress['x'], $generatorSiteAddress['y'], true);
        }

//        transporter_carrier_c
        if (!empty($salesAndServiceBean->account_id_c)) {
            $salesAndServiceTransporterBean = BeanFactory::getBean('Accounts', $salesAndServiceBean->account_id_c, array('disable_row_level_security' => true));

            // Transporter 1 Company Name
            $pdf->SetXY(0, 0);
            $transporter1CompanyName = array('x' => $startXIndex - 28, 'y' => $startYIndex + 24
                , 'text' => htmlspecialchars_decode($salesAndServiceTransporterBean->name)); // 22, 43
            // 'Pacific Oil Company'
            $pdf->MultiCell(70, 5, $transporter1CompanyName['text'], 0, '', 0, 1, $transporter1CompanyName['x'], $transporter1CompanyName['y'], true);

            // EPA ID Number
            $pdf->SetXY(0, 0);
            $epaIdNumber1 = array('x' => $startXIndex + 110, 'y' => $startYIndex + 24
                , 'text' => $salesAndServiceTransporterBean->ac_usepa_id_c); // 160, 43
            // 'CAD9841667891'
            $pdf->MultiCell(70, 5, $epaIdNumber1['text'], 0, '', 0, 1, $epaIdNumber1['x'], $epaIdNumber1['y'], true);
        }

        // Transporter 2 Company Name
//        $pdf->SetXY(0, 0);
//        $transporter2CompanyName = array('x' => $startXIndex - 28, 'y' => $startYIndex + 32
//            , 'text' => 'Pacific Oil Company'); // 22, 51
//        $pdf->MultiCell(70, 5, $transporter2CompanyName['text'], 0, '', 0, 1, $transporter2CompanyName['x'], $transporter2CompanyName['y'], true);
        // EPA ID Number
//        $pdf->SetXY(0, 0);
//        $epaIdNumber2 = array('x' => $startXIndex + 110, 'y' => $startYIndex + 32
//            , 'text' => 'CAD9841667891'); // 160, 51
//        $pdf->MultiCell(70, 5, $epaIdNumber2['text'], 0, '', 0, 1, $epaIdNumber2['x'], $epaIdNumber2['y'], true);

        if (!empty($salesAndServiceBean->account_id1_c)) {
            $salesAndServiceDesignatedFacilityBean = BeanFactory::getBean('Accounts', $salesAndServiceBean->account_id1_c, array('disable_row_level_security' => true));
            // Designated Facility Name
            $pdf->SetXY(0, 0);
            $designatedFacilityName = array('x' => $startXIndex - 28, 'y' => $startYIndex + 40
                , 'text' => htmlspecialchars_decode($salesAndServiceDesignatedFacilityBean->name)); // 22, 59
            // 'Botavia Energy'
            $pdf->MultiCell(70, 5, $designatedFacilityName['text'], 0, '', 0, 1, $designatedFacilityName['x'], $designatedFacilityName['y'], true);

            $shippingAddress = '';
            $shippingAddress = $salesAndServiceDesignatedFacilityBean->shipping_address_street;
            $shippingAddress .= ' ' . !empty(trim($salesAndServiceDesignatedFacilityBean->shipping_address_city)) ? $salesAndServiceDesignatedFacilityBean->shipping_address_city . ',' : '';
            $shippingAddress .= ' ' . $salesAndServiceDesignatedFacilityBean->shipping_address_state;
            $shippingAddress .= ' ' . $salesAndServiceDesignatedFacilityBean->shipping_address_postalcode;
//            $shippingAddress .= ' ' . $salesAndServiceDesignatedFacilityBean->shipping_address_country;
            $shippingAddress = trim(preg_replace('/\s+/', ' ', preg_replace('/\s+/', ' ', preg_replace('/\s+/', ' ', $shippingAddress))));
            $shippingAddress = htmlspecialchars_decode($shippingAddress);

            // Designated Facility Name
            $pdf->SetXY(0, 0);
            $designatedFacilitySiteAddress = array('x' => $startXIndex - 28, 'y' => $startYIndex + 43
                , 'text' => $shippingAddress); // 22, 62
            // '19528 Ventura Blvd Tarzana, CA 91356 United States'
            $pdf->MultiCell(70, 5, $designatedFacilitySiteAddress['text'], 0, '', 0, 1, $designatedFacilitySiteAddress['x'], $designatedFacilitySiteAddress['y'], true);

            // Designated Facility Phone
            $pdf->SetXY(0, 0);
            $designatedFacilityPhone = array('x' => $startXIndex + 20, 'y' => $startYIndex + 49
                , 'text' => $salesAndServiceDesignatedFacilityBean->phone_office); // 70, 68
            // '(800) 424-9300'
            $pdf->MultiCell(70, 5, $designatedFacilityPhone['text'], 0, '', 0, 1, $designatedFacilityPhone['x'], $designatedFacilityPhone['y'], true);

            // EPA ID Number
            $pdf->SetXY(0, 0);
            $epaIdNumber3 = array('x' => $startXIndex + 110, 'y' => $startYIndex + 49
                , 'text' => $salesAndServiceDesignatedFacilityBean->ac_usepa_id_c); // 160, 68
            // 'CAD9841667891'
            $pdf->MultiCell(70, 5, $epaIdNumber3['text'], 0, '', 0, 1, $epaIdNumber3['x'], $epaIdNumber3['y'], true);
        }

        // ---------------------------------------------------------
        // ---------------Revenue Line Items Stuff------------------
        // ---------------------------------------------------------
        global $db;
        $rliYScailing = 0;
        $result = $this->getRelatedRLIs($salesAndServiceBean);
        $rowCount = 0;
        $manifest_hazmat_handle_code_list = array();
        while ($row = $db->fetchByAssoc($result)) {
            if ($rowCount > 3)
                continue;

            $rliBean = BeanFactory::getBean('RevenueLineItems', $row['id'], array('disable_row_level_security' => true));
            $manifest_hazmat_handle_code_list[$rowCount] = $rliBean->manifest_hazmat_handle_code_c;
            $additional_info_ack_list[$rowCount] = htmlspecialchars_decode($rliBean->additional_info_ack_c);
            $rowCount += 1;

            // Line Number 1
            // HM Hazardeous Material
            $pdf->SetXY(0, 0);
            $pdf->SetFont('courier', 'B', $fontSize);
            // set font for chars
            /*
              $pdf->SetFont('zapfdingbats', '', 16);
              $hm1 = array('x' => $startXIndex - 37, 'y' => $startYIndex + $rliYScailing + 66
              , 'text' => ''); // ✅ ❌ 13, 85
              $pdf->SetXY($hm1['x'], $hm1['y']);
              if ($rliBean->shipping_hazardous_materia_c) {
              $pdf->Image('custom/modules/sales_and_services/tpls/checked_rli.png', '', '', 0, 0, '', '', '', false, 300, '', false, false, 1, false, false, false);
              } else {
              $pdf->Image('custom/modules/sales_and_services/tpls/crossed_rli.png', '', '', 0, 0, '', '', '', false, 300, '', false, false, 1, false, false, false);
              } */
            $hm1 = array('x' => $startXIndex - 36, 'y' => $startYIndex + $rliYScailing + 66
                , 'text' => 'X'); // 14, 85
            if ($rliBean->shipping_hazardous_materia_c) {
                $pdf->MultiCell(5, 5, $hm1['text'], 0, '', 0, 1, $hm1['x'], $hm1['y'], true);
            }

            // set font
            $pdf->SetFont('courier', 'B', $fontSize);

            $pdf->SetXY(0, 0);
            $rli1 = array('x' => $startXIndex - 28, 'y' => $startYIndex + $rliYScailing + 64
                , 'text' => htmlspecialchars_decode($rliBean->name . (!empty(trim($rliBean->proper_shipping_name_c)) ? ' - ' . $rliBean->proper_shipping_name_c : ''))); // 22, 83
            // 'NON-RCRA HAZARDOUS WASTE MATERIAL LIQUID - (OILY WATER)' . ' - ' . 'NO PLACARDS REQUIRED'
            $pdf->MultiCell(95, 5, $rli1['text'], 0, '', 0, 1, $rli1['x'], $rli1['y'], true);

//            $pdf->SetXY(0, 0);
//            $containerNo1 = array('x' => $startXIndex + 72, 'y' => $startYIndex + $rliYScailing + 66
//                , 'text' => '001'); // 122, 85
//            // 001
//            $pdf->MultiCell(95, 5, $containerNo1['text'], 0, '', 0, 1, $containerNo1['x'], $containerNo1['y'], true);

            $pdf->SetXY(0, 0);
            $containerType1 = array('x' => $startXIndex + 85, 'y' => $startYIndex + $rliYScailing + 66
                , 'text' => $rliBean->manifest_container_type_c); // 135, 85
            // TT
            $pdf->MultiCell(95, 5, $containerType1['text'], 0, '', 0, 1, $containerType1['x'], $containerType1['y'], true);

            $pdf->SetXY(0, 0);
            $unitOfMeasure1 = array('x' => $startXIndex + 112, 'y' => $startYIndex + $rliYScailing + 66
                , 'text' => $rliBean->manifest_uom_c); // 162, 85
            // G
            $pdf->MultiCell(95, 5, $unitOfMeasure1['text'], 0, '', 0, 1, $unitOfMeasure1['x'], $unitOfMeasure1['y'], true);

            // waste_state_codes_c , epa_waste_codes_c
            $waste_state_codes_c = unencodeMultienum($rliBean->waste_state_codes_c);
            $wasteStateCodeXScailing = 0;
            $pdf->SetFont('courier', 'B', $fontSize);
            foreach ($waste_state_codes_c as $key => $value) {
                if ($key > 2)
                    continue;
                // set font
                $pdf->SetXY(0, 0);
                $wasteCode1 = array('x' => ($startXIndex + $wasteStateCodeXScailing + 121) - ($key == 0 ? 1 : 0), 'y' => $startYIndex + $rliYScailing + 63
                    , 'text' => $value); // 171, 82
                // 'CA221'
                $pdf->MultiCell(12, 5, $wasteCode1['text'], 0, '', 0, 1, $wasteCode1['x'], $wasteCode1['y'], true);

                $wasteStateCodeXScailing += 10;
            }

            // waste_state_codes_c , epa_waste_codes_c
            $epa_waste_codes_c = unencodeMultienum($rliBean->epa_waste_codes_c);
            $epaWasteCodeXScailing = 0;
            $pdf->SetFont('courier', 'B', $fontSize);
            foreach ($epa_waste_codes_c as $key => $value) {
                if ($key > 2)
                    continue;
                // set font
                $pdf->SetXY(0, 0);
                $wasteCode1 = array('x' => ($startXIndex + $epaWasteCodeXScailing + 121) - ($key == 0 ? 1 : 0), 'y' => $startYIndex + $rliYScailing + 69
                    , 'text' => $value); // 171, 82
                // 'CA221'
                $pdf->MultiCell(12, 5, $wasteCode1['text'], 0, '', 0, 1, $wasteCode1['x'], $wasteCode1['y'], true);

                $epaWasteCodeXScailing += 10;
            }
            $rliYScailing += 12;
        }

//        $GLOBALS['log']->fatal('$additional_info_ack_list : ' . print_r($additional_info_ack_list, 1));
//        $additionalInfoYScailing = 0;
//        foreach ($additional_info_ack_list as $value) {
//            $pdf->SetFont('courier', 'B', 8);
//            $pdf->SetXY(0, 0);
//            $additional_info_ack = array('x' => $startXIndex - 28, 'y' => $startYIndex + $additionalInfoYScailing + 112
//                , 'text' => $value); // 22, 139
//            // 'CA221'
//            $pdf->MultiCell(180, 5, $additional_info_ack['text'], 0, '', 0, 1, $additional_info_ack['x'], $additional_info_ack['y'], true);
//            $additionalInfoYScailing += 5;
//        }

        $pdf->SetFont('courier', 'B', $fontSize);
        $manifestHazmatXScailing = 5;
        foreach ($manifest_hazmat_handle_code_list as $value) {
            $pdf->SetXY(0, 0);
            $manifest_hazmat_handle_code = array('x' => ($startXIndex - 28) + $manifestHazmatXScailing, 'y' => $startYIndex + 219
                , 'text' => $value); // 27, 238
            // 'CA221'
            $pdf->MultiCell(30, 5, $manifest_hazmat_handle_code['text'], 0, '', 0, 1, $manifest_hazmat_handle_code['x'], $manifest_hazmat_handle_code['y'], true);
            $manifestHazmatXScailing += 45;
        }

        // Download PDF
        ob_clean();
        $pdf->Output(htmlspecialchars_decode(trim($salesAndServiceBean->name . ' Manifest.pdf')), 'D');
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
    revenue_line_items.deleted = 0
ORDER BY revenue_line_items.line_number ASC , revenue_line_items.id ASC";
        $result = $db->query($query, false);
        return $result;
    }

}
