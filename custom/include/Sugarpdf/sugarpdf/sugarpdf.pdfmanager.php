<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

use Sugarcrm\Sugarcrm\Util\Uuid;

class SugarpdfPdfmanager extends SugarpdfSmarty {

    public $hrLikeDiv = false;
    protected $pdfFilename;
    protected $footerText = null;

    public function preDisplay() {
        parent::preDisplay();

//        //set margins
//        // $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//        $this->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
        // settings for disable smarty php tags
        $this->ss->security_settings['PHP_TAGS'] = false;
        $this->ss->security = true;
        if (defined('SUGAR_SHADOW_PATH')) {
            $this->ss->secure_dir[] = SUGAR_SHADOW_PATH;
        }

        // header/footer settings
        $this->setPrintHeader(false);
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

            $this->bean->load_relationship('product_bundles');
            $product_bundle_list = $this->bean->product_bundles->getBeans();
            usort($product_bundle_list, array('ProductBundle', 'compareProductBundlesByIndex'));

            $bundles = array();
            $count = 0;
            foreach ($product_bundle_list as $ordered_bundle) {

                $bundleFields = PdfManagerHelper::parseBeanFields($ordered_bundle, true);
                $bundleFields['products'] = array();
                $product_bundle_line_items = $ordered_bundle->get_product_bundle_line_items();
                foreach ($product_bundle_line_items as $product_bundle_line_item) {

                    $bundleFields['products'][$count] = PdfManagerHelper::parseBeanFields($product_bundle_line_item, true);

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

        // For phone number formatting...
        $phoneFields = array(
            'phone_office' => 'phone_office',
            'phone_fax' => 'phone_fax',
            'phone_alternate' => 'phone_alternate',
        );

        foreach ($fields as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $_key => $_value) {
                    if (array_key_exists($_key, $phoneFields)) {
                        $fields[$key][$_key] = $this->formatPhone($fields[$key][$_key]);
                    }
                }
            } else if (array_key_exists($key, $phoneFields)) {
                $fields[$key] = $this->formatPhone($fields[$key]);
            }
        }

        $this->ss->assign('fields', $fields);
    }

    public function display() {
        parent::display();

        $headerdata = $this->getHeaderData();
        // Remove the temporary logo copy (starts with "upload/") if exists
        if (!empty($headerdata['logo']) && file_exists($headerdata['logo']) && strpos($headerdata['logo'], "upload/") === 0) {
            unlink($headerdata['logo']);
        }
    }

