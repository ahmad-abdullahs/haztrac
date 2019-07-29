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

class ActivityErasure
{
    const ERASED_LABEL = 'LBL_VALUE_ERASED';

    protected $referencedActivities = array();
    protected $entityNames = array();
    protected $changedNames = array();
    protected $erasedFields = array();
    protected $lastActivityUpdate = array();
    protected $activitiesUpdated = 0;
    protected $commentsUpdated = 0;
    protected $activityIdsProcessed = array();

    /**
     * Find and erase all activities record fields containing data that has since been erased as a result of the Data
     * Privacy records whose ids are supplied.
     *
     * @param array $dataPrivacyIds Array of DataPrivacy ids to pe processed.
     * @return array Erasure statistics and data, including the erased field info, lastActivity processed, and stats on
     * the number of DataPrivacy records processed and number of Activities and Comments records updated.
     */
    public function process($dataPrivacyIds = array())
    {
        $this->activitiesUpdated = 0;
        $this->commentsUpdated = 0;

        // Load the DataPrivacy records from the dataPrivacyIds array and set up the erased field information for each
        // object being processed
        $dpRecordsProcessed = $this->initialize($dataPrivacyIds);
        if ($dpRecordsProcessed > 0) {
            // Scan and fix up erased name references in the comments table to one of the modules being processed
            $this->processComments();

            // Scan and fix up data changes or name usage for erased fields
            $this->processModuleActivities();

            // Scan and fix up any other erased name references in activities table
            $this->processUnreferencedActivities();
        }

        return array(
            'dpRecordsProcessed' => $dpRecordsProcessed,
            'activitiesUpdated' => $this->activitiesUpdated,
            'commentsUpdated' => $this->commentsUpdated,
            'erasedFields' => $this->erasedFields,
            'entityNames' => $this->entityNames,
            'changedNames' => $this->changedNames,
            'lastActivityUpdate' => $this->lastActivityUpdate,
        );
    }

    /**
     * Scan and fix up erased name references in the comments table to one of the modules being processed
     */
    protected function processComments()
    {
        $this->referencedActivities = array();
        if (!empty($this->erasedFields)) {
            $sql = '';
            $params = array();
            foreach ($this->erasedFields as $module => $erasedObjects) {
                if (!empty($erasedObjects)) {
                    foreach ($erasedObjects as $objectId => $objectFields) {
                        if (empty($sql)) {
                            $sql = 'SELECT id, parent_id, date_modified, data FROM comments WHERE (';
                        } else {
                            $sql .= ' OR (';
                        }
                        $params[] = "%@[{$module}:{$objectId}:%";
                        $sql .= 'data LIKE ?)';
                    }
                }
            }

            if (!empty($sql)) {
                $sql .= ' ORDER BY date_modified';

                $GLOBALS['log']->debug("[processComments] SQL: {$sql}");
                $GLOBALS['log']->debug('PARAMS: ' . print_r($params, true));

                $conn = $GLOBALS['db']->getConnection();
                $stmt = $conn->executeQuery($sql, $params);
                while ($row = $stmt->fetch()) {
                    $GLOBALS['log']->debug("COMMENT-ID: {$row['id']} ACTIVITY-ID: {$row['parent_id']}");
                    $activityId = $row['parent_id'];
                    $commentData = $row['data'];
                    $references = $this->getReferences($commentData, '@[', ']');

                    $updateFrom = array();
                    $updateTo = array();
                    $updateModules = array();
                    foreach ($references as $reference) {
                        list($module, $moduleId, $name) = explode(':', $reference);
                        if (isset($this->changedNames[$module][$moduleId])) {
                            $name = trim($name);
                            if (!$this->isErased($name) && $name !== $this->changedNames[$module][$moduleId]) {
                                $this->entityNames[$name] = true;
                                $updateModules["{$module}:{$moduleId}"] = true;
                                $updateFrom[] = "@[{$reference}]";
                                $updateTo[] = "@[{$module}:{$moduleId}:{$this->changedNames[$module][$moduleId]}]";
                            }

                            if (!isset($this->referencedActivities[$activityId])) {
                                $this->referencedActivities[$activityId] = array();
                            }
                            $this->referencedActivities[$activityId][] = array(
                                'commentId' => $row['id'],
                                'module' => $module,
                                'moduleId' => $moduleId,
                                'reference' => $reference,
                            );
                        }
                    }

                    if (!empty($updateFrom)) {
                        $this->updateCommentData($row['id'], $updateModules, $updateFrom, $updateTo, $commentData);
                    }
                }
            }
        }
    }

