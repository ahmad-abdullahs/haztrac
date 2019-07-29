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

require_once 'include/export_utils.php'; // for user defined delimiter

/**
 * Class ReportCSVExporterBase
 * @package Sugarcrm\Sugarcrm\modules\Reports\Exporters
 */
abstract class ReportCSVExporterBase implements ReportExporterInterface
{
    /**
     * @var \Report
     */
    protected $reporter;

    public function __construct(\Report $reporter)
    {
        $this->reporter = $reporter;
    }

    /**
     * Concrete implementations must define their own export methodology
     *
     * @return string
     */
    abstract public function export(): string;

    /**
     * Run the corresponding query to get the data
     * Concrete implementations must define their own query method
     */
    abstract protected function runQuery();

    /**
     * To prepare the export
     */
    protected function prepareExport()
    {
        $this->reporter->do_export = true;
        $this->reporter->_load_currency();
        $this->runQuery();
    }

    /**
     * Helper function that builds the grand total csv
     * @return string
     */
    protected function getGrandTotal()
    {
        $return = $this->getTranslationOf('LBL_GRAND_TOTAL') . $this->getLineEnd();
        $return .= '"' . implode($this->getDelimiter(), $this->reporter->get_total_header_row(true)) . '"' . $this->getLineEnd();

        $row = $this->reporter->get_summary_total_row(true);
        if (isset($row['cells'])) {
            $return .= '"' . implode($this->getDelimiter(), $row['cells']) . '"';
        }

        return $return;
    }

    /**
     * Wrapper of global getDelimiter
     * @param bool $withQuotes
     * @return string
     */
    protected function getDelimiter($withQuotes = true) : string
    {
        if ($withQuotes) {
            return '"' . getDelimiter() . '"';
        }
        return getDelimiter();
    }

    /**
     * Gets a translation for the given label.
     * @param string $label The label to get.
     * @param bool $withQuotes If true, wrap in double quotes. Defaults to true
     * @return string The translation.
     */
    protected function getTranslationOf(string $label, $withQuotes = true): string
    {
        $str = translate($label, 'Reports');
        if ($withQuotes) {
            $str = $this->wrapInQuotes($str);
        }
        return $str;
    }

    /**
     * @param int $count
     * @return string
     */
    protected function getLineEnd(int $count = 1)
    {
        $ret = '';
        $c = 0;
        while ($c < $count) {
            $ret .= "\r\n";
            $c++;
        }
        return $ret;
    }

    /**
     * A Helper function to make the corrent detail data for ::summaryWDetailBuilder()
     * @param array $detail_row The row data returned by Report
     * @param array $detail_header The header(key, label) for $detail_row
     * @requires $detailed_row['cells'] and $detail_header should have same amount of elements, which
     *           the sequence of the data in $detailed_row['cells'] should correspond to the sequence
     *           in $detail_header
     * @return array An array with each label mapped to the corresponding value in ['cells'], and the count
     *               of the table in ['count']. Returns empty array when no data is in $detail_row
     */
    protected function makeDetailData(array $detail_row, array $detail_header)
    {
        $output = array();
        if ($detail_row == 0) {
            // if there is no data
            return $output;
        }
        // if there is data
        $output['cells'] = array_combine($detail_header, $detail_row['cells']);
        $output['count'] = $detail_row['count'];
        return $output;
    }

    /**
     * Returns the given string wrapped in double quotes.
     * @param string The string to wrap.
     * @return string The wrapped string.
     */
    private function wrapInQuotes(string $str): string
    {
        return '"' . $str . '"';
    }
}
