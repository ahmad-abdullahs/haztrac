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

require_once 'modules/pmse_Inbox/engine/PMSEFieldsUtils.php';

use Sugarcrm\Sugarcrm\ProcessManager;

class PMSEBeanHandler
{
    /**
     * @var PMSELogger
     */
    protected $logger;

    /**
     * @var PMSEEvaluator
     */
    protected $evaluator;

    /**
     * @var PMSERelatedModule
     */
    protected $pmseRelatedModule;

    /**
     * @var PMSEExpressionEvaluator
     */
    protected $expressionEvaluator;

    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->logger = PMSELogger::getInstance();
        $this->evaluator = ProcessManager\Factory::getPMSEObject('PMSEEvaluator');
        $this->pmseRelatedModule = ProcessManager\Factory::getPMSEObject('PMSERelatedModule');
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getEvaluator()
    {
        return $this->evaluator;
    }

    /**
     *
     * @param $evaluator
     * @codeCoverageIgnore
     */
    public function setEvaluator($evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     *
     * @param type $logger
     * @codeCoverageIgnore
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     *
     * @param type $module
     * @param type $id
     * @return type
     * @codeCoverageIgnore
     */
    public function retrieveBean($module, $id = null)
    {
        return BeanFactory::getBean($module, $id);
    }

    /**
     * get the related modules of a determined bean passed as parameter
     * @global type $beanList
     * @global type $beanFiles
     * @global type $db
     * @param type $bean
     * @param type $flowBean
     * @param type $act_field_module
     * @return type
     */
    public function getRelatedModule($bean, $flowBean, $act_field_module)
    {
        global $beanList, $db;
        $moduleName = $flowBean['cas_sugar_module'];
        //$object_id = $flowBean->cas_sugar_object_id;

        $id_mainModule = $bean->id;

        $relatedNew = $this->getRelationshipData($act_field_module, $db);
        $left = $relatedNew['lhs_module'];
        $act_field_module = $related = $relatedNew['rhs_module'];

        if (!isset($beanList[$act_field_module])) {
            $this->logger->error("[][] $act_field_module module is not related to $moduleName, ain't appear in the bean list");
        } else {
            $this->logger->info("[][] $moduleName got a related module named: [$act_field_module]");
//            $moduleClassName = $beanList[$act_field_module];
//            $moduleDir = $beanFiles[$moduleClassName];
            $moduleName = $act_field_module;

            ///relationship
//            $relationship = "Relationship";
//            $RelationshipModuleDir = $beanFiles[$relationship];
//            require_once ($RelationshipModuleDir);
            $beanRelations = $this->retrieveBean("Relationships");
            $relation = $beanRelations->retrieve_by_sides($left, $related, $db);
            $ID_Related = $relation['rhs_key'];
            $this->logger->info("[][] $related $ID_Related field found.");

            // related module ID
//            $classRelatedBean = $beanList[$related];
//            $RelatedModuleDir = $beanFiles[$classRelatedBean];
//            require_once ($RelatedModuleDir);
            $beanRelated = $this->retrieveBean("$related");

            $singleCondition = $ID_Related . "='" . $id_mainModule . "'";
            $list_bean_related = $beanRelated->get_full_list('', $singleCondition);
            $len = sizeof($list_bean_related);
            if (isset($list_bean_related[$len - 1])) {
                $this->logger->info("[][] Getting the last related record of $len records.");
                $beanRelated = $list_bean_related[$len - 1];
            } else {
                $beanRelated->retrieve_by_string_fields(array($ID_Related => $id_mainModule), true);
            }
            if (!isset($beanRelated->id)) {
                $this->logger->info("[][] There is not a data relationship beetween $act_field_module and {$flowBean['cas_sugar_module']}");
                $bean = null;
            } else {
                $bean = $this->retrieveBean("{$related}", $beanRelated->id);
                $this->logger->info("[][] Related $act_field_module loaded using id: $beanRelated->id");
            }
        }
        return $bean;
    }

    /**
     * TODO: this function should move to utilities lib
     * Get the relationship data based on a relationship name.
     * @param string $relationName
     * @return array of fields
     */
    public function getRelationshipData($relationName, $db)
    {
        return SugarRelationshipFactory::getInstance()->getRelationshipDef($relationName);
    }

    /**
     * Merge Bean data into an email template
     * @param type $bean
     * @param type $template
     * @param type $evaluate
     * @return type
     */
    public function mergeBeanInTemplate($bean, $template, $evaluate = false)
    {
        //Parse template and return a string mergin bean fields and the template
        $component_array = $this->parseString($template, $bean->module_dir);
        $parsed_template = $this->mergingTemplate($bean, $template, $component_array, $evaluate);
        return trim($parsed_template);
    }

    /**
     * Gets the PMSERelatedModule object
     * @return PMSERelatedModule
     */
    public function getPMSERelatedModuleObject()
    {
        if ($this->pmseRelatedModule === null) {
            $this->pmseRelatedModule = ProcessManager\Factory::getPMSEObject('PMSERelatedModule');
        }

        return $this->pmseRelatedModule;
    }

    /**
     * Merges parsed placeholders into the email template
     * @param SugarBean|array $bean A collection of beans, or a single bean
     * @param string $template The email template to parse
     * @param array $components The substitutions array
     * @param boolean $evaluate Whether to evaluate or return
     * @return string
     */
    public function mergingTemplate($bean, $template, $components, $evaluate)
    {
        $replace = array();

        // Loop over each of the component elements
        foreach ($components as $module) {
            // Then each component element
            foreach ($module as $field => $data) {
                // This is the default case
                $newBean = $bean;

                // If there is no filter, or if the filter is not a bean...
                if (!isset($data['filter']) || BeanFactory::getBeanClass($data['filter']) === false) {
                    // Needs to be reset each iteration
                    $fetch = null;
                    if (isset($data['type']) && $data['type'] === 'relate') {
                        $fetch = $data['rel_module'];
                    } elseif (isset($data['filter'])) {
                        $fetch = $data['filter'];
                    }

                    // If there is a related record to fetch, fetch it
                    if (!empty($fetch)) {
                        $newBean = $this->getPMSERelatedModuleObject()->getRelatedModule($bean, $fetch);
                    }
                }

                // There are strange cases where bean that was passed in is actually
                // an array of beans, so this needs to handle that
                if (!$newBean instanceof SugarBean) {
                    // Why we even allow an array of beans is beyond me, but it
                    // is what it is, for now
                    $newBean = array_pop($newBean);
                }

                // Set a default value
                $value = null;

                // If we have a bean, work with it
                if ($newBean instanceof SugarBean) {
                    // Now get a value for our field name
                    $fieldName = $data['name'];

                    // Default value is always the bean's current value
                    $value = $newBean->$fieldName;

                    // We'll need these for later
                    $def = $newBean->field_defs[$fieldName];

                    // If we are looking for a "from" value, and we have one...
                    if ($data['value_type'] === 'old' && array_key_exists($fieldName, (array) $newBean->dataChanges)) {
                        $value = $newBean->dataChanges[$fieldName]['before'];
                    } else {
                        // Handle date/datetime, and boolean, field types
                        // to maintain proper UTC values
                        if (in_array($def['type'], ['datetime', 'datetimecombo']) && !empty($newBean->fetched_row[$fieldName])) {
                            $value = $newBean->fetched_row[$fieldName];
                        }
                    }

                    // Handle booleans, but only for non null values
                    if ($def['type'] === 'bool' && $value !== null) {
                        $value = $value == 1;
                    }
                }

                if ($data['value_type'] === 'href_link') {
                    $replace[$data['original']] = bpminbox_get_href($newBean, $fieldName, $value);
                } else {
                    $replace[$data['original']] = $evaluate ?
                        nl2html(bpminbox_get_display_text($newBean, $fieldName, $value)) :
                        bpminbox_get_display_text($newBean, $fieldName, $value);
                }
            }
        }

        // Handle the replacements and send back the parsed template
        return str_replace(
            array_keys($replace),
            array_values($replace),
            $template
        );
    }

    /**
     * Merge determined bean data into an determined text template, this could be
     * an email template, expression template, or another type of text with
     * bean variables in it.
     *
     * @global type $beanList
     * @param type $bean
     * @param type $template
     * @param type $component_array
     * @param type $evaluate
     * @return type
     */
    public function mergeTemplate($bean, $template, $component_array, $evaluate = false)
    {
        global $beanList;
        $replace_array = Array();
        $replace_type_array = array();


        foreach ($component_array as $module_name => $module_array) {
            //base module
            if ($module_name == $bean->module_dir) {
                foreach ($module_array as $field => $field_array) {
                    if ($field_array['value_type'] == 'href_link') {
                        //Create href link to target record
                        $replacement_value = $this->get_href_link($bean);
                    }

                    if ($field_array['value_type'] == 'future') {
                        if ($evaluate) {
                            $replacement_value = bpminbox_check_special_fields($field_array['name'], $bean, false,
                                array());
                        } else {
                            $replacement_value = bpminbox_check_special_fields($field_array['name'], $bean, false,
                                array());
                        }
                    }
                    if ($field_array['value_type'] == 'past') {
                        $replacement_value = bpminbox_check_special_fields($field_array['name'], $bean, true, array());
                    }

                    $replace_type_array[$field_array['original']] = get_bean_field_type($field_array['name'], $bean);
                    $replace_array[$field_array['original']] = implode(', ', unencodeMultienum($replacement_value));
                }
            } else {
                //Confirm this is an actual module in the beanlist
                if (isset($beanList[$module_name]) || isset($bean->field_defs[$module_name])) {
                    ///Build the relationship information using the Relationship handler
                    $rel_handler = $bean->call_relationship_handler("module_dir", true);
                    if (isset($bean->field_defs[$module_name])) {
                        $rel_handler->rel1_relationship_name = $bean->field_defs[$module_name]['relationship'];
                        $rel_module = get_rel_module_name($bean->module_dir, $rel_handler->rel1_relationship_name,
                            $bean->db);
                        $rel_handler->rel1_module = $rel_module;
                        $rel_handler->rel1_bean = get_module_info($rel_module);
                    } else {
                        $rel_handler->process_by_rel_bean($module_name);
                    }

                    foreach ($bean->field_defs as $field => $attribute_array) {
                        if (!empty($attribute_array['relationship']) && $attribute_array['relationship'] == $rel_handler->rel1_relationship_name) {
                            $rel_handler->base_vardef_field = $field;
                            break;
                        }
                    }
                    //obtain the rel_module object
                    $rel_list = $rel_handler->build_related_list("base");
                    if (!empty($rel_list[0])) {
                        $rel_object = $rel_list[0];
                        $rel_module_present = true;
                    } else {
                        $rel_module_present = false;
                    }

                    foreach ($module_array as $field => $field_array) {
                        if ($rel_module_present == true) {
                            if ($field_array['value_type'] == 'href_link') {
                                //Create href link to target record
                                $replacement_value = $this->get_href_link($rel_object);
                            } else {
                                //use future always for rel because fetched should always be the same
                                $replacement_value = bpminbox_check_special_fields($field_array['name'], $rel_object,
                                    false, array());
                            }
                        } else {
                            $replacement_value = "Invalid Value";
                        }
                        $replace_array[$field_array['original']] = implode(', ', unencodeMultienum($replacement_value));
                    }
                }
            }
        }

        foreach ($replace_array as $name => $replacement_value) {
            if ($evaluate) {
                $replacement_value = str_replace("\n", ' ', $replacement_value);
                $type = $replace_type_array[$name]['type'];
                $dbtype = $replace_type_array[$name]['db_type'];
                //TODO evaluate more types even Ids perhaps
                $this->logger->info("Field : $name , type: '$type',  DBtype: '$dbtype'");
                if (($dbtype == 'double' || $dbtype == 'int') && $type != 'currency') {
                    $replacement_value = trim($replacement_value);
                } elseif ($type == 'currency') {
                    //TODO hardcoded . , should use system currency format
                    $replacement_value = str_replace(",", '', $replacement_value);
                    $replacement_value = str_replace(".", ',', $replacement_value);
                    $replacement_value = floatval($replacement_value);
                } else {
                    //here $replacement_value must be datatime, time, string datatype values
                    $replacement_value = "'" . $replacement_value . "'";
                }
            } else {
                $replacement_value = nl2br($replacement_value);
            }
            $template = str_replace($name, $replacement_value, $template);
        }
        return $template;
    }

    /**
     * Executes a cast in order to process the value of a determined expression.
     * @param type $expression
     * @param type $bean
     * @return type
     */
    public function processValueExpression($expression, $bean)
    {
        global $timedate;
        $response = new stdClass();
        $dataEval = array();
        foreach ($expression as $value) {
            $expSubtype = PMSEEngineUtils::getExpressionSubtype($value);
            if ($value->expType != 'VARIABLE') {
                if (isset($expSubtype)) {
                    switch (strtoupper($expSubtype)) {
                        case 'INT':
                            $dataEval[] = (int)$value->expValue;
                            break;
                        case 'FLOAT':
                            $dataEval[] = (float)$value->expValue;
                            break;
                        case 'DOUBLE':
                            $dataEval[] = (double)$value->expValue;
                            break;
                        case 'NUMBER':
                            $dataEval[] = (float)$value->expValue;
                            break;
                        case 'CURRENCY':
                            $dataEval[] = json_encode($value);
                            break;
                        case 'BOOL':
                            $dataEval[] = $value->expValue == 'TRUE' ? true : false;
                            break;
                        default:
                            $dataEval[] = $value->expValue;
                            break;
                    }
                }
            } else {
                $fields = $value->expValue;
                $field_value = !empty($bean->fetched_row[$fields]) ? $bean->fetched_row[$fields] : $bean->$fields;
                switch (strtolower($expSubtype)) {
                    case 'currency':
                        $constantCurrency = new stdClass();
                        $constantCurrency->expType = 'CONSTANT';
                        $constantCurrency->expSubtype = 'currency';
                        $constantCurrency->expValue = $bean->$fields;
                        $constantCurrency->expField = $bean->currency_id;
                        $dataEval[] = json_encode($constantCurrency);
                        break;
                    case 'datetime':
                    case 'datetimecombo':
                        $dataEval[] = $timedate->asIso(new DateTime($field_value, new DateTimeZone('UTC')));
                        break;
                    default:
                        $dataEval[] = $field_value;
                }
            }
        }
        if (count($dataEval) > 1) {
            $response->value = $this->evaluator->evaluateExpression(json_encode($expression), $bean);
            $response->type = gettype($response->value);
        } else {
            $response->value = $dataEval[0];
            $response->type = $value->expSubtype;
        }
        if (strtolower($response->type) == 'timespan' ||
            (strtolower($response->type) == 'object' &&
                is_a($response->value, 'DateInterval'))) {
            if (!isset($this->expressionEvaluator)) {
                $this->expressionEvaluator = ProcessManager\Factory::getPMSEObject('PMSEExpressionEvaluator');
            }
            $now = new DateTime();
            $now->add($this->expressionEvaluator->processDateInterval($response->value));
            $response->value = $timedate->asIso($now);
        }

        if (strtolower($response->value) === 'now') {
            $response->value = $timedate->asIso(new DateTime());
        }
        return $response->value;
    }

    /**
     * Sets the proper metadata for handling record link replacements
     * @param array &$return The return data
     * @param array $parts Parts of the replacement placeholder
     * @param string $target The target module
     * @param string $original The original full replacement placeholder
     */
    protected function setRecordLinkReplacementMeta(array &$return, array $parts, string $target, string $original)
    {
        // This is to support legacy workflow conversions
        $key = $this->getLastArrayKey($parts);
        if ($parts[$key] === 'href_link') {
            $parts[$key] = 'name';
        }

        // This is a related record link...
        // $parts[href_link, base_module, rel_module, field]
        if (isset($parts[3])) {
            // Formart is [rel_module][field] = []
            $return[$parts[2]][$parts[3]] = [
                'name' => $parts[3],
                'value_type' => $parts[0],
                'original' => $original,
                'type' => 'relate',
                'rel_module' => $parts[2],
            ];
        } else {
            // This is a target record link...
            // $parts[href_link, base_module, field]
            $return[$target][$parts[2] . '_' . $parts[0]] = [
                'name' => $parts[2],
                'value_type' => $parts[0],
                'original' => $original,
            ];
        }
    }

    /**
     * Sets the proper metadata for handling regular data replacements. Expected
     * format of the `$parts` array should be one of:
     *  - `$parts[target_or_link, field]`
     *  - `$parts[target_or_link, field, old]`
     *  - `$parts[future, target, field]`
     *  - `$parts[future, target, link_name, field]`
     *  - `$parts[past, target, field]`
     *  - `$parts[past, target, link_name, field]`
     * @param array &$return The return data
     * @param array $parts Parts of the replacement placeholder
     * @param string $target The target module
     * @param string $original The original full replacement placeholder
     */
    protected function setDataReplacementMeta(array &$return, array $parts, string $target, string $original)
    {
        // See if we can handle legacy workflow template conversion
        if (($parts[0] === 'past' || $parts[0] === 'future') && ($partsCount = count($parts)) > 2) {
            // Convert past to old, or leave future as is
            $type = $parts[0] === 'past' ? 'old' : 'future';

            // Set up our module|link value
            $mod = $partsCount === 4 ? $parts[2] : $target;

            // Get the field, which is always the last element in the placeholder array
            $field = $this->getLastArrayValue($parts);

            // Reset the parts array
            $parts = [$mod, $field, $type];
        }

        // Old value, or new value?
        $type = !isset($parts[2]) || $parts[2] !== 'old' ? 'future' : 'old';

        // Prepare the key for the return array
        $key = sprintf(
            '%s_%s_%s',
            $parts[0],
            $parts[1],
            $type
        );

        // Handle setting the metadata
        $return[$target][$key] = [
            'filter' => $parts[0],
            'name' => $parts[1],
            'value_type' => $type,
            'original' => $original,
        ];
    }

    /**
     * Gets the last member of a numerically indexed array
     * @param array $array The numerically indexed array to get the last value from
     * @return mixed
     */
    public function getLastArrayValue(array $array)
    {
        return $array[$this->getLastArrayKey($array)];
    }

    /**
     * Gets the key of the last member of a numerically indexed array
     * @param array $array The numerically indexed array to get the last value key from
     * @return int
     */
    public function getLastArrayKey(array $array)
    {
        return count($array) - 1;
    }

    /**
     * Determines if a placeholder is for a record link. Supports both legacy and
     * advanced workflow template placeholders
     * @param array $parts Placeholder string broken down into its parts
     * @return boolean
     */
    public function isRecordLinkType(array $parts)
    {
        // {::href_link::Accounts::href_link::}
        // {::href_link::Accounts::member_of::href_link::}
        // {::href_link::Accounts::name::}
        // {::href_link::Accounts::member_of::name::}
        return $parts[0] === 'href_link' && in_array($this->getLastArrayValue($parts), ['href_link', 'name']);
    }

    /**
     * Collect all template placeholders for parsing and replacement with bean data
     * @param string $template The email template body
     * @param string $base_module The target module
     * @return array
     */
    public function parseString($template, $base_module)
    {
        $return = [
            $base_module => [],
        ];

        preg_match_all(
            '/(({::)[^>]*?)(.*?)((::})[^>]*?)/',
            $template,
            $matches,
            PREG_SET_ORDER
        );

        foreach ($matches as $val) {
            // The array of placeholder parts
            $parts = explode('::', $val[3]);

            // Determine if we are creating record link or data replacement meta
            $method = sprintf(
                'set%sReplacementMeta',
                $this->isRecordLinkType($parts) ? 'RecordLink' : 'Data'
            );

            // Handle it
            $this->$method($return, $parts, $base_module, $val[0]);
        }

        return $return;
    }

    /**
     * Method to evaluate the activation date for any flow
     * @param $expre Date +/- unit time (minutes,hours,days, month, year) adding or substracting
     * @param $bean this value is send in cse the date a native Sugar Date
     * @return array with two values  $today and $dueDate
     */
    public function calculateDueDate($expre, $bean)
    {
        $isDate = false;
        $date = '';
        $arrayUnitPos = array();
        $arrayUnitNeg = array();
        foreach ($expre as $keyevn => $evn) {
            switch ($evn->expType) {
                case 'FIXED_DATE':
                    $isDate = true;
                    $date = $evn->expValue;
                    break;
                case 'SUGAR_DATE':
                    $string = $evn->expValue;
                    $isDate = true;
                    $date = $bean->$string;
                    break;
                case 'UNIT_TIME':
                    switch ($evn->expUnit) {
                        case 'minutes':
                            $arrayUnitPos['minutes'] = isset($arrayUnitPos['minutes']) ? $arrayUnitPos['minutes'] : 0;
                            $arrayUnitNeg['minutes'] = isset($arrayUnitNeg['minutes']) ? $arrayUnitNeg['minutes'] : 0;
                            if ($expre[$keyevn - 1]->expValue == '+') {
                                $arrayUnitPos['minutes'] = $arrayUnitPos['minutes'] + $evn->expValue;
                            } else {
                                $arrayUnitNeg['minutes'] = $arrayUnitNeg['minutes'] - $evn->expValue;
                            }
                            break;
                        case 'hours':
                            $arrayUnitPos['hours'] = isset($arrayUnitPos['hours']) ? $arrayUnitPos['hours'] : 0;
                            $arrayUnitNeg['hours'] = isset($arrayUnitNeg['hours']) ? $arrayUnitNeg['hours'] : 0;
                            if ($expre[$keyevn - 1]->expValue == '+') {
                                $arrayUnitPos['hours'] = $arrayUnitPos['hours'] + $evn->expValue;
                            } else {
                                $arrayUnitNeg['hours'] = $arrayUnitNeg['hours'] - $evn->expValue;
                            }
                            break;
                        case 'days':
                            $arrayUnitPos['days'] = isset($arrayUnitPos['days']) ? $arrayUnitPos['days'] : 0;
                            $arrayUnitNeg['days'] = isset($arrayUnitNeg['days']) ? $arrayUnitNeg['days'] : 0;
                            if ($expre[$keyevn - 1]->expValue == '+') {
                                $arrayUnitPos['days'] = $arrayUnitPos['days'] + $evn->expValue;
                            } else {
                                $arrayUnitNeg['days'] = $arrayUnitNeg['days'] - $evn->expValue;
                            }
                            break;
                        case 'months':
                            $arrayUnitPos['months'] = isset($arrayUnitPos['months']) ? $arrayUnitPos['months'] : 0;
                            $arrayUnitNeg['months'] = isset($arrayUnitNeg['months']) ? $arrayUnitNeg['months'] : 0;
                            if ($expre[$keyevn - 1]->expValue == '+') {
                                $arrayUnitPos['months'] = $arrayUnitPos['months'] + $evn->expValue;
                            } else {
                                $arrayUnitNeg['months'] = $arrayUnitNeg['months'] - $evn->expValue;
                            }
                            break;
                        case 'years':
                            $arrayUnitPos['year'] = isset($arrayUnitPos['year']) ? $arrayUnitPos['year'] : 0;
                            $arrayUnitNeg['year'] = isset($arrayUnitNeg['year']) ? $arrayUnitNeg['year'] : 0;
                            if ($expre[$keyevn - 1]->expValue == '+') {
                                $arrayUnitPos['year'] = $arrayUnitPos['year'] + $evn->expValue;
                            } else {
                                $arrayUnitNeg['year'] = $arrayUnitNeg['year'] - $evn->expValue;
                            }
                            break;
                        default:
                            break;
                    }
                    break;
                default:
                    //default
                    break;
            }
        }
        if ($isDate) {
            $dateInt = strtotime($date);
            $date_evn = date("Y-m-d H:i:s", $dateInt);
            if (!empty($arrayUnitPos) || !empty($arrayUnitNeg)) {
                foreach ($arrayUnitPos as $unit => $value) {
                    $duration = $value . ' ' . $unit;
                    $dueDate = date("Y-m-d H:i:s", strtotime("+$duration", $dateInt));
                    $dateInt = strtotime($dueDate);
                }
                foreach ($arrayUnitNeg as $unit => $value) {
                    $duration = $value . ' ' . $unit;
                    $dueDate = date("Y-m-d H:i:s", strtotime("$duration", $dateInt));
                    $dateInt = strtotime($dueDate);
                }
                if ($dueDate > $date_evn) {
                    $today = $date_evn;
                } else {
                    $today = $dueDate;
                    $dueDate = date("Y-m-d H:i:s", strtotime("+10 seconds", $dateInt));
                }
            } else {
                $today = $date_evn;
                $dueDate = date("Y-m-d H:i:s", strtotime("+1 day", $dateInt));
            }
        }
        return array($today, $dueDate);
    }

    /**
     *
     * @param type $module
     * @return \DeployedRelationships
     * @codeCoverageIgnore
     */
    public function getDeployedRelationships($module)
    {
        return new DeployedRelationships($module);
    }

    /**
     *
     * @global type $app_list_strings
     * @global type $sugar_config
     * @param type $bean
     * @return type
     */
    private function get_href_link($bean)
    {
        global $app_list_strings;
        global $sugar_config;
        $link = "{$sugar_config['site_url']}/index.php?module={$bean->module_dir}&action=DetailView&record={$bean->id}";
        return "<a href=\"$link\">Click Here</a>";
    }
}
