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

use Sugarcrm\Sugarcrm\DependencyInjection\Container;

/**
 * Class that handles installation of business process data on install of Sugar
 */
class BusinessProcessInstaller
{
    /**
     * List of files that have been installed
     * @var array
     */
    protected $installedFiles = [];

    /**
     * List of files to be read for installation
     * @var array
     */
    protected $installFiles = [
        'bpm' => [],
        'pbr' => [],
        'pet' => [],
    ];

    /**
     * List of what has been installed, by type, since a PD *can* include
     * both BR and ET types.
     * @var array
     */
    protected $installed = [
        'bpm' => [],
        'pbr' => [],
        'pet' => [],
    ];

    /**
     * Tracks failed installatations
     * @var array
     */
    protected $failures = [];

    /**
     * List of extensions on files that are used by the installer
     * @var array
     */
    protected $exts = [
        'Process Definitions' => 'bpm',
        'Process Business Rules' => 'pbr',
        'Process Email Templates' => 'pet',
    ];

    /**
     * List of importers for each record type
     * @var array
     */
    protected $importerTypes = [
        'bpm' => 'Project',
        'pbr' => 'BusinessRule',
        'pet' => 'EmailTemplate',
    ];

    /**
     * The data directory for the business processes installation data
     * @var string
     */
    protected $dataDirectory = 'install/BusinessProcesses/data/';

    /**
     * Settings properties
     * @var array
     */
    protected $settings = [
        'category' => 'processes',
        'key' => 'sample_designs',
    ];

    /**
     * Count of files deleted as part of cleanup
     * @var int
     */
    protected $cleanupCount = 0;

    /**
     * Gets the PMSEImporter object
     * @param string $type The type of importer to get
     * @return PMSEImporter
     */
    public function getImporter(string $type)
    {
        return \PMSEImporterFactory::getImporter($type);
    }

    /**
     * Will add a data file to the code repository
     */
    public function addInstallData()
    {
        // Create a data file
        // Placeholder for when we implement this functionality
    }

    /**
     * Gathers up installation files for processing
     * @return BusinessProcessInstaller
     */
    protected function collectInstallationFiles() : BusinessProcessInstaller
    {
        $files = glob($this->dataDirectory . '*.{' . implode(',', $this->exts) . '}', GLOB_BRACE|GLOB_NOSORT);
        foreach ($files as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $this->installFiles[$ext][] = $file;
        }

        return $this;
    }

    /**
     * Gets sanitized project data from a file
     * @param string $file The file to get data from
     * @return array
     */
    public function getProjectData(string $file) : array
    {
        $content = file_get_contents($file);
        $data = json_decode($content, true);
        unset($data['metadata']);
        return $data;
    }

    /**
     * Checks if a given id for an extension file is installed
     * @param string $ext The extension file type
     * @param string $id The ID of the record in the file
     * @return boolean
     */
    protected function isInstalled(string $ext, string $id)
    {
        return !empty($this->installed[$ext][$id]);
    }

    /**
     * Marks a given id for an extension file as installed
     * @param string $ext The extension file type
     * @param string $id The ID of the record in the file
     */
    protected function markInstalled(string $ext, string $id)
    {
        $this->installed[$ext][$id] = true;
    }

    /**
     * Marks a file installed. Used for deleting installed files after
     * the process is done.
     * @param string $file Path to the file
     * @return BusinessProcessInstaller
     */
    protected function markFileInstalled($file)
    {
        $this->installedFiles[$file] = $file;
        return $this;
    }

    /**
     * Returns the list of installed files by type
     * @return array
     */
    public function getInstalledFiles()
    {
        return $this->installedFiles;
    }

    /**
     * Appends a list of installed elements onto the installed stack
     * @param array $installed List of installed elements to append
     */
    protected function appendInstalled(array $installed)
    {
        $this->installed = array_merge($this->installed, $installed);
    }

