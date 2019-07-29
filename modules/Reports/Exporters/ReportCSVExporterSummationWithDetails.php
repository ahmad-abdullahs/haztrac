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
 * Class ReportCSVExporterSummationWithDetails
 * @package Sugarcrm\Sugarcrm\modules\Reports\Exporters
 */
class ReportCSVExporterSummationWithDetails extends ReportCSVExporterBase
{
    /**
     * Run the query to execute this report.
     * {@inheritdoc}
     */
    protected function runQuery()
    {
        $this->reporter->run_summary_combo_query();
    }

    /**
     * {@inheritdoc}
     */
    public function export(): string
    {
        $this->prepareExport();

        // accumulate the report data to be exported
        $tree = $this->buildTree();

        // format the accumulated report data for CSV export
        $content = $this->buildMainTable($tree)['content'];
        $content .= $this->getLineEnd();

        // format the grand total rows
        $content .= $this->getGrandTotal();

        return $content;
    }

    /**
     * Builds a tree for later processing main data table of Summation with
     * details.
     *
     * @return array Tree of the detail_header structure. Example:
     *   array(
     *     'group1' => array (
     *       'group1data1' => array(
     *         'group2' => .....
     *        ),
     *     ),
     *   )
     */
    private function buildTree(): array
    {
        $tree = array();

        // get display summary columns, split into count and non-count groups
        if (!isset($this->reporter->report_def['summary_columns'])) {
            throw new \Exception('All summation with details reports must have at least one summary column');
        }
        $summaryColumns = $this->reporter->report_def['summary_columns'];
        $groups = $this->determineGroups($summaryColumns);

        // get array of display summary column names
        $header = $this->reporter->get_summary_header_row(true);

        // iterate over all summary rows
        while (($row = $this->reporter->get_summary_next_row(true)) !== 0) {
            // get actual data for this group value
            $rowData = $this->makeSummaryData($row, $header);

            $walker = &$tree;

            // iterate over all non-group display summaries
            $cells = $groups['cells'];
            $numCells = count($cells);
            for ($i = 0; $i < $numCells; $i++) {
                $displaySummaryName = $cells[$i];
                if (!isset($walker[$displaySummaryName])) {
                    // when the group is not set
                    $walker[$displaySummaryName] = array();
                }

                $walker = &$walker[$displaySummaryName];

                $displaySummaryValue = $rowData['cells'][$displaySummaryName];
                if (!isset($walker[$displaySummaryValue])) {
                    $walker[$displaySummaryValue] = array();
                }
                $walker = &$walker[$displaySummaryValue];
            }

            $walker['count'] = $rowData['count'];
            $walker['group_function_cells'] = array();

            // build the extra display summary
            $groupFunctionCells = $groups['group_function_cells'];
            $numGroupFunctionCells = count($groupFunctionCells);
            for ($i = 0; $i < $numGroupFunctionCells; $i++) {
                $groupFunctionSummaryName = $groupFunctionCells[$i];
                $groupFunctionSummaryValue = $rowData['cells'][$groupFunctionSummaryName];
                $walker['group_function_cells'][$groupFunctionSummaryName] = $groupFunctionSummaryValue;
            }
        }

        return $tree;
    }

