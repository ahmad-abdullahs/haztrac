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
 * Class ReportCSVExporterMatrix2x1
 * @package Sugarcrm\Sugarcrm\modules\Reports\Exporters
 */
class ReportCSVExporterMatrix2x1 extends ReportCSVExporterMatrix
{
    /**
     * {@inheritdoc}
     */
    public function export(): string
    {
        $this->prepareExport();

        $groupings = $this->reporter->report_def['group_defs'];
        $content = "\"\"" . $this->getDelimiter(false) . "\"\"" . $this->getDelimiter(false)
            . "\"{$groupings[2]['label']}\"" . $this->spacePadder(count($this->columnHeaders) - 1)
            . $this->getDelimiter(false) . "\"\"" . $this->getLineEnd();
        $content .= "\"{$groupings[0]['label']}\"" . $this->getDelimiter(false) . "\"{$groupings[1]['label']}\"";
        foreach ($this->columnHeaders as $columnHeader) {
            $content .= $this->getDelimiter(false) . "\"$columnHeader\"";
        }
        $content .= $this->getDelimiter(false) . $this->getTranslationOf('LBL_GRAND_TOTAL') . $this->getLineEnd();
        $rowGrandTotal = array_pad(
            [],
            count($this->columnHeaders),
            array_pad(array(), count($this->displayHeaders), 0)
        );
        $rowCount = array_pad(array(), count($this->columnHeaders), 0);
        $veryFirstRow = true;
        foreach ($this->rowHeaders[0] as $rowHeader1 => $value1) {
            $passedFirstRow = false;
            $content .= "\"$rowHeader1\"";
            $total = array_pad(
                [],
                count($this->columnHeaders),
                array_pad(array(), count($this->displayHeaders), 0)
            );
            $totalCount = array_pad(array(), count($this->columnHeaders), 0);
            foreach ($this->rowHeaders[1] as $rowHeader2 => $value2) {
                for ($i = 0; $i < count($this->displayHeaders); $i++) {
                    if ($i == 0 && $rowHeader2 != array_keys($this->rowHeaders[1])[0]) {
                        $content .= "\"\"" . $this->getDelimiter(false) . "\"$rowHeader2\"";
                    } elseif ($i == 0) {
                        $content .= $this->getDelimiter(false) . "\"$rowHeader2\"";
                    } else {
                        $content .= "\"\"" . $this->getDelimiter(false) . "\"\"";
                    }
                    $columnGrandTotal = 0;
                    $columnCount = 0;
                    $j = 0;
                    if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'min') {
                        $columnGrandTotal = PHP_INT_MAX;
                    }
                    foreach ($this->columnHeaders as $columnHeader) {
                        if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'min') {
                            $total[$j][$i] = $passedFirstRow ? $total[$j][$i] : PHP_INT_MAX;
                            $rowGrandTotal[$j][$i] = $veryFirstRow ? PHP_INT_MAX : $rowGrandTotal[$j][$i];
                        }
                        $data = $this->matrixDataFinder(array($rowHeader1, $rowHeader2), $columnHeader);
                        if (!empty($data)) {
                            $cell = $data['cells'][$this->displayHeaders[$i]];
                            $dataCount = $data['count'];
                        } else {
                            $cell = '';
                            $dataCount = 0;
                        }
                        $content .= $this->getDelimiter(false) . "\"{$cell}\"";
                        $unformated = unformat_number(empty($cell) ? 0 : $cell);
                        $total[$j][$i] = $this->groupFunctionHandler(
                            $this->displayHeaders[$i],
                            $unformated,
                            $dataCount,
                            $total[$j][$i]
                        );
                        $columnGrandTotal = $this->groupFunctionHandler(
                            $this->displayHeaders[$i],
                            $unformated,
                            $dataCount,
                            $columnGrandTotal
                        );
                        $rowGrandTotal[$j][$i] = $this->groupFunctionHandler(
                            $this->displayHeaders[$i],
                            $unformated,
                            $dataCount,
                            $rowGrandTotal[$j][$i]
                        );
                        $columnCount += $dataCount;
                        if ($i == 0) {
                            $totalCount[$j] += $dataCount;
                            $rowCount[$j] += $dataCount;
                        }
                        $j++;
                    }
                    if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg'
                        && $columnCount != 0) {
                        $columnGrandTotal = $columnGrandTotal / $columnCount;
                    }
                    $content .= $this->getDelimiter(false)
                        . "\""
                        . $this->currencyFormatter($this->displayHeaders[$i], $columnGrandTotal)
                        . "\"" . $this->getLineEnd();
                }
                $passedFirstRow = true;
            }
            // row total
            $content .= "\"\"" . $this->getDelimiter(false) . $this->getTranslationOf('LBL_TOTAL');
            for ($i = 0; $i < count($this->displayHeaders); $i++) {
                if ($i != 0) {
                    $content .= "\"\"" . $this->getDelimiter(false) . "\"\"";
                }
                $columnGrandTotal = 0;
                $columnCount = 0;
                if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'min') {
                    $columnGrandTotal = PHP_INT_MAX;
                }
                for ($j = 0; $j < count($this->columnHeaders); $j++) {
                    if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg'
                        && $totalCount[$j] != 0) {
                        $total[$j][$i] = $total[$j][$i] / $totalCount[$j];
                    }
                    if ($totalCount[$j] == 0) {
                        $content .= $this->getDelimiter(false) . "\"\"";
                    } else {
                        $content .= $this->getDelimiter(false)
                            . "\""
                            . $this->currencyFormatter($this->displayHeaders[$i], $total[$j][$i])
                            . "\"";
                    }
                    $columnGrandTotal = $this->groupFunctionHandler(
                        $this->displayHeaders[$i],
                        $total[$j][$i],
                        $totalCount[$j],
                        $columnGrandTotal
                    );
                    $columnCount += $totalCount[$j];
                }
                if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg'
                    && $columnCount != 0) {
                    $columnGrandTotal = $columnGrandTotal / $columnCount;
                }
                $content .= $this->getDelimiter(false)
                    . "\""
                    . $this->currencyFormatter($this->displayHeaders[$i], $columnGrandTotal)
                    . "\"" . $this->getLineEnd();
            }
            $veryFirstRow = false;
        }
        // row grand total
        $content .= "\"\"" . $this->getDelimiter(false) . $this->getTranslationOf('LBL_GRAND_TOTAL');
        for ($i = 0; $i < count($this->displayHeaders); $i++) {
            if ($i != 0) {
                $content .= "\"\"" . $this->getDelimiter(false) . "\"\"";
            }
            $columnGrandTotal = 0;
            $columnCount = 0;
            if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'min') {
                $columnGrandTotal = PHP_INT_MAX;
            }
            for ($j = 0; $j < count($this->columnHeaders); $j++) {
                if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg'
                    && $rowCount[$j] != 0) {
                    $rowGrandTotal[$j][$i] = $rowGrandTotal[$j][$i] / $rowCount[$j];
                }
                $columnGrandTotal = $this->groupFunctionHandler(
                    $this->displayHeaders[$i],
                    $rowGrandTotal[$j][$i],
                    $rowCount[$j],
                    $columnGrandTotal
                );
                if ($rowCount[$j] == 0) {
                    $content .= $this->getDelimiter(false) . "\"\"";
                } else {
                    $content .= $this->getDelimiter(false)
                        . "\""
                        . $this->currencyFormatter($this->displayHeaders[$i], $rowGrandTotal[$j][$i])
                        . "\"";
                }
                $columnCount += $rowCount[$j];
            }
            if ($this->detailHeaders[$this->displayHeaders[$i]]['group_function'] == 'avg'
                && $columnCount != 0) {
                $columnGrandTotal = $columnGrandTotal / $columnCount;
            }
            $content .= $this->getDelimiter(false)
                . "\""
                . $this->currencyFormatter($this->displayHeaders[$i], $columnGrandTotal)
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

        if (isset($this->trie[$groupings[0]['label']][$rowHeader[0]])
            && isset($this->trie[$groupings[0]['label']][$rowHeader[0]][$groupings[1]['label']][$rowHeader[1]])
            && isset($this->trie[$groupings[0]['label']][$rowHeader[0]][$groupings[1]['label']][$rowHeader[1]]
                [$groupings[2]['label']][$columnHeader])) {
            return $this->trie[$groupings[0]['label']][$rowHeader[0]][$groupings[1]['label']][$rowHeader[1]]
                [$groupings[2]['label']][$columnHeader][0];
        }
        return [];
    }
}
