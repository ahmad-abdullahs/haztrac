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
 * Validates a PMSERequest to determine if it is valid for terminating a process
 */
class PMSETerminateValidator extends PMSEBaseValidator implements PMSEValidate
{
    /**
     * Validates the process request. In all case this will return a validated PMSERequest
     * except in the case of the request having no bean.
     * @param PMSERequest $request
     * @return \PMSERequest
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
        if ($flowData['evn_id'] == 'TERMINATE') {
            $paramsRelated = $this->validateParamsRelated($bean, $flowData);

            // If there is a need to update the relate criteria, do that here
            if (!empty($paramsRelated['updateRelateCriteria'])) {
                $flowData = $this->updateRelateCriteria($flowData, $request, ['pro_terminate_variables']);
                unset($paramsRelated['updateRelateCriteria']);
            }

            $this->validateExpression($bean, $flowData, $request, $paramsRelated);
        }
        return $request;
    }

    /**
     * Validates the criteria expression. As this is the Terminate validator it
     * will only mark the request as needing to terminate when criteria is met.
     * @param SugarBean $bean
     * @param array $flowData
     * @param PMSERequest $request
     * @param array $paramsRelated
     * @return PMSERequest
     */
    public function validateExpression($bean, $flowData, $request, $paramsRelated = array())
    {
        // Start with trimming our criteria for evaluation
        $criteria = trim($flowData['evn_criteria']);

        // If the expression evaluates to terminate, handle that
        $valid = $criteria !== '' && $criteria !== '[]';
        if ($valid) {
            // Certain expressions are only applied when this is an update request
            $criteria = $this->validateUpdateState($criteria, $request->getArguments());
            if ($this->getEvaluator()->evaluateExpression($criteria, $bean, $paramsRelated)) {
                $request->setResult('TERMINATE_CASE');
            }
        }

        // Used for logging
        $condition = $this->getEvaluator()->condition();
        $this->getLogger()->debug("Eval: $condition returned " . ($request->isValid()));

        return $request;
    }

    /**
     *
     * @param type $bean
     * @param type $flowData
     * @param type $externalAction
     * @return array
     */
    public function validateParamsRelated($bean, $flowData)
    {
        $paramsRelated = array();
        if (!PMSEEngineUtils::isTargetModule($flowData, $bean)) {
            if ($this->hasAnyOrAllTypeOperation(trim($flowData['pro_terminate_variables']))) {
                $paramsRelated['updateRelateCriteria'] = true;
            } else {
                $paramsRelated = array(
                    'replace_fields' => array(
                        $flowData['rel_element_relationship'] => $flowData['rel_element_module'],
                    ),
                );
            }
        }

        $this->getLogger()->debug("Parameters related returned :" . print_r($paramsRelated, true));
        return $paramsRelated;
    }
}
