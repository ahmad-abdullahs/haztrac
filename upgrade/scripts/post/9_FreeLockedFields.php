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

use Sugarcrm\Sugarcrm\ProcessManager;

/**
 * Due to a bug, we can have records that are no longer in a process but still have their
 * fields locked. This will unlock those fields.
 */
class SugarUpgradeFreeLockedFields extends UpgradeScript
{
    /**
     * {@inheritdoc }
     * @var int
     */
    public $order = 9000;

    /**
     * {@inheritdoc }
     * @var int
     */
    public $type = self::UPGRADE_DB;

    /**
     * @var PMSECaseFlowHandler
     */
    private $caseFlowHandler;

    /**
     * Delete any locked fields for records no longer in a process
     */
    protected function freeLockedFields()
    {
        $db = DBManagerFactory::getInstance();
        $conn = $db->getConnection();

        $sql = "SELECT pd_id, bean_id, bean_module FROM locked_field_bean_rel WHERE deleted = 0";
        $stmt = $conn->executeQuery($sql);

        $this->caseFlowHandler = ProcessManager\Factory::getPMSEObject('PMSECaseFlowHandler');

        while ($row = $stmt->fetch()) {
            $beanId = $row['bean_id'];
            $pdId = $row['pd_id'];
            $module = $row['bean_module'];
            // Check if that bean is involved in a process
            if ($this->isBeanOutOfProcess($beanId, $pdId)) {
                $this->deleteLockedFieldRelationship($module, $beanId, $pdId);
                $this->log('Deleted locked field relationship for bean: ' . $beanId . ' and PD: ' . $pdId);
            }
        }
    }

    /**
     * Checks if a record is currently not involved in a process for the given PD
     *
     * @param $beanId
     * @param $proId
     * @return bool
     * @throws SugarQueryException
     */
    protected function isBeanOutOfProcess($beanId, $proId)
    {
        $inbox = BeanFactory::newBean('pmse_Inbox');

        $query = new SugarQuery();
        $query->from($inbox, ['alias' => 'i']);

        $query->joinTable('pmse_bpm_flow', ['alias' => 'f'])
            ->on()->equalsField('f.cas_id', 'i.cas_id');

        $query->where()->queryAnd()
            ->equals('i.cas_status', 'IN PROGRESS')
            ->equals('f.cas_sugar_object_id', $beanId)
            ->equals('i.pro_id', $proId);

        $query->limit(1);
        $row = $query->execute();

        return empty($row[0]);
    }

    /**
     * Delete the locked fields relationship
     *
     * @param $module
     * @param $beanId
     * @param $proId
     */
    protected function deleteLockedFieldRelationship($module, $beanId, $proId)
    {
        // Enforce strict retrieve of the bean so you can verify module AND record
        $bean = BeanFactory::retrieveBean($module, $beanId);

        // If there is a bean, use it
        if ($bean) {
            $this->caseFlowHandler->deleteLockFieldsFromBean($bean, $proId);
        } else {
            // Log that there was no record found. This realistically shouldn't happen,
            // but in case it does, handle it.
            $this->log("Free Locked Fields could not find $module record $beanId");
        }
    }

    /**
     * {@inheritdoc }
     */
    public function run()
    {
        // the bug was introduced in 8.1.0 so only run the upgrader if we are coming from 8.1.x
        if (version_compare($this->from_version, '8.2.0', '<') &&
            version_compare($this->from_version, '8.1.0', '>=') &&
            version_compare($this->to_version, '8.2.0', '>=')) {
            $this->freeLockedFields();
        }
    }
}
