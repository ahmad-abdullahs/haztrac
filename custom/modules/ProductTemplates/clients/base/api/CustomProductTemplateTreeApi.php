<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

require_once("modules/ProductTemplates/clients/base/api/ProductTemplateTreeApi.php");

class CustomProductTemplateTreeApi extends ProductTemplateTreeApi {

    public $groupBundleIdsString = "";

    public function registerApiRest() {
        return array_merge(parent::registerApiRest(), array(
            'bundledtree' => array(
                'reqType' => 'GET',
                'path' => array('ProductTemplates', 'bundledtree',),
                'pathVars' => array('module', 'type',),
                'method' => 'getTemplateBundledTree',
                'shortHelp' => 'Returns a filterable tree structure of all Product Templates and Product Categories',
                'longHelp' => 'modules/ProductTemplates/clients/base/api/help/tree.html',
            ),
            'bundledtreeFilter' => array(
                'reqType' => 'POST',
                'path' => array('ProductTemplates', 'bundledtree',),
                'pathVars' => array('module', 'type',),
                'method' => 'getTemplateBundledTree',
                'shortHelp' => 'Returns a filterable tree structure of all Product Templates and Product Categories',
                'longHelp' => 'modules/ProductTemplates/clients/base/api/help/tree.html',
            ))
        );
    }

    /**
     * Gets the full tree data in a jstree structure
     * @param ServiceBase $api
     * @param array $args
     * @return stdClass
     */
    public function getTemplateBundledTree(ServiceBase $api, array $args) {
        $data = [];
        $tree = [];
        $records = [];
        $max_num = $this->getSugarConfig()->get('list_max_entries_per_page', 20);
        $offset = -1;
        $total = 0;
        $max_limit = $this->getSugarConfig()->get('max_list_limit');

        // Get the ids of bundles which are part of groups...
        // We need to exclude those bundles from the tree...
        $this->groupBundleIdsString = $this->getGroupBundleIds();
        //set parameters
        if (array_key_exists('filter', $args)) {
            $data = $this->_getFilteredTreeData($args['filter']);
        } elseif (array_key_exists('root', $args)) {
            $data = $this->_getRootedTreeData($args['root']);
        } else {
            $data = $this->_getRootedTreeData(null);
        }

        if (array_key_exists('offset', $args)) {
            $offset = $args['offset'];
        }

        //if the max_num is in-between 1 and $max_limit, set it, otherwise use max_limit
        if (array_key_exists('max_num', $args) && ($args['max_num'] < 1 || $args['max_num'] > $max_limit)) {
            $max_num = $max_limit;
        } elseif (array_key_exists('max_num', $args)) {
            $max_num = $args['max_num'];
        }

        // get total records in this set, calculate start position, slice data to current page
        $total = count($data);

        $offset = ($offset == -1) ? 0 : $offset;

        if ($offset < $total) {
            $data = array_slice($data, $offset, $max_num);

            //build the treedata
            foreach ($data as $node) {
                //create new leaf
                $records[] = $this->_generateNewLeaf($node, $offset);
                $offset++;
            }
        }

        if ($total <= $offset) {
            $offset = -1;
        }

        $tree['records'] = $records;
        $tree['next_offset'] = $offset;

        return $tree;
    }

    public function _getFilteredTreeData($filter) {
        if (empty($this->groupBundleIdsString)) {
            $this->groupBundleIdsString = "''";
        }

        $filter = "%$filter%";
        $unionFilter1 = "and name like ? ";

        $filter = "%$filter%";
        $unionFilter2 = "and name like ? AND (is_bundle_product_c IS NULL
        OR is_bundle_product_c = ''
        OR is_bundle_product_c = ?) AND (standalone_item_c IS NULL
        OR standalone_item_c = ''
        OR standalone_item_c = 0) AND id NOT IN ($this->groupBundleIdsString) ";

