<?php

require_once 'modules/ModuleBuilder/parsers/views/AbstractMetaDataImplementation.php';

use Sugarcrm\Sugarcrm\Util\Files\FileLoader;

/**
 * Class Synolia_SynoFieldMask_Helpers_DeployerImplementation
 */
class Synolia_SynoFieldMask_Helpers_DeployerImplementation extends AbstractMetaDataImplementation
{
    const FILE_PREFIX = 'SynoFieldMask_';
    const DEPENDENCY_SUFFIX = '_synofieldmask';

    /**
     * List of Sugar Entreprise module files for which dependency files
     * do exist but without the Synolia 'dependencies' var.
     * @var array
     */
    protected $filesToCheckIfAllowed = [
        'custom/modules/Opportunities/Ext/Dependencies/deps.ext.php'
    ];



    public static $excluded_fields = array(
        'id',
        'kbdocument_revision_id',
        'outlook_id',
        'tracker_text',
        'refer_url',
        'related_doc_rev_id',
        'related_doc_id',
        'portal_app',
        'filename',
        'file_mime_type',
        'quote_type',
        'parent_type',
        'pricing_formula',
        'currency',
        'document_revision_id',
        'website',
    );
    public static $allowed_types = array(
        'varchar',
        'name',
        'phone',
    );
    public static $allowed_aliases = array(
        'upper',
        'upper_first',
        'lower',
    );

    protected $_dependencies = array();

    public $dependenciesPath = '';

    /**
     * The constructor
     * @param string $moduleName - Accounts
     * @throws Exception
     */
    public function __construct($moduleName)
    {
        $this->_fileVariables = array_merge($this->_fileVariables, array(
            'synofieldmask' => 'dependencies',
        ));

        $this->_view = 'synofieldmask';
        $this->dependenciesPath = 'custom/Extension/modules/'.$moduleName.'/Ext/Dependencies/';

        $this->bean = BeanFactory::getBean($moduleName);
        if (empty($this->bean)) {
            throw new Exception("Bean is not valid");
        }

        $this->_moduleName = $moduleName;
        $this->_fielddefs = $this->bean->field_defs;

        $locations = SugarAutoLoader::existingCustom("modules/$moduleName/metadata/dependencydefs.php");
        if ($extension = SugarAutoLoader::loadExtension("dependencies", $moduleName)) {
            $locations[] = $extension;
        }

        foreach ($locations as $loc) {
            if (in_array($loc, $this->filesToCheckIfAllowed) && !$this->moduleIsAllowed($loc)) {
                continue;
            }
            $loadData = $this->_loadFromFile($loc);
            if ($loadData !== null) {
                $this->_dependencies = $loadData;
            }
        }
    }

    public function moduleIsAllowed($filename)
    {
        try {
            $GLOBALS['log']->debug(get_class($this)."->_loadFromFile(): reading from ".$filename );

            require FileLoader::validateFilePath($filename);
            // loads the viewdef - must be a require not require_once
            // to ensure can reload if called twice in succession
        } catch (\Exception $e) {
            $GLOBALS['log']->warning(sprintf('Failed to valid file name : %s', $filename, $e->getMessage()));
            return false;
        }

        // Check to see if we have the module name set as a variable rather than embedded in the $viewdef array
        // If we do, then we have to preserve the module variable when we write the file back out
        // This is a format used by ModuleBuilder templated modules to speed the renaming of modules
        // OOB Sugar modules don't use this format

        $moduleVariables = array ( 'module_name' , '_module_name' , 'OBJECT_NAME' , '_object_name' ) ;

        $variables = array ( ) ;
        foreach ($moduleVariables as $name) {
            if (isset ( $$name )) {
                $variables [ $name ] = $$name ;
            }
        }

        // Extract the layout definition from the loaded file - the layout definition is held under a variable name that varies between the various layout types (e.g., listviews hold it in listViewDefs, editviews in viewdefs)
        $viewVariable = $this->_fileVariables [ $this->_view ] ;

        return isset($$viewVariable);
    }


