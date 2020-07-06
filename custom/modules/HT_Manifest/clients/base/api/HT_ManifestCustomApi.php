<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');

class HT_ManifestCustomApi extends SugarApi {

    public function registerApiRest() {
        return array(
            'isDuplicateManifestNumber' => array(
                'reqType' => 'GET',
                'path' => array('HT_Manifest', '?', 'isDuplicateManifestNumber'),
                'pathVars' => array('module', 'manifest_no_actual_c', 'action'),
                'min_version' => 11.5,
                'method' => 'isDuplicateManifestNumberMethod',
            ),
        );
    }

    /**
     * Check if the manifest number is duplicate or not
     * 
     * @param ServiceBase $api
     * @param array $args
     * @return bool
     * @throws SugarApiExceptionMissingParameter
     */
    public function isDuplicateManifestNumberMethod(ServiceBase $api, array $args) {
        global $db;
        $this->requireArgs($args, array('module'));

        try {
            if (!empty($args['manifest_no_actual_c'])) {
                $manifestNumber = $args['manifest_no_actual_c'];
                $data = array();
                $sql = "SELECT 
                        id
                    FROM
                        ht_manifest
                            LEFT JOIN
                        ht_manifest_cstm ON ht_manifest.id = ht_manifest_cstm.id_c
                    WHERE
                        manifest_no_actual_c = '{$manifestNumber}'
                            AND deleted = 0;";
                $result = $db->query($sql);
                while ($row = $db->fetchByAssoc($result)) {
                    array_push($data, $row['id']);
                }

                return $data;
            }
        } catch (SugarQueryException $e) {
            // Swallow the exception.
            $GLOBALS['log']->warn(__METHOD__ . ': ' . $e->getMessage());
        }
    }

}
