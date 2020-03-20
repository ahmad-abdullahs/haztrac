<?php

require_once 'include/SugarFields/Fields/RelateLink/SugarFieldRelateLink.php';

class CustomSugarFieldRelateLink extends SugarFieldRelateLink {

    /**
     * Return the data that should be returned for link or collection field
     *
     * @param SugarBean $bean Source bean
     * @param array $field Link or collection field definition
     * @param array $displayParams Field display parameters
     * @param ServiceBase $service
     *
     * @return array
     * @throws SugarApiExceptionError
     */
    protected function getBeanCollection(SugarBean $bean, array $field, array $displayParams, ServiceBase $service) {
        if ($displayParams['type'] == 'relate-collection-preview' ||
                $field['name'] == 'revenuelineitems_revenuelineitems_1' ||
                $field['name'] == 'sales_and_services_revenuelineitems_1') {
            $args = array_merge(array(
                // make sure "fields" argument is always passed to the API
                // since otherwise it will return all fields by default
                'fields' => array(
                    'id',
                    'date_modified',
                    'name',
                    'discount_price',
                    'list_price',
                    'cost_price',
                    'quantity',
                    'product_uom_c',
                    'total_amount',
                    'estimated_total_amount',
                    'rli_as_template_c',
                    'v_vendors_id_c',
                    'is_bundle_product_c',
                    'manifest_required_c',
                    'line_number',
                    'revenuelineitems_revenuelineitems_1revenuelineitems_ida',
                ),
                    ), $displayParams, array(
                'module' => $bean->module_name,
                'record' => $bean->id,
                'link_name' => $field['name'],
                'order_by' => 'line_number:asc',
                'max_num' => -1,
            ));
        } else {
            $args = array_merge(array(
                // make sure "fields" argument is always passed to the API
                // since otherwise it will return all fields by default
                'fields' => array('id', 'date_modified'),
                    ), $displayParams, array(
                'module' => $bean->module_name,
                'record' => $bean->id,
                'link_name' => $field['name'],
            ));
        }

        $returnData = $this->getRelateApi()->filterRelated($service, $args);

        if ($field['name'] == 'sales_and_services_revenuelineitems_1') {
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
                        // $record['_backgroundColorClass'] = $calssName;
                        $record['_backgroundColorClass'] = 'rli-td-bcc';
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
            }
        }

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