    /**
     * Recursively builds the main table of a Summation w/ Details report CSV.
     *
     * @param array $tree Reference to the location in $tree we are going to read.
     * @param string $tabs Optional string to add in front of each row,
     *   intended to be used as indentation.
     * @return array An array with "content" mapping to the CSV we've built so
     *   far and "count" mapping to the data row count of the subtree.
     */
    private function buildMainTable(array &$tree, string $tabs = ''): array
    {
        $mainTableData = array(
            'content' => '',
            'count' => 0,
        );

        if (isset($tree['count'])) {
            // when we've reached the bottom of the tree, build the actual detail rows
            $mainTableData['content'] .= $this->buildDetailRows($tree['count'], $tabs);
            $mainTableData['count'] = $tree['count'];
            return $mainTableData;
        }

        // handle cases where there's no results (eg. a report on an empty table or an overzealous filter)
        if (is_array($tree) && empty($tree)) {
            return $mainTableData;
        }

        // iterate over all the value(s) of the group by
        $detailHeader = array_keys($tree)[0];
        foreach ($tree[$detailHeader] as $groupValue => $groupSummaryData) {
            $mainTableData['content'] .= "$tabs\"" . $detailHeader . " = " . $groupValue;

            // call this function recursively on either the next group by value or the actual results
            $lowerOutput = $this->buildMainTable($groupSummaryData);

            if (isset($groupSummaryData['count'])) {
                // if we've reached the bottom of the tree, add an entry for all the group functions
                // the final result is an array with keys "count" and "group_function_cells"
                foreach ($groupSummaryData['group_function_cells'] as $label => $data) {
                    $mainTableData['content'] .= $this->getSummaryDelimiter() . " $label = $data";
                }
            }
            $mainTableData['content'] .= '"' . $this->getLineEnd();

            // accumulate both the detail rows and the number of rows into this table
            $mainTableData['content'] .= $lowerOutput['content'];
            $mainTableData['count'] += $lowerOutput['count'];

            $summaryHeaderRowForExport = $this->reporter->get_summary_header_row(true);
            if ($summaryHeaderRowForExport[0] === $detailHeader) {
                // if we finished the highest grouping, add an extra line
                $mainTableData['content'] .= $this->getLineEnd();
            }
        }

        return $mainTableData;
    }

    /**
     * Builds the detail data rows for the grouping.
     *
     * @param int $count Total rows in this data table.
     * @param string $tabs String to add in front of each row,
     *   for uniform indentation. Defaults to ''.
     * @return string The CSV string for this data table.
     */
    private function buildDetailRows(int $count, string $tabs = ''): string
    {
        // build the row consisting of only the display column names
        $tableHeadersArray = $this->reporter->get_header_row('display_columns', false, true);
        $tableHeadersString = implode($this->getDelimiter(), $tableHeadersArray);
        $tableString = "$tabs\"" . $tableHeadersString . '"' . $this->getLineEnd();

        // iterate through all the rows for this grouping
        for ($i = 0; $i < $count; $i++) {
            // get next database row, making sure to set export mode on (for eg. checkboxes)
            $row = $this->reporter->get_next_row('result', 'display_columns', false, true);
            if ($row === 0) {
                // this should never happen, but better safe than sorry
                throw new \Exception('Ran out of database rows during report export');
            }

            // add all the fields in this row into the table
            $newTableRowString = "$tabs\"" . implode($this->getDelimiter(), $row['cells']) . '"' . $this->getLineEnd();
            $tableString .= $newTableRowString;
        }

        return $tableString;
    }

    /**
     * Makes the correct summary data.
     *
     * @param array $row The row data returned by the report.
     * @param array $header The header(key, label) for $row
     * @return array An array with each label mapped to the corresponding value
     *   in ['cells'], and the count of the table in ['count'].
     *   Returns an empty array when there is no data in $row.
     */
    private function makeSummaryData(array $row, array $header): array
    {
        // if there is no data, return empty array
        if ($row === 0) {
            return array();
        }

        // if there is data, apply the data from the row to the header
        $summaryData = array();
        $summaryData['cells'] = array_combine($header, $row['cells']);
        $summaryData['count'] = intval($row['count']);
        return $summaryData;
    }

    /**
     * Figures out the sequence of grouping and group function columns, since
     * the raw grouping in report_def['group_def'] sometimes has labels
     * different from display labels.
     *
     * @param array $summaryHeaders Raw summary_header array from the report
     *   definition.
     * @return array The regular summary columns in the right sequence in
     *   'cells' and the group-function summary headers in
     *   'group_function_cells'.
     */
    private function determineGroups(array $summaryHeaders): array
    {
        $groupData = array(
            'cells' => array(),
            'group_function_cells' => array(),
        );

        // iterate through all the display summaries
        foreach ($summaryHeaders as $def) {
            if (isset($def['group_function'])) {
                $groupData['group_function_cells'][] = $def['label'];
            } else {
                $groupData['cells'][] = $def['label'];
            }
        }
        return $groupData;
    }

    /**
     * Returns a string for separating display summary labels in summary rows.
     *
     * @return string The delimiter.
     */
    private function getSummaryDelimiter(): string
    {
        return ',';
    }
}
