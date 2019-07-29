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
 * Class ADAMImporterImport a record from a file encryption
 *
 * This class imports a record of an encrypted file to a table in the database
 * @package PMSE
 */
class PMSEImporter
{

    /**
     * @var $beanFactory
     * @access private
     */
    protected $beanFactory;
    /**
     * @var $bean
     * @access private
     */
    protected $bean;

    /**
     * The module for the child importer bean
     * @var string
     */
    protected $beanModule;

    /**
     * @var $id
     * @access private
     */
    protected $id;
    /**
     * @var $name
     * @access private
     */
    protected $name;

    /**
     * @var $suffix
     * @access private
     */
    protected $suffix = '';

    /**
     * @var $extension
     * @access private
     */
    protected $extension;

    /**
     * @var $module
     * @access private
     */
    protected $module;

    /**
     * @var array $dependencyKeys
     */
    protected $dependencyKeys = [];

    /**
     * Options that can be set on this importer to handle during saving of project
     * data
     * @var array
     */
    protected $options = [];

    /**
     * Template method that allows child classes to define things to be done
     * on construct.
     */
    protected function initialize()
    {
    }

    public function __construct()
    {
        $msg = 'Constructors for PMSE Importers will be deprecated in a future release. ' .
               'Please use $this->getBean() when a process bean is needed.';
        LoggerManager::getLogger()->deprecated($msg);
        $this->setBean();
        $this->initialize();
    }

    /**
     * Sets a single option and value into this object
     * @param string $key A string option key
     * @param mixed $val A value for this option
     * @return PMSEImporter
     */
    public function setOption($key, $val)
    {
        $this->options[$key] = $val;
        return $this;
    }

    /**
     * Gets a single option by key, or a default value if key is not found
     * @param string $key The value for the option key
     * @param mixed $default A default if the key is not found
     * @return mixed
     */
    public function getOption($key, $default = null)
    {
        return array_key_exists($key, $this->options) ? $this->options[$key] : $default;
    }

    /**
     * Sets a collection of options onto this object, or merges options based on
     * $merge
     * @param array $options A key/value hash of option keys and values
     * @param boolean $merge Flag that determines merging or overriding
     * @return BusinessProcessInstaller
     */
    public function setOptions(array $options, $merge = false)
    {
        $this->options = $merge ? array_merge($this->options, $options) : $options;
        return $this;
    }

    /**
     * Gets the current option stack
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get class Bean.
     * @codeCoverageIgnore
     * @return object
     */
    public function getBean()
    {
        if (empty($this->bean)) {
            $this->setBean();
        }

        return $this->bean;
    }

    /**
     * Gets the bean ID
     * @codeCoverageIgnore
     * @return string
     */
    public function getBeanId()
    {
        return $this->getBean()->id;
    }

    /**
     * Set Bean.
     * @codeCoverageIgnore
     * @param object $bean
     * @return void
     */
    public function setBean(SugarBean $bean = null)
    {
        // If presented $bean is null, but we have not beanModule
        // Then let the $bean property of this class be null
        if ($bean === null && !empty($this->beanModule)) {
            $this->bean = BeanFactory::newBean($this->beanModule);
        } else {
            $this->bean = $bean;
        }
    }

    /**
     * Get Name of a file.
     * @codeCoverageIgnore
     * @return object
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set extension of file to be imported.
     * @codeCoverageIgnore
     * @param string $extension
     * @return void
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * get extension of file to be imported.
     * @codeCoverageIgnore
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set name of file to be imported.
     * @codeCoverageIgnore
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get dependencyKeys
     *
     * @return array
     */
    public function getDependencyKeys()
    {
        return $this->dependencyKeys;
    }

    /**
     * Method to upload a file and read content for import in database
     * @param $file
     * @param $options
     * @return bool
     * @throws SugarApiExceptionNotAuthorized
     * @throws SugarApiExceptionRequestMethodFailure
     * @codeCoverageIgnore
     */
    public function importProject($file, $options = [])
    {
        $data = $this->getDataFile($file);

        if ($this->isPAOldVersionFile($data)) {
            LoggerManager::getLogger()->fatal('PA Unsupported file. The version of this file is not currently supported.');
            $sugarApiExceptionRequestMethodFailure = new SugarApiExceptionRequestMethodFailure(
                'ERROR_PA_UNSUPPORTED_FILE'
            );
            PMSELogger::getInstance()->alert($sugarApiExceptionRequestMethodFailure->getMessage());
            throw $sugarApiExceptionRequestMethodFailure;
        }

        $project = json_decode($data, true);

        return $this->importProjectFromData($project, $options);
    }