    /**
     * Scan and fix up data changes or name usage for erased fields
     */
    protected function processModuleActivities()
    {
        $sql = '';
        $params = array();
        $activityParentIdLists = $this->getActivityParentIdLists();
        if (!empty($activityParentIdLists)) {
            $sql = 'SELECT * from activities';
            $first = true;
            foreach ($activityParentIdLists as $module => $idList) {
                if ($first) {
                    $sql .= ' WHERE (';
                    $first = false;
                } else {
                    $sql .= ' OR (';
                }
                $params[] = $module;
                $sql .= "parent_type = ? AND parent_id IN ({$idList}))";
            }
        }

        $activityIdList = $this->getReferencedActivityIdList();
        if (!empty($activityIdList)) {
            if (empty($sql)) {
                $sql = 'SELECT * from activities WHERE (';
            } else {
                $sql .= ' OR (';
            }
            $sql .= "id IN ({$activityIdList}))";
        }

        if (!empty($sql)) {
            $sql .= ' ORDER BY date_entered';

            $GLOBALS['log']->debug("[processModuleActivities] SQL: {$sql}");
            $GLOBALS['log']->debug('PARAMS: ' . print_r($params, true));

            $conn = $GLOBALS['db']->getConnection();
            $stmt = $conn->executeQuery($sql, $params);
            while ($row = $stmt->fetch()) {
                $GLOBALS['log']->debug("ACTIVITY-ID: {$row['id']} ACTIVITY-TYPE: {$row['activity_type']}");
                $this->updateActivityData($row);
            }
        }
    }

    /**
     * Scan and fix up any other Activity records containing name occurrences for names that have been erased as part
     * the DataPrivacy Erasure records(s) being processed. Such references can exist for certain activity types, and
     * because there are no other references to these activities, a general scan is required.
     */
    protected function processUnreferencedActivities()
    {
        if (!empty($this->entityNames)) {
            $sql = '';
            $params = array();
            foreach ($this->entityNames as $name => $bool) {
                if ($sql === '') {
                    $sql = 'SELECT * from activities WHERE (';
                } else {
                    $sql .= ' OR ';
                }
                $params[] = "%{$name}%";
                $sql .= 'data LIKE ?';
            }

            if (!empty($sql)) {
                $sql .= ') ORDER BY date_entered';

                $GLOBALS['log']->debug("[processUnreferencedActivities] SQL: {$sql}");
                $GLOBALS['log']->debug('PARAMS: ' . print_r($params, true));

                $conn = $GLOBALS['db']->getConnection();
                $stmt = $conn->executeQuery($sql, $params);
                while ($row = $stmt->fetch()) {
                    $GLOBALS['log']->debug("ACTIVITY-ID: {$row['id']} ACTIVITY-TYPE: {$row['activity_type']}");
                    $this->updateActivityData($row);
                }
            }
        }
    }

    /**
     * Update comments and remove any explicit names that have been erased as a part of the DataPrivacy records being
     * processed.
     *
     * @param string $id
     * @param array $updateModules
     * @param array $updateFrom
     * @param array $updateTo
     * @param string $commentData
     */
    protected function updateCommentData($id, $updateModules, $updateFrom, $updateTo, $commentData)
    {
        $cdata = json_decode(html_entity_decode($commentData), true);
        if (isset($cdata['value'])) {
            $cdata['value'] = str_replace($updateFrom, $updateTo, $cdata['value']);
        }

        if (!empty($cdata['tags'])) {
            $i = 0;
            foreach ($cdata['tags'] as $tag) {
                $module = "{$tag['module']}:{$tag['id']}";
                if (isset($updateModules[$module])) {
                    $tag['name'] = $this->changedNames[$tag['module']][$tag['id']];
                    $cdata['tags'][$i] = $tag;
                }
                $i++;
            }
        }

        $newCommentData = json_encode($cdata);
        if ($newCommentData != $commentData) {
            $sql = 'UPDATE comments SET data = ? WHERE id = ?';
            $conn = $GLOBALS['db']->getConnection();
            $conn->executeUpdate($sql, [$newCommentData, $id]);
            $this->commentsUpdated++;
        }
    }

