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

/**
 * The SugarBean for Each commentlog message, should be immutable.
 */
class CommentLog extends Basic
{
    public $module_dir = 'CommentLog';
    public $object_name = 'CommentLog';
    public $module_name = 'CommentLog';
    public $table_name = 'commentlog';
    public $new_schema = true;
    public $importable = true;

    /**
     * The join table used to get the parent record for an entry
     * @var string
     */
    protected $joinTable = 'commentlog_rel';

    /**
     * The column in the join table to match the ID of this entry to in order to
     * find the parent record of this entry
     * @var string
     */
    protected $joinKey = 'commentlog_id';

    /**
     * The list of fields to select when getting the parent record
     * @var array
     */
    protected $parentFields = [
        [
            'field' => 'record_id',
            'alias' => 'record',
        ],
        [
            'field' => 'module',
        ],
    ];

    /**
     * @inheritDoc
     */
    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }

        return false;
    }

    /**
     * Sets the entry of this commentlog message. Shall only be called while creating
     * new commentlog message, not for editing
     * @param string $entry The entry of this commentlog message
     * @modifies $this->entry
     * @effects Sets $this->entry to processed $entry
     */
    public function setEntry(string $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Sets the module of this commentlog message. Shall only be called while creating
     * new commentlog message, not for editing
     * @param string $module The module this commentlog is associated to,
     *                       has to be an existing module
     * @modifies $this->module
     * @effects Set $this->module to $module
     * @return true When $module exists and added to $this->module successfully
     *         Otherwise false.
     */
    public function setModule(string $module)
    {
        if (!is_string(BeanFactory::getBeanClass($module))) {
            return false;
        }

        $this->module = $module;

        return true;
    }

    /**
     * Gets all the commentlog for every record id given
     *
     * @param $focus
     * @param $ids array of record ids
     * @return array
     */
    public function getRelatedModuleRecords($focus, $ids)
    {
        // No ids means nothing to do
        // Not use this in CommentLog module, use only for other modules
        if (empty($ids) || ($focus == null) || ($focus->table_name === 'commentlog')) {
            return array();
        }

        $query = new SugarQuery($this->db);
        $query->from($focus);
        $query->join('commentlog_link');
        $query->select()->fieldRaw('commentlog_id');
        $query->where()->in('record_id', $ids);
        $results = $query->execute();

        $returnArray = array();
        foreach ($results as $result) {
            $returnArray[] = $result['commentlog_id'];
        }

        return $returnArray;
    }

    /**
     * Gets fields for selection from the join table to get a parent record
     * @return array
     */
    private function getParentSelectFields()
    {
        // Build a select field list
        $fields = [];
        foreach ($this->parentFields as $field) {
            $add = $field['field'];
            if (isset($field['alias'])) {
                $add .= ' ' . $field['alias'];
            }

            $fields[] = $add;
        }

        return $fields;
    }

    /**
     * Verifies that the necessary elements of the parent data array are found
     * in an array
     * @param array $row A row of data as an array, typically from a DB result
     * @return boolean
     */
    private function verifyParentData(array $row)
    {
        // If the result to verify is not an array then return false immediately
        if (!is_array($row)) {
            return false;
        }

        // Now loop over the parent fields and if any of them are not in the result
        // return false
        foreach ($this->parentFields as $field) {
            $verify = isset($field['alias']) ? $field['alias'] : $field['field'];
            if (!isset($row[$verify])) {
                return false;
            }
        }

        // Return true as a default after passing through everything else
        return true;
    }

    /**
     * Retrieves the record id and module of the commentlog
     * @return array The id and module of the parent record if connecting parent
     *               record exists, otherwise empty array
     */
    public function getParentRecord()
    {
        $qry = $this->db->getConnection()->createQueryBuilder();
        $qry->select($this->getParentSelectFields())
            ->from($this->joinTable)
            ->where('deleted = 0')
            ->andWhere(
                $qry->expr()->eq(
                    $this->joinKey,
                    $qry->createPositionalParameter($this->id)
                )
            );

        $row = $qry->execute()->fetch();
        return $this->verifyParentData($row) ? $row : [];
    }
}
