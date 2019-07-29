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
 * Class ReportCSVExporterMatrix
 * @package Sugarcrm\Sugarcrm\modules\Reports\Exporters
 */
abstract class ReportCSVExporterMatrix extends ReportCSVExporterBase
{

    /**
     * The detail information for headers in this report, specifically for matrix
     * @var array
     */
    protected $detailHeaders;

    /**
     * The headers of data going to display in a matrix inner table, specifically for matrix
     * @var array
     */
    protected $displayHeaders;

    /**
     * The main data structure under the hood for export summation with detail and matrix, specifically
     * for fast data retrieving and grouping hierarchy
     * @var array
     */
    protected $trie;

    /**
     * The headers that will be shown in a column of the matrix table, specifically for matrix
     * @var array
     */
    protected $columnHeaders;

    /**
     * The headers that will be shown in a row of the matrix table, specifically for matrix
     * @var array
     */
    protected $rowHeaders;

    /**
     * Get the correct type for matrix export based on the layout options
     * @param \Report $reporter
     * @return string
     */
    public static function getSubTypeExporter(\Report $reporter) : string
    {
        $layout = $reporter->report_def['layout_options'];
        if ($layout == '2x2') {
            return '1x1';
        } elseif ($layout == '1x2') {
            return '1x2';
        } else {
            return '2x1';
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function runQuery()
    {
        $this->reporter->run_summary_query();
        $this->detailHeaders = $this->reporter->getDataTypeForColumnsForMatrix();
        $this->displayHeaders = $this->matrixCleanUpHeaders();
        $this->trie = $this->matrixTrieBuilder();
        $this->columnHeaders = $this->columnHeaderDictionary();
        $this->rowHeaders = $this->rowHeaderDictionary();
    }

    /**
     * Makes a string containing $count of ,"", comma may be swapped with other user defined delimiter
     * @param int $count The amount of ,"" to generate
     * @return string A string containing $count of ,"", comma may be swapped with other user defined delimiter
     */
    protected function spacePadder(int $count) : string
    {
        $output = "";
        for ($i = 0; $i < $count; $i++) {
            $output .= $this->getDelimiter(false) . "\"\"";
        }
        return $output;
    }

    /**
     * Handles different situations of Grand Total variables
     * @param string The header of $data
     * @param $data The data for $displayHeader, unformated
     * @param $count The count for this specifically this piece of data
     * @param $current The currently held total
     * @param bool $no_data_check Whether the $current should avoid interact with empty string in $data
     * @return int|string int When $data and $current are no empty string, or whenever $noDataCheck is
     *      set to true. string when at least $data or $current is empty string, and $noDataCheck is set to false.
     */
    protected function groupFunctionHandler(
        string $displayHeader,
        $data,
        $count,
        $current,
        bool $noDataCheck = true
    ) {
        if ($noDataCheck && ($count == null || $count == 0)) {
            return $current;
        }
        $funcName = $this->detailHeaders[$displayHeader]['group_function'];
        switch ($funcName) {
            case 'avg':
                return $current + $data * $count;
            case 'max':
                return $current > $data ? $current : $data;
            case 'min':
                return $current < $data ? $current : $data;
            case 'sum':
            case 'count':
                return $current + $data;
            default:
                throw new \Exception('Unsupported function: ' . $funcName);
        }
    }

    /**
     * Gives the formatted number according to whether the $number needs to add currency symbol
     * @param string $displayHeader The header of this $number
     * @param $number The data to display
     * @return string The formatted number with currency symbol when needed, otherwise the string
     *                of $number
     */
    protected function currencyFormatter(string $displayHeader, $number)
    {
        if ($this->detailHeaders[$displayHeader]['type'] == 'currency') {
            return \SugarCurrency::formatAmount(
                $number,
                $GLOBALS['current_user']->getPreference('currency')
            );
        }
        return strval($number);
    }

    /**
     * Clean up the mixed in grouping headers
     * @return array returns an array of headers that will display as neither row or column headers
     */
    protected function matrixCleanUpHeaders()
    {
        $output = array();
        $groupings = $this->reporter->report_def['group_defs'];
        $headers = $this->reporter->get_summary_header_row(true);
        foreach ($headers as $header) {
            $toDisplay = true;
            foreach ($groupings as $grouping) {
                if ($grouping['label'] == $header) {
                    $toDisplay = false;
                    break;
                }
            }
            if ($toDisplay) {
                $output[] = $header;
            }
        }
        return $output;
    }

    /**
     * Builds the trie for matrix
     * @requires $reporter has to finish running report query
     * @return array A Trie for making matrix csv, in the following format
     *               array(
     *                  group1 => array(
     *                       data_in_group1 => array(
     *                          array(rest_of_data1),
     *                          array(rest_of_data2), ...
     *                       )
     *                  ),
     *               )
     * @modifies $reporter
     * @effects Reads all the summary row data in $reporter.
     */
    protected function matrixTrieBuilder()
    {
        $output = array();
        $grouping = $this->reporter->report_def['group_defs'];
        $headers = $this->reporter->get_summary_header_row(true);
        while (($row = $this->reporter->get_summary_next_row(true)) != 0) {
            $data = $this->makeDetailData($row, $headers);
            $walker = &$output;
            // make the trie for the grouping part
            for ($i = 0; $i < count($grouping); $i++) {
                if (!isset($walker[$grouping[$i]['label']])) {
                    // if the label is not yet there
                    $walker[$grouping[$i]['label']] = array();
                }
                $walker = &$walker[$grouping[$i]['label']];
                if (!isset($walker[$data['cells'][$grouping[$i]['label']]])) {
                    $walker[$data['cells'][$grouping[$i]['label']]] = array();
                }
                $walker = &$walker[$data['cells'][$grouping[$i]['label']]];
                // unset the data that are grouping to ensure only grouping is in trie path
                unset($data['cells'][$grouping[$i]['label']]);
            }
            $remainingData = array(
                'cells' => array(),
                'count' => $data['count'],
            );
            // append the reset of the data to the end of this trie route
            for ($i = 0; $i < count($headers); $i++) {
                if (isset($data['cells'][$headers[$i]])) {
                    $remainingData['cells'][$headers[$i]] = $data['cells'][$headers[$i]];
                }
            }
            $remainingData['Count'] = $data['count'];
            $walker[] = $remainingData;
        }
        return $output;
    }

    /**
     * Builds a set of matrix header columns for columns(on the x axis)
     * @require After the $this->trie is generated
     * @return array an array of headers, if the header is a combination of two groupings, the array
     *               will have two array with the higher grouping in the first array, and the second
     *               array with the lower level header
     */
    protected function columnHeaderDictionary() : array
    {
        $output = array();
        $groupings = $this->reporter->report_def['group_defs'];
        $layout = $this->getLayoutOptions();
        $walker1 = &$this->trie[$groupings[0]['label']];
        if (is_null($walker1)) {
            return $output;
        }
        if ($layout[0] == '1') {
            if ($layout[1] == '1') {
                foreach ($walker1 as $d1 => &$value1) {
                    $walker2 = &$value1[$groupings[1]['label']];
                    foreach ($walker2 as $d2 => &$value2) {
                        if (!in_array($d2, $output)) {
                            $output[] = $d2;
                        }
                    }
                }
            } else {
                $output[] = array(); // higher level header
                $output[] = array(); // lower level header
                foreach ($walker1 as $d1 => &$value1) {
                    $walker2 = &$value1[$groupings[1]['label']];
                    foreach ($walker2 as $d2 => &$value2) {
                        if (!isset($output[0][$d2])) {
                            // if $d2 is not yet in the list
                            // making the header as a list to make use of the hashing benefit
                            $output[0][$d2] = true;
                        }
                        $walker3 = &$value2[$groupings[2]['label']];
                        foreach ($walker3 as $d3 => &$value3) {
                            if (!isset($output[1][$d3])) {
                                // if $d3 is not in the list
                                // making the header as a list to make use of the hashing benefit
                                $output[1][$d3] = true;
                            }
                        }
                    }
                }
            }
        } else {
            foreach ($walker1 as $d1 => &$next) {
                $walker2 = &$next[$groupings[1]['label']];
                foreach ($walker2 as $d2 => &$value) {
                    $walker3 = &$value[$groupings[2]['label']];
                    foreach ($walker3 as $d3 => &$data) {
                        if (!in_array($d3, $output)) {
                            $output[] = $d3;
                        }
                    }
                }
            }
        }
        return $output;
    }

    /**
     * Builds a set of matrix header columns for row(on the y axis)
     * @require After the $this->trie is generated
     * @return array an array of headers, if the header is a combination of two groupings, each header will
     *               be an array with the two groupings, which is higher level grouping is in the front, and
     *               the lower level grouping in the back
     */
    protected function rowHeaderDictionary()
    {
        $output = array();
        $groupings = $this->reporter->report_def['group_defs'];
        $layout = $this->getLayoutOptions();
        if ($layout[0] == '1') {
            $trieValue = $this->trie[$groupings[0]['label']];
            $output = !is_null($trieValue) ? array_keys($trieValue) : [];
        } else {
            $output[] = array();
            $output[] = array();
            $walker1 = &$this->trie[$groupings[0]['label']];
            foreach ($walker1 as $d1 => &$next) {
                $walker2 = &$next[$groupings[1]['label']];
                if (!isset($output[0][$d1])) {
                    $output[0][$d1] = true;
                }
                foreach ($walker2 as $d2 => &$value) {
                    if (!isset($output[1][$d2])) {
                        $output[1][$d2] = true;
                    }
                }
            }
        }
        return $output;
    }

    /**
     * @return array
     */
    protected function getLayoutOptions() : array
    {
        return explode(
            'x',
            $this->reporter->report_def['layout_options'] == '2x2' ? '1x1' : $this->reporter->report_def['layout_options']
        );
    }
}
