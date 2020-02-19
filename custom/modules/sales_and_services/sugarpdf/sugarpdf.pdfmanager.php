<?php

require_once('custom/include/Sugarpdf/sugarpdf/sugarpdf.pdfmanager.php');

class sales_and_servicesSugarpdfPdfmanager extends SugarpdfPdfmanager {

    public function preDisplay() {
        $retData = parent::preDisplay();
        $bundles = $retData['bundles'];
        $fields = $retData['fields'];

        $previewMode = FALSE;
        if (!empty($_REQUEST['pdf_preview']) && $_REQUEST['pdf_preview'] == 1) {
            $previewMode = true;
        }

        // For multiline rows
        if ($this->module == 'sales_and_services' && $previewMode === FALSE) {
            global $locale;
            $customerCertificatesList = array();
            $transporterCertificatesList = array();
            $revenuelineitems = array();
            $count = 0;
            $_count = 0;
            $__count = 0;
            $bundleFields['revenuelineitems'] = array();
            $bundleFields['additional_info_ack_c'] = array();
            $feds = 0;
            $tax = 0;

            // RevenueLineItems
            $this->bean->load_relationship('sales_and_services_revenuelineitems_1');
            $revenuelineitemsList = $this->bean->sales_and_services_revenuelineitems_1->getBeans();

            foreach ($revenuelineitemsList as $revenuelineitemsBean) {
                if ($revenuelineitemsBean->is_bundle_product_c == "parent") {
                    continue;
                }

                $bundleFields['revenuelineitems'][$count] = PdfManagerHelper::parseBeanFields($revenuelineitemsBean, true);
                $bundleFields['revenuelineitems'][$count]['estimated_quantity_c'] = format_number($revenuelineitemsBean->estimated_quantity_c, $locale->getPrecision(), $locale->getPrecision());
                $bundleFields['revenuelineitems'][$count]['discount_price'] = format_number($revenuelineitemsBean->discount_price, $locale->getPrecision(), $locale->getPrecision());
                $bundleFields['revenuelineitems'][$count]['index'] = $count + 1;

                if ($revenuelineitemsBean->tax_class == "Taxable" && $tax == 0) {
                    $tax = 1;
                }

                if ((!empty($revenuelineitemsBean->fed_percentage) && $revenuelineitemsBean->fed_percentage != '0.00') && $feds == 0) {
                    $feds = 1;
                }

                if (!empty($bundleFields['revenuelineitems'][$count]['additional_info_ack_c'])) {
                    $bundleFields['additional_info_ack_c'][$__count]['additional_info_ack_c'] = $bundleFields['revenuelineitems'][$count]['additional_info_ack_c'];
                    $bundleFields['additional_info_ack_c'][$__count]['index'] = $__count + 1;
                    $__count++;
                }

                $count++;

                // Terms And Conditions
                $customerCertificatesList = array_merge($customerCertificatesList, unencodeMultienum($revenuelineitemsBean->customer_certificates));
                $transporterCertificatesList = array_merge($transporterCertificatesList, unencodeMultienum($revenuelineitemsBean->transporter_certificates));
            }

            $customerCertificatesString = '';
            $customerCertificatesList = array_filter(array_unique(array_values($customerCertificatesList)));
            if (!empty($customerCertificatesList)) {
                foreach ($customerCertificatesList as $key => $certificateId) {
                    $certificateBean = BeanFactory::getBean('wp_terms_and_conditions', $certificateId, array('disable_row_level_security' => true));
                    $customerCertificatesString .= $certificateBean->description . '; ';
                }
            }

            $transporterCertificatesString = '';
            $transporterCertificatesList = array_filter(array_unique(array_values($transporterCertificatesList)));
            if (!empty($transporterCertificatesList)) {
                foreach ($transporterCertificatesList as $key => $certificateId) {
                    $certificateBean = BeanFactory::getBean('wp_terms_and_conditions', $certificateId, array('disable_row_level_security' => true));
                    $transporterCertificatesString .= $certificateBean->description . '; ';
                }
            }

            $revenuelineitems[] = $bundleFields;
            $this->ss->assign('sales_and_services_revenuelineitems_1', $revenuelineitems);
            $this->ss->assign('customerCertificates', $customerCertificatesString);
            $this->ss->assign('transporterCertificates', $transporterCertificatesString);
            $fields['customerCertificates'] = $customerCertificatesString;
            $fields['transporterCertificates'] = $transporterCertificatesString;

            // Check is Customer 3rd Party / Broker
            if (strpos($fields['accounts_sales_and_services_1']['account_type_cst_c'], "3rd Party / Broker") !== false) {
                $fields['accounts_sales_and_services_1']['isThirdParty'] = "1";
            }
        }

        $fields['all'] = $feds && $tax ? 1 : 0;
        $fields['feds'] = $feds;
        $fields['tax'] = $tax;

        $this->ss->assign('fields', $fields);
    }

    /**
     * Build the template file for smarty to parse
     *
     * @param $pdfTemplate
     * @param $previewMode
     * @return $tpl_filename
     */
    public function buildTemplateFile($pdfTemplate, $previewMode = FALSE) {
        if (!empty($pdfTemplate)) {

            if (!file_exists(sugar_cached('modules/PdfManager/tpls'))) {
                mkdir_recursive(sugar_cached('modules/PdfManager/tpls'));
            }
            $tpl_filename = sugar_cached('modules/PdfManager/tpls/' . $pdfTemplate->id . '.tpl');

            if ($previewMode !== FALSE) {
                $tpl_filename = sugar_cached('modules/PdfManager/tpls/' . $pdfTemplate->id . '_preview.tpl');
                $pdfTemplate->body_html = str_replace(array('{', '}'), array('&#123;', '&#125;'), $pdfTemplate->body_html);
            }

            if ($pdfTemplate->base_module == 'Quotes') {

                $pdfTemplate->body_html = str_replace(
                        '$fields.product_bundles', '$bundle', $pdfTemplate->body_html
                );

                $pdfTemplate->body_html = str_replace(
                        '$fields.products', '$product', $pdfTemplate->body_html
                );

                $pdfTemplate->body_html = str_replace(
                        '<!--START_BUNDLE_LOOP-->', '{foreach from=$product_bundles item="bundle"}', $pdfTemplate->body_html
                );

                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT_LOOP-->', '{foreach from=$bundle.products item="product"}', $pdfTemplate->body_html
                );

                $pdfTemplate->body_html = str_replace(
                        array("<!--END_PRODUCT_LOOP-->", "<!--END_BUNDLE_LOOP-->"), '{/foreach}', $pdfTemplate->body_html
                );
            }

            if ($pdfTemplate->base_module == 'sales_and_services') {
                $pdfTemplate->body_html = str_replace(
                        '<!--START_sales_and_services_revenuelineitems_1_LOOP-->', '{foreach from=$revenuelineitemsList.revenuelineitems item="revenuelineitem"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_sales_and_services_revenuelineitems_2_LOOP-->', '{foreach from=$revenuelineitemsList.additional_info_ack_c item="revenuelineitem"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        array(
                    "<!--END_sales_and_services_revenuelineitems_1_LOOP-->",
                    "<!--END_sales_and_services_revenuelineitems_2_LOOP-->",
                        ), '{/foreach}', $pdfTemplate->body_html
                );
            }

            sugar_file_put_contents($tpl_filename, $pdfTemplate->body_html);

            return $tpl_filename;
        }

        return '';
    }

}
