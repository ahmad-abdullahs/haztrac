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


use Sugarcrm\Sugarcrm\ProcessManager\Registry;

/**
 * Description of PMSEElementValidator
 *
 */
class PMSEElementValidator extends PMSEBaseValidator implements PMSEValidate
{

    /**
     * @var type
     */
    protected $dbHandler;

    /**
     * @var
     */
    protected $sugarQueryObject;

    /**
     * @var
     */
    protected $beanFlow;

    /**
     * Process states used in determining validity of existing processes
     * @var array
     */
    protected $states = [
        // Open states have a number of values. For example,
        // Completed means it can start again
        'open' => [
            'IN PROGRESS',
            'COMPLETED',
            'FORM',
            'WAITING',
            'SLEEPING',
            'QUEUE',
            'NEW',
        ],
        'closed' => [
            'TERMINATED',
            'ERROR',
            'CLOSED',
            'DELETED',
            'INVALID',
        ],
    ];

    /**
     * Gets a list of states by type
     * @param string $state `open` or `closed`
     * @return array
     */
    protected function getStates($state)
    {
        return array_key_exists($state, $this->states) ? $this->states[$state] : [];
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getDbHandler()
    {
        return $this->dbHandler;
    }

    /**
     * @return SugarQuery
     */
    public function getSugarQueryObject()
    {
        return new SugarQuery();
    }

    /**
     * @return SugarBean
     */
    public function getBeanFlow()
    {
        if (empty($this->beanFlow)) {
            $this->beanFlow = BeanFactory::newBean('pmse_BpmFlow');
        }

        return $this->beanFlow;
    }

    /**
     *
     * @param type $dbHandler
     * @codeCoverageIgnore
     */
    public function setDbHandler($dbHandler)
    {
        $this->dbHandler = $dbHandler;
    }

    public function setBeanFlow($beanFlow)
    {
        $this->beanFlow = $beanFlow;
    }

    /**
     * Sets the SugarObject onto this object
     *
     * NOTE: THIS METHOD IS DEPRECATED AS OF 7.9.1.0 AND WILL BE REMOVED IN A
     * FUTURE RELEASE
     *
     * @param $sugarQueryObject
     */
    public function setSugarQueryObject($sugarQueryObject)
    {
        $msg = sprintf(
            '%s::%s is deprecated and will be removed in a future release.',
            __CLASS__,
            __METHOD__
        );
        LoggerManager::getLogger()->deprecated($msg);
        $this->sugarQueryObject = $sugarQueryObject;
    }

    /**
     *
     * @param PMSERequest $request
     * @param type $flowData
     * @return PMSERequest
     */
    public function validateRequest(PMSERequest $request)
    {
        // This should be done right away
        $bean = $request->getBean();
        if (empty($bean)) {
            $request->invalidate();
            return $request;
        }

        $flowData = $request->getFlowData();
        $request->setExternalAction($this->processExternalAction($flowData));
        $request->setCreateThread($this->processCreateThread($flowData));

        //Evaluate parent bean
        if (!PMSEEngineUtils::isTargetModule($flowData, $bean)) {
            $parentBean = PMSEEngineUtils::getParentBean($flowData, $bean);
            if (empty($parentBean) || !is_object($parentBean)) {
                $request->invalidate();
                return $request;
            }
        }

        // If this is a start event or intermediate event, handle that
        if ($flowData['evn_type'] === 'START' || $flowData['evn_type'] === 'INTERMEDIATE') {
            // Get our type string
            $type = ucfirst(strtolower($flowData['evn_type']));

            // Get the method name that we will run
            $method = 'validate' . $type . 'Event';

            // Log the method to be run
            $this->getLogger()->info("Validate $type Event.");

            // Run the method
            $this->{$method}($bean, $flowData, $request);
        }

        return $request;
    }

    /**
     *
     * @param type $flowData
     * @return string
     */
    public function identifyElementStatus($flowData)
    {
        $result = '';
        if (isset($flowData['cas_id']) && isset($flowData['cas_index'])) {
            $result = 'RUNNING';
        } else {
            $result = 'NEW';
        }
        return $result;
    }

    /**
     * @param $flowData
     * @return string
     */
    public function identifyEventAction($flowData)
    {
        $str = 'EVALUATE_%s_MODULE';
        $type = PMSEEngineUtils::isTargetModuleNotProcessModule($flowData) ? 'RELATED' : 'MAIN';
        return sprintf($str, $type);
    }

    /**
     *
     * @param type $flowData
     * @return boolean
     */
    public function processExternalAction($flowData)
    {
        if ($this->identifyElementStatus($flowData) == 'RUNNING' && $flowData['evn_type'] == 'INTERMEDIATE') {
            return $this->identifyEventAction($flowData);
        } else {
            return $this->identifyElementStatus($flowData);
        }
    }

    /**
     *
     * @param type $flowData
     * @return boolean
     */
    public function processCreateThread($flowData)
    {
        if ($this->identifyElementStatus($flowData) == 'NEW') {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param type $bean
     * @return type
     * @codeCoverageIgnore
     */
    public function isNewRecord($bean)
    {
        return empty($bean->fetched_row['id']);
    }

    /**
     *
     * @param type $bean
     * @param type $flowData
     * @return boolean
     */
    public function isCaseDuplicated($bean, $flowData, $processFinished = false)
    {
        $q = $this->getSugarQueryObject();
        $q->select()->fieldRaw('NULL');
        $q->from($this->getBeanFlow(), array('add_deleted' => true));
        $q->where()
            ->equals('cas_sugar_object_id', $bean->id)
            ->equals('cas_sugar_module', $bean->module_name)
            ->equals('pro_id', $flowData['pro_id']);

        if ($processFinished) {
            $q->where()
                ->in('cas_flow_status', $this->getStates('open'));
        } else {
            $q->where()
                ->equals('cas_index', 1);
        }

        $result = $q->getOne();

        if ($result !== false) {
            if (!$processFinished) {
                $this->getLogger()->debug("Start Event {$bean->id} already exists");
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if the user updated the bean from PMSE_Inbox
     *
     * @param type $bean
     * @return boolean
     */
    public function isPMSEEdit($bean)
    {
        if (isset($_REQUEST['moduleName']) && isModuleBWC($_REQUEST['moduleName'])) {
            $url = $_REQUEST['module'];
        } else {
            // In most cases __sugar_url will be set, but if it isn't, handle it
            $url = isset($_REQUEST['__sugar_url']) ? $_REQUEST['__sugar_url'] : '';
        }

        if (strpos($url, 'pmse') === false) {
            return false;
        } else {
            $this->getLogger()->debug("Start Event {$bean->id} can not be triggered by PMSE modules.");
            return true;
        }
    }

    /**
     *
     * @param type $bean
     * @param type $flowData
     * @return boolean
     */
    public function validateStartEvent($bean, $flowData, $request)
    {
        if (!$this->isPMSEEdit($bean)) {
            $isNewRecord = $this->isNewRecord($bean);
            switch ($flowData['evn_params']) {
                case 'new':
                    if ($isNewRecord && !$this->isCaseDuplicated($bean, $flowData)) {
                        $request->validate();
                    } else {
                        $request->invalidate();
                    }
                    break;
                case 'updated':
                    if (!$isNewRecord && !$this->isCaseDuplicated($bean, $flowData)) {
                        $request->validate();
                    } else {
                        $request->invalidate();
                    }
                    break;
                case 'allupdates':
                    if (!$isNewRecord && !$this->isCaseDuplicated($bean, $flowData, true)) {
                        $request->validate();
                    } else {
                        $request->invalidate();
                    }
                    break;
                default:
                    $request->invalidate();
                    break;
            }
        } else {
            $request->invalidate();
        }
    }

    /**
     *
     * @param type $bean
     * @param type $flowData
     * @param type $request
     * @return type
     * @codeCoverageIgnore
     */
    public function validateIntermediateEvent($bean, $flowData, $request)
    {
        $request->validate();
        return $request;
    }

}