    /**
     * Process and fixup the activity data and last_comment json structures in the activity. The Activity Record is then
     * updated in the database if either or both of the data or last_comment fields change as a result of processing.
     *
     * @param array $activity
     */
    protected function updateActivityData($activity)
    {
        if (!isset($this->activityIdsProcessed[$activity['id']])) {
            $this->activityIdsProcessed[$activity['id']] = true;

            $parentType = empty($activity['parent_type']) ? '' : $activity['parent_type'];
            $parentId = empty($activity['parent_id']) ? '' : $activity['parent_id'];
            if (!empty($activity['data'])) {
                $activity['data'] = html_entity_decode($activity['data']);
            };
            if (!empty($activity['last_comment'])) {
                $activity['last_comment'] = html_entity_decode($activity['last_comment']);
            }

            $activityData = empty($activity['data']) ? '' : $activity['data'];
            $activityComment = empty($activity['last_comment']) ? '' : $activity['last_comment'];

            $this->processActivityData($activity);

            $newActivityData = empty($activity['data']) ? '' : $activity['data'];
            $newActivityComment = empty($activity['last_comment']) ? '' : $activity['last_comment'];

            if ($newActivityData !== $activityData || $newActivityComment !== $activityComment) {
                $sql = 'UPDATE activities SET data = ?, last_comment = ? WHERE id = ?';
                $conn = $GLOBALS['db']->getConnection();
                $conn->executeUpdate($sql, [$newActivityData, $newActivityComment, $activity['id']]);
                $this->activitiesUpdated++;
                if (empty($this->lastActivityUpdate[$parentType][$parentId]) ||
                    (substr_count($newActivityData, static::ERASED_LABEL) >
                        substr_count($this->lastActivityUpdate[$parentType][$parentId], static::ERASED_LABEL))
                ) {
                    $this->lastActivityUpdate[$parentType][$parentId] = $newActivityData;
                }
            }
        }
    }

