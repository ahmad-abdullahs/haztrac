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

    public function filterRelatedSetup(ServiceBase $api, array $args) {
        // Load the parent bean.
        $record = BeanFactory::retrieveBean($args['module'], $args['record']);

        if (empty($record)) {
            throw new SugarApiExceptionNotFound(
            sprintf(
                    'Could not find parent record %s in module: %s', $args['record'], $args['module']
            )
            );
        }

        // Load the relationship.
        $linkName = $args['link_name'];
        if (!$record->load_relationship($linkName)) {
            // The relationship did not load.
            throw new SugarApiExceptionNotFound('Could not find a relationship named: ' . $args['link_name']);
        }
        $linkModuleName = $record->$linkName->getRelatedModuleName();
        $linkSeed = BeanFactory::newBean($linkModuleName);
        if (!$linkSeed->ACLAccess('list')) {
            throw new SugarApiExceptionNotAuthorized('No access to list records for module: ' . $linkModuleName);
        }

        $options = $this->parseArguments($api, $args, $linkSeed);

        // If they don't have fields selected we need to include any link fields
        // for this relationship
        if (empty($args['fields']) && is_array($linkSeed->field_defs)) {
            $relatedLinkName = $record->$linkName->getRelatedModuleLinkName();
            $options['linkDataFields'] = array();
            foreach ($linkSeed->field_defs as $field => $def) {
                if (empty($def['rname_link']) || empty($def['link'])) {
                    continue;
                }
                if ($def['link'] != $relatedLinkName) {
                    continue;
                }
                // It's a match
                $options['linkDataFields'][] = $field;
                $options['select'][] = $field;
            }
        }

        // In case the view parameter is set, reflect those fields in the
        // fields argument as well so formatBean only takes those fields
        // into account instead of every bean property.
        if (!empty($args['view'])) {
            $args['fields'] = $options['select'];
        } elseif (!empty($args['fields'])) {
            $args['fields'] = $this->normalizeFields($args['fields'], $options['displayParams']);
        }


        $q = self::getQueryObject($linkSeed, $options);

        // Some relationships want the role column ignored
        if (!empty($args['ignore_role'])) {
            $ignoreRole = true;
        } else {
            $ignoreRole = false;
        }

        $q->joinSubpanel($record, $linkName, array('joinType' => 'INNER', 'ignoreRole' => $ignoreRole));

        $q->setJoinOn(array('baseBeanId' => $record->id));

        if (!isset($args['filter']) || !is_array($args['filter'])) {
            $args['filter'] = array();
        }
        self::addFilters($args['filter'], $q->where(), $q);

        if (!sizeof($q->order_by)) {
            self::addOrderBy($q, $this->defaultOrderBy);
        }

        if (isset($options['relate_collections'])) {
            $options = $this->removeRelateCollectionsFromSelect($options);
        }

        // fixing duplicates in the query is not needed since even if it selects many-to-many related records,
        // they are still filtered by one primary record, so the subset is at most one-to-many
        $options['skipFixQuery'] = true;

        return array($args, $q, $options, $linkSeed);
    }

    public function filterRelated(ServiceBase $api, array $args) {
        if ($args['link_name'] == 'sales_and_services_revenuelineitems_1') {
            $args['max_num'] = -1;
        }

        $api->action = 'list';

        list($args, $q, $options, $linkSeed) = $this->filterRelatedSetup($api, $args);

        $returnData = $this->runQuery($api, $args, $q, $options, $linkSeed);

        $originalAllRLIIds = array();
        $bundleIds = array();
        foreach ($returnData['records'] as $key => $value) {
            if ($value['is_bundle_product_c'] == 'parent') {
                array_push($bundleIds, $value['id']);
            }
            array_push($originalAllRLIIds, $value['id']);
        }

        if (!empty($bundleIds)) {
            global $db;
            $sql = "SELECT 
                    *
                FROM
                    revenuelineitems_revenuelineitems_1_c
                WHERE
                    revenuelineitems_revenuelineitems_1revenuelineitems_ida IN ('" . implode("','", $bundleIds) . "') AND deleted = '0'";

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