        return $this->_getTreeData($unionFilter1, $unionFilter2, [$filter, $filter, 'parent']);
    }

    public function _getRootedTreeData($root) {
        $union1Root = '';
        $union2Root = '';

        if (empty($this->groupBundleIdsString)) {
            $this->groupBundleIdsString = "''";
        }

        if ($root == null) {
            $union1Root = "and parent_id is null ";
            $union2Root = "and category_id is null AND (is_bundle_product_c IS NULL
        OR is_bundle_product_c = ''
        OR is_bundle_product_c = ?) AND (standalone_item_c IS NULL
        OR standalone_item_c = ''
        OR standalone_item_c = 0) AND id NOT IN ($this->groupBundleIdsString) ";
            $params = ['parent'];
        } else {
            $union1Root = "and parent_id = ? ";
            $union2Root = "and category_id = ? AND (is_bundle_product_c IS NULL
        OR is_bundle_product_c = ''
        OR is_bundle_product_c = ?) AND (standalone_item_c IS NULL
        OR standalone_item_c = ''
        OR standalone_item_c = 0) AND id NOT IN ($this->groupBundleIdsString) ";
            $params = [$root, $root, 'parent'];
        }

        return $this->_getTreeData($union1Root, $union2Root, $params);
    }

    /**
     * Gets the tree data
     *
     * @param string $union1Filter
     * @param string $union2Filter
     * @param array $params Query parameters
     *
     * @return mixed[][]
     */
    public function _getTreeData($union1Filter, $union2Filter, array $params) {
        $q = "select id, name, 'category' as type, '' AS is_bundle_product_c, '' AS is_group_item_c from product_categories " .
                "where deleted = 0 " .
                $union1Filter .
                "union all " .
                "SELECT 
                    id, name, 'product' AS type, is_bundle_product_c, is_group_item_c
                FROM
                    product_templates
                        LEFT JOIN
                    product_templates_cstm ON product_templates.id = product_templates_cstm.id_c
                WHERE
                    deleted = 0 " .
                $union2Filter .
                "order by type, name";
        $conn = $this->getDBConnection();
        $stmt = $conn->prepare($q);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    protected function _generateNewLeaf($node, $index) {
        $returnObj = new \stdClass();
        $returnObj->id = $node['id'];
        $returnObj->type = $node['type'];
        $returnObj->is_bundle_product_c = $node['is_bundle_product_c'];
        $returnObj->is_group_item_c = $node['is_group_item_c'] == 1 ? true : false;
        $returnObj->data = $node['name'];
        $returnObj->state = ($node['type'] == 'product') ? '' : 'closed';
        $returnObj->index = $index;

        return $returnObj;
    }

    /* Default functions overriden... */

    protected function getFilteredTreeData($filter) {
        if (empty($this->groupBundleIdsString)) {
            $this->groupBundleIdsString = "''";
        }

        $filter = "%$filter%";
        $unionFilter1 = "and name like ? ";

        $filter = "%$filter%";
        $unionFilter2 = "and name like ? AND (is_bundle_product_c IS NULL
        OR is_bundle_product_c = '') AND (standalone_item_c IS NULL
        OR standalone_item_c = ''
        OR standalone_item_c = 0) AND id NOT IN ($this->groupBundleIdsString) ";

        return $this->getTreeData($unionFilter1, $unionFilter2, [$filter, $filter]);
    }

    protected function getRootedTreeData($root) {
        $union1Root = '';
        $union2Root = '';

        if (empty($this->groupBundleIdsString)) {
            $this->groupBundleIdsString = "''";
        }

        if ($root == null) {
            $union1Root = "and parent_id is null ";
            $union2Root = "and category_id is null AND (is_bundle_product_c IS NULL
        OR is_bundle_product_c = '') AND (standalone_item_c IS NULL
        OR standalone_item_c = ''
        OR standalone_item_c = 0) AND id NOT IN ($this->groupBundleIdsString) ";
            $params = [];
        } else {
            $union1Root = "and parent_id = ? ";
            $union2Root = "and category_id = ? AND (is_bundle_product_c IS NULL
        OR is_bundle_product_c = '') AND (standalone_item_c IS NULL
        OR standalone_item_c = ''
        OR standalone_item_c = 0) AND id NOT IN ($this->groupBundleIdsString) ";
            $params = [$root, $root];
        }

        return $this->getTreeData($union1Root, $union2Root, $params);
    }

    /**
     * Gets the tree data
     *
     * @param string $union1Filter
     * @param string $union2Filter
     * @param array $params Query parameters
     *
     * @return mixed[][]
     */
    protected function getTreeData($union1Filter, $union2Filter, array $params) {
        $q = "select id, name, 'category' as type, '' AS is_bundle_product_c, '' AS is_group_item_c from product_categories " .
                "where deleted = 0 " .
                $union1Filter .
                "union all " .
                "SELECT 
                    id, name, 'product' AS type, is_bundle_product_c, is_group_item_c
                FROM
                    product_templates
                        LEFT JOIN
                    product_templates_cstm ON product_templates.id = product_templates_cstm.id_c
                WHERE
                    deleted = 0 " .
                $union2Filter .
                "order by type, name";
        $conn = $this->getDBConnection();
        $stmt = $conn->prepare($q);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    protected function getGroupBundleIds() {
        global $db;
        $ids = array();
        $sql = "SELECT DISTINCT
                product_templates_product_templates_1product_templates_idb AS id,
                is_bundle_product_c,
                is_group_item_c
            FROM
                product_templates_product_templates_1_c middle_table
                    JOIN
                product_templates_cstm ON middle_table.product_templates_product_templates_1product_templates_idb = product_templates_cstm.id_c
            WHERE
                deleted = 0
                    AND is_bundle_product_c = 'parent'
                    AND is_group_item_c = 0;";

        $result = $db->query($sql);
        while ($row = $db->fetchByAssoc($result)) {
            array_push($ids, $row['id']);
        }
        return "'" . implode("' , '", $ids) . "'";
    }

}
