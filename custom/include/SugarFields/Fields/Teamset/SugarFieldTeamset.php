<?php

/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

require_once 'include/SugarFields/Fields/Teamset/SugarFieldTeamset.php';

class CustomSugarFieldTeamset extends SugarFieldTeamset {

    // Here are the functions used by the REST API
    /**
     * This function will pull out the various teams in this teamset and return them in a collection
     *
     * {@inheritDoc}
     */
    public function apiFormatField(array &$data, SugarBean $bean, array $args, $fieldName, $properties, array $fieldList = null, ServiceBase $service = null) {
        $this->ensureApiFormatFieldArguments($fieldList, $service);

        if ($fieldName !== $this->field_name) {
            return;
        }

        $selectedTeamIds = array_map(function ($el) {
            return $el['id'];
        }, TeamSetManager::getTeamsFromSet($bean->acl_team_set_id));

        if (empty($bean->teamList)) {
            $teamList = TeamSetManager::getUnformattedTeamsFromSet($bean->team_set_id);
            if (!is_array($teamList)) {
                // No teams on this bean yet.
                $teamList = array();
            }
        } else {
            $teamList = $bean->teamList;
        }

        foreach ($teamList as $idx => $team) {
            // Check team name as well for cases in which team_name is selected
            // but team_id is not
            // ++ Custom code is added because when the team field is added in the point-of-attention-list.php
            // dashlet list, it was not correctly pointing the team as primary.
            // So this additional name_2 check was added.
            if ($team['id'] == $bean->team_id || $team['name'] == $bean->team_name) {
                $teamList[$idx]['primary'] = true;
            } else if (($team['name'] . " " . $team['name_2']) == $bean->team_name) {
                $teamList[$idx]['primary'] = true;
                $teamList[$idx]['name'] = $team['name'] . " " . $team['name_2'];
            } else {
                $teamList[$idx]['primary'] = false;
            }
            $teamList[$idx]['selected'] = in_array($team['id'], $selectedTeamIds) ? true : false;
        }
        $data[$fieldName] = $teamList;

        // These are just confusing to people on the other side of the API
        unset($data['acl_team_set_id']);
        unset($data['team_set_id']);
        unset($data['team_id']);
    }

}