    /**
     * Runs through each install file by type and calls the proper importer to
     * do the actual importing of the data
     * @return BusinessProcessInstaller
     */
    protected function installFileData() : BusinessProcessInstaller
    {
        // Install Projects first, followed by Business Rules and Email Templates
        foreach ($this->exts as $ext) {
            foreach ($this->installFiles[$ext] as $file) {
                // This is the raw import data
                $data = $this->getProjectData($file);

                // For Process Definition, these will be the included dependencies
                $options = $this->getOptionsFromProjectData($data);

                // Needed for tracking what dependencies were already saved
                $dependencyMap = [];
                if (isset($options['dependencyMap'])) {
                    $dependencyMap = $options['dependencyMap'];
                    unset($options['dependencyMap']);
                }

                // This sets IDs and such
                $data = $this->linkIdsForProject($data);

                // Needed for tracking
                $id = $data['project']['id'];

                // If we have not already processed this data file, import it
                if (!$this->isInstalled($ext, $id)) {
                    // Mark this one as done now
                    $this->markInstalled($ext, $id);

                    // Load the importer that is needed
                    $importer = $this->getImporter($this->importerTypes[$ext]);

                    // To maintain consistency in installed data, we need to tell
                    // the importer to not reset IDs or other data of records
                    $importer->setOptions([
                        'keepIds' => true,
                        'keepData' => true,
                        'keepName' => true,
                        'exceptUnsetFields' => [
                            'id',
                            'dia_id',
                            'prj_id',
                            'pro_id',
                        ],
                    ], true);

                    // Try to import the data
                    try {
                        $result = $importer->importProjectFromData($data, $options);

                        // If we were successful then we will have an ID of the
                        // project that was imported
                        if (isset($result['id'])) {
                            $this->markInstalled($ext, $result['id']);
                            $this->markFileInstalled($file);
                        }
                    } catch (Exception $e) {
                        // Log the failure to this object
                        $this->failures[] = $data['id'];

                        // Log to the installer
                        installLog(
                            sprintf(
                                'Process Import of file %s for %s \'%s\' (ID: %s) failed',
                                $file,
                                $ext,
                                $data['name'],
                                $data['id']
                            )
                        );
                    }

                    $this->appendInstalled($dependencyMap);
                } else {
                    $this->markFileInstalled($file);
                }
            }
        }

        return $this;
    }

    /**
     * Recursively finds the value for a key in an array
     * @param array $data The input array
     * @param string $key The key to find a value for
     * @return mixed
     */
    protected function findID($data, $key)
    {
        // If the key is an element in the array, stop searching
        if (isset($data[$key])) {
            return $data[$key];
        } else {
            // Go through the array and look for the key
            foreach ($data as $k => $v) {
                // If the value is an array, search that array
                if (is_array($v) && ($ret = $this->findID($v, $key)) !== null) {
                    return $ret;
                }
            }

            // Found nothing, send it back
            return null;
        }
    }

    /**
     * Gets all associated IDs relevant to proper linking of records
     * @param array $data Project data
     * @return array
     */
    protected function linkIdsForProject(array $data)
    {
        // Business Rules, Email Templates and already modified
        // Projects will have this set, so we havine nothing to do
        if (isset($data['project']['id'])) {
            return $data;
        }

        // Find the project and process ids so we can link things better
        $prj_id = $this->findID($data['project'], 'prj_id') ?? Sugarcrm\Sugarcrm\Util\Uuid::uuid1();
        $pro_id = $this->findID($data['project'], 'pro_id') ?? Sugarcrm\Sugarcrm\Util\Uuid::uuid1();

        // Set necessary values
        $data['project']['id'] = $prj_id;
        $data['project']['prj_id'] = $prj_id;
        $data['project']['process']['id'] = $pro_id;
        $data['project']['process']['prj_id'] = $prj_id;
        $data['project']['definition']['pro_id'] = $pro_id;
        $data['project']['definition']['prj_id'] = $prj_id;

        // Send it back
        return $data;
    }

    /**
     * Gets business rule dependencies for a project
     * @param array $project Project data
     * @param array $options Existing options to append
     * @return array
     */
    protected function getBusinessRuleDependencies(array $project, array $options)
    {
        // $project['diagram']['activities'] is an array and each item is an
        // element. If the element has act_script_type = BUSINESS_RULE then you
        // need to get def_act_fields from the item for the BR id.
        if (!empty($project['diagram']['activities'])) {
            foreach ($project['diagram']['activities'] as $element) {
                if (isset($element['act_script_type']) && $element['act_script_type'] === 'BUSINESS_RULE') {
                    $options['selectedIds'][$element['def_act_fields']] = $element['def_act_fields'];
                    $options['dependencyMap']['pbr'][$element['def_act_fields']] = true;
                }
            }
        }

        return $options;
    }