    /**
     * Write the metadata for SynoFieldMask
     * @param boolean $refresh
     */
    public function deploy($refresh = false)
    {
        foreach ($this->getDependencies() as $depName => $depOptions) {
            $contentFile = array();

            // Override parameters for writing file using parent methods
            $this->_variables = array('module_name' => '"'.$this->_moduleName.'"]["'.$depName.'"');
            $this->_fileVariables['synofieldmask'] = 'dependencies["'.$this->_moduleName.'"]["'.$depName.'"]';

            // we are not trying to remove a dependency
            if ($depOptions !== null) {
                $contentFile = $depOptions;
            }

            $this->_saveToFile($this->dependenciesPath.self::FILE_PREFIX.self::convertDependencyNameToFieldName($depName).'.php', $contentFile, false, true);

            if ($refresh) {
                self::refreshMeta(array($this->_moduleName));
            }
        }
    }

    /**
     * Apply a mask for a field, it manage creation or update of the related
     * dependency
     * @param string  $fieldname field name key
     * @param string  $mask      mask used by the js plugin (https://github.com/RobinHerbots/jquery.inputmask)
     * @param boolean $deploy    deploy after setting mask
     * @return bool|void
     */
    public function setFieldMask($fieldname, $mask, $deploy = false)
    {
        if (!array_key_exists($fieldname, $this->getFieldsdefs())) {
            $GLOBALS['log']->fatal(get_class($this).'->setFieldMask: field "'.$fieldname.'" not exist in module "'.$this->_moduleName.'"');

            return;
        }

        if (!is_array($this->_dependencies)) {
            $this->_dependencies = array();
        }

        $dependencyName = self::convertFieldNameToDependencyName($fieldname);
        $oldMask = $this->getFieldMask($fieldname);

        // Test if it is an update
        if ($oldMask != $mask && $oldMask != '' && isset($this->_dependencies[$dependencyName])) {
            // Remove the related dependency if mask is empty
            if ($mask == '') {
                $this->_dependencies[$dependencyName] = null;
            } else {
                $this->_setMaskValue($dependencyName, $mask);
            }
        } elseif ($mask != '') {
            $this->_dependencies[$dependencyName] = array(
                'hooks' => array(
                    0 => 'edit',
                    1 => 'save'
                ),
                'trigger' => 'true',
                'triggerFields' => array(
                    0 => $fieldname,
                ),
                'onload' => true,
                'actions' => array(
                    0 => array(
                        'name' => 'SetSynoFieldMask',
                        'params' => array(
                            'target' => $fieldname,
                            'label' => $fieldname.'_label',
                            'value' => array(),
                        ),
                    ),
                ),
            );

            $this->_setMaskValue($dependencyName, $mask);
        } else {
            return false;
        }

        if ($deploy) {
            $this->deploy();
        }

        return true;
    }

    protected function _setMaskValue($dependencyName, $mask, $numAction = 0)
    {
        try {
            if (self::isAlias($mask)) {
                $this->_dependencies[$dependencyName]['actions'][$numAction]['params']['value'] = $mask;
            } else {
                if (!isset($this->_dependencies[$dependencyName]['actions'][$numAction]['params']['value']['mask'])) {
                    $this->_dependencies[$dependencyName]['actions'][$numAction]['params']['value'] = array(
                        'mask' => '',
                    );
                }
                $this->_dependencies[$dependencyName]['actions'][$numAction]['params']['value']['mask'] = $mask;

                // Force greedy => false option for optionnal mask
                $this->_dependencies[$dependencyName]['actions'][$numAction]['params']['value']['greedy'] = false;
            }
        } catch (Exception $e) {
            $GLOBALS['log']->fatal(get_class($this).'->getFieldMask: not valid dependency options for setMaskValue()');
        }
    }

    /**
     * find the dependency deployed for a field
     * @param  string $fieldName field name key
     * @return array  the dependency options
     */
    public function getDependencyLinkedField($fieldName)
    {
        $targetDependencyName = self::convertFieldNameToDependencyName($fieldName);

        foreach ($this->getDependencies() as $dependencyName => $dependencyOptions) {
            if ($targetDependencyName == $dependencyName) {
                return $dependencyOptions;
            }
        }

        return;
    }

    /**
     * get the mask value deployed for a field
     * @param  string $fieldName field name key
     * @return string mask value
     */
    public function getFieldMask($fieldName)
    {
        $depOptions = $this->getDependencyLinkedField($fieldName);

        return $this->_getMaskValue($depOptions);
    }

