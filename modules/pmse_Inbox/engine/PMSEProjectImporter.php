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
 * Description of the ProjectImporter class
 * This class is in charge of the import of bpm files into Processes.
 */
class PMSEProjectImporter extends PMSEImporter
{

    /**
     * The import result
     * @var \stdClass
     */
    private $importResult;

    /**
     * The array of saved elements
     * @var array
     */
    private $savedElements = array();

    /**
     * The array of changed uid elements
     * @var array
     */
    private $changedUidElements = array();

    /**
     * The list of default flows
     * @var array
     */
    private $defaultFlowList = array();

    /**
     *
     * @var type
     */
    protected $dependenciesWrapper;

    /**
     * The target module from the import
     * @var string
     */
    protected $targetModule;

    /**
     * @var
     */
    protected $warningBR = false;

    /**
     * @var
     */
    protected $warningET = false;

    /**
     * @inheritDoc
     */
    protected $beanModule = 'pmse_Project';

    /**
     * @inheritDoc
     */
    protected $id = 'prj_id';

    /**
     * @inheritDoc
     */
    protected $name = 'name';

    /**
     * @inheritDoc
     */
    protected $extension = 'bpm';

    /**
     * @inheritDoc
     */
    protected $module = 'prj_module';

    /**
     * List of keys created as part of this import
     * @var array
     */
    protected $projectKeys = [];

    /**
     * @inheritDoc
     */
    protected function initialize()
    {
        $this->setDependenciesWrapper();
    }

    /**
     * Sets a key and key value into this object
     * @param string $key The key to set
     * @param string $val The value for this key
     */
    protected function addKey($key, $val)
    {
        $this->projectKeys[$key] = $val;
    }

    /**
     * Gets a single value for a key, or null if key is not set
     * @param string $key The key to get the value for
     * @return string
     */
    protected function getKey($key)
    {
        return array_key_exists($key, $this->projectKeys) ? $this->projectKeys[$key] : null;
    }