    /**
     * Imports a project from the data in the import file, after it has been
     * decoded.
     * @param array $project Decoded project file data
     * @param array $options Additional options passed to the importer
     * @return array Success flag and id of new record if successful
     */
    public function importProjectFromData(array $project, array $options = [])
    {
        if (!empty($project['dependencies'])) {
            if (!empty($options['selectedIds'])) {
                $this->importDependencies($project['dependencies'], $options['selectedIds']);
            }
            $this->matchDependenciesByDefinition($project);
        }

        if (!empty($project) && isset($project['project'])) {
            if (in_array($project['project'][$this->module], PMSEEngineUtils::getSupportedModules())) {
                $result = $this->saveProjectData($this->validateLockedFieldGroups($project['project']));
            } else {
                $sugarApiExceptionNotAuthorized = new SugarApiExceptionNotAuthorized('EXCEPTION_NOT_AUTHORIZED');
                PMSELogger::getInstance()->alert($sugarApiExceptionNotAuthorized->getMessage());
                throw $sugarApiExceptionNotAuthorized;
            }
        } else {
            $sugarApiExceptionRequestMethodFailure = new SugarApiExceptionRequestMethodFailure('ERROR_UPLOAD_FAILED');
            PMSELogger::getInstance()->alert($sugarApiExceptionRequestMethodFailure->getMessage());
            throw $sugarApiExceptionRequestMethodFailure;
        }

        return $result;
    }

    /**
     * Import any dependencies like BRs and ETs
     * @param $dependencies
     * @param $selectedIds array of ids that represent elements the user wants imported
     */
    public function importDependencies($dependencies, $selectedIds = [])
    {
        if (empty($selectedIds)) {
            return;
        }
        foreach ($dependencies as $type => $definitions) {
            foreach ($definitions as $def) {
                $oldId = $def['id'];
                if (!in_array($oldId, $selectedIds)) {
                    continue;
                }
                $importer = PMSEImporterFactory::getImporter($type);
                $importer->setOptions($this->getOptions());
                $result = $this->processImport($importer, $def);
                $newId = $result['id'];

                // Save the old and new ids so that we can link the dependent elements later
                if (isset($oldId) && isset($newId)) {
                    $this->dependencyKeys[$oldId] = $newId;
                }
            }
        }
    }

    /**
     * Matches process dependencies like business rules and email templates with
     * existing ones in the system according to their definitions
     * @param $dependencies
     * @deprecated This method will be removed in a future release
     */
    public function matchDependencies($dependencies)
    {
        SugarLogger::getLogger()->deprecated(
            sprintf(
                'This method %s will be removed in a future release',
                __METHOD__
            )
        );
        if ($dependencies['business_rule']) {
            // Create a map of BR definitions -> BR IDs to make matching easier
            $businessRulesByDefinition = $this->mapDefinitionsToIDs($dependencies, 'business_rule');
            $this->matchDependencyDefinitions($businessRulesByDefinition, 'business_rule');
        }
        if ($dependencies['email_template']) {
            // Create a map of ET definitions -> ET IDs to make matching easier
            $emailTemplatesByDefinition = $this->mapDefinitionsToIDs($dependencies, 'email_template');
            $this->matchDependencyDefinitions($emailTemplatesByDefinition, 'email_template');
        }
    }

    /**
     * Matches process dependencies like business rules and email templates with
     * existing ones in the system according to their definitions
     * @param $project array data of the project being imported
     * @throws SugarQueryException
     */
    public function matchDependenciesByDefinition($project)
    {
        $dependencies = $project['dependencies'];
        if (isset($dependencies['business_rule'])) {
            // Create a map of BR definitions -> BR IDs to make matching easier
            $businessRulesByDefinition = $this->mapDefinitionsToIDs($dependencies, 'business_rule');
            $this->matchDependencyDefinitions($businessRulesByDefinition, 'business_rule', $project);
        }
        if (isset($dependencies['email_template'])) {
            // Create a map of ET definitions -> ET IDs to make matching easier
            $emailTemplatesByDefinition = $this->mapDefinitionsToIDs($dependencies, 'email_template');
            $this->matchDependencyDefinitions($emailTemplatesByDefinition, 'email_template', $project);
        }
    }

