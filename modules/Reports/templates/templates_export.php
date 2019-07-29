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

use Sugarcrm\Sugarcrm\modules\Reports\Exporters\ReportExporter;

require_once('include/export_utils.php');

function template_handle_export(&$reporter)
{
    ini_set('zlib.output_compression', 'Off');
    $reporter->plain_text_output = true;
    //disable paging so we get all results in one pass
    $reporter->enable_paging = false;

    $exporter = new ReportExporter($reporter);
    $content = $exporter->export();

    global $locale, $sugar_config;

    $transContent = $GLOBALS['locale']->translateCharset(
        $content,
        'UTF-8',
        $GLOBALS['locale']->getExportCharset(),
        false,
        true
    );

    ob_clean();
    header("Pragma: cache");
    header("Content-type: application/octet-stream; charset=".$locale->getExportCharset());
    header("Content-Disposition: attachment; filename={$_REQUEST['module']}.csv");
    header("Content-transfer-encoding: binary");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . TimeDate::httpTime());
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Content-Length: ".mb_strlen($transContent, '8bit'));
    if (!empty($sugar_config['export_excel_compatible'])) {
        print $transContent;
    } else {
        $user_agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
        if ($locale->getExportCharset() == 'UTF-8' &&
            ! preg_match('/macintosh|mac os x|mac_powerpc/i', $user_agent)) {
            $BOM = "\xEF\xBB\xBF";
        } else {
            $BOM = ''; // Mac Excel does not support utf-8
        }
        print $BOM . $transContent;
    }
}
