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
 * Description of PMSEEndSendMessageEvent
 *
 */
class PMSEEndSendMessageEvent extends PMSEEndEvent
{
    /**
     *
     * @var type
     */
    protected $logger;

    /**
     *
     * @var type
     */
    protected $definitionBean;

    /**
     * @codeCoverageIgnore
     * @deprecated since version 8.2.0
     */
    public function __construct()
    {
        $msg = 'The %s method will be removed in a future release and should no longer be used';
        LoggerManager::getLogger()->deprecated(sprintf($msg, __METHOD__));

        $this->definitionBean = BeanFactory::newBean('pmse_BpmEventDefinition');
        parent::__construct();

    }

    /**
     * @deprecated since version 8.2.0
     * @param $id
     * @return array
     * @codeCoverageIgnore
     */
    public function retrieveDefinitionData($id)
    {
        $msg = 'The %s method will be removed in a future release and should no longer be used';
        LoggerManager::getLogger()->deprecated(sprintf($msg, __METHOD__));

        $this->definitionBean->retrieve($id);
        return ($this->definitionBean->toArray());
    }

    /**
     * This method prepares the response of the current element based on the
     * $bean object and the $flowData, an external action such as
     * ROUTE or ADHOC_REASSIGN could be also processed.
     *
     * This method probably should be override for each new element, but it's
     * not mandatory. However the response structure always must pass using
     * the 'prepareResponse' Method.
     *
     * As defined in the example:
     *
     * $response['route_action'] = 'ROUTE'; //The action that should process the Router
     * $response['flow_action'] = 'CREATE'; //The record action that should process the router
     * $response['flow_data'] = $flowData; //The current flowData
     * $response['flow_filters'] = array('first_id', 'second_id'); //This attribute is used to filter the execution of the following elements
     * $response['flow_id'] = $flowData['id']; // The flowData id if present
     *
     *
     * @param type $flowData
     * @param type $bean
     * @param type $externalAction
     * @return type
     */
    public function run($flowData, $bean = null, $externalAction = '', $arguments = array())
    {
        $this->emailHandler->queueEmail($flowData);

        // since all the actions from now on are exactly the same as the PMSEEndEvent
        // run method we just call the parent implementation
        return parent::run($flowData, $bean, $externalAction, $arguments);
    }

}
