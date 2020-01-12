<?php

require_once('include/Sugarpdf/sugarpdf/sugarpdf.pdfmanager.php');

class WPM_Waste_Profile_ModuleSugarpdfPdfmanager extends SugarpdfPdfmanager {

    public $hrLikeDiv = false;
    public $logoSize = 20;

    public function preDisplay() {
        SugarpdfSmarty::preDisplay();

        //set margins
        //PDF_MARGIN_TOP
        $this->SetMargins(PDF_MARGIN_LEFT, 38, PDF_MARGIN_RIGHT);
        // $this->setCellHeightRatio(1.25);
        /* function Footer for page number */

        // settings for disable smarty php tags
        $this->ss->security_settings['PHP_TAGS'] = false;
        $this->ss->security = true;
        if (defined('SUGAR_SHADOW_PATH')) {
            $this->ss->secure_dir[] = SUGAR_SHADOW_PATH;
        }

        // header/footer settings
//        $this->setPrintHeader(true);
        $this->setPrintFooter(false); // always print page number at least

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
                            $headerLogo, $this->logoSize, $pdfTemplate->header_title, $pdfTemplate->header_text
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

        if ($this->module == 'WPM_Waste_Profile_Module' && $previewMode === FALSE) {
            global $locale;
            $compositions = array();
            $count = 0;
            $count1 = 0;
            $count2 = 0;
            $count3 = 0;
            $count4 = 0;
            $count5 = 0;
            $bundleFields['compositions'] = array();
            $bundleFields['constituent_regulateds'] = array();
            $bundleFields['constituent_volatiles'] = array();
            $bundleFields['constituent_others'] = array();
            $bundleFields['constituent_semivolatiles'] = array();
            $bundleFields['constituent_pesticide_herbicides'] = array();
            $fields['showTotal'] = 0;
            $fields['composition_max_total'] = format_number($fields['composition_max_total'], $locale->getPrecision(), $locale->getPrecision());

            // Composition
            $this->bean->load_relationship('waste_composition_wpm_waste_profile_module');
            $compositionList = $this->bean->waste_composition_wpm_waste_profile_module->getBeans();
            foreach ($compositionList as $compositionBean) {
                $bundleFields['compositions'][$count] = PdfManagerHelper::parseBeanFields($compositionBean, true);
                $bundleFields['compositions'][$count]['min'] = format_number($compositionBean->min, $locale->getPrecision(), $locale->getPrecision());
                $bundleFields['compositions'][$count]['max'] = format_number($compositionBean->max, $locale->getPrecision(), $locale->getPrecision());
                $fields['showTotal'] = 1;
                $count++;
            }

            // Constituents : Regulated Metals 
            $this->bean->load_relationship('waste_constituents_wpm_waste_profile_module');
            $constituentList = $this->bean->waste_constituents_wpm_waste_profile_module->getBeans();
            foreach ($constituentList as $constituentBean) {
                $tempBean = PdfManagerHelper::parseBeanFields($constituentBean, true);
                if ($constituentBean->type == 'Regulated') {
                    $bundleFields['constituent_regulateds'][$count1] = $tempBean;
                    $bundleFields['constituent_regulateds'][$count1]['regulatory_level'] = format_number($constituentBean->regulatory_level, $locale->getPrecision(), $locale->getPrecision());
                    $bundleFields['constituent_regulateds'][$count1]['tclp'] = format_number($constituentBean->tclp, $locale->getPrecision(), $locale->getPrecision());
                    // $bundleFields['constituent_regulateds'][$count1]['not_applicable'] = $constituentBean->not_applicable ? 'Yes' : '';
                    $count1++;
                } else if ($constituentBean->type == 'Volatile') {
                    $bundleFields['constituent_volatiles'][$count2] = $tempBean;
                    $bundleFields['constituent_volatiles'][$count2]['regulatory_level'] = format_number($constituentBean->regulatory_level, $locale->getPrecision(), $locale->getPrecision());
                    $bundleFields['constituent_volatiles'][$count2]['tclp'] = format_number($constituentBean->tclp, $locale->getPrecision(), $locale->getPrecision());
                    $count2++;
                } else if ($constituentBean->type == 'Other Constituents') {
                    $bundleFields['constituent_others'][$count3] = $tempBean;
                    $bundleFields['constituent_others'][$count3]['regulatory_level'] = format_number($constituentBean->regulatory_level, $locale->getPrecision(), $locale->getPrecision());
                    $bundleFields['constituent_others'][$count3]['tclp'] = format_number($constituentBean->tclp, $locale->getPrecision(), $locale->getPrecision());
                    $count3++;
                } else if ($constituentBean->type == 'Semi-Volatile') {
                    $bundleFields['constituent_semivolatiles'][$count4] = $tempBean;
                    $bundleFields['constituent_semivolatiles'][$count4]['regulatory_level'] = format_number($constituentBean->regulatory_level, $locale->getPrecision(), $locale->getPrecision());
                    $bundleFields['constituent_semivolatiles'][$count4]['tclp'] = format_number($constituentBean->tclp, $locale->getPrecision(), $locale->getPrecision());
                    $count4++;
                } else if ($constituentBean->type == 'Pesticides And Herbicides') {
                    $bundleFields['constituent_pesticide_herbicides'][$count5] = $tempBean;
                    $bundleFields['constituent_pesticide_herbicides'][$count5]['regulatory_level'] = format_number($constituentBean->regulatory_level, $locale->getPrecision(), $locale->getPrecision());
                    $bundleFields['constituent_pesticide_herbicides'][$count5]['tclp'] = format_number($constituentBean->tclp, $locale->getPrecision(), $locale->getPrecision());
                    $count5++;
                }
            }

            global $app_list_strings;
            $multienums = unencodeMultienum($this->bean->choose_hazards_that_apply_c);
            $index = -1;
            $count = 0;
            $bundleFields['catas'][$count] = array();
            foreach ($app_list_strings['choose_hazards_that_apply_c_list'] as $key => $value) {
                $index++;
                if ($index == 4) {
                    $index = 0;
                    $count++;
                    $bundleFields['catas'][$count] = array();
                }

                if (in_array($key, $multienums)) {
                    $bundleFields['catas'][$count]['status' . $index] = "Yes";
                } else {
                    $bundleFields['catas'][$count]['status' . $index] = "No";
                }
                $bundleFields['catas'][$count]['name' . $index] = $app_list_strings['choose_hazards_that_apply_c_list'][$key];
            }


            $certificates = array_unique(unencodeMultienum($this->bean->certificates));
            if (!empty($certificates)) {
                $count = 0;
                $bundleFields['certificates'][$count] = array();
                foreach ($certificates as $key => $certificateId) {
                    $certificateBean = BeanFactory::getBean('wp_terms_and_conditions', $certificateId, array('disable_row_level_security' => true));
                    $bundleFields['certificates'][$count]['description'] = $certificateBean->description;
                    $count++;
                }
            }

            $link2 = 'accounts_wpm_waste_profile_module_2';
            $this->bean->load_relationship($link2);
            $accountBean = $this->bean->$link2->getBeans();
            if (!empty($accountBean)) {
                $accountBean = array_shift($accountBean);
                $accountBean->load_relationship('contacts');
                $contactsList = $accountBean->contacts->getBeans();
                foreach ($contactsList as $contactBean) {
                    $tempBean = PdfManagerHelper::parseBeanFields($contactBean, true);
                    if ($contactBean->role_contact == 'EHS') {
                        $fields[$link2]['contacts'] = $tempBean;
                        break;
                    } else if ($contactBean->role_contact == 'Primary') {
                        $fields[$link2]['contacts'] = $tempBean;
                    } else if (empty($fields[$link2]['contacts'])) {
                        $fields[$link2]['contacts'] = $tempBean;
                    }
                }
            }

            $link1 = 'accounts_wpm_waste_profile_module_1';
            $this->bean->load_relationship($link1);
            $this->bean->$link1->getBeans();
            $accountBean = $this->bean->$link1->getBeans();
            if (!empty($accountBean)) {
                $accountBean = array_shift($accountBean);
                $accountBean->load_relationship('contacts');
                $contactsList = $accountBean->contacts->getBeans();
                foreach ($contactsList as $contactBean) {
                    $tempBean = PdfManagerHelper::parseBeanFields($contactBean, true);
                    if ($contactBean->role_contact == 'EHS') {
                        $fields[$link1]['contacts'] = $tempBean;
                        break;
                    } else if ($contactBean->role_contact == 'Primary') {
                        $fields[$link1]['contacts'] = $tempBean;
                    } else if (empty($fields[$link1]['contacts'])) {
                        $fields[$link1]['contacts'] = $tempBean;
                    }
                }
            }

            $compositions[] = $bundleFields;
            $this->ss->assign('waste_composition_wpm_waste_profile_module', $compositions);
            $this->ss->assign('waste_constituents_wpm_waste_profile_module', $compositions);
            $this->ss->assign('choose_hazards_that_apply_list', $compositions);
            $this->ss->assign('certificates', $compositions);
        }

        $this->ss->assign('fields', $fields);

        $this->ss->assign('PDF_MARGIN_TOP', 0);
    }

