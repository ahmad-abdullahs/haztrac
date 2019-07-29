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
 * Class ReportCSVExporterSummation
 * @package Sugarcrm\Sugarcrm\modules\Reports\Exporters
 */
class ReportCSVExporterSummation extends ReportCSVExporterBase
{
    /**
     * {@inheritdoc}
     */
    protected function runQuery()
    {
        $this->reporter->run_summary_query();
        $this->reporter->run_total_query();
    }

    /**
     * {@inheritdoc}
     */
    public function export(): string
    {
        $this->prepareExport();

        $content = '';

        $content .= "\"" . implode($this->getDelimiter(), $this->reporter->get_summary_header_row());
        $content .= "\"" . $this->getLineEnd();

        while (($row = $this->reporter->get_next_row('summary_result', 'summary_columns', false, true)) != 0) {
            $content .= "\"" . implode($this->getDelimiter(), $row['cells']);
            $content .= "\"" . $this->getLineEnd();
        }

        $content .= $this->getLineEnd(2);
        $content .= $this->getGrandTotal();

        return $content;
    }
}
