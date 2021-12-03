<?php

class QuotesHooks {

    function beforeSave($bean, $event, $arguments)
    {
        //$bean->quote_num="QT";
        if (!isset($bean->fetched_row['id'])) {
            // if lat long are not calculated or address changed
            $query="SELECT MAX(quote_num_internal) AS max_n FROM quotes;";
            $max=14950-26;
            $r = $bean->db->query($query);
            while($a = $bean->db->fetchByAssoc($r)) {
                $max=$a['max_n'];
            }
            $max=$max+26;
            $bean->quote_num_internal=$max;
            $bean->quote_num="QT".$max;
        }


    }

}