    protected function _getMaskValue($depOptions, $numAction = 0)
    {
        $mask = '';

        if (!$depOptions) {
            return $mask;
        }

        try {
            if (isset($depOptions['actions'][$numAction]['params']['value']) && is_string($depOptions['actions'][$numAction]['params']['value'])) {
                if (self::isAlias($depOptions['actions'][$numAction]['params']['value'])) {
                    $mask = $depOptions['actions'][$numAction]['params']['value'];
                }
            } elseif (isset($depOptions['actions'][$numAction]['params']['value']['mask'])) {
                $mask = $depOptions['actions'][$numAction]['params']['value']['mask'];
            }
        } catch (Exception $e) {
            $GLOBALS['log']->fatal(get_class($this).'->getFieldMask: not valid dependency options for getMaskValue()');
        }

        return $mask;
    }

    /**
     * retrieve the dependency loaded with a filter option
     * @param  boolean $filtered active filter for fieldmask's dependencies
     * @return array   dependencies loaded
     */
    public function getDependencies($filtered = true)
    {
        if (is_array($this->_dependencies)) {
            if ($filtered) {
                return self::filterFieldMasksDependencies($this->_dependencies);
            }

            return $this->_dependencies;
        }

        return array();
    }

    /**
     * retrieve the fields definitions with a filter option
     * @param  boolean $filtered active filter for fieldmask's allowed field definitions
     * @return array   field definitions
     */
    public function getFieldsdefs($filtered = true)
    {
        $fielddefs = $this->getFielddefs();
        $module_fields = array();

        foreach ($fielddefs as $kfield => $kfielddef) {
            if ($filtered) {
                if (
                    !empty($kfielddef['vname'])
                    &&  ((!empty($kfielddef['source']) && $kfielddef['source'] != 'non-db') || empty($kfielddef['source']))
                    &&  ((!empty($kfielddef['dbType']) && $kfielddef['dbType'] != 'id') || empty($kfielddef['dbType']))
                    &&  !in_array($kfielddef['name'], self::$excluded_fields)
                    &&  !empty($kfielddef['type'])
                    &&  in_array($kfielddef['type'], self::$allowed_types)
                ) {
                    if (empty($kfielddef['required'])) {
                        $kfielddef['required'] = 'false';
                    }
                    if (empty($kfielddef['audited'])) {
                        $kfielddef['audited'] = false;
                    }
                    if (empty($kfielddef['importable'])) {
                        $kfielddef['importable'] = 'false';
                    }
                    if (empty($kfielddef['reportable'])) {
                        $kfielddef['reportable'] = false;
                    }

                    $module_fields[$kfield] = $kfielddef;
                }
            } else {
                $module_fields[$kfield] = $kfielddef;
            }
        }

        ksort($module_fields, SORT_LOCALE_STRING);

        return $module_fields;
    }

    /**
     * hack field definitions for old admin template
     * @param  array $fielddefs field definitions
     * @return array updated field definitions
     */
    public function formatFieldDefsForAdmin($fielddefs)
    {
        $module_fields = array();

        if (!isset($fielddefs['help'])) {
            $fielddefs['help'] = '';
        }

        $module_fields[translate($fielddefs['vname'], $this->_moduleName)] = array(
            'name' => $fielddefs['name'],
            'vname' => translate($fielddefs['vname'], $this->_moduleName),
            'required' => $fielddefs['required'],
            'audited' => $fielddefs['audited'],
            'importable' => $fielddefs['importable'],
            'reportable' => $fielddefs['reportable'],
            'help' => $fielddefs['help'],
        );

        if (
            (
                $this->_moduleName == 'Leads' &&  (
                    $fielddefs['name'] == 'account_name'
                    ||  $fielddefs['name'] == 'first_name'
                )
            )
            ||
            (
                $this->_moduleName == 'Contacts' &&  (
                    $fielddefs['name'] == 'first_name'
                )
            )
        ) {
            $module_fields[translate($fielddefs['vname'], $this->_moduleName)]['custom_code'] = 'custom_code';
        } else {
            $module_fields[translate($fielddefs['vname'], $this->_moduleName)]['custom_code'] = '';
        }

        return $module_fields;
    }

