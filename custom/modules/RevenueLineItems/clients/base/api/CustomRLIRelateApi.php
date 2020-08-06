<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("clients/base/api/RelateApi.php");

class CustomRLIRelateApi extends RelateApi {

    public function registerApiRest() {
        return array_merge(parent::registerApiRest(), array(
            'listRelatedRecords' => array(
                'reqType' => 'GET',
                'path' => array('RevenueLineItems', '?', 'link', 'revenuelineitems_revenuelineitems_1'),
                'pathVars' => array('module', 'record', '', 'link_name'),
                'jsonParams' => array('filter'),
                'method' => 'filterRelated',
                'shortHelp' => 'Lists related records.',
                'longHelp' => 'include/api/help/module_record_link_link_name_filter_get_help.html',
            ),
            'FetchRecords' => array(
                'reqType' => 'POST',
                'path' => array('RevenueLineItems', '?', 'fetch_record_data'), // this is called
                'pathVars' => array('moduleName', 'record', 'featureName'),
                'method' => 'fetchData',
                'jsonParams' => array(),
                'shortHelp' => 'Fetch Record view data',
                'longHelp' => '',
                'exceptions' => array(
                    // Thrown in filterList
                    'SugarApiExceptionInvalidParameter',
                    // Thrown in filterListSetup and parseArguments
                    'SugarApiExceptionNotAuthorized',
                ),
            ),
        ));
    }

    public function filterRelated(ServiceBase $api, array $args) {
        if ($args['link_name'] == 'revenuelineitems_revenuelineitems_1') {
            // If order by is already set to line_number:desc || line_number:asc, it's fine. Otherwise set the order to line_number:asc
            if (isset($args['order_by'])) {
                $orderBy = explode(':', $args['order_by']);
                if (count($orderBy)) {
                    if ($orderBy[0] != 'line_number') {
                        $args['order_by'] = 'line_number:asc';
                    }
                } else {
                    $args['order_by'] = 'line_number:asc';
                }
            }
        }
        $data = parent::filterRelated($api, $args);

        foreach ($data['records'] as $key => $value) {
            if (!empty($value['v_vendors_id_c'])) {
                global $db;
                $sql = "SELECT 
                    accounts.id,
                    accounts.name
                FROM
                    accounts
                WHERE
                    accounts.id ='" . $value['v_vendors_id_c'] . "'
                        AND accounts.deleted = '0'";

                $result = $db->query($sql);

                while ($row = $db->fetchByAssoc($result)) {
                    $data['records'][$key]['product_vendor_c'] = ($row['name']);
                }
            }
        }

        return $data;
    }

    public function fetchData(ServiceBase $api, array $args) {
//        error_reporting(-1);
//        ini_set('display_errors', 'On');
        $serviceSubpanels['RevenueLineItems'] = array(
            'competitor_cost_revenuelineitems' => array(
                'module' => 'competitor_cost',
                'linkField' => 'competitor_cost_revenuelineitems'
            ),
        );

        // To get Meta of List control
        $panels = array();
        if (isset($args['viewName']) && !empty($args['viewName'])) {
            $viewData = $this->getMetaDataManager($api->platform)
                    ->getModuleView("RevenueLineItems", $args['viewName']);
            if (isset($viewData['meta']) && isset($viewData['meta']['panels'])) {
                $panels = $viewData['meta']['panels'];
            }
        }

        // get list control data
        $returnData = array();
        $subpanelData = array();
        foreach ($serviceSubpanels['RevenueLineItems'] as $name => $subpanel) {
            $subpanelData[$name] = $this->getSubpanelData($api, 'RevenueLineItems', $args['modelId'], $subpanel, $name, $panels);
        }

        $returnData['subpanelData'] = $subpanelData;
        
        return $returnData;
    }

    public function getSubpanelData(ServiceBase $api, $relatedType, $related_id, $subpanel, $name, $panels) {
        $fields = $this->getSubpanelFields($name, $panels);
        $args['max_num'] = -1;
        $args['module'] = $relatedType;
        $args['record'] = $related_id;
        $args['link_name'] = $subpanel['linkField'];
        $args['filter'] = $subpanel['filter'];
        $args['order_by'] = $subpanel['order_by'];
        $args['fields'] = $fields;
        $args['custom'] = true;
        $data = $this->filterRelated($api, $args);
        return $data;
    }

    public function getSubpanelFields($fieldName, $panels) {
        $subpanelFields = [];
        foreach ($panels as $panel) {
            if (isset($panel['fields']) && is_array($panel['fields'])) {
                foreach ($panel['fields'] as $field) {
                    if (is_array($field) && $field['name'] == $fieldName) {
                        $module = $field['relatedModule'];
                        $beanObj = BeanFactory::newBean($module);
                        foreach ($field['columns'] as $columnMeta) {
                            $subpanelFields[] = $columnMeta['name'];
                            if (isset($columnMeta['related_fields']) && is_array($columnMeta['related_fields'])) {
                                foreach ($columnMeta['related_fields'] as $field) {
                                    $subpanelFields[] = $field;
                                }
                            }
                            $fieldVardef = $beanObj->field_defs[$columnMeta['name']];
                            $dependentIndexes = ['start_range_field', 'end_range_field', 'all_range_field'];
                            foreach ($dependentIndexes as $depFields) {
                                if (isset($fieldVardef[$depFields])) {
                                    if (is_array($fieldVardef[$depFields])) {
                                        foreach ($fieldVardef[$depFields] as $field) {
                                            $subpanelFields[] = $field;
                                        }
                                    } else {
                                        $subpanelFields[] = $fieldVardef[$depFields];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return implode(",", $subpanelFields);
    }

}
