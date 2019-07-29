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

class PdfManagerGeneratePdfApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'generatePdf' => array(
                'reqType' => 'GET',
                'path' => array('PdfManager', 'generate'),
                'pathVars' => array('', ''),
                'method' => 'generatePdf',
                'rawReply' => true,
                'allowDownloadCookie' => true,
                'shortHelp' => 'Generate a PDF',
                'longHelp' => 'modules/PdfManager/clients/base/api/help/generate_pdf_api.html',
            ),
        );
    }

    public function generatePdf(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, array('module', 'record', 'pdf_template_id'));

        $bean = $this->loadBean($api, $args);

        if (!$bean->ACLAccess('view')) {
            throw new SugarApiExceptionNotAuthorized('EXCEPTION_NOT_AUTHORIZED');
        }

        // if sugarpdf is empty, default to 'pdfmanager'
        if (!isset($args['sugarpdf']) || empty($args['sugarpdf'])) {
            $args['sugarpdf'] = 'pdfmanager';
        }

        $sugarpdfBean = SugarpdfFactory::loadSugarpdf($args['sugarpdf'], $args['module'], $bean, array());
        $sugarpdfBean->module = $args['module'];
        $sugarpdfBean->process();

        /*
         * This line of code that returns the forceDownload result could also be done as such:
         *
         * ```php
         * ob_start();
         * $sugarpdfBean->Output();
         * return ob_get_flush();
         * ```
         *
         * While this is simpler it does mess with output buffers which might have
         * unintended consequences.
         */
        return $sugarpdfBean->forceDownload($sugarpdfBean->getPDFFilename());
    }
}