    /**
     * Build the template file for smarty to parse
     *
     * @param $pdfTemplate
     * @param $previewMode
     * @return $tpl_filename
     */
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

            if ($pdfTemplate->base_module == 'WPM_Waste_Profile_Module') {
                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT_LOOP-->', '{foreach from=$compositionList.compositions item="composition"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT1_LOOP-->', '{foreach from=$constituentList.constituent_regulateds item="constituent_regulated"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT2_LOOP-->', '{foreach from=$constituentList.constituent_volatiles item="constituent_volatile"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT3_LOOP-->', '{foreach from=$constituentList.constituent_semivolatiles item="constituent_semivolatile"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT4_LOOP-->', '{foreach from=$constituentList.constituent_pesticide_herbicides item="constituent_pesticide_herbicide"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT5_LOOP-->', '{foreach from=$constituentList.constituent_others item="constituent_other"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_CATA_LOOP-->', '{foreach from=$cataList.catas item="cata"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_CERTIFICATE_LOOP-->', '{foreach from=$certificateList.certificates item="certificate"}', $pdfTemplate->body_html
                );

                $pdfTemplate->body_html = str_replace(
                        array(
                    "<!--END_PRODUCT_LOOP-->",
                    "<!--END_PRODUCT1_LOOP-->",
                    "<!--END_PRODUCT2_LOOP-->",
                    "<!--END_PRODUCT3_LOOP-->",
                    "<!--END_PRODUCT4_LOOP-->",
                    "<!--END_PRODUCT5_LOOP-->",
                    "<!--END_CATA_LOOP-->", // CHOOSE ALL THAT APPLY
                    "<!--END_CERTIFICATE_LOOP-->", // Certificates
                        ), '{/foreach}', $pdfTemplate->body_html
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
                $fields_module[$name] = implode(', ', $multienums_value);
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
            // ++ code added for multi checkboxes.
            if (isset($module_instance->field_defs[$name]['type']) &&
                    $module_instance->field_defs[$name]['type'] == 'radioenum' &&
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
                $fields_module[$name] = implode(', ', $multienums_value);
                $fields_module[$name] = str_replace(array('&#39;', '&#039;'), "'", $fields_module[$name]);
            }
            if (isset($module_instance->field_defs[$name]['type']) &&
                    ($module_instance->field_defs[$name]['type'] == 'enum' || $module_instance->field_defs[$name]['type'] == 'radio' || $module_instance->field_defs[$name]['type'] == 'radioenum') &&
                    isset($module_instance->field_defs[$name]['options']) &&
                    isset($app_list_strings[$module_instance->field_defs[$name]['options']]) &&
                    isset($app_list_strings[$module_instance->field_defs[$name]['options']][$value]) &&
                    ($name == 'associated_source_code_c' || $name == 'associated_form_code_c')
            ) {
                $fields_module[$name] = str_replace(array('&#39;', '&#039;'), "'", $value);
            }
            if (isset($module_instance->field_defs[$name]['type']) &&
                    $module_instance->field_defs[$name]['type'] == 'multienum' &&
                    isset($module_instance->field_defs[$name]['options']) &&
                    isset($app_list_strings[$module_instance->field_defs[$name]['options']]) &&
                    ($name == 'notes_any_state_code_apply_c')
            ) {
                $multienums = unencodeMultienum($value);
                $multienums_value = array();
                foreach ($multienums as $multienum) {
                    $multienums_value[] = $multienum;
                }
                $fields_module[$name] = implode(', ', $multienums_value);
                $fields_module[$name] = str_replace(array('&#39;', '&#039;'), "'", $fields_module[$name]);
            }
        }

        return $fields_module;
    }

    /**
     * Process opening tags.
     * @param array $dom html dom array
     * @param int $key current element id
     * @param boolean $cell if true add the default cMargin space to each new line (default false).
     * @access protected
     */
    protected function openHTMLTagHandler(&$dom, $key, $cell = false) {
        $tag = $dom[$key];
        $parent = $dom[($dom[$key]['parent'])];
        $firstorlast = ($key == 1);
        // check for text direction attribute
        if (isset($tag['attribute']['dir'])) {
            $this->tmprtl = $tag['attribute']['dir'] == 'rtl' ? 'R' : 'L';
        } else {
            $this->tmprtl = false;
        }
        //Opening tag
        switch ($tag['value']) {
            case 'table': {
                    $cp = 0;
                    $cs = 0;
                    $dom[$key]['rowspans'] = array();
                    if (!$this->empty_string($dom[$key]['thead'])) {
                        // set table header
                        $this->thead = $dom[$key]['thead'];
                    }
                    if (isset($tag['attribute']['cellpadding'])) {
                        $cp = $this->getHTMLUnitToUnits($tag['attribute']['cellpadding'], 1, 'px');
                        $this->oldcMargin = $this->cMargin;
                        $this->cMargin = $cp;
                    }
                    if (isset($tag['attribute']['cellspacing'])) {
                        $cs = $this->getHTMLUnitToUnits($tag['attribute']['cellspacing'], 1, 'px');
                    }
                    $this->checkPageBreak((2 * $cp) + (2 * $cs) + $this->lasth);
                    break;
                }
            case 'tr': {
                    // array of columns positions
                    $dom[$key]['cellpos'] = array();
                    break;
                }
            case 'hr': {
                    $this->addHTMLVertSpace(1, $cell, '', $firstorlast, $tag['value'], false);
                    $this->htmlvspace = 0;
                    $wtmp = $this->w - $this->lMargin - $this->rMargin;
                    if ((isset($tag['attribute']['width'])) AND ( $tag['attribute']['width'] != '')) {
                        $hrWidth = $this->getHTMLUnitToUnits($tag['attribute']['width'], $wtmp, 'px');
                    } else {
                        $hrWidth = $wtmp;
                    }
                    $x = $this->GetX();
                    $y = $this->GetY();
                    $prevlinewidth = $this->GetLineWidth();
                    $this->Line($x, $y, $x + $hrWidth, $y);
                    $this->SetLineWidth($prevlinewidth);
                    $this->addHTMLVertSpace(1, $cell, '', !isset($dom[($key + 1)]), $tag['value'], false);
                    break;
                }
            case 'a': {
                    if (array_key_exists('href', $tag['attribute'])) {
                        $this->HREF['url'] = $tag['attribute']['href'];
                    }
                    $this->HREF['color'] = $this->htmlLinkColorArray;
                    $this->HREF['style'] = $this->htmlLinkFontStyle;
                    if (array_key_exists('style', $tag['attribute'])) {
                        // get style attributes
                        preg_match_all('/([^;:\s]*):([^;]*)/', $tag['attribute']['style'], $style_array, PREG_PATTERN_ORDER);
                        $astyle = array();
                        while (list($id, $name) = each($style_array[1])) {
                            $name = strtolower($name);
                            $astyle[$name] = trim($style_array[2][$id]);
                        }
                        if (isset($astyle['color'])) {
                            $this->HREF['color'] = $this->convertHTMLColorToDec($astyle['color']);
                        }
                        if (isset($astyle['text-decoration'])) {
                            $this->HREF['style'] = '';
                            $decors = explode(' ', strtolower($astyle['text-decoration']));
                            foreach ($decors as $dec) {
                                $dec = trim($dec);
                                if (!$this->empty_string($dec)) {
                                    if ($dec{0} == 'u') {
                                        $this->HREF['style'] .= 'U';
                                    } elseif ($dec{0} == 'l') {
                                        $this->HREF['style'] .= 'D';
                                    }
                                }
                            }
                        }
                    }
                    break;
                }
            case 'img': {
                    if (isset($tag['attribute']['src'])) {
                        // replace relative path with real server path
                        if ($tag['attribute']['src'][0] == '/') {
                            $tag['attribute']['src'] = $_SERVER['DOCUMENT_ROOT'] . $tag['attribute']['src'];
                        }
                        $tag['attribute']['src'] = urldecode($tag['attribute']['src']);
                        $tag['attribute']['src'] = str_replace(K_PATH_URL, K_PATH_MAIN, $tag['attribute']['src']);
                        if (!isset($tag['attribute']['width'])) {
                            $tag['attribute']['width'] = 0;
                        }
                        if (!isset($tag['attribute']['height'])) {
                            $tag['attribute']['height'] = 0;
                        }
                        //if (!isset($tag['attribute']['align'])) {
                        // the only alignment supported is "bottom"
                        // further development is required for other modes.
                        $tag['attribute']['align'] = 'bottom';
                        //}
                        switch ($tag['attribute']['align']) {
                            case 'top': {
                                    $align = 'T';
                                    break;
                                }
                            case 'middle': {
                                    $align = 'M';
                                    break;
                                }
                            case 'bottom': {
                                    $align = 'B';
                                    break;
                                }
                            default: {
                                    $align = 'B';
                                    break;
                                }
                        }
                        $fileinfo = pathinfo($tag['attribute']['src']);
                        if (isset($fileinfo['extension']) AND ( !$this->empty_string($fileinfo['extension']))) {
                            $type = strtolower($fileinfo['extension']);
                        }
                        $prevy = $this->y;
                        $xpos = $this->GetX();
                        if (isset($dom[($key - 1)]) AND ( $dom[($key - 1)]['value'] == ' ')) {
                            if ($this->rtl) {
                                $xpos += $this->GetStringWidth(' ');
                            } else {
                                $xpos -= $this->GetStringWidth(' ');
                            }
                        }
                        $imglink = '';
                        if (isset($this->HREF['url']) AND ! $this->empty_string($this->HREF['url'])) {
                            $imglink = $this->HREF['url'];
                            if ($imglink{0} == '#') {
                                // convert url to internal link
                                $page = intval(substr($imglink, 1));
                                $imglink = $this->AddLink();
                                $this->SetLink($imglink, 0, $page);
                            }
                        }
                        $border = 0;
                        if (isset($tag['attribute']['border']) AND ! empty($tag['attribute']['border'])) {
                            // currently only support 1 (frame) or a combination of 'LTRB'
                            $border = $tag['attribute']['border'];
                        }
                        $iw = '';
                        if (isset($tag['attribute']['width'])) {
                            $iw = $this->getHTMLUnitToUnits($tag['attribute']['width'], 1, 'px', false);
                        }
                        $ih = '';
                        if (isset($tag['attribute']['height'])) {
                            $ih = $this->getHTMLUnitToUnits($tag['attribute']['height'], 1, 'px', false);
                        }
                        if (($type == 'eps') OR ( $type == 'ai')) {
                            $this->ImageEps($tag['attribute']['src'], $xpos, $this->GetY(), $iw, $ih, $imglink, true, $align, '', $border);
                        } else {
                            $this->Image($tag['attribute']['src'], $xpos, $this->GetY(), $iw, $ih, '', $imglink, $align, false, 300, '', false, false, $border);
                        }
                        switch ($align) {
                            case 'T': {
                                    $this->y = $prevy;
                                    break;
                                }
                            case 'M': {
                                    $this->y = (($this->img_rb_y + $prevy - ($tag['fontsize'] / $this->k)) / 2);
                                    break;
                                }
                            case 'B': {
                                    $this->y = $this->img_rb_y - ($tag['fontsize'] / $this->k);
                                    break;
                                }
                        }
                    }
                    break;
                }
            case 'dl': {
                    ++$this->listnum;
                    $this->addHTMLVertSpace(0, $cell, '', $firstorlast, $tag['value'], false);
                    break;
                }
            case 'dt': {
                    $this->addHTMLVertSpace(1, $cell, '', $firstorlast, $tag['value'], false);
                    break;
                }
            case 'dd': {
                    if ($this->rtl) {
                        $this->rMargin += $this->listindent;
                    } else {
                        $this->lMargin += $this->listindent;
                    }
                    $this->addHTMLVertSpace(1, $cell, '', $firstorlast, $tag['value'], false);
                    break;
                }
            case 'ul':
            case 'ol': {
                    $this->addHTMLVertSpace(0, $cell, '', $firstorlast, $tag['value'], false);
                    $this->htmlvspace = 0;
                    ++$this->listnum;
                    if ($tag['value'] == 'ol') {
                        $this->listordered[$this->listnum] = true;
                    } else {
                        $this->listordered[$this->listnum] = false;
                    }
                    if (isset($tag['attribute']['start'])) {
                        $this->listcount[$this->listnum] = intval($tag['attribute']['start']) - 1;
                    } else {
                        $this->listcount[$this->listnum] = 0;
                    }
                    if ($this->rtl) {
                        $this->rMargin += $this->listindent;
                    } else {
                        $this->lMargin += $this->listindent;
                    }
                    $this->addHTMLVertSpace(0, $cell, '', $firstorlast, $tag['value'], false);
                    $this->htmlvspace = 0;
                    break;
                }
            case 'li': {
                    $this->addHTMLVertSpace(1, $cell, '', $firstorlast, $tag['value'], false);
                    if ($this->listordered[$this->listnum]) {
                        // ordered item
                        if (isset($parent['attribute']['type']) AND ! $this->empty_string($parent['attribute']['type'])) {
                            $this->lispacer = $parent['attribute']['type'];
                        } elseif (isset($parent['listtype']) AND ! $this->empty_string($parent['listtype'])) {
                            $this->lispacer = $parent['listtype'];
                        } elseif (isset($this->lisymbol) AND ! $this->empty_string($this->lisymbol)) {
                            $this->lispacer = $this->lisymbol;
                        } else {
                            $this->lispacer = '#';
                        }
                        ++$this->listcount[$this->listnum];
                        if (isset($tag['attribute']['value'])) {
                            $this->listcount[$this->listnum] = intval($tag['attribute']['value']);
                        }
                    } else {
                        // unordered item
                        if (isset($parent['attribute']['type']) AND ! $this->empty_string($parent['attribute']['type'])) {
                            $this->lispacer = $parent['attribute']['type'];
                        } elseif (isset($parent['listtype']) AND ! $this->empty_string($parent['listtype'])) {
                            $this->lispacer = $parent['listtype'];
                        } elseif (isset($this->lisymbol) AND ! $this->empty_string($this->lisymbol)) {
                            $this->lispacer = $this->lisymbol;
                        } else {
                            $this->lispacer = '!';
                        }
                    }
                    break;
                }
            case 'blockquote': {
                    if ($this->rtl) {
                        $this->rMargin += $this->listindent;
                    } else {
                        $this->lMargin += $this->listindent;
                    }
                    $this->addHTMLVertSpace(2, $cell, '', $firstorlast, $tag['value'], false);
                    break;
                }
            case 'br': {
                    $this->Ln('', $cell);
                    break;
                }
            case 'div': {
                    // ++
                    if (isset($tag['attribute']['id']) && $tag['attribute']['id'] == 'dotted-line') {
                        $this->addHTMLVertSpace(0, $cell, '', $firstorlast, $tag['value'], false);
                        $this->htmlvspace = 0;
                        $wtmp = $this->w - $this->lMargin - $this->rMargin;
                        if ((isset($tag['attribute']['width'])) AND ( $tag['attribute']['width'] != '')) {
                            $hrWidth = $this->getHTMLUnitToUnits($tag['attribute']['width'], $wtmp, 'px');
                        } else {
                            $hrWidth = $wtmp;
                        }
                        $x = $this->GetX();
                        $y = $this->GetY() - 1;
                        $prevlinewidth = $this->GetLineWidth();
                        $this->Line($x, $y, $x + $hrWidth, $y, array('dash' => '3,1', 'color' => '#999'));
                        $this->SetLineWidth($prevlinewidth);
                        $this->addHTMLVertSpace(0, $cell, '', !isset($dom[($key + 1)]), $tag['value'], false);
                        $this->hrLikeDiv = true;
                    } else {
                        $this->addHTMLVertSpace(1, $cell, '', $firstorlast, $tag['value'], false);
                    }
                    break;
                }
            case 'p': {
                    $this->addHTMLVertSpace(2, $cell, '', $firstorlast, $tag['value'], false);
                    break;
                }
            case 'pre': {
                    $this->addHTMLVertSpace(1, $cell, '', $firstorlast, $tag['value'], false);
                    $this->premode = true;
                    break;
                }
            case 'sup': {
                    $this->SetXY($this->GetX(), $this->GetY() - ((0.7 * $this->FontSizePt) / $this->k));
                    break;
                }
            case 'sub': {
                    $this->SetXY($this->GetX(), $this->GetY() + ((0.3 * $this->FontSizePt) / $this->k));
                    break;
                }
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
            case 'h5':
            case 'h6': {
                    $this->addHTMLVertSpace(1, $cell, ($tag['fontsize'] * 1.5) / $this->k, $firstorlast, $tag['value'], false);
                    break;
                }
            case 'tcpdf': {
                    if (defined('K_TCPDF_CALLS_IN_HTML') AND ( K_TCPDF_CALLS_IN_HTML === true)) {
                        // Special tag used to call TCPDF methods
                        if (isset($tag['attribute']['method'])) {
                            $tcpdf_method = $tag['attribute']['method'];
                            if (method_exists($this, $tcpdf_method)) {
                                if (isset($tag['attribute']['params']) AND ( !empty($tag['attribute']['params']))) {
                                    $params = unserialize(urldecode($tag['attribute']['params']));
                                    call_user_func_array(array($this, $tcpdf_method), $params);
                                } else {
                                    $this->$tcpdf_method();
                                }
                                $this->newline = true;
                            }
                        }
                    }
                }
            default: {
                    break;
                }
        }
    }

    /**
     * Process closing tags.
     * @param array $dom html dom array
     * @param int $key current element id
     * @param boolean $cell if true add the default cMargin space to each new line (default false).
     * @access protected
     */
    protected function closeHTMLTagHandler(&$dom, $key, $cell = false) {
        $tag = $dom[$key];
        $parent = $dom[($dom[$key]['parent'])];
        $firstorlast = ((!isset($dom[($key + 1)])) OR ( (!isset($dom[($key + 2)])) AND ( $dom[($key + 1)]['value'] == 'marker')));
        //Closing tag
        switch ($tag['value']) {
            case 'tr': {
                    $table_el = $dom[($dom[$key]['parent'])]['parent'];
                    if (!isset($parent['endy'])) {
                        $dom[($dom[$key]['parent'])]['endy'] = $this->y;
                        $parent['endy'] = $this->y;
                    }
                    if (!isset($parent['endpage'])) {
                        $dom[($dom[$key]['parent'])]['endpage'] = $this->page;
                        $parent['endpage'] = $this->page;
                    }
                    // update row-spanned cells
                    if (isset($dom[$table_el]['rowspans'])) {
                        foreach ($dom[$table_el]['rowspans'] as $k => $trwsp) {
                            $dom[$table_el]['rowspans'][$k]['rowspan'] -= 1;
                            if ($dom[$table_el]['rowspans'][$k]['rowspan'] == 0) {
                                if ($dom[$table_el]['rowspans'][$k]['endpage'] == $parent['endpage']) {
                                    $dom[($dom[$key]['parent'])]['endy'] = max($dom[$table_el]['rowspans'][$k]['endy'], $parent['endy']);
                                } elseif ($dom[$table_el]['rowspans'][$k]['endpage'] > $parent['endpage']) {
                                    $dom[($dom[$key]['parent'])]['endy'] = $dom[$table_el]['rowspans'][$k]['endy'];
                                    $dom[($dom[$key]['parent'])]['endpage'] = $dom[$table_el]['rowspans'][$k]['endpage'];
                                }
                            }
                        }
                        // report new endy and endpage to the rowspanned cells
                        foreach ($dom[$table_el]['rowspans'] as $k => $trwsp) {
                            if ($dom[$table_el]['rowspans'][$k]['rowspan'] == 0) {
                                $dom[$table_el]['rowspans'][$k]['endpage'] = max($dom[$table_el]['rowspans'][$k]['endpage'], $dom[($dom[$key]['parent'])]['endpage']);
                                $dom[($dom[$key]['parent'])]['endpage'] = $dom[$table_el]['rowspans'][$k]['endpage'];
                                $dom[$table_el]['rowspans'][$k]['endy'] = max($dom[$table_el]['rowspans'][$k]['endy'], $dom[($dom[$key]['parent'])]['endy']);
                                $dom[($dom[$key]['parent'])]['endy'] = $dom[$table_el]['rowspans'][$k]['endy'];
                            }
                        }
                        // update remaining rowspanned cells
                        foreach ($dom[$table_el]['rowspans'] as $k => $trwsp) {
                            if ($dom[$table_el]['rowspans'][$k]['rowspan'] == 0) {
                                $dom[$table_el]['rowspans'][$k]['endpage'] = $dom[($dom[$key]['parent'])]['endpage'];
                                $dom[$table_el]['rowspans'][$k]['endy'] = $dom[($dom[$key]['parent'])]['endy'];
                            }
                        }
                    }
                    $this->setPage($dom[($dom[$key]['parent'])]['endpage']);
                    $this->y = $dom[($dom[$key]['parent'])]['endy'];
                    if (isset($dom[$table_el]['attribute']['cellspacing'])) {
                        $cellspacing = $this->getHTMLUnitToUnits($dom[$table_el]['attribute']['cellspacing'], 1, 'px');
                        $this->y += $cellspacing;
                    }
                    $this->Ln(0, $cell);
                    $this->x = $parent['startx'];
                    // account for booklet mode
                    if ($this->page > $parent['startpage']) {
                        if (($this->rtl) AND ( $this->pagedim[$this->page]['orm'] != $this->pagedim[$parent['startpage']]['orm'])) {
                            $this->x += ($this->pagedim[$this->page]['orm'] - $this->pagedim[$parent['startpage']]['orm']);
                        } elseif ((!$this->rtl) AND ( $this->pagedim[$this->page]['olm'] != $this->pagedim[$parent['startpage']]['olm'])) {
                            $this->x += ($this->pagedim[$this->page]['olm'] - $this->pagedim[$parent['startpage']]['olm']);
                        }
                    }
                    break;
                }
            case 'table': {
                    // draw borders
                    $table_el = $parent;
                    if ((isset($table_el['attribute']['border']) AND ( $table_el['attribute']['border'] > 0))
                            OR ( isset($table_el['style']['border']) AND ( $table_el['style']['border'] > 0))) {
                        $border = 1;
                    } else {
                        $border = 0;
                    }
                    // fix bottom line alignment of last line before page break
                    foreach ($dom[($dom[$key]['parent'])]['trids'] as $j => $trkey) {
                        // update row-spanned cells
                        if (isset($dom[($dom[$key]['parent'])]['rowspans'])) {
                            foreach ($dom[($dom[$key]['parent'])]['rowspans'] as $k => $trwsp) {
                                if ($trwsp['trid'] == $trkey) {
                                    $dom[($dom[$key]['parent'])]['rowspans'][$k]['mrowspan'] -= 1;
                                }
                                if (isset($prevtrkey) AND ( $trwsp['trid'] == $prevtrkey) AND ( $trwsp['mrowspan'] >= 0)) {
                                    $dom[($dom[$key]['parent'])]['rowspans'][$k]['trid'] = $trkey;
                                }
                            }
                        }
                        if (isset($prevtrkey) AND ( $dom[$trkey]['startpage'] > $dom[$prevtrkey]['endpage'])) {
                            $pgendy = $this->pagedim[$dom[$prevtrkey]['endpage']]['hk'] - $this->pagedim[$dom[$prevtrkey]['endpage']]['bm'];
                            $dom[$prevtrkey]['endy'] = $pgendy;
                            // update row-spanned cells
                            if (isset($dom[($dom[$key]['parent'])]['rowspans'])) {
                                foreach ($dom[($dom[$key]['parent'])]['rowspans'] as $k => $trwsp) {
                                    if (($trwsp['trid'] == $trkey) AND ( $trwsp['mrowspan'] == 1) AND ( $trwsp['endpage'] == $dom[$prevtrkey]['endpage'])) {
                                        $dom[($dom[$key]['parent'])]['rowspans'][$k]['endy'] = $pgendy;
                                        $dom[($dom[$key]['parent'])]['rowspans'][$k]['mrowspan'] = -1;
                                    }
                                }
                            }
                        }
                        $prevtrkey = $trkey;
                        $table_el = $dom[($dom[$key]['parent'])];
                    }
                    // for each row
                    foreach ($table_el['trids'] as $j => $trkey) {
                        $parent = $dom[$trkey];
                        // for each cell on the row
                        foreach ($parent['cellpos'] as $k => $cellpos) {
                            if (isset($cellpos['rowspanid']) AND ( $cellpos['rowspanid'] >= 0)) {
                                $cellpos['startx'] = $table_el['rowspans'][($cellpos['rowspanid'])]['startx'];
                                $cellpos['endx'] = $table_el['rowspans'][($cellpos['rowspanid'])]['endx'];
                                $endy = $table_el['rowspans'][($cellpos['rowspanid'])]['endy'];
                                $startpage = $table_el['rowspans'][($cellpos['rowspanid'])]['startpage'];
                                $endpage = $table_el['rowspans'][($cellpos['rowspanid'])]['endpage'];
                            } else {
                                $endy = $parent['endy'];
                                $startpage = $parent['startpage'];
                                $endpage = $parent['endpage'];
                            }
                            if ($endpage > $startpage) {
                                // design borders around HTML cells.
                                for ($page = $startpage; $page <= $endpage; ++$page) {
                                    $this->setPage($page);
                                    if ($page == $startpage) {
                                        $this->y = $parent['starty']; // put cursor at the beginning of row on the first page
                                        $ch = $this->getPageHeight() - $parent['starty'] - $this->getBreakMargin();
                                        $cborder = $this->getBorderMode($border, $position = 'start');
                                    } elseif ($page == $endpage) {
                                        $this->y = $this->tMargin; // put cursor at the beginning of last page
                                        $ch = $endy - $this->tMargin;
                                        $cborder = $this->getBorderMode($border, $position = 'end');
                                    } else {
                                        $this->y = $this->tMargin; // put cursor at the beginning of the current page
                                        $ch = $this->getPageHeight() - $this->tMargin - $this->getBreakMargin();
                                        $cborder = $this->getBorderMode($border, $position = 'middle');
                                    }
                                    if (isset($cellpos['bgcolor']) AND ( $cellpos['bgcolor']) !== false) {
                                        $this->SetFillColorArray($cellpos['bgcolor']);
                                        $fill = true;
                                    } else {
                                        $fill = false;
                                    }
                                    $cw = abs($cellpos['endx'] - $cellpos['startx']);
                                    $this->x = $cellpos['startx'];
                                    // account for margin changes
                                    if ($page > $startpage) {
                                        if (($this->rtl) AND ( $this->pagedim[$page]['orm'] != $this->pagedim[$startpage]['orm'])) {
                                            $this->x -= ($this->pagedim[$page]['orm'] - $this->pagedim[$startpage]['orm']);
                                        } elseif ((!$this->rtl) AND ( $this->pagedim[$page]['lm'] != $this->pagedim[$startpage]['olm'])) {
                                            $this->x += ($this->pagedim[$page]['olm'] - $this->pagedim[$startpage]['olm']);
                                        }
                                    }
                                    // design a cell around the text
                                    $ccode = $this->FillColor . "\n" . $this->getCellCode($cw, $ch, '', $cborder, 1, '', $fill, '', 0, true);
                                    if ($cborder OR $fill) {
                                        $pagebuff = $this->getPageBuffer($this->page);
                                        $pstart = substr($pagebuff, 0, $this->intmrk[$this->page]);
                                        $pend = substr($pagebuff, $this->intmrk[$this->page]);
                                        $this->setPageBuffer($this->page, $pstart . $ccode . "\n" . $pend);
                                        $this->intmrk[$this->page] += strlen($ccode . "\n");
                                    }
                                }
                            } else {
                                $this->setPage($startpage);
                                if (isset($cellpos['bgcolor']) AND ( $cellpos['bgcolor']) !== false) {
                                    $this->SetFillColorArray($cellpos['bgcolor']);
                                    $fill = true;
                                } else {
                                    $fill = false;
                                }
                                $this->x = $cellpos['startx'];
                                $this->y = $parent['starty'];
                                $cw = abs($cellpos['endx'] - $cellpos['startx']);
                                $ch = $endy - $parent['starty'];
                                // design a cell around the text
                                $ccode = $this->FillColor . "\n" . $this->getCellCode($cw, $ch, '', $border, 1, '', $fill, '', 0, true);
                                if ($border OR $fill) {
                                    if (end($this->transfmrk[$this->page]) !== false) {
                                        $pagemarkkey = key($this->transfmrk[$this->page]);
                                        $pagemark = &$this->transfmrk[$this->page][$pagemarkkey];
                                    } elseif ($this->InFooter) {
                                        $pagemark = &$this->footerpos[$this->page];
                                    } else {
                                        $pagemark = &$this->intmrk[$this->page];
                                    }
                                    $pagebuff = $this->getPageBuffer($this->page);
                                    $pstart = substr($pagebuff, 0, $pagemark);
                                    $pend = substr($pagebuff, $pagemark);
                                    $this->setPageBuffer($this->page, $pstart . $ccode . "\n" . $pend);
                                    $pagemark += strlen($ccode . "\n");
                                }
                            }
                        }
                        if (isset($table_el['attribute']['cellspacing'])) {
                            $cellspacing = $this->getHTMLUnitToUnits($table_el['attribute']['cellspacing'], 1, 'px');
                            $this->y += $cellspacing;
                        }
                        $this->Ln(0, $cell);
                        $this->x = $parent['startx'];
                        if ($endpage > $startpage) {
                            if (($this->rtl) AND ( $this->pagedim[$endpage]['orm'] != $this->pagedim[$startpage]['orm'])) {
                                $this->x += ($this->pagedim[$endpage]['orm'] - $this->pagedim[$startpage]['orm']);
                            } elseif ((!$this->rtl) AND ( $this->pagedim[$endpage]['olm'] != $this->pagedim[$startpage]['olm'])) {
                                $this->x += ($this->pagedim[$endpage]['olm'] - $this->pagedim[$startpage]['olm']);
                            }
                        }
                    }
                    if (isset($parent['cellpadding'])) {
                        $this->cMargin = $this->oldcMargin;
                    }
                    $this->lasth = $this->FontSize * $this->cell_height_ratio;
                    if (!$this->empty_string($this->theadMargin)) {
                        // restore top margin
                        $this->tMargin = $this->theadMargin;
                        $this->pagedim[$this->page]['tm'] = $this->theadMargin;
                    }
                    // reset table header
                    $this->thead = '';
                    $this->theadMargin = '';
                    break;
                }
            case 'a': {
                    $this->HREF = '';
                    break;
                }
            case 'sup': {
                    $this->SetXY($this->GetX(), $this->GetY() + ((0.7 * $parent['fontsize']) / $this->k));
                    break;
                }
            case 'sub': {
                    $this->SetXY($this->GetX(), $this->GetY() - ((0.3 * $parent['fontsize']) / $this->k));
                    break;
                }
            case 'div': {
                    if ($this->hrLikeDiv) {
                        $this->hrLikeDiv = false;
                    } else {
                        $this->addHTMLVertSpace(1, $cell, '', $firstorlast, $tag['value'], true);
                    }
                    break;
                }
            case 'blockquote': {
                    if ($this->rtl) {
                        $this->rMargin -= $this->listindent;
                    } else {
                        $this->lMargin -= $this->listindent;
                    }
                    $this->addHTMLVertSpace(2, $cell, '', $firstorlast, $tag['value'], true);
                    break;
                }
            case 'p': {
                    $this->addHTMLVertSpace(2, $cell, '', $firstorlast, $tag['value'], true);
                    break;
                }
            case 'pre': {
                    $this->addHTMLVertSpace(1, $cell, '', $firstorlast, $tag['value'], true);
                    $this->premode = false;
                    break;
                }
            case 'dl': {
                    --$this->listnum;
                    if ($this->listnum <= 0) {
                        $this->listnum = 0;
                        $this->addHTMLVertSpace(2, $cell, '', $firstorlast, $tag['value'], true);
                    }
                    break;
                }
            case 'dt': {
                    $this->lispacer = '';
                    $this->addHTMLVertSpace(0, $cell, '', $firstorlast, $tag['value'], true);
                    break;
                }
            case 'dd': {
                    $this->lispacer = '';
                    if ($this->rtl) {
                        $this->rMargin -= $this->listindent;
                    } else {
                        $this->lMargin -= $this->listindent;
                    }
                    $this->addHTMLVertSpace(0, $cell, '', $firstorlast, $tag['value'], true);
                    break;
                }
            case 'ul':
            case 'ol': {
                    --$this->listnum;
                    $this->lispacer = '';
                    if ($this->rtl) {
                        $this->rMargin -= $this->listindent;
                    } else {
                        $this->lMargin -= $this->listindent;
                    }
                    if ($this->listnum <= 0) {
                        $this->listnum = 0;
                        $this->addHTMLVertSpace(2, $cell, '', $firstorlast, $tag['value'], true);
                    }
                    $this->lasth = $this->FontSize * $this->cell_height_ratio;
                    break;
                }
            case 'li': {
                    $this->lispacer = '';
                    $this->addHTMLVertSpace(0, $cell, '', $firstorlast, $tag['value'], true);
                    break;
                }
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
            case 'h5':
            case 'h6': {
                    $this->addHTMLVertSpace(1, $cell, ($parent['fontsize'] * 1.5) / $this->k, $firstorlast, $tag['value'], true);
                    break;
                }
            default : {
                    break;
                }
        }
        $this->tmprtl = false;
    }

    /**
     * This method allows printing text with line breaks.
     * They can be automatic (as soon as the text reaches the right border of the cell) or explicit (via the \n character). As many cells as necessary are output, one below the other.<br />
     * Text can be aligned, centered or justified. The cell block can be framed and the background painted.
     * @param float $w Width of cells. If 0, they extend up to the right margin of the page.
     * @param float $h Cell minimum height. The cell extends automatically if needed.
     * @param string $txt String to print
     * @param mixed $border Indicates if borders must be drawn around the cell block. The value can be either a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul>or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul>
     * @param string $align Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align</li><li>C: center</li><li>R: right align</li><li>J: justification (default value when $ishtml=false)</li></ul>
     * @param int $fill Indicates if the cell background must be painted (1) or transparent (0). Default value: 0.
     * @param int $ln Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right</li><li>1: to the beginning of the next line [DEFAULT]</li><li>2: below</li></ul>
     * @param int $x x position in user units
     * @param int $y y position in user units
     * @param boolean $reseth if true reset the last cell height (default true).
     * @param int $stretch stretch carachter mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if necessary</li><li>2 = forced horizontal scaling</li><li>3 = character spacing only if necessary</li><li>4 = forced character spacing</li></ul>
     * @param boolean $ishtml set to true if $txt is HTML content (default = false).
     * @param boolean $autopadding if true, uses internal padding and automatically adjust it to account for line width.
     * @param float $maxh maximum height. It should be >= $h and less then remaining space to the bottom of the page, or 0 for disable this feature. This feature works only when $ishtml=false.
     * @return int Return the number of cells or 1 for html mode.
     * @access public
     * @since 1.3
     * @see SetFont(), SetDrawColor(), SetFillColor(), SetTextColor(), SetLineWidth(), Cell(), Write(), SetAutoPageBreak()
     */
    public function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = 0, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $addpage = true) {
        if ($this->empty_string($this->lasth) OR $reseth) {
            //set row height
            $this->lasth = $this->FontSize * $this->cell_height_ratio;
        }
        if (!$this->empty_string($y)) {
            $this->SetY($y);
        } else {
            $y = $this->GetY();
        }
        // should not add page for each cell
        if ($addpage) {
            // check for page break
            $this->checkPageBreak($h);
        }
        $y = $this->GetY();
        // get current page number
        $startpage = $this->page;
        if (!$this->empty_string($x)) {
            $this->SetX($x);
        } else {
            $x = $this->GetX();
        }
        if ($this->empty_string($w) OR ( $w <= 0)) {
            if ($this->rtl) {
                $w = $this->x - $this->lMargin;
            } else {
                $w = $this->w - $this->rMargin - $this->x;
            }
        }
        // store original margin values
        $lMargin = $this->lMargin;
        $rMargin = $this->rMargin;
        if ($this->rtl) {
            $this->SetRightMargin($this->w - $this->x);
            $this->SetLeftMargin($this->x - $w);
        } else {
            $this->SetLeftMargin($this->x);
            $this->SetRightMargin($this->w - $this->x - $w);
        }
        $starty = $this->y;
        if ($autopadding) {
            // Adjust internal padding
            if ($this->cMargin < ($this->LineWidth / 2)) {
                $this->cMargin = ($this->LineWidth / 2);
            }
            // Add top space if needed
            if (($this->lasth - $this->FontSize) < $this->LineWidth) {
                $this->y += $this->LineWidth / 2;
            }
            // add top padding
            $this->y += $this->cMargin;
        }
        if ($ishtml) {
            // ******* Write HTML text
            $this->writeHTML($txt, true, 0, $reseth, true, $align);
            $nl = 1;
        } else {
            // ******* Write text
            $nl = $this->Write($this->lasth, $txt, '', 0, $align, true, $stretch, false, false, $maxh);
        }
        // ++
        if (strpos($txt, 'dotted-line') !== false) {
            $this->y -= 3;
        }
        if ($autopadding) {
            // add bottom padding
            $this->y += $this->cMargin;
            // Add bottom space if needed
            if (($this->lasth - $this->FontSize) < $this->LineWidth) {
                $this->y += $this->LineWidth / 2;
            }
        }
        // Get end-of-text Y position
        $currentY = $this->y;
        // get latest page number
        $endpage = $this->page;
        // check if a new page has been created
        if ($endpage > $startpage) {
            // design borders around HTML cells.
            for ($page = $startpage; $page <= $endpage; ++$page) {
                $this->setPage($page);
                if ($page == $startpage) {
                    $this->y = $starty; // put cursor at the beginning of cell on the first page
                    $h = $this->getPageHeight() - $starty - $this->getBreakMargin();
                    $cborder = $this->getBorderMode($border, $position = 'start');
                } elseif ($page == $endpage) {
                    $this->y = $this->tMargin; // put cursor at the beginning of last page
                    $h = $currentY - $this->tMargin;
                    $cborder = $this->getBorderMode($border, $position = 'end');
                } else {
                    $this->y = $this->tMargin; // put cursor at the beginning of the current page
                    $h = $this->getPageHeight() - $this->tMargin - $this->getBreakMargin();
                    $cborder = $this->getBorderMode($border, $position = 'middle');
                }
                $nx = $x;
                // account for margin changes
                if ($page > $startpage) {
                    if (($this->rtl) AND ( $this->pagedim[$page]['orm'] != $this->pagedim[$startpage]['orm'])) {
                        $nx = $x + ($this->pagedim[$page]['orm'] - $this->pagedim[$startpage]['orm']);
                    } elseif ((!$this->rtl) AND ( $this->pagedim[$page]['olm'] != $this->pagedim[$startpage]['olm'])) {
                        $nx = $x + ($this->pagedim[$page]['olm'] - $this->pagedim[$startpage]['olm']);
                    }
                }
                $this->SetX($nx);
                $ccode = $this->getCellCode($w, $h, '', $cborder, 1, '', $fill, '', 0, false);
                if ($cborder OR $fill) {
                    $pagebuff = $this->getPageBuffer($this->page);
                    $pstart = substr($pagebuff, 0, $this->intmrk[$this->page]);
                    $pend = substr($pagebuff, $this->intmrk[$this->page]);
                    $this->setPageBuffer($this->page, $pstart . $ccode . "\n" . $pend);
                    $this->intmrk[$this->page] += strlen($ccode . "\n");
                }
            }
        } else {
            $h = max($h, ($currentY - $y));
            // put cursor at the beginning of text
            $this->SetY($y);
            $this->SetX($x);
            // design a cell around the text
            $ccode = $this->getCellCode($w, $h, '', $border, 1, '', $fill, '', 0, true);
            if ($border OR $fill) {
                if (end($this->transfmrk[$this->page]) !== false) {
                    $pagemarkkey = key($this->transfmrk[$this->page]);
                    $pagemark = &$this->transfmrk[$this->page][$pagemarkkey];
                } elseif ($this->InFooter) {
                    $pagemark = &$this->footerpos[$this->page];
                } else {
                    $pagemark = &$this->intmrk[$this->page];
                }
                $pagebuff = $this->getPageBuffer($this->page);
                $pstart = substr($pagebuff, 0, $pagemark);
                $pend = substr($pagebuff, $pagemark);
                $this->setPageBuffer($this->page, $pstart . $ccode . "\n" . $pend);
                $pagemark += strlen($ccode . "\n");
            }
        }
        // Get end-of-cell Y position
        $currentY = $this->GetY();
        // restore original margin values
        $this->SetLeftMargin($lMargin);
        $this->SetRightMargin($rMargin);
        if ($ln > 0) {
            //Go to the beginning of the next line
            $this->SetY($currentY);
            if ($ln == 2) {
                $this->SetX($x + $w);
            }
        } else {
            // go left or right by case
            $this->setPage($startpage);
            $this->y = $y;
            $this->SetX($x + $w);
        }
        return $nl;
    }

    /**
     * PDF manager specific Header function
     */
    public function Header() {
        $fields = self::parseBeanFields($this->bean, true);
        $ormargins = $this->getOriginalMargins();
        $headerfont = $this->getHeaderFont();
        $headerdata = $this->getHeaderData();
        $marginTop = 4;

        if ($headerdata['logo'] && $headerdata['logo'] != K_BLANK_IMAGE) {
            $this->Image($headerdata['logo'], $this->GetX() + $marginTop, $this->getHeaderMargin() + 5, $headerdata['logo_width'], $headerdata['logo_width']);
            $imgy = $this->getImageRBY();
        } else {
            $imgy = $this->GetY();
        }
        $cell_height = round(($this->getCellHeightRatio() * $headerfont[2]) / $this->getScaleFactor(), 2);
        // set starting margin for text data cell
        if ($this->getRTL()) {
            $header_x = $ormargins['right'] + ($headerdata['logo_width'] * 1.1);
        } else {
            $header_x = $ormargins['left'] + ($headerdata['logo_width'] * 1.1);
        }
        $this->SetTextColor(0, 0, 0);
        // header title
        $this->SetFont($headerfont[0], 'B', $headerfont[2] + 6);
        $headerLine = $this->GetY() + $marginTop;
        $this->MultiCell(0, $cell_height, "WASTE PROFILE SHEET", 0, '', 0, 1, 67, $headerLine, true, 0, false);
        // header string
        $this->SetFont($headerfont[0], $headerfont[1], $headerfont[2] + 1);
        $this->SetX($header_x);
        $infoCorner = "
   Profile No:   {$fields['waste_profile_num_c']}
     Revision:   1
Submission:   {$fields['submission_type_c']}";
        $infoCornerXPosition = 149;
        $this->MultiCell(0, 0, $infoCorner, 0, '', 0, 1, $infoCornerXPosition, $headerLine, true, 0, false);
        $infoCorner = "       Page(s)   {{pnb}} of ";
        $pageNumberYAxis = $this->GetY();
        $this->MultiCell(0, 0, $infoCorner, 0, '', 0, 1, $infoCornerXPosition, $pageNumberYAxis, true, 0, false);
        $this->MultiCell(0, 0, "{{nb}}", 0, '', 0, 1, $infoCornerXPosition + 29, $pageNumberYAxis, true, 0, false);
    }

}
