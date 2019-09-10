<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/RelateApi.php");

class CustomSASRelateApi extends RelateApi {

    public function registerApiRest() {
        return array_merge(parent::registerApiRest(), array(
            'listRelatedRecords' => array(
                'reqType' => 'GET',
                'path' => array('sales_and_services', '?', 'link', 'sales_and_services_revenuelineitems_1'),
                'pathVars' => array('module', 'record', '', 'link_name'),
                'jsonParams' => array('filter'),
                'method' => 'filterRelated',
                'shortHelp' => 'Lists related records.',
                'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
            ),
        ));
    }

    public function filterRelated(ServiceBase $api, array $args) {

        $GLOBALS['log']->fatal('$args kaka : ' . print_r($args, 1));

        $args['order_by'] = 'line_number:asc';

        if ($args['link_name'] == 'sales_and_services_revenuelineitems_1') {
            $args['max_num'] = -1;
        }

        $api->action = 'list';

        list($args, $q, $options, $linkSeed) = $this->filterRelatedSetup($api, $args);

        //get the compiled prepared statement
        $preparedStmt = $q->compile();

        //Retrieve the Parameterized SQL
        $sql = $preparedStmt->getSQL();
        $GLOBALS['log']->fatal('$sql' . print_r($sql, 1));
        //Retrieve the parameters as an array
        $parameters = $preparedStmt->getParameters();
        $GLOBALS['log']->fatal('$parameters' . print_r($parameters, 1));

        $returnData = $this->runQuery($api, $args, $q, $options, $linkSeed);

        $originalAllRLIIds = array();
        // get the bundle ids and all the ids od records shown in this subpanel
        $bundleIds = array();
        foreach ($returnData['records'] as $key => $value) {
            if ($value['is_bundle_product_c'] == 'parent') {
                array_push($bundleIds, $value['id']);
            }
            array_push($originalAllRLIIds, $value['id']);
        }

        // yes we have the bundles in the data set
        // then get the related ids of revenue line items related to bundle
        if (!empty($bundleIds)) {
            global $db;
            $sql = "SELECT 
                revenuelineitems_revenuelineitems_1_c.id,
                revenuelineitems_revenuelineitems_1revenuelineitems_ida,
                revenuelineitems_revenuelineitems_1revenuelineitems_idb
            FROM
                revenuelineitems_revenuelineitems_1_c
                    LEFT JOIN
                revenue_line_items ON revenuelineitems_revenuelineitems_1_c.revenuelineitems_revenuelineitems_1revenuelineitems_idb = revenue_line_items.id
            WHERE
                revenuelineitems_revenuelineitems_1revenuelineitems_ida IN ('" . implode("','", $bundleIds) . "')
                    AND revenue_line_items.deleted = '0'
            ORDER BY revenue_line_items.line_number";

            $result = $db->query($sql);

            $relatedIds = array();
            while ($row = $db->fetchByAssoc($result)) {
                if (!isset($relatedIds[$row['revenuelineitems_revenuelineitems_1revenuelineitems_ida']])) {
                    $relatedIds[$row['revenuelineitems_revenuelineitems_1revenuelineitems_ida']] = array();
                }
                array_push($relatedIds[$row['revenuelineitems_revenuelineitems_1revenuelineitems_ida']]
                        , $row['revenuelineitems_revenuelineitems_1revenuelineitems_idb']);
            }
        }

        $formatedAllRLIIds = array_merge(array_keys((array) $relatedIds), (array) $this->array_values_recursive(array_values((array) $relatedIds)));
        $diffRLIIds = array_diff($originalAllRLIIds, (array) $formatedAllRLIIds);

        $formatedRecords = array();
        $classColorCount = 1;
        if (!empty($diffRLIIds)) {
            foreach ($diffRLIIds as $id) {
                $record = $this->getRecordOnId($returnData['records'], $id);
                if (!is_null($record))
                    array_push($formatedRecords, $record);
            }
        }

        $paddingClass = 'branch-upto-tab';
        foreach ($relatedIds as $key => $value) {
            $record = $this->getRecordOnId($returnData['records'], $key);
            $calssName = 'rli-td-bcc-' . $classColorCount;
            if (!is_null($record)) {
                $record['_backgroundColorClass'] = $calssName;
                array_push($formatedRecords, $record);
            }
            foreach ($value as $_key => $_value) {
                $record = $this->getRecordOnId($returnData['records'], $_value);
                if (!is_null($record)) {
                    $record['_backgroundColorClass'] = $calssName;
                    $record['_branchUptoTab'] = $paddingClass;
                    array_push($formatedRecords, $record);
                }
            }
            $classColorCount++;
        }

        $returnData['records'] = $formatedRecords;
        return $returnData;
    }

    public function getRecordOnId($dataArr, $id) {
        foreach ($dataArr as $key => $value) {
            if ($value['id'] == $id) {
                return $value;
            }
        }
        return null;
    }

    /*
     * Take multi dimentional array and return the single dimension array.
     */

    public function array_values_recursive($ary) {
        $lst = array();
        foreach (array_keys($ary) as $k) {
            $v = $ary[$k];
            if (is_scalar($v)) {
                $lst[] = $v;
            } elseif (is_array($v)) {
                $lst = array_merge($lst, $this->array_values_recursive($v));
            }
        }
        return $lst;
    }

}
