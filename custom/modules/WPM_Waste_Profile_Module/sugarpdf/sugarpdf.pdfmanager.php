<?php

require_once('include/Sugarpdf/sugarpdf/sugarpdf.pdfmanager.php');

class WPM_Waste_Profile_ModuleSugarpdfPdfmanager extends SugarpdfPdfmanager {

    protected $pdfFilename;
    protected $footerText = null;

    public function preDisplay() {
        parent::preDisplay();

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
            $fields = PdfManagerHelper::parseBeanFields($this->bean, true);
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

            // Composition
            $this->bean->load_relationship('waste_composition_wpm_waste_profile_module');
            $compositionList = $this->bean->waste_composition_wpm_waste_profile_module->getBeans();
            foreach ($compositionList as $compositionBean) {
                $bundleFields['compositions'][$count] = PdfManagerHelper::parseBeanFields($compositionBean, true);
                $bundleFields['compositions'][$count]['min'] = format_number($compositionBean->min, $locale->getPrecision(), $locale->getPrecision());
                $bundleFields['compositions'][$count]['max'] = format_number($compositionBean->max, $locale->getPrecision(), $locale->getPrecision());
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
                    $count1++;
                } else if ($constituentBean->type == 'Volatile') {
                    $bundleFields['constituent_volatiles'][$count2] = $tempBean;
                    $bundleFields['constituent_volatiles'][$count2]['regulatory_level'] = format_number($constituentBean->regulatory_level, $locale->getPrecision(), $locale->getPrecision());
                    $bundleFields['constituent_volatiles'][$count2]['tclp'] = format_number($constituentBean->tclp, $locale->getPrecision(), $locale->getPrecision());
                    $count2++;
                } else if ($constituentBean->type == 'Other Constituents') {
                    $bundleFields['constituent_others'][$count3] = $tempBean;
                    $bundleFields['constituent_others'][$count3]['max'] = format_number($constituentBean->max, $locale->getPrecision(), $locale->getPrecision());
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

            $compositions[] = $bundleFields;
            $this->ss->assign('waste_composition_wpm_waste_profile_module', $compositions);
            $this->ss->assign('waste_constituents_wpm_waste_profile_module', $compositions);
        }

        $this->ss->assign('fields', $fields);
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
                        '$fields.waste_composition_wpm_waste_profile_module', '$compositionList', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '$fields.compositions', '$composition', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_BUNDLE_LOOP-->', '{foreach from=$waste_composition_wpm_waste_profile_module item="compositionList"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT_LOOP-->', '{foreach from=$compositionList.compositions item="composition"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        array("<!--END_PRODUCT_LOOP-->", "<!--END_BUNDLE_LOOP-->"), '{/foreach}', $pdfTemplate->body_html
                );
                //
                $pdfTemplate->body_html = str_replace(
                        '$fields.waste_constituents_wpm_waste_profile_module', '$constituentList', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '$fields.constituent_regulateds', '$constituent_regulated', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '$fields.constituent_volatiles', '$constituent_volatile', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '$fields.constituent_others', '$constituent_other', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '$fields.constituent_semivolatiles', '$constituent_semivolatile', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '$fields.constituent_pesticide_herbicides', '$constituent_pesticide_herbicide', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_BUNDLE_LOOP-->', '{foreach from=$waste_constituents_wpm_waste_profile_module item="constituentList"}', $pdfTemplate->body_html
                );

                //----------------------

                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT1_LOOP-->', '{foreach from=$constituentList.constituent_regulateds item="constituent_regulated"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT2_LOOP-->', '{foreach from=$constituentList.constituent_volatiles item="constituent_volatile"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT5_LOOP-->', '{foreach from=$constituentList.constituent_others item="constituent_other"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT3_LOOP-->', '{foreach from=$constituentList.constituent_semivolatiles item="constituent_semivolatile"}', $pdfTemplate->body_html
                );
                $pdfTemplate->body_html = str_replace(
                        '<!--START_PRODUCT4_LOOP-->', '{foreach from=$constituentList.constituent_pesticide_herbicides item="constituent_pesticide_herbicide"}', $pdfTemplate->body_html
                );

                //-----------------------

                $pdfTemplate->body_html = str_replace(
                        array("<!--END_PRODUCT1_LOOP-->", "<!--END_PRODUCT2_LOOP-->", "<!--END_PRODUCT3_LOOP-->", "<!--END_PRODUCT4_LOOP-->", "<!--END_PRODUCT5_LOOP-->", "<!--END_BUNDLE_LOOP-->"), '{/foreach}', $pdfTemplate->body_html
                );
            }

            sugar_file_put_contents($tpl_filename, $pdfTemplate->body_html);

            return $tpl_filename;
        }

        return '';
    }

}
