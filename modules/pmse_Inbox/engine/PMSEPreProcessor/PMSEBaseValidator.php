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
use Sugarcrm\Sugarcrm\ProcessManager\Registry;

/**
 * Description of PMSEBaseValidator
 *
 */
class PMSEBaseValidator
{
    /**
     * The PMSEEvaluator object
     * @var PMSEEvaluator
     */
    protected $evaluator;

    /**
     * The validation level
     * @var Integer
     */
    protected $level;

    /**
     * The PMSELogger object
     * @var PMSELogger
     */
    protected $logger;

    /**
     * The name of the validator utilizing the internal cache
     * @var string
     */
    protected $validatorName;

    /**
     * Change operators, needed to determine whether to skip termination on new
     * records
     * @var array
     */
    private $changesValues = [
        'changes',
        'changes_from',
        'changes_to',
    ];

    /**
     *
     * @return PMSEEvaluator
     * @codeCoverageIgnore
     */
    public function getEvaluator()
    {
        if (empty($this->evaluator)) {
            $this->evaluator = ProcessManager\Factory::getPMSEObject('PMSEEvaluator');
        }

        return $this->evaluator;
    }

    /**
     *
     * @return Integer
     * @codeCoverageIgnore
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     *
     * @return PMSELogger
     * @codeCoverageIgnore
     */
    public function getLogger()
    {
        if (empty($this->logger)) {
            $this->logger = PMSELogger::getInstance();
        }

        return $this->logger;
    }

