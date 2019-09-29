<?php

require_once('include/Sugarpdf/sugarpdf/sugarpdf.pdfmanager.php');

class LR_Lab_ReportsSugarpdfPdfmanager extends SugarpdfPdfmanager {

    public function preDisplay() {
        global $sugar_config;

        SugarpdfSmarty::preDisplay();

        /**/
        // settings for disable smarty php tags
        $this->ss->security_settings['PHP_TAGS'] = false;
        $this->ss->security = true;
        if (defined('SUGAR_SHADOW_PATH')) {
            $this->ss->secure_dir[] = SUGAR_SHADOW_PATH;
        }

        // header/footer settings
        $this->setPrintHeader(false);
        $this->setPrintFooter(true); // always print page number at least

        if (!empty($_REQUEST['pdf_template_id'])) {

            $pdfTemplate = BeanFactory::newBean('PdfManager');
            if ($pdfTemplate->retrieve($_REQUEST['pdf_template_id'], false) !== null) {

                $previewMode = FALSE;
                if (!empty($_REQUEST['pdf_preview']) && $_REQUEST['pdf_preview'] == 1) {
                    $previewMode = true;
                    $this->bean = BeanFactory::newBean($pdfTemplate->base_module);
                }

                $this->SetCreator(PDF_CREATOR);
                $this->SetAuthor($pdfTemplate->author);
                $this->SetTitle($pdfTemplate->title);
                $this->SetSubject($pdfTemplate->subject);
                $this->SetKeywords($pdfTemplate->keywords);
                $this->templateLocation = $this->buildTemplateFile($pdfTemplate, $previewMode);

                $headerLogo = '';
                if (!empty($pdfTemplate->header_logo)) {
                    // Create a temporary copy of the header logo
                    // and append the original filename, so TCPDF can figure the extension
                    $headerLogo = 'upload/' . $pdfTemplate->id . $pdfTemplate->header_logo;
                    copy('upload/' . $pdfTemplate->id, $headerLogo);
                }

                if (!empty($pdfTemplate->header_logo) ||
                        !empty($pdfTemplate->header_title) || !empty($pdfTemplate->header_text)) {
                    $this->setHeaderData(
                            $headerLogo, PDF_HEADER_LOGO_WIDTH, $pdfTemplate->header_title, $pdfTemplate->header_text
                    );
                    $this->setPrintHeader(true);
                }

                if (!empty($pdfTemplate->footer_text)) {
                    $this->footerText = $pdfTemplate->footer_text;
                }


                $filenameParts = array();
                if (!empty($this->bean) && !empty($this->bean->name)) {
                    $filenameParts[] = $this->bean->name;
                }
                if (!empty($pdfTemplate->name)) {
                    $filenameParts[] = $pdfTemplate->name;
                }

                $cr = array(' ', "\r", "\n", "/");
                $this->pdfFilename = str_replace($cr, '_', implode("_", $filenameParts) . ".pdf");
            }
        }


        if ($previewMode === FALSE) {
            require_once 'modules/PdfManager/PdfManagerHelper.php';
            $fields = self::parseBeanFields($this->bean, true);
        } else {
            $fields = array();
        }

        if ($this->module == 'Quotes' && $previewMode === FALSE) {
            global $locale;
            require_once 'modules/Quotes/config.php';
            require_once 'modules/Currencies/Currency.php';
            $currency = BeanFactory::newBean('Currencies');
            $format_number_array = array(
                'currency_symbol' => true,
                'type' => 'sugarpdf',
                'currency_id' => $this->bean->currency_id,
                'charset_convert' => true, /* UTF-8 uses different bytes for Euro and Pounds */
            );
            $currency->retrieve($this->bean->currency_id);
            $fields['currency_iso'] = $currency->iso4217;

            // Adding Tax Rate Field
            $fields['taxrate_value'] = format_number_sugarpdf($this->bean->taxrate_value, $locale->getPrecision(), $locale->getPrecision(), array('percentage' => true));
            ;

            $this->bean->load_relationship('product_bundles');
            $product_bundle_list = $this->bean->product_bundles->getBeans();
            usort($product_bundle_list, array('ProductBundle', 'compareProductBundlesByIndex'));

            $bundles = array();
            $count = 0;
            foreach ($product_bundle_list as $ordered_bundle) {

                $bundleFields = self::parseBeanFields($ordered_bundle, true);
                $bundleFields['products'] = array();
                $product_bundle_line_items = $ordered_bundle->get_product_bundle_line_items();
                foreach ($product_bundle_line_items as $product_bundle_line_item) {

                    $bundleFields['products'][$count] = self::parseBeanFields($product_bundle_line_item, true);

                    if ($product_bundle_line_item->object_name == "ProductBundleNote") {
                        $bundleFields['products'][$count]['name'] = $bundleFields['products'][$count]['description'];
                    } else {
                        // Special case about discount amount
                        if ($product_bundle_line_item->discount_select) {
                            $bundleFields['products'][$count]['discount_amount'] = format_number($product_bundle_line_item->discount_amount, $locale->getPrecision(), $locale->getPrecision()) . '%';
                        }
                        // ensure the discount_select field exists in the pdf data
                        $bundleFields['products'][$count]['discount_select'] = $product_bundle_line_item->discount_select;

                        // Special case about ext price
                        $bundleFields['products'][$count]['ext_price'] = format_number_sugarpdf($product_bundle_line_item->discount_price * $product_bundle_line_item->quantity, $locale->getPrecision(), $locale->getPrecision(), $format_number_array);
                    }


                    $count++;
                }
                $bundles[] = $bundleFields;
            }

            $this->ss->assign('product_bundles', $bundles);
        }

        $this->ss->assign('fields', $fields);
        /**/




        if (!empty($_REQUEST['pdf_template_id']) && $_REQUEST['pdf_template_id'] == $sugar_config['coc_pdf_template']) {
            $filenameParts = array('COC');
            if (!empty($this->bean) && !empty($this->bean->commodity_c)) {
                $filenameParts[] = $this->bean->commodity_c;
            }
            if (!empty($this->bean->sample_id_number_c)) {
                $filenameParts[] = $this->bean->sample_id_number_c;
            }

            $cr = array(' ', "\r", "\n", "/");
            $this->pdfFilename = str_replace($cr, '_', implode("-", $filenameParts) . ".pdf");
        }
    }

