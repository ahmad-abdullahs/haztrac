<?php

require_once('include/Sugarpdf/sugarpdf/sugarpdf.pdfmanager.php');

class LR_Lab_ReportsSugarpdfPdfmanager extends SugarpdfPdfmanager
{
    public function preDisplay() {
        global $sugar_config;

        parent::preDisplay();

        if (!empty($_REQUEST['pdf_template_id']) && $_REQUEST['pdf_template_id'] == $sugar_config['coc_pdf_template']) {
            $filenameParts = array('COC');
            if (!empty($this->bean) && !empty($this->bean->commodity_c)) {
                $filenameParts[] = $this->bean->commodity_c;
            }
            if (!empty($this->bean->sample_id_number_c)) {
                $filenameParts[] = $this->bean->sample_id_number_c;
            }

            $cr = array(' ',"\r", "\n","/");
            $this->pdfFilename = str_replace($cr, '_', implode("-", $filenameParts ).".pdf");
        }
    }

    protected function buildEmail ($file_name, $focus) {
        global $sugar_config;

        $email_id = parent::buildEmail ($file_name, $focus);

        if (!empty($_REQUEST['pdf_template_id']) && $_REQUEST['pdf_template_id'] == $sugar_config['coc_pdf_template']) {
            $email_object = BeanFactory::retrieveBean("Emails", $email_id);

            $email_object->name = "[Lab Report: {$focus->sample_id_number_c}] {$focus->commodity_c}-{$focus->sample_id_number_c}";

            $email_object->save();
        }

        return $email_id;
    }
}
