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
use Sugarcrm\Sugarcrm\custom\modules\HintNotificationTargets\NotificationTargetTypes;

class SugarFieldHintAccountsetTargets extends \SugarFieldBase
{
    /**
     * {@inheritdoc}
     */
    public function apiFormatField(array &$data, \SugarBean $bean, array $args, $fieldName, $properties, array $fieldList = null, \ServiceBase $service = null)
    {
        // we already have a value
        if (!empty($bean->$fieldName)) {
            $data[$fieldName] = is_array($bean->$fieldName)
                ? $bean->$fieldName
                : json_decode($bean->$fieldName, true);
            return;
        }

        // calculate value
        $types = [];
        $link = $properties['link'];
        if ($bean->load_relationship($link)) {
            $targets = $bean->$link->getBeans();
            $types = $this->getTypesFromTargets($targets);
        }

        $data[$fieldName] = $types;
    }

    /**
     * {@inheritdoc}
     */
    public function apiSave(\SugarBean $bean, array $params, $field, $properties)
    {
        global $current_user;

        // exit early
        if (!isset($params[$field])) {
            return;
        }

        // handle link issues
        $link = $properties['link'];
        if (!$bean->load_relationship($link)) {
            return;
        }

        // get existing targets
        $targets = $bean->$link->getBeans();
        $types = $this->getTypesFromTargets($targets);
        $userId = $bean->assigned_user_id ?: $current_user->id;

        // unlink missing targets
        if ($typesToDelete = array_diff($types, $params[$field])) {
            $targets = $this->filterTargetsByTypes($targets, $typesToDelete);
            foreach ($targets as $target) {
                $bean->$link->delete($bean->id, $target);
            }
        }

        // link new targets
        $typesToAdd = array_diff($params[$field], $types);
        foreach ($typesToAdd as $type) {
            switch ($type) {
                case NotificationTargetTypes::BROWSER_TARGET_TYPE:
                    // we don't have credentials, browser targets will be saved later
                    continue;
                case NotificationTargetTypes::SUGAR_TARGET_TYPE:
                    $targets = $this->getAssignedTargetsByType($userId, $type);
                    $bean->$link->add($targets ?: \HintNotificationTarget::activateSugarTarget($userId));
                    break;
                case NotificationTargetTypes::EMAIL_IMMEDIATE_TARGET_TYPE:
                case NotificationTargetTypes::EMAIL_DAILY_TARGET_TYPE:
                case NotificationTargetTypes::EMAIL_WEEKLY_TARGET_TYPE:
                    $targets = $this->getAssignedTargetsByType($userId, $type);
                    $bean->$link->add($targets ?: \HintNotificationTarget::activateEmailTarget($userId, $type));
                    break;
            }
        }

        // resave browser targets as this type can be added separately
        if (in_array(NotificationTargetTypes::BROWSER_TARGET_TYPE, $params[$field], true)) {
            $targets = $this->getAssignedTargetsByType($userId, NotificationTargetTypes::BROWSER_TARGET_TYPE);
            $bean->$link->add($targets);
        }

        // sugar internals expect object or something convertable to string
        $bean->$field = json_encode($params[$field]);
    }

    /**
     * Validates submitted data
     * @param SugarBean $bean
     * @param array $params
     * @param string $field
     * @param array $properties
     * @return boolean
     */
    public function apiValidate(\SugarBean $bean, array $params, $field, $properties)
    {
        $types = is_array($params[$field]) ? $params[$field] : [$params[$field]];

        return !array_diff($types, NotificationTargetTypes::getAllTypes());
    }

    /**
     * {@inheritDoc}
     */
    public function addFieldToQuery($field, array &$fields)
    {
        // this one should be empty as we don't want anything to be added to the query
    }

    /**
     * Get unique values from given field
     *
     * @param \HintNotificationTarget[] $targets
     * @param $field
     * @return array
     */
    private function getTypesFromTargets(array $targets)
    {
        $types = [];
        if (!$targets) {
            return $types;
        }

        foreach ($targets as $target) {
            array_push($types, $target->type);
        }

        return array_values(array_unique($types));
    }

    /**
     * Filter targets by types
     *
     * @param \HintNotificationTarget[] $targets
     * @param array $types
     * @return array
     */
    private function filterTargetsByTypes(array $targets, array $types)
    {
        $filtered = [];
        foreach ($targets as $target) {
            if (in_array($target->type, $types)) {
                $filtered[] = $target;
            }
        }

        return $filtered;
    }

    /**
     * Get assigned targets by type
     *
     * @param string $userId
     * @param string $type
     * @return \SugarBean[]
     * @throws \SugarQueryException
     */
    private function getAssignedTargetsByType($userId, $type)
    {
        $seed = \BeanFactory::newBean('HintNotificationTargets');

        $query = new \SugarQuery();
        $query->from($seed)
            ->where()
            ->equals('assigned_user_id', $userId)
            ->equals('type', $type);

        return $seed->fetchFromQuery($query, ['id']);
    }
}
