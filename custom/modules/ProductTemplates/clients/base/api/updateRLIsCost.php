<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class updateRLIsCost extends SugarApi {

    public function registerApiRest() {
        return array(
            'updateRLIsCost' => array(
                //request type
                'reqType' => 'GET',
                //endpoint path
                'path' => array('ProductTemplates', '?', '?', 'updateRLIsCost'),
                //endpoint variables
                'pathVars' => array('', 'vendorPartNum', 'costPrice', ''),
                //method to call
                'method' => 'updateRLIsCostMethod',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Update customer RLIS cost which has same vendor part number.',
            ),
        );
    }

    /**
     * Method to be used for my MyEndpoint/GetExample endpoint
     */
    public function updateRLIsCostMethod(ServiceBase $api, array $args) {
        $vendorPartNum = $args['vendorPartNum'];
        $cost = $args['costPrice'];
        $rliIds = $this->getRLIIds($vendorPartNum);

        foreach ($rliIds as $id) {
            $rliBean = BeanFactory::getBean('RevenueLineItems', $id);
            $rliBean->cost_price = $cost;
            $rliBean->save();
        }
        return count($rliIds) . ' Record(s) Updated.';
    }

    function getRLIIds($vendorPartNum) {
        global $db;
        $rliIds = array();

        $sql = <<<SQL
                    SELECT 
                    id
                FROM
                    revenue_line_items
                        INNER JOIN
                    revenue_line_items_cstm ON id = id_c
                WHERE
                    vendor_part_num = '$vendorPartNum'
                        AND (account_id IS NOT NULL
                        OR account_id != '')
                        AND rli_as_template_c = 1;
SQL;

        $res = $db->query($sql);
        if ($res->num_rows > 0) {
            while ($row = $db->fetchByAssoc($res)) {
                array_push($rliIds, $row['id']);
            }
        }

        return $rliIds;
    }

}