    /**
     * Build the Email with the attachement
     *
     * @param $file_name
     * @param $focus
     * @return $email_id
     */
    protected function buildEmail($file_name, $focus) {

        global $mod_strings;
        global $current_user;

        //First Create e-mail draft
        $email_object = BeanFactory::newBean("Emails");
        // set the id for relationships
        $email_object->id = create_guid();
        $email_object->new_with_id = true;

        //subject
        $email_object->name = $focus->name;
        //body
        $email_object->description_html = sprintf(translate('LBL_EMAIL_PDF_DEFAULT_DESCRIPTION', "PdfManager"), $file_name);
        $email_object->description = html_entity_decode($email_object->description_html, ENT_COMPAT, 'UTF-8');

        //parent type, id
        $email_object->parent_type = $focus->module_name;
        $email_object->parent_id = $focus->id;
        //type is draft
        $email_object->type = "draft";
        $email_object->status = "draft";
        $email_object->state = Email::STATE_DRAFT;

        $email_object->to_addrs_ids = $focus->id;
        $email_object->to_addrs_names = $focus->name . ";";

        if (isset($focus->emailAddress)) {
            $to_addrs = $focus->emailAddress->getPrimaryAddress($focus);
            $email_object->to_addrs_emails = $to_addrs . ";";
            $email_object->to_addrs = $focus->name . " <" . $to_addrs . ">";
        } elseif ($focus->module_name == "Quotes") {
            // link the sent pdf to the relevant account
            if (isset($focus->billing_account_id) && !empty($focus->billing_account_id)) {
                $email_object->load_relationship('accounts');
                $email_object->accounts->add($focus->billing_account_id);
            }

            //check to see if there is a billing contact associated with this quote
            if (!empty($focus->billing_contact_id) && $focus->billing_contact_id != "") {
                $contact = BeanFactory::newBean("Contacts");
                $contact->retrieve($focus->billing_contact_id);

                if (!empty($contact->email1) || !empty($contact->email2)) {
                    if ($email_object->load_relationship('to')) {
                        $ep = BeanFactory::newBean('EmailParticipants');
                        $ep->new_with_id = true;
                        $ep->id = Uuid::uuid1();
                        BeanFactory::registerBean($ep);
                        $ep->parent_type = $contact->getModuleName();
                        $ep->parent_id = $contact->id;
                        $ep->email_address = $contact->emailAddress->getPrimaryAddress($contact);

                        if (!empty($ep->email_address)) {
                            $ep->email_address_id = $contact->emailAddress->getEmailGUID($ep->email_address);
                        }

                        $email_object->to->add($ep);
                    };

                    //contact email is set
                    $email_object->to_addrs_ids = $focus->billing_contact_id;
                    $email_object->to_addrs_names = $focus->billing_contact_name . ";";

                    if (!empty($contact->email1)) {
                        $email_object->to_addrs_emails = $contact->email1 . ";";
                        $email_object->to_addrs = $focus->billing_contact_name . " <" . $contact->email1 . ">";
                    } elseif (!empty($contact->email2)) {
                        $email_object->to_addrs_emails = $contact->email2 . ";";
                        $email_object->to_addrs = $focus->billing_contact_name . " <" . $contact->email2 . ">";
                    }

                    // create relationship b/t the email(w/pdf) and the contact
                    $contact->load_relationship('emails');
                    $contact->emails->add($email_object->id);
                }//end if contact name is set
            } elseif (isset($focus->billing_account_id) && !empty($focus->billing_account_id)) {
                $acct = BeanFactory::newBean("Accounts");
                $acct->retrieve($focus->billing_account_id);

                if (!empty($acct->email1) || !empty($acct->email2)) {
                    if ($email_object->load_relationship('to')) {
                        $ep = BeanFactory::newBean('EmailParticipants');
                        $ep->new_with_id = true;
                        $ep->id = Uuid::uuid1();
                        BeanFactory::registerBean($ep);
                        $ep->parent_type = $acct->getModuleName();
                        $ep->parent_id = $acct->id;
                        $ep->email_address = $acct->emailAddress->getPrimaryAddress($acct);

                        if (!empty($ep->email_address)) {
                            $ep->email_address_id = $acct->emailAddress->getEmailGUID($ep->email_address);
                        }

                        $email_object->to->add($ep);
                    };

                    //acct email is set
                    $email_object->to_addrs_ids = $focus->billing_account_id;
                    $email_object->to_addrs_names = $focus->billing_account_name . ";";

                    if (!empty($acct->email1)) {
                        $email_object->to_addrs_emails = $acct->email1 . ";";
                        $email_object->to_addrs = $focus->billing_account_name . " <" . $acct->email1 . ">";
                    } elseif (!empty($acct->email2)) {
                        $email_object->to_addrs_emails = $acct->email2 . ";";
                        $email_object->to_addrs = $focus->billing_account_name . " <" . $acct->email2 . ">";
                    }

                    // create relationship b/t the email(w/pdf) and the acct
                    $acct->load_relationship('emails');
                    $acct->emails->add($email_object->id);
                }//end if acct name is set
            }
        }

        if (isset($email_object->team_id)) {
            $email_object->team_id = $current_user->getPrivateTeamID();
        }
        if (isset($email_object->team_set_id)) {
            $teamSet = BeanFactory::newBean('TeamSets');
            $teamIdsArray = array($current_user->getPrivateTeamID());
            $email_object->team_set_id = $teamSet->addTeams($teamIdsArray);
        }

        $email_object->assigned_user_id = $current_user->id;

        //Save the email object
        global $timedate;
        $email_object->date_start = $timedate->now();

        $email_object->save(FALSE);
        $email_id = $email_object->id;

        //Handle PDF Attachment
        $note = BeanFactory::newBean("Notes");
        $note->id = Uuid::uuid1();
        $note->new_with_id = true;
        $note->filename = $file_name;
        $note->file_mime_type = get_file_mime_type("upload://{$file_name}", 'application/octet-stream');
        $note->name = translate('LBL_EMAIL_ATTACHMENT', "Quotes") . $file_name;

        $note->email_id = $email_object->id;
        $note->email_type = $email_object->module_name;

        //teams
        $note->team_id = $current_user->getPrivateTeamID();
        $noteTeamSet = BeanFactory::newBean('TeamSets');
        $noteteamIdsArray = array($current_user->getPrivateTeamID());
        $note->team_set_id = $noteTeamSet->addTeams($noteteamIdsArray);

        // Copy the file before saving so that the file size is captured during save.
        $source = 'upload://' . $file_name;
        $destination = "upload://{$note->id}";

        if (!copy($source, $destination)) {
            $msg = str_replace('$destination', $destination, translate('LBL_RENAME_ERROR', "Quotes"));
            die($msg);
        }

        @unlink($source);

        $note->save();
        $email_object->attachments->add($note);

        //return the email id
        return $email_id;
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

    /**
     * Set the file name and manage the email attachement output
     *
     * @see TCPDF::Output()
     */
    public function Output($name = "doc.pdf", $dest = 'I') {
        if (!empty($this->pdfFilename)) {
            $name = $this->pdfFilename;
        }

        // This case is for "email as PDF"
        if (isset($_REQUEST['to_email']) && $_REQUEST['to_email'] == "1") {
            // After the output the object is destroy

            $bean = $this->bean;

            $tmp = parent::Output('', 'S');
            $badoutput = ob_get_contents();
            if (strlen($badoutput) > 0) {
                ob_end_clean();
            }
            file_put_contents('upload://' . $name, ltrim($tmp));

            $email_id = $this->buildEmail($name, $bean);

            //redirect
            if ($email_id == "") {
                //Redirect to quote, since something went wrong
                echo "There was an error with your request";
                exit; //end if email id is blank
            } else {
                SugarApplication::redirect("index.php?module=Emails&action=Compose&record=" . $email_id . "&replyForward=true&reply=");
            }
        }

        parent::Output($name, 'D');
    }

    /**
     * PDF manager specific Header function
     */
    public function Header() {
        $ormargins = $this->getOriginalMargins();
        $headerfont = $this->getHeaderFont();
        $headerdata = $this->getHeaderData();
        if ($headerdata['logo'] && $headerdata['logo'] != K_BLANK_IMAGE) {
            $this->Image($headerdata['logo'], $this->GetX(), $this->getHeaderMargin(), $headerdata['logo_width'], 12);
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
        $this->SetFont($headerfont[0], 'B', $headerfont[2] + 1);
        $this->SetX($header_x);
        $this->Cell(0, $cell_height, $headerdata['title'], 0, 1, '', 0, '', 0);
        // header string
        $this->SetFont($headerfont[0], $headerfont[1], $headerfont[2]);
        $this->SetX($header_x);
        $this->MultiCell(0, $cell_height, $headerdata['string'], 0, '', 0, 1, '', '', true, 0, false);
        // print an ending header line
        $this->SetLineStyle(array('width' => 0.85 / $this->getScaleFactor(), 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
        $this->SetY((2.835 / $this->getScaleFactor()) + max($imgy, $this->GetY()));
        if ($this->getRTL()) {
            $this->SetX($ormargins['right']);
        } else {
            $this->SetX($ormargins['left']);
        }
        $this->Cell(0, 0, '', 'T', 0, 'C');
    }

    /**
     * PDF manager specific Footer function
     */
    public function Footer() {
        $cur_y = $this->GetY();
        $ormargins = $this->getOriginalMargins();
        $this->SetTextColor(0, 0, 0);
        //set style for cell border
        $line_width = 0.85 / $this->getScaleFactor();
        $this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
        //print document barcode
        $barcode = $this->getBarcode();
        if (!empty($barcode)) {
            $this->Ln($line_width);
            $barcode_width = round(($this->getPageWidth() - $ormargins['left'] - $ormargins['right']) / 3);
            $this->write1DBarcode($barcode, 'C128B', $this->GetX(), $cur_y + $line_width, $barcode_width, (($this->getFooterMargin() / 3) - $line_width), 0.3, '', '');
        }
        if (empty($this->pagegroups)) {
            $pagenumtxt = $this->l['w_page'] . ' ' . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages();
        } else {
            $pagenumtxt = $this->l['w_page'] . ' ' . $this->getPageNumGroupAlias() . ' / ' . $this->getPageGroupAlias();
        }
        $this->SetY($cur_y);

        if ($this->getRTL()) {
            $this->SetX($ormargins['right']);
            if ($this->footerText) {
                // footer text and page number
                $this->Cell(0, 0, $this->footerText, 'T', 0, 'R');
                $this->Cell(0, 0, $pagenumtxt, 0, 0, 'L');
            } else {
                // page number only
                $this->Cell(0, 0, $pagenumtxt, 'T', 0, 'L');
            }
        } else {
            $this->SetX($ormargins['left']);
            if ($this->footerText) {
                // footer text and page number
                $this->Cell(0, 0, $this->footerText, 'T', 0, 'L');
                $this->Cell(0, 0, $pagenumtxt, 0, 0, 'R');
            } else {
                // page number only
                $this->Cell(0, 0, $pagenumtxt, 'T', 0, 'R');
            }
        }
    }

    /**
     * Gets the PDF Filename
     * @return string
     */
    public function getPDFFilename() {
        return $this->pdfFilename;
    }

    /**
     * Forces a download of the PDF in a way our API understands.
     * @param string $filename The name of the file to force
     * @return string
     */
    public function forceDownload($filename) {
        $this->sendForceDownloadHeaders($filename);
        return parent::Output($filename, 'S');
    }

    /**
     * Sends the necessary headers to force a download of a PDF file
     *
     * This is borrowed entirely from {@see TCPDF::Output}, in the 'D' case for
     * forcing a download. It is done this way to allow the return of data rather
     * than echoing data.
     * @param string $filename The name of the file to force
     * @return null
     */
    protected function sendForceDownloadHeaders($filename) {
        // Download PDF as file
        if (ob_get_contents()) {
            $this->Error('Some data has already been output, can\'t send PDF file');
        }
        header('Content-Description: File Transfer');
        if (headers_sent()) {
            $this->Error('Some data has already been output to browser, can\'t send PDF file');
        }
        header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
        header('Pragma: public');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        // force download dialog
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream', false);
        header('Content-Type: application/download', false);
        header('Content-Type: application/pdf', false);
        // use the Content-Disposition header to supply a recommended filename
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . $this->bufferlen);
    }

    public function formatPhone($value) {
        $phone = null;
        if (!is_null($value) && !empty($value)) {
            $piece1 = $piece2 = $piece3 = '';
            $phone = $value;

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

            $phone = '(' . trim($piece1) . ') ' . trim($piece2) . '-' . trim($piece3);
            $phone = preg_replace('!\s+!', ' ', $phone);
        }

        return $phone;
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
                    if (isset($tag['attribute']['id']) && ($tag['attribute']['id'] == 'dotted-line' || $tag['attribute']['id'] == 'full-line')) {
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
                        if ($tag['attribute']['id'] == 'dotted-line') {
                            $this->Line($x, $y, $x + $hrWidth, $y, array('dash' => '3,1', 'color' => '#999'));
                        } else {
                            $this->Line($x, $y, $x + $hrWidth, $y, array('dash' => '0', 'color' => '#999'));
                        }
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
                                $moreDetails = false;
                                if ($border) {
                                    if (isset($table_el['attribute']['rules'])) {
                                        $border = $table_el['attribute']['rules'];
                                    }
                                    if (isset($table_el['attribute']['summary'])) {
                                        $this->SetLineStyle(array('dash' => $table_el['attribute']['summary'], 'color' => '#999'));
                                    }
                                    $moreDetails = true;
                                }

                                $ccode = $this->FillColor . "\n" . $this->getCellCode($cw, $ch, '', $border, 1, '', $fill, '', 0, true);

                                if ($moreDetails) {
                                    $border = 1;
                                }
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
                    // ++
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
        if (strpos($txt, 'dotted-line') !== false || strpos($txt, 'full-line') !== false) {
            $this->y -= 5;
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

    protected function _putpages() {
        $nb = $this->numpages;
        if (!empty($this->AliasNbPages)) {
            $nbs = $this->formatPageNumber($nb);
            $nbu = $this->UTF8ToUTF16BE($nbs, false); // replacement for unicode font
            $alias_a = $this->_escape($this->AliasNbPages);
            $alias_au = $this->_escape('{' . $this->AliasNbPages . '}');
            // ++
            $alias_a_ = $this->_escape('[nb]');
            $alias_au_ = $this->_escape('[[nb]]');
            if ($this->isunicode) {
                $alias_b = $this->_escape($this->UTF8ToLatin1($this->AliasNbPages));
                $alias_bu = $this->_escape($this->UTF8ToLatin1('{' . $this->AliasNbPages . '}'));
                $alias_c = $this->_escape($this->utf8StrRev($this->AliasNbPages, false, $this->tmprtl));
                $alias_cu = $this->_escape($this->utf8StrRev('{' . $this->AliasNbPages . '}', false, $this->tmprtl));
                // ++
                $alias_b_ = $this->_escape($this->UTF8ToLatin1('[nb]'));
                $alias_bu_ = $this->_escape($this->UTF8ToLatin1('[[nb]]'));
                $alias_c_ = $this->_escape($this->utf8StrRev('[nb]', false, $this->tmprtl));
                $alias_cu_ = $this->_escape($this->utf8StrRev('[[nb]]', false, $this->tmprtl));
            }
        }


        if (!empty($this->AliasNumPage)) {
            $alias_pa = $this->_escape($this->AliasNumPage);
            $alias_pau = $this->_escape('{' . $this->AliasNumPage . '}');
            // ++
            $alias_pa_ = $this->_escape('[pnb]');
            $alias_pau_ = $this->_escape('[[pnb]]');
            if ($this->isunicode) {
                $alias_pb = $this->_escape($this->UTF8ToLatin1($this->AliasNumPage));
                $alias_pbu = $this->_escape($this->UTF8ToLatin1('{' . $this->AliasNumPage . '}'));
                $alias_pc = $this->_escape($this->utf8StrRev($this->AliasNumPage, false, $this->tmprtl));
                $alias_pcu = $this->_escape($this->utf8StrRev('{' . $this->AliasNumPage . '}', false, $this->tmprtl));
                // ++
                $alias_pb_ = $this->_escape($this->UTF8ToLatin1('[pnb]'));
                $alias_pbu_ = $this->_escape($this->UTF8ToLatin1('[[pnb]]'));
                $alias_pc_ = $this->_escape($this->utf8StrRev('[pnb]', false, $this->tmprtl));
                $alias_pcu_ = $this->_escape($this->utf8StrRev('[[pnb]]', false, $this->tmprtl));
            }
        }
        $pagegroupnum = 0;
        $filter = ($this->compress) ? '/Filter /FlateDecode ' : '';
        for ($n = 1; $n <= $nb; ++$n) {
            $temppage = $this->getPageBuffer($n);
            if (!empty($this->pagegroups)) {
                if (isset($this->newpagegroup[$n])) {
                    $pagegroupnum = 0;
                }
                ++$pagegroupnum;
                foreach ($this->pagegroups as $k => $v) {
                    // replace total pages group numbers
                    $vs = $this->formatPageNumber($v);
                    $vu = $this->UTF8ToUTF16BE($vs, false);
                    $alias_ga = $this->_escape($k);
                    $alias_gau = $this->_escape('{' . $k . '}');
                    if ($this->isunicode) {
                        $alias_gb = $this->_escape($this->UTF8ToLatin1($k));
                        $alias_gbu = $this->_escape($this->UTF8ToLatin1('{' . $k . '}'));
                        $alias_gc = $this->_escape($this->utf8StrRev($k, false, $this->tmprtl));
                        $alias_gcu = $this->_escape($this->utf8StrRev('{' . $k . '}', false, $this->tmprtl));
                    }
                    $temppage = str_replace($alias_gau, $vu, $temppage);
                    if ($this->isunicode) {
                        $temppage = str_replace($alias_gbu, $vu, $temppage);
                        $temppage = str_replace($alias_gcu, $vu, $temppage);
                        $temppage = str_replace($alias_gb, $vs, $temppage);
                        $temppage = str_replace($alias_gc, $vs, $temppage);
                    }
                    $temppage = str_replace($alias_ga, $vs, $temppage);
                    // replace page group numbers
                    $pvs = $this->formatPageNumber($pagegroupnum);
                    $pvu = $this->UTF8ToUTF16BE($pvs, false);
                    $pk = str_replace('{nb', '{pnb', $k);
                    $alias_pga = $this->_escape($pk);
                    $alias_pgau = $this->_escape('{' . $pk . '}');
                    if ($this->isunicode) {
                        $alias_pgb = $this->_escape($this->UTF8ToLatin1($pk));
                        $alias_pgbu = $this->_escape($this->UTF8ToLatin1('{' . $pk . '}'));
                        $alias_pgc = $this->_escape($this->utf8StrRev($pk, false, $this->tmprtl));
                        $alias_pgcu = $this->_escape($this->utf8StrRev('{' . $pk . '}', false, $this->tmprtl));
                    }
                    $temppage = str_replace($alias_pgau, $pvu, $temppage);
                    if ($this->isunicode) {
                        $temppage = str_replace($alias_pgbu, $pvu, $temppage);
                        $temppage = str_replace($alias_pgcu, $pvu, $temppage);
                        $temppage = str_replace($alias_pgb, $pvs, $temppage);
                        $temppage = str_replace($alias_pgc, $pvs, $temppage);
                    }
                    $temppage = str_replace($alias_pga, $pvs, $temppage);
                }
            }
            if (!empty($this->AliasNbPages)) {
                // replace total pages number
                $temppage = str_replace($alias_au, $nbu, $temppage);
                // ++
                $temppage = str_replace($alias_au_, $nbu, $temppage);
                if ($this->isunicode) {
                    $temppage = str_replace($alias_bu, $nbu, $temppage);
                    $temppage = str_replace($alias_cu, $nbu, $temppage);
                    $temppage = str_replace($alias_b, $nbs, $temppage);
                    $temppage = str_replace($alias_c, $nbs, $temppage);
                    // ++
                    $temppage = str_replace($alias_bu_, $nbu, $temppage);
                    $temppage = str_replace($alias_cu_, $nbu, $temppage);
                    $temppage = str_replace($alias_b_, $nbs, $temppage);
                    $temppage = str_replace($alias_c_, $nbs, $temppage);
                }
                $temppage = str_replace($alias_a, $nbs, $temppage);
                // ++
                $temppage = str_replace($alias_a_, $nbs, $temppage);
            }
            if (!empty($this->AliasNumPage)) {
                // replace page number
                $pnbs = $this->formatPageNumber($n);
                $pnbu = $this->UTF8ToUTF16BE($pnbs, false); // replacement for unicode font
                $temppage = str_replace($alias_pau, $pnbu, $temppage);
                if ($this->isunicode) {
                    $temppage = str_replace($alias_pbu, $pnbu, $temppage);
                    $temppage = str_replace($alias_pcu, $pnbu, $temppage);
                    $temppage = str_replace($alias_pb, $pnbs, $temppage);
                    $temppage = str_replace($alias_pc, $pnbs, $temppage);
                    // ++
                    $temppage = str_replace($alias_pbu_, $pnbu, $temppage);
                    $temppage = str_replace($alias_pcu_, $pnbu, $temppage);
                    $temppage = str_replace($alias_pb_, $pnbs, $temppage);
                    $temppage = str_replace($alias_pc_, $pnbs, $temppage);
                }
                $temppage = str_replace($alias_pa, $pnbs, $temppage);
                // ++
                $temppage = str_replace($alias_pa_, $pnbs, $temppage);
            }
            $temppage = str_replace($this->epsmarker, '', $temppage);
            //$this->setPageBuffer($n, $temppage);
            //Page
            $this->_newobj();
            $this->_out('<</Type /Page');
            $this->_out('/Parent 1 0 R');
            $this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]', $this->pagedim[$n]['w'], $this->pagedim[$n]['h']));
            $this->_out('/Resources 2 0 R');
            $this->_putannots($n);
            $this->_out('/Contents ' . ($this->n + 1) . ' 0 R>>');
            $this->_out('endobj');
            //Page content
            $p = ($this->compress) ? gzcompress($temppage) : $temppage;
            $this->_newobj();
            $this->_out('<<' . $filter . '/Length ' . strlen($p) . '>>');
            $this->_putstream($p);
            $this->_out('endobj');
            if ($this->diskcache) {
                // remove temporary files
                unlink($this->pages[$n]);
            }
        }
        //Pages root
        $this->offsets[1] = $this->bufferlen;
        $this->_out('1 0 obj');
        $this->_out('<</Type /Pages');
        $kids = '/Kids [';
        for ($i = 0; $i < $nb; ++$i) {
            $kids .= (3 + (2 * $i)) . ' 0 R ';
        }
        $this->_out($kids . ']');
        $this->_out('/Count ' . $nb);
        //$this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]',$this->pagedim[0]['w'],$this->pagedim[0]['h']));
        $this->_out('>>');
        $this->_out('endobj');
    }

}
