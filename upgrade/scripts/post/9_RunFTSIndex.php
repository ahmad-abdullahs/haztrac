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

use Elastica\Exception\ResponseException;
use Elastica\Request;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\Implement\CommentLogHandler;
use Sugarcrm\Sugarcrm\SearchEngine\SearchEngine;
use Sugarcrm\Sugarcrm\SearchEngine\Engine\Elastic;
use Sugarcrm\Sugarcrm\Elasticsearch\Adapter\Index;

/**
 * Upgrade script to run a full FTS index.
 */
class SugarUpgradeRunFTSIndex extends UpgradeScript
{
    public $order = 9610;
    public $type = self::UPGRADE_CUSTOM;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $esVersion = $this->getEsVersion();
        if (empty($esVersion)) {
            return;
        }

        if (version_compare($this->from_version, '7.10', '<')
            || (version_compare($this->from_version, '8.0.0', '<=') && version_compare($esVersion, '6.0', '>='))
        ) {
            // do full elastic index if
            // old sugar version < 7.10
            // or old sugar version <=8.0.0 and Elastic version is 6.x
            $this->dropExistingIndex();
            $this->runFTSIndex();
        } elseif (version_compare($this->from_version, '8.3.0', '<')) {
            $this->updateIndexMapping();
        }
    }

    /**
     *
     * code base.
     */
    public function runFTSIndex()
    {
        try {
            // Since the full reindex may take a long time, only schedule the indexing for upgrade.
            // Note: After the upgrade, the cron job needs to be run before the global search
            // can be used. It includes indexing the data from database to Elastic search server.
            SearchEngine::getInstance()->scheduleIndexing(array(), true);
        } catch (Exception $e) {
            $this->log("SugarUpgradeRunFTSIndex: scheduling FTS reindex got exceptions!");
        }
    }

    /**
     * Drop the existing index
     */
    public function dropExistingIndex()
    {
        $engine = SearchEngine::getInstance()->getEngine();
        if ($engine instanceof Elastic) {
            //the old index name is unique_key from sugar config
            $name = \SugarConfig::getInstance()->get('unique_key', 'sugarcrm');
            try {
                $client = $engine->getContainer()->client;
                $index = new Index($client, $name);
                $index->delete();
                $this->log("SugarUpgradeRunFTSIndex: the existing index {$name} is deleted.");
            } catch (Exception $e) {
                if ($e instanceof ResponseException && strpos($e->getMessage(), "no such index") !== false) {
                    $this->log("SugarUpgradeRunFTSIndex: the index {$name} does not exist.");
                } else {
                    $this->log("SugarUpgradeRunFTSIndex: deleting the existing index {$name} got exceptions!");
                }
            }
        }
    }

    /**
     * Update Mapping
     */
    protected function updateIndexMapping()
    {
        $engine = SearchEngine::getInstance()->getEngine();
        if ($engine instanceof Elastic) {
            try {
                // update mapping
                $engine->getContainer()->indexManager->updateIndexMappings([], new CommentLogHandler());

                $this->log("SugarUpgradeRunFTSIndex: mappings on Elastic server have been updated.");
            } catch (Exception $e) {
                $this->log("SugarUpgradeRunFTSIndex: updating index mapping got exceptions!");
            }
        }
    }

    /**
     * @return string elasticsearch version
     * @throws \Exception
     */
    protected function getEsVersion() : string
    {
        $esVersion = null;
        $engine = SearchEngine::getInstance()->getEngine();
        if ($engine instanceof Elastic) {
            try {
                $result = $engine->getContainer()->client->request('', Request::GET);
                if ($result->isOk()) {
                    $data = $result->getData();
                    $esVersion = $data['version']['number']?? null;
                }
            } catch (Exception $e) {
                $this->log("getEsVersion: get ES version got exceptions: " . $e->getMessage());
            }
        }
        return $esVersion;
    }
}
