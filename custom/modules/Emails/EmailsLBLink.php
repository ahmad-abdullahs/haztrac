<?php

class EmailsLBLink extends Link2
{
    protected $db;

    public function __construct($linkName, $bean, $linkDef = false) {
        $this->focus = $bean;
        $this->name = $linkName;
        $this->db = DBManagerFactory::getInstance();
        if (empty($linkDef)) {
            $this->def = $bean->field_defs[$linkName];
        } else {
            $this->def = $linkDef;
        }
    }

    public function getRelationshipFieldMapping(SugarBean $seed = null) {
        return array();
    }

    public function add($rel_keys, $additional_values = array()) {
        return false;
    }

    public function delete($id, $related_id = '') {
        return false;
    }

    public function loadedSuccesfully() {
        return true;
    }

    public function query($params = array()) {
        unset($params['return_as_array']);
        $query = $this->getQuery($params);
        $result = $this->db->query($query);
        $rows = array();
        while ($row = $this->db->fetchByAssoc($result, false)) {
            $rows[$row['id']] = $row;
        }
        return array("rows" => $rows);
    }

    public function getRelatedModuleName() {
        return 'LR_Lab_Reports';
    }

    public function getRelatedModuleLinkName() {
        return false;
    }

    public function getType() {
        return "many";
    }

    public function getSide() {
        return REL_LHS;
    }

    public function is_self_relationship() {
        return false;
    }

    public function isParentRelationship() {
        return false;
    }

    public function buildJoinSugarQuery($sugar_query, $options = array()) {
        $joinParams = array('joinType' => isset($options['joinType']) ? $options['joinType'] : 'INNER');
        $jta = 'lr_lab_reports';
        if (!empty($options['joinTableAlias'])) {
            $jta = $joinParams['alias'] = $options['joinTableAlias'];
        }

        if (!empty($options['myAlias'])) {
            $fromAlias = $options['myAlias'];
        } else {
            $fromAlias = 'lr_lab_reports';
        }

        if (!empty($options['reverse'])) {
            return $this->joinEmails($sugar_query, $fromAlias, $jta);
        } else {
            $sugar_query->joinTable('lr_lab_reports', $joinParams);
            return $this->joinEmails($sugar_query, $fromAlias, $jta);
        }
    }

    public function getJoin($params = array(), $return_as_array = false) {
        $return_array['join'] = $this->getEmailsJoin($params);

        $join_type = !empty($params['join_type']) ? $params['join_type'] : ' INNER JOIN ';

        if (isset($params['join_table_alias'])) {
            $return_array['join'] = "$join_type lr_lab_reports {$params['join_table_alias']} ON {$params['join_table_alias']}.deleted=0 " .
                 $return_array['join'];
        } else {
            $return_array['join'] = "$join_type lr_lab_reports ON lr_lab_reports.deleted=0 " . $return_array['join'];
        }

        if (!empty($return_as_array) || !empty($params['return_as_array'])) {
            return $return_array;
        } else {
            return $return_array['join'] . $return_array['where'];
        }
    }

    public function getQuery($params = array()) {
        $query_array['select'] = "SELECT DISTINCT lr_lab_reports.* ";
        $query_array['from'] = "FROM lr_lab_reports ";
        $query_array['join'] = $this->getEmailsJoin();

        $deleted = !empty($params['deleted']) ? 1 : 0;
        $query_array['where'] = " WHERE lr_lab_reports.deleted=$deleted ";

        // Add any optional where clause
        if (!empty($params['where'])) {
            $query_array['where'] .= " AND ({$params['where']}) ";
        }

        if (!empty($params['enforce_teams'])) {
            $seed = BeanFactory::newBean($this->getRelatedModuleName());
            $seed->addVisibilityFrom($query_array['join']);
            $seed->addVisibilityWhere($query_array['where']);
        }

        if (!empty($params['return_as_array'])) {
            return $query_array;
        }

        $query = $query_array['select'] . $query_array['from'] . $query_array['join'] .
             $query_array['where'];
        if (!empty($params['orderby'])) {
            $query .= "ORDER BY {$params['orderby']}";
        }
        if (!empty($params['limit']) && $params['limit'] > 0) {
            $offset = isset($params['offset']) ? $params['offset'] : 0;
            $query = $this->db->limitQuery($query, $offset, $params['limit'], false, "", false);
        }
        return $query;
    }

    public function getSubpanelQuery($params = array(), $return_array = false) {
        $query_array['join'] = $this->getEmailsJoin($params);
        $query_array['select'] = "";
        $query_array['from'] = "";
        $query_array['join_tables'] = 'report_ids';

        if (!empty($params['return_as_array'])) {
            $return_array = true;
        }
        if ($return_array) {
            return $query_array;
        }
        return $query_array['join'];
    }

    protected function joinEmails(SugarQuery $query, $fromAlias, $alias) {
        $bean_id = $this->db->quoted($this->focus->id);
        $reportNumber = $this->db->quoted($this->getReportNumber($this->focus->name));

        $table = <<<SQL
                (
                  SELECT
                    {$bean_id} as 'id',
                    id_c as 'report_id'
                  FROM
                    lr_lab_reports_cstm
                  WHERE
                    sample_id_number_c = $reportNumber
                )
SQL;

        $join = $query->joinTable($table, array(
            'alias' => $alias,
        ));
        $join->on()->equalsField($alias . '.report_id', $fromAlias . '.id');

        return $join;
    }

    protected function getEmailsJoin($params = array()) {
        $bean_id = $this->db->quoted($this->focus->id);
        $reportNumber = $this->db->quoted($this->getReportNumber($this->focus->name));

        if (!empty($params['join_table_alias'])) {
            $table_name = $params['join_table_alias'];
        } else {
            $table_name = 'lr_lab_reports';
        }

        return <<<SQL
                INNER JOIN (
                    SELECT
                        {$bean_id} as 'id',
                        id_c as 'report_id'
                      FROM
                        lr_lab_reports_cstm
                      WHERE
                        sample_id_number_c = $reportNumber
                ) report_ids ON {$table_name}.id = report_ids.report_id
SQL;
    }

    private function getReportNumber($emailSubject) {
        global $sugar_config;

        $exMacro = explode('%1', $sugar_config['lab_report_macro']);
        $open = $exMacro[0];
        $close = $exMacro[1];

        if($sub = stristr($emailSubject, $open)) {
            $sub2 = str_replace($open, '', $sub);
            $sub3 = substr($sub2, 0, strpos($sub2, $close));

            if (!empty(trim($sub3))) {
                return $sub3;
            }
        }

        return null;
    }
}