    // *****
    // TOOLS
    // *****
    public static function refreshMeta(array $modules = array())
    {
        if(empty($modules)) {
            $modules = array($GLOBALS['mod_strings']['LBL_ALL_MODULES']);
        }

        if (!empty($_REQUEST['repair_silent'])) {
            $old_value = $_REQUEST['repair_silent'];
        }

        $_REQUEST['repair_silent'] = '1';
        $autoexecute = false; //execute the SQL
        $show_output = false; //output to the screen
        require_once 'modules/Administration/QuickRepairAndRebuild.php';
        $repair = new RepairAndClear();
        $repair->repairAndClearAll(array('clearAll'), $modules, $autoexecute, $show_output, '');

        if (!empty($old_value)) {
            $_REQUEST['repair_silent'] = $old_value;
        }
    }

    public static function isAlias($mask)
    {
        return in_array($mask, self::$allowed_aliases);
    }

    public static function convertFieldNameToDependencyName($fieldName)
    {
        if ($fieldName) {
            return $fieldName.self::DEPENDENCY_SUFFIX;
        }

        return '';
    }

    public static function convertDependencyNameToFieldName($dependencyName)
    {
        if ($dependencyName) {
            return substr($dependencyName, 0, strlen(self::DEPENDENCY_SUFFIX) * -1);
        }

        return '';
    }

    public static function filterFieldMasksDependencies($dependencies)
    {
        $filteredDependencies = array();
        foreach ($dependencies as $dependencyName => $dependencyOptions) {
            if (substr($dependencyName, strlen(self::DEPENDENCY_SUFFIX) * -1) == self::DEPENDENCY_SUFFIX) {
                $filteredDependencies[$dependencyName] = $dependencyOptions;
            }
        }

        return $filteredDependencies;
    }

    public static function getModulesAvailables()
    {
        global $sugar_config;
        require_once 'modules/ModuleBuilder/Module/StudioBrowser.php';
        $sb = new StudioBrowser();
        $sb->loadModules();

        $modules = array();
        $moduleNames = array();

        foreach ($sb->modules as $key => $module) {
            if ($key != 'KBDocuments'
                &&  $key != 'ProductBundleNotes'
                &&  $key != 'ProductBundles'
                &&  $key != 'ProductCategories'
                &&  $key != 'Products'
                &&  $key != 'ProductTemplates'
                &&  $key != 'ProductTypes'
                &&  $key != 'Project'
                &&  $key != 'ProjectResources'
                &&  $key != 'ProjectTask'
            ) {
                $modules[$key] = $module;
                $moduleNames[$key] = $module->name;
            }
        }

        asort($moduleNames, SORT_LOCALE_STRING);

        //maj cache available modules
        $availableModules = "";
        if (!empty($sugar_config['synoFieldMaskAvailableModules'])) {
            $availableModules = $sugar_config['synoFieldMaskAvailableModules'];
        }

        if (empty($availableModules) ||
            (!empty($availableModules) && $availableModules != json_encode(array_keys($moduleNames)))
        ) {
            $parameters = array();
            $parameters['synoFieldMaskAvailableModules'] = json_encode(array_keys($moduleNames));
            self::addToConfig($parameters);
        }

        return array($modules, $moduleNames);
    }

    public static function addToConfig($parameters)
    {
        require_once 'modules/Configurator/Configurator.php';
        $cfg                    = new Configurator();

        $sugarConfig = SugarConfig::getInstance();
        foreach ($parameters as $key => $value) {
            $cfg->allow_undefined[] = $key;

            if (isset($cfg->config[$key]) || in_array($key, $cfg->allow_undefined)) {
                if (strcmp("$value", 'true') == 0) {
                    $value = true;
                }
                if (strcmp("$value", 'false') == 0) {
                    $value = false;
                }
                $cfg->config[$key] = $value;
            } else {
                $v = $sugarConfig->get(str_replace('_', '.', $key));
                if ($v  !== null) {
                    setDeepArrayValue($cfg->config, $key, $value);
                }
            }
        }

        $cfg->handleOverride();
    }
}