    /**
     * Returns an array with dependency definitions of the given type as keys,
     * and their corresponding IDs in the database as values
     * @param $dependencies
     * @param $type
     * @return array
     */
    public function mapDefinitionsToIDs($dependencies, $type)
    {
        $mapping = array();
        switch ($type) {
            case 'business_rule':
                foreach ($dependencies['business_rule'] as $businessRuleDependency) {
                    $brDefinition = $businessRuleDependency['rst_source_definition'];
                    $brId = $businessRuleDependency['id'];
                    $mapping[$brDefinition] = $brId;
                }
                break;
            case 'email_template':
                foreach ($dependencies['email_template'] as $emailTemplateDependency) {
                    $etDefinition = $this->extractDefinitionFromET($emailTemplateDependency, 'base_module') .
                        $this->extractDefinitionFromET($emailTemplateDependency, 'name') .
                        $this->extractDefinitionFromET($emailTemplateDependency, 'description') .
                        $this->extractDefinitionFromET($emailTemplateDependency, 'subject') .
                        $this->extractDefinitionFromET($emailTemplateDependency, 'body_html');
                    $etId = $emailTemplateDependency['id'];
                    $mapping[$etDefinition] = $etId;
                }
                break;
        }
        return $mapping;
    }

    /**
     * Searches the database to link any process dependencies of the given type
     * to any existing dependency that matches them by definition
     * @param $dependenciesByDefinition array mapping dependency definitions to their IDs
     * @param $dependencyType string indicating the type of dependency (business rule, email template, etc.)
     * @param $project array data of the project being imported
     * @throws SugarQueryException
     */
    public function matchDependencyDefinitions($dependenciesByDefinition, $dependencyType, $project = [])
    {
        $q = new SugarQuery();
        switch ($dependencyType) {
            case 'business_rule':
                $q->select(array('id', 'rst_source_definition'));
                $q->from(BeanFactory::getBean('pmse_Business_Rules'));
                if (!empty($project['project']['prj_module'])) {
                    $q->where()->equals('rst_module', $project['project']['prj_module']);
                }
                $result = $q->execute();
                
                // Match the business rules by definition and set their new ID references
                foreach ($result as $existingBusinessRule) {
                    $existingBRDef = $existingBusinessRule['rst_source_definition'];
                    if (isset($dependenciesByDefinition[$existingBRDef])) {
                        $oldBRId = $dependenciesByDefinition[$existingBRDef];
                        $newBRId = $existingBusinessRule['id'];
                        $this->dependencyKeys[$oldBRId] = $newBRId;
                    }
                }
                break;
            case 'email_template':
                $q->select(array('id', 'base_module', 'name', 'description', 'subject', 'body_html'));
                $q->from(BeanFactory::getBean('pmse_Emails_Templates'));
                if (!empty($project['project']['prj_module'])) {
                    $q->where()->equals('base_module', $project['project']['prj_module']);
                }
                $result = $q->execute();

                foreach ($result as $existingEmailTemplate) {
                    // Compare the stringified definition of the existing ET with the non-imported
                    // email template dependencies
                    $extractedDefinition = $this->extractDefinitionFromET($existingEmailTemplate, 'base_module') .
                        $this->extractDefinitionFromET($existingEmailTemplate, 'name') .
                        $this->extractDefinitionFromET($existingEmailTemplate, 'description') .
                        $this->extractDefinitionFromET($existingEmailTemplate, 'subject') .
                        $this->extractDefinitionFromET($existingEmailTemplate, 'body_html');
                    if (isset($dependenciesByDefinition[$extractedDefinition])) {
                        $oldETId = $dependenciesByDefinition[$extractedDefinition];
                        $newETId = $existingEmailTemplate['id'];
                        $this->dependencyKeys[$oldETId] = $newETId;
                    }
                }
                break;
        }
    }

    /**
     * Returns a stringified definition of an email template field from its contents
     * @param $emailTemplateDependency
     * @param $field
     * @return string
     */
    public function extractDefinitionFromET($emailTemplateDependency, $field)
    {
        return isset($emailTemplateDependency[$field]) ? $emailTemplateDependency[$field] . '|' : 'NULL|';
    }