    /**
     * Process and fixup the activity data and last_comment json structures in the activity. All erased data will be
     * replaced with a Label string indicating that the data value has been erased.
     *
     * @param array $activity Passed as Reference: Data field is updated if erasure changes made.
     */
    protected function processActivityData(&$activity)
    {
        $parentType = empty($activity['parent_type']) ? '' : $activity['parent_type'];
        $parentId = empty($activity['parent_id']) ? '' : $activity['parent_id'];

        $references = array();
        if (!empty($activity['data'])) {
            $references = array_merge($references, $this->getReferences($activity['data'], '@[', ']'));
        };

        if (!empty($activity['last_comment'])) {
            $references = array_merge($references, $this->getReferences($activity['last_comment'], '@[', ']'));
        }

        $from = array();
        $updateFrom = array();
        $updateTo = array();
        if (!empty($references)) {
            foreach ($references as $reference) {
                list($module, $moduleId, $name) = explode(':', $reference);
                if (isset($this->changedNames[$module][$moduleId])) {
                    $name = trim($name);
                    if (!$this->isErased($name) && $name !== $this->changedNames[$module][$moduleId]) {
                        $this->entityNames[$name] = true;

                        if (!isset($from[$reference])) {
                            $from[$reference] = true;
                            $updateFrom[] = "@[{$reference}]";
                            $updateTo[] = "@[{$module}:{$moduleId}:{$this->changedNames[$module][$moduleId]}]";
                        }
                    }
                }
            }

            if (!empty($updateFrom)) {
                if (!empty($activity['data'])) {
                    $activity['data'] = str_replace($updateFrom, $updateTo, $activity['data']);
                }
                if (!empty($activity['last_comment'])) {
                    $activity['last_comment'] = str_replace($updateFrom, $updateTo, $activity['last_comment']);
                }
            }
        }

        $data = array();
        if (!empty($activity['data'])) {
            $data = json_decode($activity['data'], true);
        }

        $comment = array();
        if (!empty($activity['last_comment'])) {
            $comment = json_decode($activity['last_comment'], true);
        }

        if (!empty($data['changes'])) {
            if (!empty($this->erasedFields[$parentType][$parentId])) {
                $objectFields = $this->erasedFields[$parentType][$parentId];
                foreach ($objectFields as $fieldName) {
                    if (!isset($data['changes'][$fieldName])) {
                        continue;
                    }
                    if ($fieldName === 'email' && isset($data['changes']['email'])) {
                        if (!$this->isErased($data['changes']['email']['before'])) {
                            if (is_array($data['changes']['email']['before'])) {
                                foreach ($data['changes']['email']['before'] as $index => $email) {
                                    if (isset($data['changes']['email']['before'][$index]['email_address'])) {
                                        $data['changes']['email']['before'][$index]['email_address'] =
                                            static::ERASED_LABEL;
                                    }
                                    if (isset($data['changes']['email']['before'][$index]['email_address_caps'])) {
                                        $data['changes']['email']['before'][$index]['email_address_caps'] =
                                            static::ERASED_LABEL;
                                    }
                                }
                            } else {
                                $data['changes']['email']['before'] = static::ERASED_LABEL;
                            }
                        }
                        if (!$this->isErased($data['changes']['email']['after'])) {
                            if (is_array($data['changes']['email']['after'])) {
                                foreach ($data['changes']['email']['after'] as $index => $email) {
                                    if (isset($data['changes']['email']['after'][$index]['email_address'])) {
                                        $data['changes']['email']['after'][$index]['email_address'] =
                                            static::ERASED_LABEL;
                                    }
                                    if (isset($data['changes']['email']['after'][$index]['email_address_caps'])) {
                                        $data['changes']['email']['after'][$index]['email_address_caps'] =
                                            static::ERASED_LABEL;
                                    }
                                }
                            } else {
                                $data['changes']['email']['after'] = static::ERASED_LABEL;
                            }
                        }
                    } else {
                        $data['changes'][$fieldName]['before'] = static::ERASED_LABEL;
                        $data['changes'][$fieldName]['after'] = static::ERASED_LABEL;
                    }
                }
            }
        }

        if (!empty($data['tags'])) {
            $j = 0;
            foreach ($data['tags'] as $tag) {
                if (!empty($tag['module']) && !empty(!empty($tag['id']))) {
                    $tagModule = $tag['module'];
                    $tagId = $tag['id'];
                    if (isset($this->changedNames[$tagModule][$tagId])) {
                        $data['tags'][$j]['name'] = $this->changedNames[$tagModule][$tagId];
                    }
                }
                $j++;
            }
        }

        if (!empty($comment['data']['tags'])) {
            $j = 0;
            foreach ($comment['data']['tags'] as $tag) {
                if (!empty($tag['module']) && !empty(!empty($tag['id']))) {
                    $tagModule = $tag['module'];
                    $tagId = $tag['id'];
                    if (isset($this->changedNames[$tagModule][$tagId])) {
                        $comment['data']['tags'][$j]['name'] = $this->changedNames[$tagModule][$tagId];
                    }
                }
                $j++;
            }
        }

        if (isset($this->changedNames[$parentType][$parentId]) && !$this->isErased($data['object']['name'])) {
            $this->entityNames[$data['object']['name']] = true;
            $data['object']['name'] = $this->changedNames[$parentType][$parentId];
        }

        if ($activity['activity_type'] === 'link' || $activity['activity_type'] === 'unlink') {
            foreach (['object', 'subject'] as $element) {
                if (!empty($data[$element]['module']) && !empty($data[$element]['id'])) {
                    $module = $data[$element]['module'];
                    $moduleId = $data[$element]['id'];
                    if (isset($this->changedNames[$module][$moduleId]) && !empty($data[$element]['name'])) {
                        $name = trim($data[$element]['name']);
                        if (!$this->isErased($name) && $name !== $this->changedNames[$module][$moduleId]) {
                            $this->entityNames[$name] = true;
                        }
                        $data[$element]['name'] = $this->changedNames[$module][$moduleId];
                    }
                }
            }
        }

        $this->applyDataExceptions($activity, $data, $comment);

        if (!empty($activity['data'])) {
            $activity['data'] = json_encode($data);
        }
        if (!empty($activity['last_comment'])) {
            $activity['last_comment'] = json_encode($comment);
        }
    }

    /**
     * Helper function to build up the SQL id list for the activity references found
     *
     * @return string
     */
    protected function getReferencedActivityIdList()
    {
        $activityIdList = '';
        $objectIds = array();
        foreach ($this->referencedActivities as $activityId => $referenceData) {
            $objectIds[$activityId] = $GLOBALS['db']->quoted($activityId);
        }
        if (!empty($objectIds)) {
            $activityIdList = implode(',', array_values($objectIds));
        }
        return $activityIdList;
    }

    /**
     * Helper function to return the array of SQL id lists for the module type we are processing
     *
     * @return array
     */
    protected function getActivityParentIdLists()
    {
        $moduleIdLists = array();
        foreach ($this->erasedFields as $module => $fields) {
            if (!empty($fields) && !empty(array_keys($fields))) {
                $objectIds = array();
                foreach (array_keys($fields) as $objectId) {
                    $objectIds[$objectId] = $GLOBALS['db']->quoted($objectId);
                }
                $moduleIdLists[$module] = implode(',', array_values($objectIds));
            }
        }
        return $moduleIdLists;
    }