    /**
     * Gets all keys
     * @return array
     */
    protected function getKeys()
    {
        return $this->projectKeys;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getSavedElements()
    {
        return $this->savedElements;
    }

    /**
     *
     * @param type $savedElements
     * @codeCoverageIgnore
     */
    public function setSavedElements($savedElements)
    {
        $this->savedElements = $savedElements;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getDependenciesWrapper()
    {
        if (empty($this->dependenciesWrapper)) {
            $this->setDependenciesWrapper();
        }

        return $this->dependenciesWrapper;
    }

    /**
     *
     * @param type $dependenciesWrapper
     * @codeCoverageIgnore
     */
    public function setDependenciesWrapper(PMSERelatedDependencyWrapper $dependenciesWrapper = null)
    {
        if ($dependenciesWrapper === null) {
            $this->dependenciesWrapper = ProcessManager\Factory::getPMSEObject('PMSERelatedDependencyWrapper');
        } else {
            $this->dependenciesWrapper = $dependenciesWrapper;
        }
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getDefaultFlowList()
    {
        return $this->defaultFlowList;
    }

    /**
     *
     * @param type $defaultFlowList
     * @codeCoverageIgnore
     */
    public function setDefaultFlowList($defaultFlowList)
    {
        $this->defaultFlowList = $defaultFlowList;
    }

    /**
     *
     * @return type
     * @codeCoverageIgnore
     */
    public function getChangedUidElements()
    {
        return $this->changedUidElements;
    }

    /**
     *
     * @param type $changedUidElements
     * @codeCoverageIgnore
     */
    public function setChangedUidElements($changedUidElements)
    {
        $this->changedUidElements = $changedUidElements;
    }

    /**
     * Sets the targetModule property
     * @param string $targetModule The target module for this project
     */
    public function setTargetModule($targetModule)
    {
        $this->targetModule = $targetModule;
    }

    /**
     * Gets the targetModule
     * @return string
     */
    public function getTargetModule()
    {
        return $this->targetModule;
    }

    /**
     * Gets the name of the project record, appended with numbers if need be
     * @param array $projectData Project data array
     * @return string
     */
    protected function getProjectName(array $projectData)
    {
        $name = !empty($projectData['prj_name']) ? $projectData['prj_name'] : $projectData[$this->name];

        if ($this->getOption('keepName', false) === false) {
            $name = $this->getNameWithSuffix($name);
        }

        return $name;
    }

    /**
     * Initialized the project data array
     * @param array $projectData Project data array
     * @return array
     */
    protected function initProjectData(array $projectData)
    {
        // Only nuke ids if needed
        if ($this->getOption('keepIds') !== true) {
            unset($projectData[$this->id]);
        }

        // Unset common fields
        $this->unsetCommonFields($projectData);
        if (!isset($projectData['assigned_user_id'])) {
            $projectData['assigned_user_id'] = $this->getCurrentUser()->id;
        }

        // This gets the name of the project
        $name = $this->getProjectName($projectData);

        // This adds the project name to the various related records
        $projectData['name'] = $name;
        $projectData['process']['name'] = $name;
        $projectData['diagram']['name'] = $name;

        // Only nuke ids if needed
        if ($this->getOption('keepIds') !== true || empty($projectData['prj_uid'])) {
            $projectData['prj_uid'] = Sugarcrm\Sugarcrm\Util\Uuid::uuid1();
        }

        // Imported/copied/installed process definitions should always be inactive
        $projectData['prj_status'] = 'INACTIVE';

        return $projectData;
    }

    /**
     * Gets an element from the $project data array and unsets it if needed
     * @param array &$project A reference to the project data array
     * @param string $element The element type to get
     * @param  boolean $unset Flag that determines if a property needs to be unset
     * @return array
     */
    protected function getProjectDataElement(&$project, $element, $unset = true)
    {
        $return = !empty($project[$element]) ? $project[$element] : [];

        if ($unset) {
            unset($project[$element]);
        }

        return $return;
    }

    /**
     * Saves the project bean
     * @param array $projectData The project data
     * @return array
     */
    protected function saveProjectBean(array $project)
    {
        $this->handleProjectBeanSave($project);
        $this->addKey('prj_id', $this->getBeanId());

        return $project;
    }

    /**
     * Saves the diagram bean
     * @param array $diagramData The Diagram data array
     * @return array
     */
    protected function saveDiagramBean(array $diagram)
    {
        $bean = BeanFactory::newBean('pmse_BpmnDiagram');

        // If we need to keep IDs, keep them
        if ($this->getOption('keepIds') !== true) {
            unset($diagram['dia_id']);
        }

        $diagram['prj_id'] = $this->getKey('prj_id');
        if ($this->getOption('keepIds') !== true || empty($diagram['dia_uid'])) {
            $diagram['dia_uid'] = Sugarcrm\Sugarcrm\Util\Uuid::uuid1();
        }

        $this->loadBeanFromArray($bean, $diagram);
        $this->addKey('dia_id', $bean->save());

        return $diagram;
    }

    /**
     * Saves the process bean with data from both the process and project
     * @param array $processData Process data array
     * @param array &$projectData Reference to the project data array
     * @return array
     */
    protected function saveProcessBean(array $process, array &$project)
    {
        $bean = BeanFactory::newBean('pmse_BpmnProcess');

        if ($this->getOption('keepIds') !== true) {
            unset($process['pro_id']);
        }

        $process['prj_id'] = $this->getKey('prj_id');
        $process['dia_id'] = $this->getKey('dia_id');

        if ($this->getOption('keepIds') !== true || empty($process['pro_uid'])) {
            $process['pro_uid'] = Sugarcrm\Sugarcrm\Util\Uuid::uuid1();
        }

        $this->loadBeanFromArray($bean, $process);

        if ($this->getOption('isCopy') === true && !empty($project['assigned_user_id'])) {
            $bean->assigned_user_id = $project['assigned_user_id'];
        }
        $this->addKey('pro_id', $bean->save());

        return $process;
    }

    /**
     * Saves a process definitionbean
     * @param array $data The process definition data array
     * @param array &$project A reference to the project data
     * @return array
     */
    protected function saveProcessDefinitionBean($data, &$project)
    {
        $bean = BeanFactory::newBean('pmse_BpmProcessDefinition');
        if ($this->getOption('keepIds') !== true) {
            unset($project['definition']['pro_id']);
        }

        $data['prj_id'] = $this->getKey('prj_id');
        $this->loadBeanFromArray($bean, $data);

        // Relate the process definition to the project
        // This is a one to one relationship
        $bean->id = $this->getKey('pro_id');
        $bean->pro_status = 'INACTIVE';
        $bean->new_with_id = true;

        if ($this->getOption('isCopy') === true && !empty($project['prj_status'])) {
            // make PD's status consistent with project status
            $bean->pro_status = $project['prj_status'];
        } else {
            // by default an imported project should be disabled
            $bean->pro_status = 'INACTIVE';
        }

        if ($this->getOption('isCopy') === true && !empty($project['assigned_user_id'])) {
            $bean->assigned_user_id = $project['assigned_user_id'];
        }

        $bean->save();

        // Process termination definition, which has to come after the save so we have an ID
        if (!empty($bean->pro_terminate_variables) && $bean->pro_terminate_variables != '[]') {
            $this->createRelatedDependencyTerminateProcess($bean->id, $bean->pro_terminate_variables);
        }

        return $data;
    }

    /**
     * Save the project data into the bpm project, and process beans, validates the uniqueness of
     * ids and also saves the rest.
     * @param array $projectData The project data from the import file
     * @param boolean $isCopy Deprecated. Please use {@see setOption()}.
     * @return bool|void
     */
    public function saveProjectData($projectData, $isCopy = false)
    {
        // Handling for isCopy, which should be removed in 10.0.0
        LoggerManager::getLogger()->deprecated(
            sprintf(
                'The isCopy flag in %s::%s is deprecated. Please use $i->setOption(\'isCopy\', true).',
                __CLASS__,
                __METHOD__
            )
        );

        if (isset($isCopy) && $isCopy === true) {
            $this->setOption('isCopy', true);
        }

        // The return data...
        $result = ['success' => false];

        // This will be needed down the road
        $this->setTargetModule($projectData[$this->module]);

        // Handle initial decoration of the project data
        $projectData = $this->initProjectData($projectData);

        // Since we need the various elements of the project, but need the projectData
        // array without it, grab what we need then unset what we grabbed
        $diagramData = $this->getProjectDataElement($projectData, 'diagram');
        $processData = $this->getProjectDataElement($projectData, 'process');
        $processDefinitionData = $this->getProjectDataElement($projectData, 'definition');
        $dynaFormData = $this->getProjectDataElement($projectData, 'dynaforms');

        // Project Bean handling
        $projectData = $this->saveProjectBean($projectData);

        // Handle the diagram records now
        $diagramData = $this->saveDiagramBean($diagramData);

        // Handle Process data now
        $processData = $this->saveProcessBean($processData, $projectData);

        // Process definitions now
        $processDefinitionData = $this->saveProcessDefinitionBean($processDefinitionData, $projectData);

        // Now save the rest of what is needed for the process definition diagram
        $this->saveProjectActivitiesData($diagramData['activities'], $this->getKeys());
        $this->saveProjectEventsData($diagramData['events'], $this->getKeys());
        $this->saveProjectGatewaysData($diagramData['gateways'], $this->getKeys());
        $this->saveProjectArtifactsData($diagramData['artifacts'], $this->getKeys());
        $this->saveProjectFlowsData($diagramData['flows'], $this->getKeys());
        $this->saveProjectDynaFormsData($dynaFormData, $this->getKeys());
        $this->processDefaultFlows();

        // Package up and send back the result
        $result['success'] = true;
        $result['id'] = $this->getKey('prj_id');
        $result['br_warning'] = $this->warningBR;
        $result['et_warning'] = $this->warningET;

        return $result;
    }

    /**
     * @codeCoverageIgnore
     * @deprecated since version 1.612
     */
    public function getFileProjectData($filePath)
    {
        return false;
    }

    /**
     * Save the project activities data.
     * @param array $activitiesData
     * @param array $keysArray
     */
    public function saveProjectActivitiesData($activitiesData, $keysArray)
    {
        foreach ($activitiesData as $element) {
            $activityBean = BeanFactory::newBean('pmse_BpmnActivity');
            $boundBean = BeanFactory::newBean('pmse_BpmnBound');
            $definitionBean = BeanFactory::newBean('pmse_BpmActivityDefinition');

            list($element, $definition, $bound) = $this->getElementDefinition($element);

            $element['prj_id'] = $keysArray['prj_id'];
            $element['pro_id'] = $keysArray['pro_id'];
            $previousId = $element['id'];
            unset($element['id']);

            $previousUid = $element['act_uid'];
            $element['act_uid'] = PMSEEngineUtils::generateUniqueID();
            $this->changedUidElements[$previousUid] = array('new_uid' => $element['act_uid'] );
            foreach ($element as $key => $value) {
                // Handle sanitization of the JSON string for activity fields
                // See MACAROON-867
                if ($key === 'act_fields') {
                    $value = PMSEEngineUtils::sanitizeImportActivityFields($element, $this->getTargetModule());
                }

                if (isset($activityBean->field_defs[$key])){
                    $activityBean->$key = $value;
                }
            }
            $currentID = $activityBean->save();

            if (!isset($this->savedElements['bpmnActivity'])) {
                $this->savedElements['bpmnActivity'] = array();
                $this->savedElements['bpmnActivity'][$previousId] = $currentID;
            } else {
                $this->savedElements['bpmnActivity'][$previousId] = $currentID;
            }

            $bound['bou_uid'] = PMSEEngineUtils::generateUniqueID();
            $bound['prj_id'] = $keysArray['prj_id'];
            $bound['dia_id'] = $keysArray['dia_id'];
            $bound['element_id'] = $keysArray['dia_id'];
            $bound['bou_element'] = $currentID;
            foreach ($bound as $key => $value) {
                if (isset($boundBean->field_defs[$key])){
                    $boundBean->$key = $value;
                }
            }
            $boundBean->save();

            $definition['pro_id'] = $keysArray['pro_id'];
            if ($element['act_task_type'] == 'SCRIPTTASK' &&
                $element['act_script_type'] == 'BUSINESS_RULE') {
                $definition = $this->addDependencyIdToDefinition($definition, 'act_fields');

                if ($definition['act_fields'] == '') {
                    $this->warningBR = true;
                }
            }
            foreach ($definition as $key => $value) {
                if (isset($definitionBean->field_defs[$key])){
                    $definitionBean->$key = $value;
                }
            }
            $definitionBean->id = $currentID;
            $definitionBean->new_with_id = true;
            $definitionBean->save();
        }
    }

    /**
     * Save the project events data.
     * @param array $eventsData
     * @param array $keysArray
     */
    public function saveProjectEventsData($eventsData, $keysArray)
    {
        foreach ($eventsData as $element) {
            $eventBean = BeanFactory::newBean('pmse_BpmnEvent');
            $boundBean = BeanFactory::newBean('pmse_BpmnBound');
            $definitionBean = BeanFactory::newBean('pmse_BpmEventDefinition');

            list($element, $definition, $bound) = $this->getElementDefinition($element);

            $element['prj_id'] = $keysArray['prj_id'];
            $element['pro_id'] = $keysArray['pro_id'];
            $previousId = $element['id'];
            unset($element['id']);

            $previousUid = $element['evn_uid'];
            $element['evn_uid'] = PMSEEngineUtils::generateUniqueID();
            $this->changedUidElements[$previousUid] = array('new_uid' => $element['evn_uid'] );
            foreach ($element as $key => $value) {
                if (isset($eventBean->field_defs[$key])){
                    $eventBean->$key = $value;
                }
            }
            $currentID = $eventBean->save();

            if (!isset($this->savedElements['bpmnEvent'])) {
                $this->savedElements['bpmnEvent'] = array();
                $this->savedElements['bpmnEvent'][$previousId] = $currentID;
            } else {
                $this->savedElements['bpmnEvent'][$previousId] = $currentID;
            }

            $bound['bou_uid'] = PMSEEngineUtils::generateUniqueID();
            $bound['prj_id'] = $keysArray['prj_id'];
            $bound['dia_id'] = $keysArray['dia_id'];
            $bound['element_id'] = $keysArray['dia_id'];
            $bound['bou_element'] = $currentID;
            foreach ($bound as $key => $value) {
                if (isset($boundBean->field_defs[$key])){
                    $boundBean->$key = $value;
                }
            }
            $boundBean->save();

            $definition['pro_id'] = $keysArray['pro_id'];
            if (($element['evn_type'] == 'INTERMEDIATE' || $element['evn_type'] == 'END') &&
                $element['evn_marker'] == 'MESSAGE' &&
                $element['evn_behavior'] == 'THROW' ) {
                $definition = $this->addDependencyIdToDefinition($definition, 'evn_criteria');

                if ($definition['evn_criteria'] == '') {
                    $this->warningET = true;
                }
            }
            foreach ($definition as $key => $value) {
                if (isset($definitionBean->field_defs[$key])){
                    $definitionBean->$key = $value;
                }
            }
            $definitionBean->id = $currentID;
            $definitionBean->new_with_id = true;
            $definitionBean->save();

            if (!empty($currentID)) {
                $definitionBean->evn_id = $currentID;
                $this->getDependenciesWrapper()->processRelatedDependencies($eventBean->toArray() + $definitionBean->toArray());
            }
        }
    }

    /**
     * Save the project gateways data.
     * @param array $gatewaysData
     * @param array $keysArray
     */
    public function saveProjectGatewaysData($gatewaysData, $keysArray)
    {
        foreach ($gatewaysData as $element) {
            $gatewayBean = BeanFactory::newBean('pmse_BpmnGateway');
            $boundBean = BeanFactory::newBean('pmse_BpmnBound');
            $definitionBean = BeanFactory::newBean('pmse_BpmGatewayDefinition');

            list($element, $definition, $bound) = $this->getElementDefinition($element);

            $element['prj_id'] = $keysArray['prj_id'];
            $element['pro_id'] = $keysArray['pro_id'];
            $previousId = $element['id'];
            unset($element['id']);

            $previousUid = $element['gat_uid'];
            $element['gat_uid'] = PMSEEngineUtils::generateUniqueID();
            $this->changedUidElements[$previousUid] = array('new_uid' => $element['gat_uid'] );
            foreach ($element as $key => $value) {
                if (isset($gatewayBean->field_defs[$key])){
                    $gatewayBean->$key = $value;
                }
            }
            $currentID = $gatewayBean->save();

            if (!isset($this->savedElements['bpmnGateway'])) {
                $this->savedElements['bpmnGateway'] = array();
                $this->savedElements['bpmnGateway'][$previousId] = $currentID;
            } else {
                $this->savedElements['bpmnGateway'][$previousId] = $currentID;
            }

            $bound['bou_uid'] = PMSEEngineUtils::generateUniqueID();
            $bound['prj_id'] = $keysArray['prj_id'];
            $bound['dia_id'] = $keysArray['dia_id'];
            $bound['element_id'] = $keysArray['dia_id'];
            $bound['bou_element'] = $currentID;
            foreach ($bound as $key => $value) {
                if (isset($boundBean->field_defs[$key])){
                    $boundBean->$key = $value;
                }
            }
            $boundBean->save();

            $definition['pro_id'] = $keysArray['pro_id'];
            foreach ($definition as $key => $value) {
                if (isset($definitionBean->field_defs[$key])){
                    $definitionBean->$key = $value;
                }
            }
            $definitionBean->id = $currentID;
            $definitionBean->new_with_id = true;
            $definitionBean->save();

            if (!empty($gatewayBean->gat_default_flow)) {
                $this->defaultFlowList[$element['gat_default_flow']] = array(
                    'bean' => 'BpmnGateway',
                    'id' => $currentID,
                    'default_flow_field' => 'gat_default_flow',
                    'default_flow_value' => $element['gat_default_flow'],
                );
            }
        }
    }

    public function saveProjectArtifactsData($gatewaysData, $keysArray)
    {
        foreach ($gatewaysData as $element) {
            $artifactBean = BeanFactory::newBean('pmse_BpmnArtifact');
            $boundBean = BeanFactory::newBean('pmse_BpmnBound');

            list($element, $definition, $bound) = $this->getElementDefinition($element);

            $element['prj_id'] = $keysArray['prj_id'];
            $element['pro_id'] = $keysArray['pro_id'];
            $previousId = $element['id'];
            unset($element['id']);

            $previousUid = $element['art_uid'];
            $element['art_uid'] = PMSEEngineUtils::generateUniqueID();
            $this->changedUidElements[$previousUid] = array('new_uid' => $element['art_uid'] );
            foreach ($element as $key => $value) {
                if (isset($artifactBean->field_defs[$key])){
                    $artifactBean->$key = $value;
                }
            }
            $currentID = $artifactBean->save();

            if (!isset($this->savedElements['bpmnArtifacts'])) {
                $this->savedElements['bpmnArtifacts'] = array();
                $this->savedElements['bpmnArtifacts'][$previousId] = $currentID;
            } else {
                $this->savedElements['bpmnArtifacts'][$previousId] = $currentID;
            }

            $bound['bou_uid'] = PMSEEngineUtils::generateUniqueID();
            $bound['prj_id'] = $keysArray['prj_id'];
            $bound['dia_id'] = $keysArray['dia_id'];
            $bound['element_id'] = $keysArray['dia_id'];
            $bound['bou_element'] = $currentID;
            foreach ($bound as $key => $value) {
                if (isset($boundBean->field_defs[$key])){
                    $boundBean->$key = $value;
                }
            }
            $boundBean->save();
        }
    }

    /**
     * Save the project flows data.
     * @param array $flowsData
     * @param array $keysArray
     */
    public function saveProjectFlowsData($flowsData, $keysArray)
    {
        foreach ($flowsData as $element) {
            $flowBean = BeanFactory::newBean('pmse_BpmnFlow');
            $element['prj_id'] = $keysArray['prj_id'];
            $element['pro_id'] = $keysArray['pro_id'];
            $element['dia_id'] = $keysArray['dia_id'];
            $previousId = $element['id'];
            unset($element['id']);
            foreach ($element as $key => $value) {
                if (isset($flowBean->field_defs[$key])){
                    switch ($key) {
                        case 'flo_element_origin':
                            if (!empty($value)) {
                                $flowBean->$key = $this->savedElements[$element['flo_element_origin_type']][$value];
                            }
                            break;
                        case 'flo_element_dest':
                            if (!empty($value)) {
                                $flowBean->$key = $this->savedElements[$element['flo_element_dest_type']][$value];
                            }
                            break;
                        case 'flo_condition':
                            if (!empty($value)) {
                                $tokenExpression = json_decode($value);
                                if (is_array($tokenExpression) && !empty($tokenExpression)) {
                                    foreach ($tokenExpression as $_key => $_value) {
                                        switch ($_value->expType) {
                                            case 'MODULE':
                                                $expSubtype = PMSEEngineUtils::getExpressionSubtype($_value);
                                                if (!empty($expSubtype) &&
                                                    (strtolower($expSubtype) == 'currency') &&
                                                    (empty($_value->expCurrency))
                                                ) {
                                                    PMSEEngineUtils::fixCurrencyType($tokenExpression[$_key]);
                                                    $flowBean->$key = json_encode($tokenExpression);
                                                } else {
                                                    $flowBean->$key = $value;
                                                }
                                                break;
                                            case 'CONTROL':
                                                $tokenExpression[$_key]->expField = $this->changedUidElements[$_value->expField]['new_uid'];
                                                $flowBean->$key = json_encode($tokenExpression);
                                                break;
                                            case 'BUSINESS_RULES':
                                                // Need to adjust references to business rule actions to reflect their new ID after being imported
                                                $oldBusinessRuleActionID = $_value->expField;
                                                $importedActivities = $this->getSavedElements()['bpmnActivity'];
                                                if (isset($importedActivities[$oldBusinessRuleActionID])) {
                                                    $newBusinessRuleActionID = $importedActivities[$oldBusinessRuleActionID];
                                                    $value = str_replace($oldBusinessRuleActionID, $newBusinessRuleActionID, $value);
                                                }
                                                $flowBean->$key = $value;
                                                break;
                                            default:
                                                $flowBean->$key = $value;
                                        }
                                    }
                                }
                            }
                            break;
                        default:
                            $flowBean->$key = $value;
                    }
                }
            }

            $previousUid = $flowBean->flo_uid;
            $flowBean->flo_uid = PMSEEngineUtils::generateUniqueID();
            $currentID = $flowBean->save();
            if (!isset($this->savedElements['bpmnFlows'])) {
                $this->savedElements['bpmnFlows'] = array();
                $this->savedElements['bpmnFlows'][$previousId] = $currentID;
            } else {
                $this->savedElements['bpmnFlows'][$previousId] = $currentID;
            }
        }
    }

    /**
     * Save the project dyna forms data.
     * @param array $flowsData
     * @param array $keysArray
     */
    public function saveProjectDynaFormsData($dynaFormsData, $keysArray)
    {
        foreach ($dynaFormsData as $element) {
            $dynaFormsBean = BeanFactory::newBean('pmse_BpmDynaForm');
            $element['prj_id'] = $keysArray['prj_id'];
            $element['pro_id'] = $keysArray['pro_id'];
            $element['dia_id'] = $keysArray['dia_id'];
            $previousId = $element['id'];
            unset($element['id']);
            foreach ($element as $key => $value) {
                if (isset($dynaFormsBean->field_defs[$key])){
                    $dynaFormsBean->$key = $value;
                }
            }

            $previousUid = $dynaFormsBean->flo_uid;
            $dynaFormsBean->flo_uid = PMSEEngineUtils::generateUniqueID();
            $currentID = $dynaFormsBean->save();
            if (!isset($this->savedElements['bpmnArtifacts'])) {
                $this->savedElements['bpmnArtifacts'] = array();
                $this->savedElements['bpmnArtifacts'][$previousId] = $currentID;
            } else {
                $this->savedElements['bpmnArtifacts'][$previousId] = $currentID;
            }
        }
    }

    /**
     * Save the project elements data.
     * @param $elementsData
     * @param $keysArray
     * @param $beanType
     * @param bool $generateBound
     * @param bool $generateWithId
     * @param string $field_uid
     * @deprecated
     */
    public function saveProjectElementsData(
        $elementsData,
        $keysArray,
        $beanType,
        $generateBound = false,
        $generateWithId = false,
        $field_uid = ''
    ) {
         foreach ($elementsData as $element) {
            $boundBean = BeanFactory::newBean('pmse_BpmnBound');
            $elementBean = BeanFactory::newBean($beanType);

            $element['prj_id'] = $keysArray['prj_id'];
            $element['pro_id'] = $keysArray['pro_id'];
            $element['dia_id'] = $keysArray['dia_id'];
            foreach ($element as $key => $value) {
                if (strpos($key, '_name') !== false) {
                    $elementBean->name = $value;
                } else {
                    $elementBean->$key = $value;
                }
                if ($generateBound) {
                    $boundBean->$key = $value;
                }
                if (strpos($key, '_uid') !== false) {
                    $uid = $key;
                }
            }
            $savedId = $elementBean->save();

            if (!empty($savedId)) {
                $this->savedElements[$beanType][$elementBean->$uid] = $savedId;
            }
            if (!empty($field_uid)) {
                $elementBean->$field_uid = PMSEEngineUtils::generateUniqueID();
            }
            if ($generateBound) {
                switch($beanType) {
                    case 'pmse_BpmnArtifact':
                        $element_type = 'bpmnArtifact';
                        break;
                    default:
                        $element_type = '';
                }
                $boundBean->bou_uid = PMSEEngineUtils::generateUniqueID();
                $boundBean->dia_id = $keysArray['dia_id'];
                $boundBean->element_id = $keysArray['dia_id'];
                $boundBean->bou_element_type = $element_type;
                $boundBean->bou_element = $savedId;
                $boundBean->save();
            }
        }
    }


    /**
     * Save the ID from the dependencyKeys array if it exists
     * @param array $definition
     * @param string $field
     * @return array Updated $defintion with ID set
     */
    public function addDependencyIdToDefinition(array $definition, string $field)
    {
        $oldId = $definition[$field];
        $dependencyKeys = $this->getDependencyKeys();
        $definition[$field] = $dependencyKeys[$oldId] ?? '';
        return $definition;
    }

    /**
     * @codeCoverageIgnore
     * Displays the import result response as a JSON string
     */
    public function displayResponse()
    {
        echo json_encode($this->importResult);
    }

    /**
     * Additional processing to the default flows
     */
    public function processDefaultFlows()
    {
        foreach ($this->defaultFlowList as $defaultFlow) {
            $elementBean = BeanFactory::getBean('pmse_' . $defaultFlow['bean'], $defaultFlow['id']);
            if (!empty($elementBean)) {
                $flowBean = BeanFactory::getBean('pmse_BpmnFlow', $this->savedElements['bpmnFlows'][$defaultFlow['default_flow_value']]);
                if (!empty($flowBean)){
                    $elementBean->{$defaultFlow['default_flow_field']} = $flowBean->id;
                    $elementBean->save();
                }
            }
        }
    }

    /**
     * Change name of modules to new version
     * @codeCoverageIgnore
     * @param $message
     * @return mixed
     * @deprecated
     */
    private function changeEventMessage($message)
    {
        $arr = array(
            'LEAD' => 'Leads',
            'OPPORTUNITIES' => 'Opportunities',
            'DOCUMENTS' => 'Documents'
        );
        if (array_key_exists($message, $arr)) {
            return $arr[$message];
        } else {
            return $message;
        }
    }

    private function getElementDefinition($element)
    {
        $definition = array();
        $bound = array();
        if (!empty($element)) {
            foreach ($element as $key => $value) {
                $pos = strpos($key, 'bound_');
                if ($pos !== false) {
                    $bound[substr($key, strlen('bound_'))] = $value;
                    unset($element[$key]);
                }
                $pos = strpos($key, 'def_');
                if ($pos !== false) {
                    $definition[substr($key, strlen('def_'))] = $value;
                    unset($element[$key]);
                }
            }
        } else {
            $element = array();
        }
        return array($element, $definition, $bound);
    }

    private function createRelatedDependencyTerminateProcess($pro_id, $pro_terminate_variables)
    {
        $fakeEventData = array(
            'id' => 'TERMINATE',
            'evn_type' => 'GLOBAL_TERMINATE',
            'evn_criteria' => $pro_terminate_variables,
            'evn_behavior' => 'CATCH',
            'pro_id' => $pro_id
        );
        $this->getDependenciesWrapper()->processRelatedDependencies($fakeEventData);
    }
}