    protected function buildEmail($file_name, $focus) {
        global $sugar_config;

        $email_id = parent::buildEmail($file_name, $focus);

        if (!empty($_REQUEST['pdf_template_id']) && $_REQUEST['pdf_template_id'] == $sugar_config['coc_pdf_template']) {
            $email_object = BeanFactory::retrieveBean("Emails", $email_id);

            $email_object->name = "[Lab Report: {$focus->sample_id_number_c}] {$focus->commodity_c}-{$focus->sample_id_number_c}";

            $email_object->save();
        }

        return $email_id;
    }

    private function buildTemplateFile($pdfTemplate, $previewMode = FALSE) {
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

            sugar_file_put_contents($tpl_filename, $pdfTemplate->body_html);

            return $tpl_filename;
        }

        return '';
    }

    protected static function hasOneRelationship(SugarBean $bean, $fieldName) {
        if (!isset($bean->$fieldName)) {
            return false;
        }

        if ($bean->$fieldName instanceof Link2) {
            return true;
        }

        // not Link2 or Link. Bail
        if (!isset($bean->$fieldName->_relationship->relationship_type)) {
            return false;
        }

        // deal with Link
        switch ($bean->$fieldName->_relationship->relationship_type) {
            case 'one-to-one':
                return true;
            case 'one-to-many':
                return !$bean->$fieldName->_get_bean_position();
            case 'many-to-one':
                return $bean->$fieldName->_get_bean_position();
            case 'many-to-many':
                if (isset($bean->field_defs[$fieldName]['side'])) {
                    return false;
                }
                switch ($bean->$fieldName->_get_link_table_definition(
                        $bean->$fieldName->_relationship_name, 'true_relationship_type'
                )) {
                    case 'one-to-many':
                        return !$bean->$fieldName->_get_bean_position();
                    case 'many-to-one':
                        return $bean->$fieldName->_get_bean_position();
                    default:
                        return false;
                }
            default:
                return false;
        }
    }

    public static function parseBeanFields($module_instance, $recursive = FALSE) {
        global $app_list_strings;

        $module_instance->ACLFilterFields();

        $fields_module = array();
        foreach ($module_instance->toArray() as $name => $value) {

            if (isset($module_instance->field_defs[$name]['type']) &&
                    ($module_instance->field_defs[$name]['type'] == 'enum' || $module_instance->field_defs[$name]['type'] == 'radio' || $module_instance->field_defs[$name]['type'] == 'radioenum') &&
                    isset($module_instance->field_defs[$name]['options']) &&
                    isset($app_list_strings[$module_instance->field_defs[$name]['options']]) &&
                    isset($app_list_strings[$module_instance->field_defs[$name]['options']][$value])
            ) {
                $fields_module[$name] = $app_list_strings[$module_instance->field_defs[$name]['options']][$value];
                $fields_module[$name] = str_replace(array('&#39;', '&#039;'), "'", $fields_module[$name]);
            } elseif (isset($module_instance->field_defs[$name]['type']) &&
                    $module_instance->field_defs[$name]['type'] == 'multienum' &&
                    isset($module_instance->field_defs[$name]['options']) &&
                    isset($app_list_strings[$module_instance->field_defs[$name]['options']])
            ) {
                $multienums = unencodeMultienum($value);
                $multienums_value = array();
                foreach ($multienums as $multienum) {
                    if (isset($app_list_strings[$module_instance->field_defs[$name]['options']][$multienum])) {
                        $multienums_value[] = $app_list_strings[$module_instance->field_defs[$name]['options']][$multienum];
                    } else {
                        $multienums_value[] = $multienum;
                    }
                }
                $fields_module[$name] = '<li>' . implode('</li><li>', $multienums_value) . '</li>';
                $fields_module[$name] = str_replace(array('&#39;', '&#039;'), "'", $fields_module[$name]);
            } elseif ($recursive &&
                    isset($module_instance->field_defs[$name]['type']) &&
                    $module_instance->field_defs[$name]['type'] == 'link' &&
                    $module_instance->load_relationship($name) &&
                    self::hasOneRelationship($module_instance, $name) &&
                    count($module_instance->$name->get()) == 1
            ) {
                $related_module = $module_instance->$name->getRelatedModuleName();
                $related_instance = BeanFactory::newBean($related_module);
                $related_instance_id = $module_instance->$name->get();
                if ($related_instance->retrieve($related_instance_id[0]) === null) {
                    $GLOBALS['log']->fatal(__FILE__ . ' Failed loading module ' . $related_module . ' with id ' . $related_instance_id[0]);
                }

                $fields_module[$name] = self::parseBeanFields($related_instance, FALSE);
            } elseif (
                    isset($module_instance->field_defs[$name]['type']) &&
                    $module_instance->field_defs[$name]['type'] == 'currency' &&
                    isset($module_instance->currency_id)
            ) {
                global $locale;
                $format_number_array = array(
                    'currency_symbol' => true,
                    'currency_id' => (!empty($module_instance->field_defs[$name]['currency_id']) ? $module_instance->field_defs[$name]['currency_id'] : $module_instance->currency_id),
                    'type' => 'sugarpdf',
                    'charset_convert' => true,
                );

                $fields_module[$name] = format_number_sugarpdf($module_instance->$name, $locale->getPrecision(), $locale->getPrecision(), $format_number_array);
            } elseif (
                    isset($module_instance->field_defs[$name]['type']) &&
                    ($module_instance->field_defs[$name]['type'] == 'decimal')
            ) {
                global $locale;
                $format_number_array = array(
                    'convert' => false,
                );
                if (!isset($module_instance->$name)) {
                    $module_instance->$name = 0;
                }

                $fields_module[$name] = format_number_sugarpdf($module_instance->$name, $locale->getPrecision(), $locale->getPrecision(), $format_number_array);
            } elseif (
                    isset($module_instance->field_defs[$name]['type']) &&
                    ($module_instance->field_defs[$name]['type'] == 'image')
            ) {
                $fields_module[$name] = $GLOBALS['sugar_config']['upload_dir'] . "/" . $value;
            } elseif (is_string($value)) {
                $value = nl2br(stripslashes($value));

                if (isset($module_instance->field_defs[$name]['type']) &&
                        $module_instance->field_defs[$name]['type'] === 'html'
                ) {
                    $value = htmlspecialchars_decode($value, ENT_QUOTES);
                }
                $fields_module[$name] = $value;
            }
        }

        return $fields_module;
    }

}

