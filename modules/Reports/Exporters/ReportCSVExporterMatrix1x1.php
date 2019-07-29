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
 * Class ReportCSVExporterMatrix1x1
 * @package Sugarcrm\Sugarcrm\modules\Reports\Exporters
 */
class ReportCSVExporterMatrix1x1 extends ReportCSVExporterMatrix
{
    /**
     * {@inheritdoc}
     */
    public function export(): string
    {
        $this->prepareExport();

        $groupings = $this->reporter->report_def['group_defs'];
        $content = "\"\"" . $this->getDelimiter(false) . "\"{$groupings[1]['label']}\""
            . $this->spacePadder(count($this->columnHeaders)) . $this->getLineEnd();
        $content .= "\"" . $groupings[0]['label'] . "\"";
        foreach ($this->columnHeaders as $columnHeader) {
            $content .= $this->getDelimiter(false) . "\"$columnHeader\"";
        }
        $content .= $this->getDelimiter(false) . $this->getTranslationOf('LBL_GRAND_TOTAL') . $this->getLineEnd();
        $rowGrandTotal = array_pad(
            array(),
            count($this->columnHeaders),
            array_pad(array(), count($this->displayHeaders), 0)
        );
        $rowCounts = array_pad(array(), count($this->columnHeaders), 0);
        $passedFirstRow = false;
        foreach ($this->rowHeaders as $rowHeader) {
            $data = array();
            foreach ($this->columnHeaders as $columnHeader) {
                // queuing data for this row
                $data[] = $this->matrixDataFinder($rowHeader, $columnHeader);
            }
            $content .= "\"$rowHeader\"";
            for ($i = 0; $i < count($this->displayHeaders); $i++) {
                $columnGrandTotal = 0;
                $columnCount = 0;
                if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'min') {
                    $columnGrandTotal = PHP_INT_MAX;
                }
                for ($j = 0; $j < count($data); $j++) {
                    if ($i != 0 && $j == 0) {
                        $content .= "\"\"";
                    }
                    if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'min') {
                        $rowGrandTotal[$j][$i] = $passedFirstRow ? $rowGrandTotal[$j][$i] : PHP_INT_MAX;
                    }
                    if (!empty($data[$j])) {
                        $cell = $data[$j]['cells'][$this->displayHeaders[$i]];
                        $dataCount = $data[$j]['count'];
                    } else {
                        $cell = '';
                        $dataCount = 0;
                    }
                    $content .= $this->getDelimiter(false) . "\"{$cell}\"";
                    $unformatedData = unformat_number(empty($cell) ? 0 : $cell);
                    $columnGrandTotal = $this->groupFunctionHandler(
                        $this->displayHeaders[$i],
                        $unformatedData,
                        $dataCount,
                        $columnGrandTotal
                    );
                    $rowGrandTotal[$j][$i] = $this->groupFunctionHandler(
                        $this->displayHeaders[$i],
                        $unformatedData,
                        $dataCount,
                        $rowGrandTotal[$j][$i]
                    );
                    $columnCount += $dataCount;
                    if ($i == 0) {
                        $rowCounts[$j] += $dataCount;
                    }
                }
                if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg') {
                    $columnGrandTotal = $columnGrandTotal / $columnCount;
                }
                $content .= $this->getDelimiter(false)
                    . "\""
                    . $this->currencyFormatter($this->displayHeaders[$i], $columnGrandTotal)
                    . "\"" . $this->getLineEnd();
            }
            $passedFirstRow = true;
        }
        // build last row grand total
        $content .= $this->getTranslationOf('LBL_GRAND_TOTAL');
        for ($i = 0; $i < count($this->displayHeaders); $i++) {
            $columnGrandTotal = 0;
            $columnCount = 0;
            if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'min') {
                $columnGrandTotal = PHP_INT_MAX;
            }
            for ($j = 0; $j < count($this->columnHeaders); $j++) {
                if ($i != 0 && $j == 0) {
                    $content .= "\"\"";
                }
                if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg') {
                    $rowGrandTotal[$j][$i] = $rowGrandTotal[$j][$i] / $rowCounts[$j];
                }
                $columnGrandTotal = $this->groupFunctionHandler(
                    $this->displayHeaders[$i],
                    $rowGrandTotal[$j][$i],
                    $rowCounts[$j],
                    $columnGrandTotal
                );
                $content .= $this->getDelimiter(false)
                    . "\""
                    . $this->currencyFormatter($this->displayHeaders[$i], $rowGrandTotal[$j][$i])
                    . "\"";
                $columnCount += $rowCounts[$j];
            }
            if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg') {
                $columnGrandTotal = $columnGrandTotal / $columnCount;
            }
            $content .= $this->getDelimiter(false)
                . "\""
                . $this->currencyFormatter($this->displayHeaders[$i], $columnGrandTotal)
                . "\"". $this->getLineEnd();
        }
        return $content;
    }

    /**
     * Finds the data in ($rowHeader, $columnHeader)
     * @param string|array $rowHeader The row header of the data
     * @param string|array $columnHeader The column header of the data
     * @return array The content of the data, if no data existed, returns empty array
     */
    private function matrixDataFinder($rowHeader, $columnHeader) : array
    {
        $groupings = $this->reporter->report_def['group_defs'];
        if (!is_array($rowHeader)) {
            if (!is_array($columnHeader)) {
                if (isset($this->trie[$groupings[0]['label']][$rowHeader])
                    && isset($this->trie[$groupings[0]['label']][$rowHeader][$groupings[1]['label']][$columnHeader])) {
                    return $this->trie[$groupings[0]['label']][$rowHeader][$groupings[1]['label']][$columnHeader][0];
                }
                return [];
            }
        }
        return [];
    }
}
