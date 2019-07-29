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
 * Description of PMSECriteriaEvaluator
 */
class PMSECriteriaEvaluator
{
    protected $expressionEvaluator;

    public function __construct()
    {
        $this->expressionEvaluator = ProcessManager\Factory::getPMSEObject('PMSEExpressionEvaluator');
    }

    public function isCriteriaToken($token)
    {
        $criteriaTypes = array (
            'MODULE',
            'CONTROL',
            'BUSINESS_RULES',
            'USER_ROLE',
            'USER_ADMIN',
            'USER_IDENTITY'
        );

        return in_array($token->expType, $criteriaTypes);
    }

    public function evaluateCriteriaToken($criteriaToken)
    {
        $resultToken = new stdClass();
        $resultToken->expType = 'CONSTANT';
        $operationGroup = 'relation';
        $expSubtype = $this->getSubtype($criteriaToken);
        if (!isset($expSubtype)) {
            $criteriaToken->expSubtype = '';
        }
        if (isset($criteriaToken->expRel)) {
            $resultToken->expValue = false;
            foreach ($criteriaToken->currentValue as $currentValue) {
                $resultToken->expValue = $this->expressionEvaluator->routeFunctionOperator(
                    $operationGroup,
                    $currentValue,
                    $criteriaToken->expOperator,
                    $criteriaToken->expValue,
                    $criteriaToken->expSubtype,
                    !empty($criteriaToken->isUpdate)
                );
                if ($criteriaToken->expRel == 'All') {
                    if (!$resultToken->expValue) {
                        break;
                    }
                } else {
                    if ($resultToken->expValue) {
                        break;
                    }
                }
            }
        } else {
            $resultToken->expValue = $this->expressionEvaluator->routeFunctionOperator(
                $operationGroup,
                $criteriaToken->currentValue[0],
                $criteriaToken->expOperator,
                $criteriaToken->expValue,
                $criteriaToken->expSubtype,
                !empty($criteriaToken->isUpdate)
            );
        }
        $this->expressionEvaluator->processTokenAttributes($resultToken);
        return $resultToken;
    }

    public function evaluateCriteriaTokenList($tokenArray)
    {
        foreach ($tokenArray as $key => $token) {
            if ($this->isCriteriaToken($token)) {
                $tokenArray[$key] = $this->evaluateCriteriaToken($token);
            }
        }
        return $tokenArray;
    }

    /**
     * helper function for test mocks
     * @param stdClass object
     * @return string || null
     */
    public function getSubtype($criteriaToken)
    {
        return PMSEEngineUtils::getExpressionSubtype($criteriaToken);
    }
}
