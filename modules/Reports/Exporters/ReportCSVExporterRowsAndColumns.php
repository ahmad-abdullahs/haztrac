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
declare(strict_types=1);
namespace Sugarcrm\Sugarcrm\modules\Reports\Exporters;

/**
 * Class ReportCSVExporterRowsAndColumns
 * @package Sugarcrm\Sugarcrm\modules\Reports\Exporters
 */
class ReportCSVExporterRowsAndColumns extends ReportCSVExporterBase
{
    /**
     * {@inheritdoc}
     */
    protected function runQuery()
    {
        $this->reporter->run_query();
    }

    /**
     * {@inheritdoc}
     */
    public function export(): string
    {
        $this->prepareExport();

        $headerRow = $this->reporter->get_header_row('display_columns', false, true, false);

        $header = "\"" . implode($this->getDelimiter(), array_values($headerRow));
        $header .= "\"" . $this->getLineEnd();
        $content = $header;

        while (($row = $this->reporter->get_next_row('result', 'display_columns', false, true)) !== 0) {
            $newArr = array();

            $cellCount = count($row['cells']);
            for ($i = 0; $i < $cellCount; $i++) {
                array_push($newArr, preg_replace("/\"/", "\"\"", from_html($row['cells'][$i])));
            }

            $line = "\"";
            $line .= implode($this->getDelimiter(), $newArr);
            $line .= "\"" . $this->getLineEnd();

            $content .= $line;
        }

        return $content;
    }
}
