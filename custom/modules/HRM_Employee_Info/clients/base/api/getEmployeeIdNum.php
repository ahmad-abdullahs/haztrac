<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class getEmployeeIdNum extends SugarApi {

    public function registerApiRest() {
        return array(
            //GET
            'getEmployeeIdNum' => array(
                //request type
                'reqType' => 'GET',
                //set authentication
                'noLoginRequired' => false,
                //endpoint path
                'path' => array('getEmployeeIdNum'),
                //endpoint variables
                // 'pathVars' => array(''),
                //method to call
                'method' => 'getEmployeeIdNum',
                //short help string to be displayed in the help documentation
                'shortHelp' => 'Jump Max Employee Id Number by 26',
            ),
        );
    }

    /**
     * Method to be used for my MyEndpoint/GetExample endpoint
     */
    public function getEmployeeIdNum() {
        return $this->jumpEmployeeIdNumBy26();
    }

    function jumpEmployeeIdNumBy26() {
        $employeeIdNum = '4760';
        // Check if its new record
        $sql = <<<SQL
                    SELECT 
                        MAX(employee_id_num) AS employee_id_num
                    FROM
                        hrm_employee_info;
SQL;
        global $db;

        $res = $db->query($sql);
        if ($res->num_rows > 0) {
            $row = $db->fetchByAssoc($res);
            if (!empty($row['employee_id_num'])) {
                $employeeIdNum = $row['employee_id_num'] + 26;
            }
        }

        return $employeeIdNum;
    }

}