    /**
     * Pass in an importer and def to import it
     *
     * @param PMSEImporter $importer
     * @param $def
     * @return array
     */
    public function processImport(PMSEImporter $importer, $def)
    {
        return $importer->saveProjectData($def);
    }

    /**
     * Checks whether there is any field group that is only partially locked.
     * @param array $project The Process Definition to be imported
     * @return array Validated Process Definition
     * @throws SugarApiExceptionError
     */
    protected function validateLockedFieldGroups($project)
    {
        $lockedFields =
            html_entity_decode($project['definition']['pro_locked_variables'], ENT_QUOTES);
        $project['definition']['pro_locked_variables'] = $lockedFields;

        $lockedFields = json_decode($lockedFields);
        if ($lockedFields) {
            $bean = BeanFactory::newBean($project[$this->module]);
            // tally the locked fields in each group
            $locked = [];
            foreach ($lockedFields as $lockedField) {
                $def = $bean->field_defs[$lockedField];
                $group = isset($def['group']) ? $def['group'] : $lockedField;
                if (isset($locked[$group])) {
                    $locked[$group][] = $lockedField;
                } else {
                    $locked[$group] = array($lockedField);
                }
            }
            // tally the number of fields in each group
            $total = [];
            foreach ($bean->field_defs as $def) {
                $group = isset($def['group']) ? $def['group'] : $def['name'];
                if (isset($total[$group])) {
                    $total[$group] += 1;
                } else {
                    $total[$group] = 1;
                }
            }
            foreach ($locked as $group => $fields) {
                if ($total[$group] > count($fields)) {
                    // found a failure
                    $msg =  "SugarBPM\u{2122}" . ' Partially Locked Field Group - Field '
                        . implode(', ', $fields) . ' locked in group ' . $group . '.';
                    LoggerManager::getLogger()->fatal($msg);
                    $sugarApiExceptionError = new SugarApiExceptionError(
                        'ERROR_AWF_PARTIAL_LOCKED_GROUP'
                    );
                    PMSELogger::getInstance()->alert($sugarApiExceptionError->getMessage());
                    throw $sugarApiExceptionError;
                }
            }
        }

        return $project;
    }

    /**
     * Detects if the string start as a serialize php file
     * @param $data
     * @return bool
     */
    protected function isPAOldVersionFile($data) {
        return (substr($data, 0, 4) == 'a:2:');
    }

    /**
     * Function to get a data for File uploaded
     * @param $file
     * @return mixed
     */
    public function getDataFile($file)
    {
        $ul = new UploadFile();
        $ul->temp_file_location = $file;
        return $ul->get_file_contents();
    }

    /**
     * Gets the name of the project from the project data. Unless the keepName
     * option is set this will try to create a revision number on the name if the
     * name exists in the system already.
     * @param array $projectData The project data array
     * @return string
     */
    protected function getProjectName(array $projectData)
    {
        $name = !empty($projectData[$this->suffix . 'name']) ? $projectData[$this->suffix . 'name'] : $projectData[$this->name];

        if ($this->getOption('keepName', false) === false) {
            $name = $this->getNameWithSuffix($name);
        }

        return $name;
    }

    /**
     * Gets the current user object
     * @return User
     */
    protected function getCurrentUser()
    {
        global $current_user;
        return $current_user;
    }

    /**
     * Handles saving the project bean as well as tagging the bean
     * @param array $projectData The project data
     */
    protected function handleProjectBeanSave($projectData)
    {
        // Load up the bean with the project data
        $this->loadBeanFromArray($this->getBean(), $projectData);

        // Get the ID of the bean we just saved
        $this->getBean()->save();

        // Save has to happen first in case it is a new bean, so that
        // proper relationships can be made
        if (isset($projectData['tag'])) {
            $this->addTagsToBean($this->getBean(), $projectData['tag']);
        }
    }

