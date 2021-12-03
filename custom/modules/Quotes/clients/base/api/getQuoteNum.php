<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class getQuoteNum extends SugarApi {

    public function registerApiRest() {
        return array(
            //GET
            'getQuoteNum' => array(
                //request type
                'reqType' => 'GET',
                //set authentication
                'noLoginRequired' => false,
                //endpoint path
                'path' => array('getQuoteNum'),
                //endpoint variables
                // 'pathVars' => array(''),
                //method to call
                'method' => 'getQuoteNum',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Jump Max Quote Number by 26',
            ),
        );
    }

    /**
     * Method to be used for my MyEndpoint/GetExample endpoint
     */
    public function getQuoteNum() {
        return $this->jumpgetQuoteNumBy26();
    }

    function jumpgetQuoteNumBy26() {
        // Check if its new record
        $quote_num = 'QT-14950';

        $sql = <<<SQL
                    SELECT 
                        MAX(quote_num) AS quote_num
                    FROM
                        quotes;
SQL;
        global $db;

        $res = $db->query($sql);
        if ($res->num_rows > 0) {
            $row = $db->fetchByAssoc($res);
            if (!empty($row['quote_num']) && !is_null($row['quote_num'])) {
                // Get the number out of the string.
                preg_match_all('!\d+!', $row['quote_num'], $matches);
                if (!empty($matches) && is_array($matches[0])) {
                    $quote_num = 'QT-' . ((int) $matches[0][0] + 26);
                }
            }
        }

        return $quote_num;
    }

}