    /**
     * Load any DataPrivacy records from the dataPrivacyIds array and set up the erased fields for each object being
     * processed.
     *
     * @param array $dataPrivacyIds Array of DataPrivacy ids to pe processed.
     * @return int The number of Data Privacy records to be processed.
     */
    protected function initialize(array $dataPrivacyIds)
    {
        $this->erasedFields = array();
        $this->changedNames = array();
        $dpRecordsProcessed = 0;
        foreach ($dataPrivacyIds as $dataPrivacyId) {
            $dataPrivacy = BeanFactory::retrieveBean('DataPrivacy', $dataPrivacyId);
            if (empty($dataPrivacy)) {
                $msg = "ActivityErasure: failed loading DataPrivacy record with id: {$dataPrivacyId}";
                $GLOBALS['log']->error($msg);
                continue;
            }

            if (empty($dataPrivacy->fields_to_erase)) {
                $msg = "ActivityErasure: DataPrivacy Record has No Erased Fields Defined with id: {$dataPrivacyId}";
                $GLOBALS['log']->error($msg);
                continue;
            }

            $dpRecordsProcessed++;
            $fieldsToErase = json_decode($dataPrivacy->fields_to_erase, true);
            foreach ($fieldsToErase as $linkName => $data) {
                if (!$dataPrivacy->load_relationship($linkName)) {
                    continue;
                }

                $module = $dataPrivacy->{$linkName}->getRelatedModuleName();

                foreach ($data as $moduleId => $fields) {
                    $isEmail = false;
                    foreach ($fields as $index => $field) {
                        if (is_array($field)) {
                            foreach ($field as $fName => $fValue) {
                                if ($fName === 'field_name' && $fValue === 'email') {
                                    $isEmail = true;
                                    break;
                                }
                            }
                            unset($fields[$index]);
                        }
                    }
                    if ($isEmail) {
                        $fields[] = 'email';
                    }
                    $this->erasedFields[$module][$moduleId] = $fields;

                    // Capture the updated name, which might be LBL_VALUE_ERASED.
                    $bean = BeanFactory::retrieveBean($module, $moduleId, ['erased_fields' => true]);

                    if ($bean) {
                        $attrs = ActivityQueueManager::getBeanAttributes($bean);
                        $this->changedNames[$module][$moduleId] = $attrs['name'];
                    }
                }
            }
        }
        return $dpRecordsProcessed;
    }

    /**
     * Return a list of all record references in the supplied string
     *
     * @param string $str
     * @param string $startDelimiter
     * @param string $endDelimiter
     * @return array
     */
    protected function getReferences($str, $startDelimiter, $endDelimiter)
    {
        $contents = array();
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = $contentStart = $contentEnd = 0;
        while (($contentStart = strpos($str, $startDelimiter, $startFrom)) !== false) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($str, $endDelimiter, $contentStart);
            if ($contentEnd === false) {
                break;
            }
            $contents[] = trim(substr($str, $contentStart, $contentEnd - $contentStart));
            $startFrom = $contentEnd + $endDelimiterLength;
        }
        return $contents;
    }

    /**
     * Final chance to inspect an activity's data or last_comment fields to determine whether there is any exceptions or
     * changes that need to be applied before the update phase of this activity completes.
     *
     * @param array $activity
     * @param array $data current changes to the activity data field
     * @param array $comment current changes to the activity last_comment field
     */
    protected function applyDataExceptions($activity, &$data, &$comment)
    {
        if ($activity['parent_type'] === 'Products' &&
            $activity['activity_type'] === 'update' &&
            isset($data['changes']['contact_id'])
        ) {
            if (isset($this->entityNames[$data['changes']['contact_id']['before']])) {
                $data['changes']['contact_id']['before'] = static::ERASED_LABEL;
            }

            if (isset($this->entityNames[$data['changes']['contact_id']['after']])) {
                $data['changes']['contact_id']['after'] = static::ERASED_LABEL;
            }
        }
    }

    /**
     * Determine whether the string supplied is an erased value
     *
     * @param string $s
     * @return bool
     */
    protected function isErased($s)
    {
        return ($s === '' || $s === static::ERASED_LABEL);
    }
}
