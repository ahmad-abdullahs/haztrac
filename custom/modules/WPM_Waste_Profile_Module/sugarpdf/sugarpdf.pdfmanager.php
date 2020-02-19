<?php

require_once('custom/include/Sugarpdf/sugarpdf/sugarpdf.pdfmanager.php');

class WPM_Waste_Profile_ModuleSugarpdfPdfmanager extends SugarpdfPdfmanager {

    public $hrLikeDiv = false;
    public $logoSize = 20;

    public function preDisplay() {
        $retData = parent::preDisplay();
        $bundles = $retData['bundles'];
        $fields = $retData['fields'];

        $previewMode = FALSE;
        if (!empty($_REQUEST['pdf_preview']) && $_REQUEST['pdf_preview'] == 1) {
            $previewMode = true;
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

}