    /**
     * Gets email template dependencies for a project
     * @param array $project Project data
     * @param array $options Existing options to append
     * @return array
     */
    protected function getEmailTemplateDependencies(array $project, array $options)
    {
        // $project['diagram']['events'] is an array and each item is an element.
        // If the element has evn_marker = MESSAGE then you need to get
        // def_evn_criteria from the item as the ET id.
        if (!empty($project['diagram']['events'])) {
            foreach ($project['diagram']['events'] as $element) {
                if ($this->isSendMessage($element)) {
                    $options['selectedIds'][$element['def_evn_criteria']] = $element['def_evn_criteria'];
                    $options['dependencyMap']['pet'][$element['def_evn_criteria']] = true;
                }
            }
        }

        return $options;
    }

    /**
     * For now this simply sets the selectedIDs for dependency import, as well
     * as a mapping of these dependencies by type.
     * @param array $data Project data
     * @return array
     */
    protected function getOptionsFromProjectData(array $data) : array
    {
        // Make this a little easier to get to what we need
        $project = $data['project'];

        // Start with Business Rules...
        $options = $this->getBusinessRuleDependencies($project, []);

        // Now move on to Email Templates...
        $options = $this->getEmailTemplateDependencies($project, $options);

        return $options;
    }

    /**
     * Determines if an element is a SEND MESSAGE type element
     * @param array $element Element definition
     * @return boolean
     */
    protected function isSendMessage(array $element) : bool
    {
        return isset($element['evn_marker']) && $element['evn_marker'] === 'MESSAGE' &&
            isset($element['evn_behavior']) && $element['evn_behavior'] === 'THROW';
    }

    /**
     * Gets the count of deleted install files
     * @return int
     */
    public function getCleanupCount()
    {
        return $this->cleanupCount;
    }

    /**
     * Gets whatever is currently installed by the installer
     * @return array
     */
    public function getInstalledData()
    {
        $admin = Container::getInstance()->get(Administration::class);
        $admin->retrieveSettings($this->settings['category'], true);
        if (empty($admin->settings[$this->settings['category'] . '_' . $this->settings['key']])) {
            return [];
        }

        return $admin->settings[$this->settings['category'] . '_' . $this->settings['key']];
    }

    /**
     * Saves what was done to the database
     * @return int
     */
    public function save()
    {
        $admin = Container::getInstance()->get(Administration::class);
        return $admin->saveSetting(
            $this->settings['category'],
            $this->settings['key'],
            $this->installed
        );
    }

    /**
     * This just updates the internal cache to prevent records that have been
     * installed already from being added again
     * @return BusinessProcessInstaller
     */
    public function prepareUpgrade()
    {
        $this->appendInstalled($this->getInstalledData());
        return $this;
    }

    /**
     * Kicks off the installation process
     * @return BusinessProcessInstaller
     */
    public function install() : BusinessProcessInstaller
    {
        // Get the installation data
        $this->collectInstallationFiles();

        // Process the installation data
        $this->installFileData();

        // Save the data
        $this->save();

        return $this;
    }

    /**
     * Gets the final count of what was done
     * @param string $type Either for failures, or extension type
     * @return integer
     */
    public function getFinalCount(string $type) : int
    {
        if ($type === 'failures') {
            return count($this->failures);
        } else {
            return isset($this->installed[$type]) ? count($this->installed[$type]) : 0;
        }
    }

    /**
     * Cleans up after the installer is done
     * @return BusinessProcessInstaller
     */
    public function cleanup() : BusinessProcessInstaller
    {
        // Delete the installation data files
        foreach ($this->getInstalledFiles() as $file) {
            if (unlink($file)) {
                $this->cleanupCount++;
            }
        }

        return $this;
    }

    /**
     * Collects the loggable results for logging
     * @return array
     */
    public function getInstallTotalsLog()
    {
        $ret = [];

        foreach ($this->exts as $type => $ext) {
            $count = $this->getFinalCount($ext);
            $ret[] = "Process Design $type installations: $count";
        }

        if (($fails = $this->getFinalCount('failures')) !== 0) {
            $ret[] = "Process Design installation failures: $fails";
        }

        $ret[] = "Process Design files cleaned up: {$this->cleanupCount}";

        return $ret;
    }

    /**
     * Logs final counts to the installation log
     * @return BusinessProcessInstaller
     */
    public function logInstallTotals() : BusinessProcessInstaller
    {
        foreach ($this->getInstallTotalsLog() as $entry) {
            installLog($entry);
        }

        return $this;
    }
}
