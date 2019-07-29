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
 * Exports a record of a table in the database
 *
 * This class exports a record from a table in the database to a file
 * by encrypting its contents, to be transported from one instance to another.
 * @package PMSE
 */
class PMSEExporter
{
    /**
     * The process bean
     * @var SugarBean
     */
    protected $bean;

    /**
     * The module for the child importer bean
     * @var string
     */
    protected $beanModule;

    /**
     * @var $uid
     * @access private
     */
    protected $uid;

    /**
     * @var $name
     * @access private
     */
    protected $name;

    /**
     * @var $extension
     * @access private
     */
    protected $extension;

    /**
     * list of dependencies for export
     * @var array
     */
    protected $dependencies = [
        'email_template',
        'business_rule',
    ];

    /**
     * Constructor, will be deprecated in a future release
     */
    public function __construct()
    {
        $this->deprecateConstructor();
    }

    /**
     * Deprecation notice for all constructors
     */
    protected function deprecateConstructor()
    {
        $msg = 'Constructors for PMSE Exporters will be deprecated in a future release. ' .
               'Please use $this->getBean() when a process bean is needed.';
        LoggerManager::getLogger()->deprecated($msg);
        $this->setBean();
    }

    /**
     * Set Bean.
     * @codeCoverageIgnore
     * @param SugarBean $bean
     * @return void
     */
    public function setBean(SugarBean $bean = null)
    {
        if ($bean === null) {
            $this->bean = BeanFactory::newBean($this->beanModule);
        } else {
            $this->bean = $bean;
        }
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
     * Set UID.
     * @codeCoverageIgnore
     * @param string $uid
     * @return void
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Set Name.
     * @codeCoverageIgnore
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set Extension.
     * @codeCoverageIgnore
     * @param string $extension
     * @return void
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * Method to download a file exported
     * @codeCoverageIgnore
     */
    public function exportProject($id, ServiceBase $api)
    {
        $projectContent = $this->getProject(array('id' => $id));

        // add dependencies when exporting a process definition
        if ($this->getBean() instanceof pmse_Project) {
            $projectContent = $this->addDependencies($projectContent);
        }

        //File Name
        $filename = str_replace(' ', '_', $projectContent['project'][$this->name]) . '.' . $this->extension;

        $api->setHeader("Content-Disposition", "attachment; filename=" . $filename);
        $api->setHeader("Content-Type", "application/" . $this->extension);
        $api->setHeader("Expires", "Mon, 26 Jul 1997 05:00:00 GMT");
        $api->setHeader("Last-Modified", TimeDate::httpTime());
        $api->setHeader("Cache-Control", "max-age=0");
        $api->setHeader("Pragma", "public");

        return json_encode($projectContent);
    }

    /**
     * Adds the dependencies like email templates and business rules when exporting
     * a process definition
     * @param array $projectContent
     * @return array
     */
    private function addDependencies(array $projectContent)
    {
        foreach ($this->dependencies as $dependency) {
            // get the related email template and business rules ids
            if ($ids = $this->getDependentElementIds($dependency, $projectContent)) {
                // now add the content for import
                $dependencyContent = $this->getDependentContent($ids, $dependency);
                // no point adding dependencies if there isn't any
                if (!empty($dependencyContent)) {
                    $projectContent['dependencies'][$dependency] = $dependencyContent;
                }
            }
        }
        return $projectContent;
    }

    /**
     * Grabs the email template or business rule ids for the associated process definition id
     * @param string $dependency email_template or business_rule
     * @param array $projectContent process definition content
     * @return array element ids array
     */
    private function getDependentElementIds(string $dependency, array $projectContent)
    {
        $ids = array();

        switch ($dependency) {
            case 'email_template':
                $activities = $projectContent['project']['diagram']['events'];
                foreach ($activities as $activity) {
                    if ($activity['evn_marker'] == 'MESSAGE' && $activity['evn_behavior'] == 'THROW') {
                        // we don't wanna add null values
                        if (!empty($activity['def_evn_criteria'])) {
                            $ids[$activity['def_evn_criteria']] = $activity['def_evn_criteria'];
                        }
                    }
                }
                break;
            case 'business_rule':
                $activities = $projectContent['project']['diagram']['activities'];
                foreach ($activities as $activity) {
                    if ($activity['act_script_type'] == 'BUSINESS_RULE') {
                        // we don't wanna add null values
                        if (!empty($activity['def_act_fields'])) {
                            $ids[$activity['def_act_fields']] = $activity['def_act_fields'];
                        }
                    }
                }
                break;
            default:
        }

        return $ids;
    }

    /**
     * Grabs the content for email template/business rules
     * @param array $ids email template or business rule ids
     * @param string $type exporter type
     * @return array content
     */
    public function getDependentContent(array $ids, string $type)
    {
        $content = array();
        foreach ($ids as $value) {
            // get the exporter type
            $exporter = $this->getExporter($type);
            // we don't wanna add metadata again
            $projectData = $exporter->getProject(array('id' => $value, 'project_only' => true));
            if (isset($projectData['project'])) {
                $content[] = $projectData['project'];
            }
        }
        return $content;
    }

    /**
     * Gets the exporter for the specified type
     * @param string $type
     * @return ProcessManager\PMSE
     */
    public function getExporter(string $type)
    {
        // because we need to format the exporter name since `_` isn't valid
        // in case of email templates and business rules
        return ProcessManager\Factory::getPMSEObject(str_replace('_', '', ucwords($type, '_')) . 'Exporter');
    }

    /**
     * Gets data for a bean, and tags on that bean as well
     * @param SugarBean $bean The process bean
     * @return array
     */
    protected function getBeanData(SugarBean $bean)
    {
        // If there is a fetched row for this bean, grab the data
        if ($bean->fetched_row !== false) {
            $ret = (array) $bean->fetched_row;

            // Add tags as a collection property of the bean
            if (($tags = $bean->getTags()) !== []) {
                // Collect them in a way the importer can handle
                foreach ($tags as $tag) {
                    $ret['tag'][$tag->name_lower] = $tag->getRecordName();
                }
            }

            // Send it back
            return $ret;
        }

        return [];
    }

    /**
     * Method to retrieve a record of the database to export.
     * @param array $args
     * @return array
     */
    public function getProject(array $args)
    {
        $this->retrieveBean($args);

        if (($data = $this->getBeanData($this->getBean())) !== []) {
            $ret = [];

            // Some imports have a specific format and won't want metadata, so
            // only add metadata if we are not explicitly asking to omit it
            if (empty($args['project_only'])) {
                // send both metadata and project as requested
                $ret['metadata'] = $this->getMetadata();
            }

            $ret['project'] = $data;

            return $ret;
        } else {
            return array('error' => true);
        }
    }

    public function retrieveBean($args)
    {
        return $this->getBean()->retrieve($args['id']);
    }

    /**
     * Method to retrieve a metadata
     * @return object
     */
    public function getMetadata()
    {
        global $sugar_flavor, $sugar_version, $sugar_config;
        $toolName = 'SugarCRM Business Process Management Suite';
        $toolVersion = '0.1';
        $metadataObject = array();
        $metadataObject['SugarCRMFlavor'] = $sugar_flavor;
        $metadataObject['SugarCRMVersion'] = $sugar_version;
        $metadataObject['SugarCRMHost'] = $sugar_config['host_name'];
        $metadataObject['SugarCRMUrl'] = $sugar_config['site_url'];
        $metadataObject['Name'] = $toolName;
        $metadataObject['Version'] = $toolVersion;
        $metadataObject['ExportDate'] = date('Y-m-d H:i:s');
        return $metadataObject;
    }
}
