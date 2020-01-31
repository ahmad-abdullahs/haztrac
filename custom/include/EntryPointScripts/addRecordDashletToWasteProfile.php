<?php

// http://localhost/haztrac/#bwc/index.php?entryPoint=addRecordDashletToWasteProfile

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');
require_once('include/entryPoint.php');

class addRecordDashletToWasteProfile {

    public function __construct() {
        $this->addDashlet();
    }

    private function addDashlet() {
        global $db;
        $selectAllUsers = "SELECT 
                        id
                    FROM
                        users
                    WHERE
                        deleted = 0;";
        $result = $db->query($selectAllUsers);

        while ($row = $db->fetchByAssoc($result)) {
            $privateTeamId = User::getPrivateTeam($row['id']);
            if ($privateTeamId) {
                $newID = create_guid();
                $newID2 = create_guid();
                $newID3 = create_guid();
                $updateQuery1 = "INSERT INTO `dashboards` (`id`, `name`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `deleted`, `dashboard_module`, 
                    `view_name`, `metadata`, `default_dashboard`, `team_id`, `team_set_id`, `assigned_user_id`) 
                    VALUES ('{$newID}', 'Waste Profile Dashlet', '2020-01-31 22:33:50', '2020-01-31 22:33:50', '{$row['id']}', '{$row['id']}', '0', "
                        . "'WPM_Waste_Profile_Module', 'record', '{\"components\":[{\"rows\":[[{\"width\":12,\"view\":{\"url\":\"https:\\/\\/docs.google.com\\/viewer?url=https%3A%2F%2Fsugar.haztrac.com%2F%3FentryPoint%3DWPM_Waste_Profile_Preview%26report_id%3D{id}&embedded=true&chrome=false&dov=1\",\"limit\":\"10\",\"label\":\"Waste Profile Preview\",\"type\":\"webpage-with-fields\",\"module\":null}}]],\"width\":12}]}', "
                        . "'0', '{$privateTeamId}', 
                    '{$privateTeamId}', 
                    '{$row['id']}');";
                $updateQuery2 = "INSERT INTO `subscriptions` (`id`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `deleted`, `parent_type`, `parent_id`) VALUES "
                        . "('{$newID2}', '2020-01-31 22:33:50', '2020-01-31 22:33:50', '{$row['id']}', '{$row['id']}', '0', 'Dashboards', '{$newID}');";
                $updateQuery3 = "INSERT INTO `sugarfavorites` (`id`, `date_entered`, `date_modified`, `modified_user_id`, `created_by`, `deleted`, `module`, `record_id`, `assigned_user_id`) VALUES "
                        . "('{$newID3}', '2020-01-31 22:33:50', '2020-01-31 22:33:50', '{$row['id']}', '{$row['id']}', '0', 'Dashboards', '{$newID}', '{$row['id']}');";

                $db->query($updateQuery1);
                $db->query($updateQuery2);
                $db->query($updateQuery3);
                echo $updateQuery1 . "</br>";
                echo $updateQuery2 . "</br>";
                echo $updateQuery3 . "</br>";
            }
        }
    }

}

$obj = new addRecordDashletToWasteProfile();
echo('Script excuted successfully');