    /**
     *
     * @param PMSEEvaluator $evaluator
     * @codeCoverageIgnore
     */
    public function setEvaluator($evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     *
     * @param Integer $level
     * @codeCoverageIgnore
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     *
     * @param PMSELogger $logger
     * @codeCoverageIgnore
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * Gets the simplified name of the validator class to use as the cache index
     * @return String
     */
    protected function getValidatorName()
    {
        if (!isset($this->validatorName)) {
            preg_match('#PMSE(.*)Validator#', get_class($this), $m);
            $this->validatorName = $m[1];
        }

        return $this->validatorName;
    }

    /**
     * Gets the cache key to use when caching things internally
     * @return string
     */
    protected function getCacheKey($add = '')
    {
        $key = 'process-validators-' . $this->getValidatorName();
        if ($add) {
            $key .= '-' . $add;
        }

        return $key;
    }

    /**
     * Gets the registry object
     * @return ProcessManager\Registry
     */
    protected function getRegistry()
    {
        return Registry\Registry::getInstance();
    }

    /**
     * Checks to see if there is a cache value for the index
     * @param string $index The portion of the cache key to use to store
     * @return boolean
     */
    public function hasCacheValue($index)
    {
        // Get the registry object
        $registry = $this->getRegistry();

        // Get the index we want
        $index = $this->getCacheKey($index);

        // Return what we know
        return $registry->has($index);
    }

    /**
     * Gets a value from the cache if it is exists
     * @param string $index The portion of the cache key to use to store
     * @return mixed
     */
    public function getCacheValue($index)
    {
        // Get the registry object
        $registry = $this->getRegistry();

        // Get the index we are in search of
        $index = $this->getCacheKey($index);

        // Send back what we know
        return $registry->get($index);
    }

    /**
     * Adds a cache value into the registry for this object
     * @param string $index The cache index to use
     * @param mixed $value The value to cache
     */
    public function addCacheValue($index, $value)
    {
        // We need the registry object for two reasons...
        $registry = $this->getRegistry();

        // One is to store the value
        $index = $this->getCacheKey($index);
        $registry->set($index, $value);

        // The other is to store the caches keys for this object
        $key = $this->getCacheKey();
        $registry->append($key, $index);
    }

    /**
     * Clears the caches that were set on this object
     */
    public function clearCache()
    {
        // We need the registry object for two reasons once more...
        $registry = $this->getRegistry();

        // One is to get the keys that were cached here...
        $validatorKey = $this->getCacheKey();
        $keys = $registry->get($validatorKey, []);

        $keys = is_array($keys) ? $keys : [$keys];

        // The other is to be able to loop and drop
        foreach ($keys as $key) {
            $registry->drop($key);
        }

        // And finally, we need to drop our validator key
        $registry->drop($validatorKey);
    }

    /**
     * Checks if the current field object is a changes/to/from operation
     * @param  stdClass $field The field criteria object
     * @return boolean
     */
    public function isChangeOperation(stdClass $field)
    {
        return isset($field->expOperator) && in_array($field->expOperator, $this->changesValues);
    }

    /**
     * Gets a JSON decode data set from an encoded string
     * @param string $criteria JSON criteria string
     * @return mixed
     */
    public function getDecodedCriteria(string $criteria)
    {
        return json_decode(html_entity_decode($criteria));
    }

    /**
     * Takes in an expression and returns a JSON encoded version of it
     * @param mixed $data Data to be JSON encoded
     * @return string
     */
    public function getEncodedCriteria($data) : string
    {
        return json_encode($data);
    }

    /**
     * Takes in the criteria JSON, decodes it, checks whether we are in an update
     * and sets a property on the TERMINATE criteria token to that affect
     * @param string $criteria The JSON encoded criteria token string
     * @param array $args The request arguments
     * @return string
     */
    public function validateUpdateState(string $criteria, array $args = []) : string
    {
        // Need to check the isUpdate flag that is set by the after_save hook
        // changes/to/from operations should not be evaluated for new records
        if (empty($args['isUpdate'])) {
            return $criteria;
        }

        $expression = $this->getDecodedCriteria($criteria);
        foreach ($expression as $k => $field) {
            if ($this->isChangeOperation($field)) {
                $expression[$k]->isUpdate = true;
            }
        }

        return $this->getEncodedCriteria($expression);
    }

    /**
     * Determines if the expression is for an Any or All type related evaluation
     * @param string $criteria JSON criteria string
     * @return boolean
     */
    public function hasAnyOrAllTypeOperation(string $criteria)
    {
        $expressions = $this->getDecodedCriteria($criteria);

        // An empty expression can't be any or all
        if (empty($expressions)) {
            return false;
        }

        foreach ($expressions as $expression) {
            if (!empty($expression->expRel) && in_array($expression->expRel, ['Any', 'All'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Updates evaluation criteria so that parsers can do their thing later on
     * @param array $flowData The current flow data set
     * @param PMSERequest $request The request object
     * @param array $props Additional flow data properties to update
     * @return array
     */
    protected function updateRelateCriteria(array $flowData, PMSERequest $request, array $props = [])
    {
        // We will always need evn_criteria for this operation. Other validators
        // might need additional properties to be handled, like in the case of
        // Terminates, which also need pro_terminate_variables handled. But those
        // validators can choose which, if any, additional properties to handle.
        $props = array_merge(['evn_criteria'], $props);

        // Make sure that all data on the flow is set as needed
        $flowData = $this->ensureFlowDataHasTargetBeanData($flowData, $request->getBean());

        foreach ($props as $prop) {
            $expressions = $this->getDecodedCriteria(trim($flowData[$prop]));
            foreach ($expressions as $key => $expression) {
                if (!empty($expression->expRel) && in_array($expression->expRel, ['Any', 'All'])) {
                    $expressions[$key]->expBeanModule = $flowData['cas_sugar_module'];
                    $expressions[$key]->expBeanId = $flowData['cas_sugar_object_id'];
                    $expressions[$key]->expLinkName = $expression->expModule;
                }
            }

            $flowData[$prop] = $this->getEncodedCriteria($expressions);
        }

        $request->setFlowData($flowData);
        return $flowData;
    }

    /**
     * Ensures that necessary data about the parent record is in the flow data.
     *
     * This is necessary since terminate definitions weren't getting this until
     * it was too late to use the expression.
     * @param array $flowData The flow data to massage if needed
     * @param SugarBean $bean The process bean
     * @return array
     */
    protected function ensureFlowDataHasTargetBeanData(array $flowData, SugarBean $bean)
    {
        if (empty($flowData['cas_sugar_module']) || empty($flowData['cas_sugar_object_id'])) {
            if (!PMSEEngineUtils::isTargetModule($flowData, $bean)) {
                $parent = PMSEEngineUtils::getParentBean($flowData, $bean);
                if ($parent) {
                    $flowData['cas_sugar_module'] = $parent->getModuleName();
                    $flowData['cas_sugar_object_id'] = $parent->id;
                }
            }
        }

        return $flowData;
    }
}
