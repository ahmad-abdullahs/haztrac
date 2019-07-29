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
 * Class that analyzes the data type of a bean
 * getting the value of this field according to the data type
 * if there is a date data type used the classes TimeDate()
 *
 */
class PMSEFieldParser extends PMSEAbstractDataParser implements PMSEDataParserInterface
{
    /**
     * Object Bean
     * @var object
     */
    private $evaluatedBean;

    /**
     * Related bean to the evaluated bean
     * @deprecated since version 7.11.0.0
     * @var SugarBean
     */
    protected $relatedBean;

    /**
     * Related beans to the evaluated bean
     * @var array
     */
    protected $relatedBeans;

    /**
     * Lists modules Bean
     * @var array
     */
    private $beanList;
    private $currentUser;
    private $pmseRelatedModule;

    /**
     * List of token parse methods
     * @var array
     */
    public $tokenMethods = array(
        'current_user' => 'parseCurrentUser',
        'supervisor' => 'parseSupervisor',
        'owner' => 'parseOwner',
    );

    /**
     * Getting the PMSERelatedModule object
     * @return object
     */
    private function getRelatedModuleObject()
    {
        if (!isset($this->pmseRelatedModule)) {
            $this->pmseRelatedModule = ProcessManager\Factory::getPMSEObject('PMSERelatedModule');
        }
        return $this->pmseRelatedModule;
    }

    /**
     * gets the bean list
     * @return array
     * @codeCoverageIgnore
     */
    public function getBeanList()
    {
        return $this->beanList;
    }

    /**
     * sets the bean list
     * @param array $beanList
     */
    public function setBeanList($beanList)
    {
        $this->beanList = $beanList;
    }

    /**
     * gets the bean
     * @return object
     * @codeCoverageIgnore
     */
    public function getEvaluatedBean()
    {
        return $this->evaluatedBean;
    }

    /**
     * sets the bean
     * @param object $evaluatedBean
     */
    public function setEvaluatedBean($evaluatedBean)
    {
        $this->evaluatedBean = $evaluatedBean;
        $this->relatedBean = null;
        $this->relatedBeans = array();
    }

    /**
     * sets the current user
     * @param object $currentUser
     * @codeCoverageIgnore
     */
    public function setCurrentUser($currentUser)
    {
        $this->currentUser = $currentUser;
    }

    /**
     * get the class TimeDate()
     * @return object
     * @codeCoverageIgnore
     */
    public function getTimeDate()
    {
        if (!isset($this->timeDate) || empty($this->timeDate)) {
            $this->timeDate = new TimeDate();
        }
        return $this->timeDate;
    }

    /**
     * set the class TimeDate()
     * @param object $timeDate
     * @codeCoverageIgnore
     */
    public function setTimeDate($timeDate)
    {
        $this->timeDate = $timeDate;
    }

    /**
     * Parser token incorporando el tipo de dato, en el caso de tipo de dato date, datetime se usa la clase TimeDate
     * @global object $current_user cuurrent user
     * @param object $criteriaToken token to be parsed
     * @param array $params
     * @return object
     */
    public function parseCriteriaToken($criteriaToken, $params = array())
    {
        if ($criteriaToken->expType === 'VARIABLE') {
            $criteriaToken = $this->parseVariable($criteriaToken, $params);
        } else {
            $criteriaToken = $this->parseCriteria($criteriaToken, $params);
        }
        return $criteriaToken;
    }

    /**
     * parse the token ussing the old function
     * @global object $current_user
     * @param type $criteriaToken
     * @param type $params
     * @return type
     */
    public function parseCriteria($criteriaToken, $params = array())
    {
        $tokenArray = array($criteriaToken->expModule, $criteriaToken->expField, $criteriaToken->expOperator);
        $criteriaToken->currentValue = $this->parseTokenValue($tokenArray, $params);
        $criteriaToken->expValue = $this->setExpValueFromCriteria($criteriaToken);

        // Use the working bean now to get what we are after
        if (isset($criteriaToken->expField)) {
            $fieldType = $this->evaluatedBean->field_defs[$criteriaToken->expField]['type'];
            if ($fieldType == 'date') {
                $criteriaToken->expSubtype = 'date';
            } elseif ($fieldType == 'datetime' || $fieldType =='datetimecombo') {
                $criteriaToken->expSubtype = 'date';
            } elseif ($fieldType == 'currency') {
                $criteriaToken->expValue = $this->setCurrentValueIfCurrency($criteriaToken);
            }
        }

        return $criteriaToken;
    }

