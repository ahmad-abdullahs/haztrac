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
 * Class ReportCSVExporterMatrix1x2
 * @package Sugarcrm\Sugarcrm\modules\Reports\Exporters
 */
class ReportCSVExporterMatrix1x2 extends ReportCSVExporterMatrix
{
    /**
     * {@inheritdoc}
     */
    public function export(): string
    {
        $this->prepareExport();

        $groupings = $this->reporter->report_def['group_defs'];
        $content = "\"\"". $this->getDelimiter(false) . "\"{$groupings[1]['label']}\""
            . $this->spacePadder(count($this->columnHeaders[0]) * (count($this->columnHeaders[1]) + 1))
            . $this->getLineEnd();
        $content .= "\"\"";
        foreach ($this->columnHeaders[0] as $columnHeader => $value) {
            $content .= $this->getDelimiter(false) . "\"{$columnHeader}\""
                . $this->spacePadder(count($this->columnHeaders[1]));
        }
        $content .= $this->getDelimiter(false) . "\"\"" . $this->getLineEnd(); // save space for grand total
        $content .= "\"\"";
        for ($i = 0; $i < count($this->columnHeaders[0]); $i++) {
            $content .= $this->getDelimiter(false) . "\"{$groupings[2]['label']}\""
                . $this->spacePadder(count($this->columnHeaders[1]));
        }
        $content .= $this->getDelimiter(false) . "\"\"" . $this->getLineEnd();
        $content .= "\"{$groupings[0]['label']}\"";
        foreach ($this->columnHeaders[0] as $columnHeader1 => $value1) {
            foreach ($this->columnHeaders[1] as $columnHeader2 => $value2) {
                $content .= $this->getDelimiter(false) . "\"{$columnHeader2}\"";
            }
            $content .= $this->getDelimiter(false) . $this->getTranslationOf('LBL_TOTAL');
        }
        $content .= $this->getDelimiter(false) . $this->getTranslationOf('LBL_GRAND_TOTAL') . $this->getLineEnd();
        $rowTotal = array_pad(
            array(),
            count($this->columnHeaders[0]) * count($this->columnHeaders[1]),
            array_pad(array(), count($this->displayHeaders), 0)
        );
        $rowCount = array_pad(
            [],
            count($this->columnHeaders[0]) * count($this->columnHeaders[1]),
            0
        );
        $passedFirstRow = false;
        foreach ($this->rowHeaders as $rowHeader) {
            $content .= "\"{$rowHeader}\"";
            for ($i = 0; $i < count($this->displayHeaders); $i++) {
                if ($i != 0) {
                    $content .= "\"\"";
                }
                $columnTotal = 0;
                $columnCount = 0;
                if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'min') {
                    // preparing for finding min
                    $columnTotal = PHP_INT_MAX;
                }
                $j = 0;
                foreach ($this->columnHeaders[0] as $columnHeader1 => $value1) {
                    $total = 0;
                    $totalCount = 0;
                    if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'min') {
                        // preparing for finding min
                        $total = PHP_INT_MAX;
                        $rowTotal[$j][$i] = $passedFirstRow ? $rowTotal[$j][$i] : PHP_INT_MAX;
                    }
                    foreach ($this->columnHeaders[1] as $columnHeader2 => $value2) {
                        if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'min') {
                            // preparing for finding min
                            $rowTotal[$j][$i] = $passedFirstRow ? $rowTotal[$j][$i] : PHP_INT_MAX;
                        }
                        $data = $this->matrixDataFinder($rowHeader, array($columnHeader1, $columnHeader2));
                        if (!empty($data)) {
                            $cell = $data['cells'][$this->displayHeaders[$i]];
                            $dataCount = $data['count'];
                        } else {
                            $cell = '';
                            $dataCount = 0;
                        }
                        $content .= $this->getDelimiter(false) . "\"{$cell}\"";
                        $unformated = unformat_number(empty($cell) ? 0 : $cell);
                        $total = $this->groupFunctionHandler(
                            $this->displayHeaders[$i],
                            $unformated,
                            $dataCount,
                            $total,
                            false
                        );
                        $columnTotal = $this->groupFunctionHandler(
                            $this->displayHeaders[$i],
                            $unformated,
                            $dataCount,
                            $columnTotal
                        );
                        $rowTotal[$j][$i] = $this->groupFunctionHandler(
                            $this->displayHeaders[$i],
                            $unformated,
                            $dataCount,
                            $rowTotal[$j][$i]
                        );
                        $totalCount += $dataCount;
                        $columnCount += $dataCount;
                        if ($i == 0) {
                            $rowCount[$j] += $dataCount;
                        }
                        $j++;
                    }
                    if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg'
                        && $totalCount != 0) {
                        $total = $total / $totalCount;
                    }
                    $content .= $this->getDelimiter(false)
                        . "\""
                        . $this->currencyFormatter($this->displayHeaders[$i], $total)
                        . "\"";
                }
                if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg'
                    && $columnCount != 0) {
                    $columnTotal = $columnTotal / $columnCount;
                }
                $content .= $this->getDelimiter(false)
                    . "\""
                    . $this->currencyFormatter($this->displayHeaders[$i], $columnTotal)
                    . "\"" . $this->getLineEnd();
            }
            $passedFirstRow = true;
        }
        // row grand total
        $content .= $this->getTranslationOf('LBL_GRAND_TOTAL');
        for ($i = 0; $i < count($this->displayHeaders); $i++) {
            if ($i != 0) {
                $content .= "\"\"";
            }
            $j = 0;
            $grandTotal = 0;
            $grandCount = 0;
            if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'min') {
                $grandTotal = PHP_INT_MAX;
            }
            foreach ($this->columnHeaders[0] as $columnHeader1) {
                $total = 0;
                $totalCount = 0;
                if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'min') {
                    // preparing for finding min
                    $total = PHP_INT_MAX;
                }
                foreach ($this->columnHeaders[1] as $columnHeader2) {
                    if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg'
                        && $rowCount[$j] != 0) {
                        $rowTotal[$j][$i] = $rowTotal[$j][$i] / $rowCount[$j];
                    }
                    $content .= $this->getDelimiter(false)
                        . "\""
                        . $this->currencyFormatter($this->displayHeaders[$i], $rowTotal[$j][$i])
                        . "\"";
                    $total = $this->groupFunctionHandler(
                        $this->displayHeaders[$i],
                        $rowTotal[$j][$i],
                        $rowCount[$j],
                        $total,
                        false
                    );
                    $grandTotal = $this->groupFunctionHandler(
                        $this->displayHeaders[$i],
                        $rowTotal[$j][$i],
                        $rowCount[$j],
                        $grandTotal,
                        false
                    );
                    $totalCount += $rowCount[$j];
                    $grandCount += $rowCount[$j];
                    $j++;
                }
                if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg' && $totalCount != 0) {
                    $total = $total / $totalCount;
                }
                $content .= $this->getDelimiter(false) . "\""
                    . $this->currencyFormatter($this->displayHeaders[$i], $total) . "\"";
            }
            if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg') {
                $grandTotal = $grandTotal / $grandCount;
            }
            $content .= $this->getDelimiter(false)
                . "\""
                .  $this->currencyFormatter($this->displayHeaders[$i], $grandTotal)
                . "\"" . $this->getLineEnd();
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
            if (isset($this->trie[$groupings[0]['label']][$rowHeader])
                && isset($this->trie[$groupings[0]['label']][$rowHeader][$groupings[1]['label']][$columnHeader[0]])
                && isset($this->trie[$groupings[0]['label']][$rowHeader][$groupings[1]['label']][$columnHeader[0]]
                    [$groupings[2]['label']][$columnHeader[1]])) {
                return $this->trie[$groupings[0]['label']][$rowHeader][$groupings[1]['label']][$columnHeader[0]]
                    [$groupings[2]['label']][$columnHeader[1]][0];
            }

            return [];
        }
        return [];
    }
}