    /**
     * Method to save record in database
     * @param $projectData
     * @return array Contains ID and if import was successful
     */
    public function saveProjectData($projectData)
    {
        $result = ['success' => false];

        //Unset common fields
        $except = $this->getAllFieldExceptions(['name', 'description']);
        $projectData = PMSEEngineUtils::unsetCommonFields($projectData, $except);

        if (!isset($projectData['assigned_user_id'])) {
            $projectData['assigned_user_id'] = $this->getCurrentUser()->id;
        }

        // Load the proper name for this project
        $projectData[$this->name] = $this->getProjectName($projectData);

        // Handle the project bean save
        $this->handleProjectBeanSave($projectData);

        // If we are successful, add that to the result
        if (!$this->getBean()->in_save) {
            $result['success'] = true;
            $result['id'] = $this->getBeanId();
        }

        return $result;
    }

    /**
     * Loads a bean from an array of data.
     * @param SugarBean $bean The SugarBean object to load
     * @param array $data Key/value hash of data to load onto the bean
     */
    protected function loadBeanFromArray(SugarBean $bean, array $data)
    {
        foreach ($data as $k => $v) {
            $bean->$k = $v;
        }

        if (!empty($bean->id)) {
            $bean->new_with_id = true;
        }
    }

    /**
     * Adds tags related to the bean, if the bean is taggable
     * @param SugarBean $bean The Process Bean
     * @param array $tags Array of tags as a TagVal.lowercase => TagVal map
     */
    protected function addTagsToBean(SugarBean $bean, array $tags)
    {
        if (($field = $bean->getTagField()) !== null) {
            $link = $bean->getFieldDefinition($field)['link'];

            // Load the tag relationship
            if ($bean->load_relationship($link)) {
                $sft = new SugarFieldTag('tag');
                $rel = [];
                foreach ($tags as $tag) {
                    $rel[] = $sft->getTagBean($tag);
                }

                $sft->addTagsToBean($bean, $rel, $link, $tags);
            }
        }
    }

    /**
     * Method to validate name of record, if name is same, add number to the end the name
     * @param $name
     * @return string
     */
    public function getNameWithSuffix($name)
    {
        $nums = array();
        $where = $this->getBean()->table_name . '.' . $this->name . " LIKE " . $this->getBean()->db->quoted($name . "%");
        $rows = $this->getBean()->get_full_list($this->name, $where);
        if (!is_null($rows)) {
            foreach ($rows as $row) {
                $names[] = $row->{$this->name};
                if (preg_match("/\([0-9]+\)$/i", $row->{$this->name}) && $row->{$this->name} != $name) {
                    $aux = substr($row->{$this->name}, strripos($row->{$this->name}, '(') + 1, -1);
                    $nums[] = $aux;
                }
            }
            if (!in_array($name, $names)) {
                $newName = $name;
            } else {
                $num = (count($nums) > 0) ? max($nums) + 1 : 1;
                $newName = $name . ' (' . $num . ')';
            }

        } else {
            $newName = $name;
        }
        return $newName;
    }

    /**
     * Gets a list of exception fields for use in unsetting commone fields. If
     * the keepIds option is set, this will add the `id` attribute to the list
     * of exceptions for unsetting.
     * @param array $except Array of fields for exception
     * @return array
     */
    protected function getAllFieldExceptions(array $except = [])
    {
        // If additional exceptions were added as an option...
        $addExcept = $this->getOption('exceptUnsetFields', []);

        // Keep ID if that is being asked for
        if ($this->getOption('keepIds')) {
            $addExcept[] = 'id';
        }

        // ... merge those with the passed in exceptions
        return array_merge($except, $addExcept);
    }

    /**
     * Unsets commonly set fields from import data. All field unsetting can be
     * overridden with either explicit setting of the `$except` argument or through
     * setting of the `exceptUnsetFields` option.
     * @param array $projectData Project data array
     * @param array $except Fields to be excepted from unsetting
     * @return array
     */
    public function unsetCommonFields($projectData, $except = array())
    {
        $except = $this->getAllFieldExceptions($except);

        $special_fields = array(
            'id',
            'date_entered',
            'date_modified',
            'modified_user_id',
            'created_by',
            'deleted',
            'team_id',
            'team_set_id',
            'au_first_name',
            'au_last_name',
            'cbu_first_name',
            'cbu_last_name',
            'mbu_first_name',
            'mbu_last_name',
            'my_favorite',
            'dia_id',
            'prj_id',
            'pro_id'
        );

        // Loop and unset unless fields are excepted
        foreach ($projectData as $key => $value) {
            if (in_array($key, $special_fields) && !in_array($key, $except)) {
                unset($projectData[$key]);
            }
        }

        return $projectData;
    }
}