    /**
     * Parse the token using a new function to parse variable tokens
     * @global object $current_user
     * @param type $criteriaToken
     * @param type $params
     * @return type
     */
    public function parseVariable($criteriaToken, $params = array())
    {
        $tokenArray = array($criteriaToken->expModule, $criteriaToken->expValue, $criteriaToken->expOperator);
        $tokenValue = $this->parseTokenValue($tokenArray);
        $tokenValue = $tokenValue[0];
        if ($criteriaToken->expSubtype == 'Currency') {
            $value = json_decode($tokenValue);
            // in some use cases, value can be numeric instead of array
            // so need to handle currency_id and amount accordingly
            if (!empty($value["currency_id"])) {
                $criteriaToken->expField = $value["currency_id"];
            } elseif (isset($this->evaluatedBean->currency_id)) {
                $criteriaToken->expField = $this->evaluatedBean->currency_id;
            }
            if (!empty($value["amount"])) {
                $criteriaToken->currentValue = $value["amount"];
            } else {
                $criteriaToken->currentValue = $tokenValue;
            }
        } else {
            $criteriaToken->currentValue = $tokenValue;
        }
        if (isset($criteriaToken->expField)) {
            if (isset($this->evaluatedBean->field_defs[$criteriaToken->expField])) {
                if ($this->evaluatedBean->field_defs[$criteriaToken->expField]['type'] == 'date') {
                    $criteriaToken->expSubtype = 'date';
                } elseif ($this->evaluatedBean->field_defs[$criteriaToken->expField]['type'] == 'datetime'
                    || $this->evaluatedBean->field_defs[$criteriaToken->expField]['type'] == 'datetimecombo'
                ) {
                    $criteriaToken->expSubtype = 'date';
                }
            }
        }
        $criteriaToken->expValue = $criteriaToken->currentValue;
        return $criteriaToken;
    }

    /**
     * Gets the related bean to the evaluated bean, if one is set
     * @param string $link The link name to get the related bean from
     * @return array SugarBeans
     */
    public function getRelatedBean($link)
    {
        if (empty($this->relatedBeans[$link])) {
            // There are times when the process bean is not the bean needed for
            // evaluations
            $bean = $this->getBeanForEvaluation();

            // Get and set the related bean since we don't have it yet
            $this->relatedBeans[$link] = $this->getRelatedModuleObject()->getRelatedModuleBeans($bean, $link);
        }

        return $this->relatedBeans[$link];
    }


    /**
     * parser a token for a field element, is this: bool or custom fields
     * @param string $token field contains a parser
     * @return array of field values, in the case of a currency type it returns a serialized array with the amount and
     * the currency id.
     */
    public function parseTokenValue($token, $params = [])
    {
        $values = array();

        if (!empty($token)) {
            // This logic is a fairly bad assumption, but works in most cases. The
            // assumption is that a link name won't be in the bean list so try to load
            // a related bean instead.
            if (!isset($this->beanList[$token[0]]) && empty($params['useEvaluatedBean'])) {
                // Get the related bean instead
                $beans = $this->getRelatedBean($token[0]);
            } else {
                $beans = array($this->evaluatedBean);
            }

            if (is_array($beans)) {
                $field = $token[1];
                foreach ($beans as $bean) {
                    if (isset($token[2]) && in_array($token[2], ['changes', 'changes_from', 'changes_to'])) {
                        // Get the bean data changes
                        $bdc = empty($bean->dataChanges) ? [] : $bean->dataChanges;

                        // Get the registry key of changs for this bean
                        $key = 'bean-data-changes-' . $bean->id;

                        // Get the registry data changes and merge the bean data changes into it
                        $rdc = Registry\Registry::getInstance()->get($key, []);
                        $dataChanges = array_merge($rdc, $bdc);

                        // Handle what is changing and to which
                        if (isset($dataChanges[$field])) {
                            if ($token[2] == 'changes_from') {
                                $value = $dataChanges[$field]['before'];
                            } else {
                                $value = $dataChanges[$field]['after'];
                            }
                        } else {
                            // used as a flag that means no changes
                            $value = null;
                        }
                    } else {
                        $value = $this->getRelatedModuleObject()->getFieldValue($bean, $field);
                    }
                    $values[] = $value;
                }
            }
        }

        return $values;
    }

