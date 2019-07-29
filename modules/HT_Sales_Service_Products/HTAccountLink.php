<?php

class HTAccountLink extends Link2
{
    public function getSubpanelQuery($params = array(), $return_array = false)
    {
        $db = DBManagerFactory::getInstance();
        $result = parent::getSubpanelQuery($params, $return_array);
        if($return_array)
        {
            $result ['join'] .= ' LEFT JOIN ht_ss_quotes ON ht_sales_service_products.quote_id = ht_ss_quotes.id ';
            $result['where'] .= ' AND (ht_ss_quotes.quote_stage IS NULL OR ht_ss_quotes.quote_stage NOT IN (' . $db->quoted('Closed Lost') . ',' . $db->quoted('Closed Dead') . ')) AND ( ht_ss_quotes.deleted = 0 OR ht_ss_quotes.deleted IS NULL )';
            array_push($result['join_tables'], 'ht_ss_quotes');
        }
        return $result;
    }
}