    /**
     * converts a string {:: future :: Users :: id ::} to an array ('future','Users','id')
     * @param string $token @example {:: future :: Users :: id ::}
     * @return array
     */
    public function decomposeToken($token)
    {
        $response = array();
        $tokenArray = explode('::', $token);
        foreach ($tokenArray as $key => $value) {
            if ($value != '{' && $value != '}' && !empty($value)) {
                $response[] = $value;
            }
        }
        return $response;
    }

    /**
     * Checks to see if there is a parser method for this token
     *
     * @param object $token Criteria token object
     * @return boolean True if there is a method for this token criteria
     */
    public function hasParseMethod($token)
    {
        return !empty($token->expValue) && !is_array($token->expValue)
               && isset($this->tokenMethods[$token->expValue])
               && method_exists($this, $this->tokenMethods[$token->expValue]);
    }

    /**
     * Parses the token value for a User field element
     * @param object $token field contains a parser
     * @return string field value
     */
    public function setExpValueFromCriteria($token)
    {
        if ($this->hasParseMethod($token)) {
            $method = $this->tokenMethods[$token->expValue];
            return $this::$method($token);
        }

        return $token->expValue;
    }

    /**
     * Parse the token value for Currency
     * @param $token
     * @return float
     */
    public function setCurrentValueIfCurrency($token)
    {
        $expCurrency = empty($token->expCurrency) ? '-99' : $token->expCurrency;
        $defCurrency = SugarCurrency::getCurrency($this->evaluatedBean);
        $amount = SugarCurrency::convertAmount((float)$token->expValue, $expCurrency, $defCurrency->id);
        return $amount;
    }

    /**
     * Gets current user id or criteria token expected value
     *
     * @param object $token field contains a parser
     * @return string field value
     */
    public function parseCurrentUser($token)
    {
        return !empty($this->currentUser->id) ?
            $this->currentUser->id : $token->expValue;
    }

    /**
     * Gets assigned user id or criteria token expected value
     *
     * @param object $token field contains a parser
     * @return string field value
     */
    public function parseOwner($token)
    {
        return !empty($this->evaluatedBean->assigned_user_id) ?
            $this->evaluatedBean->assigned_user_id : $token->expValue;
    }

    /**
     * Gets reports to id or criteria token expected value
     *
     * @param object $token field contains a parser
     * @return string field value
     */
    public function parseSupervisor($token)
    {
        return !empty($this->currentUser->reports_to_id) ?
            $this->currentUser->reports_to_id : $token->expValue;
    }

    /**
     * Gets the proper bean to work on for evaluation
     * @return SugarBean
     */
    protected function getBeanForEvaluation()
    {
        // This is simply a shortcut to make lines shorter
        $ct = $this->criteriaToken;

        // These items are set onto the token in {{@see PMSEBaseValidator::updateRelateCriteria}}
        if (!empty($ct->expBeanModule) && !empty($ct->expBeanId)) {
            if (isset($ct->expLinkName) && $ct->expLinkName === $ct->expModule) {
                $bean = BeanFactory::retrieveBean($ct->expBeanModule, $ct->expBeanId);
                if ($bean) {
                    return $bean;
                }
            }
        }

        return $this->evaluatedBean;
    }
}
