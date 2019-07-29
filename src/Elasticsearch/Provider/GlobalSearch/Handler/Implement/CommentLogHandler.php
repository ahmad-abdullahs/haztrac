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

namespace Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\Implement;

use Sugarcrm\Sugarcrm\Elasticsearch\Adapter\Document;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Mapping;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Property\ObjectProperty;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Property\MultiFieldBaseProperty;
use Sugarcrm\Sugarcrm\Elasticsearch\Mapping\Property\MultiFieldProperty;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\SearchFields;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\GlobalSearch;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\AbstractHandler;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\MappingHandlerInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\SearchFieldsHandlerInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\Handler\ProcessDocumentHandlerInterface;
use Sugarcrm\Sugarcrm\Elasticsearch\Provider\GlobalSearch\SearchField;

/**
 *
 * Worklog Handler
 *
 */
class CommentLogHandler extends AbstractHandler implements
    MappingHandlerInterface,
    SearchFieldsHandlerInterface,
    ProcessDocumentHandlerInterface
{
    const COMMENTLOG_FIELD = 'commentlog';

    /**
     * Multi field definitions
     * @var array
     */
    protected $multiFieldDefs = [
        'gs_string' => [
            'type' => 'text',
            'index' => true,
            'analyzer' => 'gs_analyzer_string',
            'store' => true,
        ],

        'gs_string_wildcard' => [
            'type' => 'text',
            'index' => true,
            'analyzer' => 'gs_analyzer_string_ngram',
            'search_analyzer' => 'gs_analyzer_string',
            'store' => true,
        ],
    ];

    /**
     * Weighted boost definition
     * @var array
     */
    protected $weightedBoost = array(
        'gs_commentlog_wildcard_commentlog_entry' => 0.45,
    );

    /**
     * Highlighter field definitions
     * @var array
     */
    protected $highlighterFields = array(
        '*.gs_commentlog' => array(
            'number_of_fragments' => 0,
        ),
        '*.gs_commentlog_wildcard' => array(
            'number_of_fragments' => 0,
        ),
    );

    /**
     * Field name to use for commentlog search
     * @var string
     */
    protected $searchField = 'commentlog_search';

    /**
     * {@inheritdoc}
     */
    public function setProvider(GlobalSearch $provider)
    {
        parent::setProvider($provider);

        $provider->addSupportedTypes(array(self::COMMENTLOG_FIELD));
        $provider->addHighlighterFields($this->highlighterFields);
        $provider->addWeightedBoosts($this->weightedBoost);

        // As we are searching against commentlog_search field, we want to remap the
        // highlights from that field back to the original commentlog field.
        $provider->addFieldRemap(array($this->searchField => self::COMMENTLOG_FIELD));

        // We don't want to add the commentlog field to the queuemanager query
        // because we will populate the commentlogs seperately.
        $provider->addSkipTypesFromQueue(array(self::COMMENTLOG_FIELD));
    }


    /**
     * {@inheritdoc}
     */
    public function buildMapping(Mapping $mapping, $field, array $defs)
    {
        if (!$this->isCommentLogField($defs)) {
            return;
        }

        // Use original field to store the raw json content
        $baseObject = new ObjectProperty();
        $baseObject->setEnabled(false);
        $mapping->addModuleObjectProperty($field, $baseObject);

        // Prepare multifield
        $commentlog = new MultiFieldBaseProperty();
        foreach ($this->multiFieldDefs as $multiField => $defs) {
            $multiFieldProp = new MultiFieldProperty();
            $multiFieldProp->setMapping($defs);
            $commentlog->addField($multiField, $multiFieldProp);
        }

        // Additional fields for commentlogs
        $searchField = new ObjectProperty();
        $searchField->addProperty('commentlog_entry', $commentlog);

        $searchFieldName = $mapping->getModule() . Mapping::PREFIX_SEP . $this->searchField;
        $mapping->addObjectProperty($searchFieldName, $searchField);
    }

    /**
     * {@inheritdoc}
     */
    public function buildSearchFields(SearchFields $sfs, $module, $field, array $defs)
    {
        if (!$this->isCommentLogField($defs)) {
            return;
        }

        $commentlogFields = array('commentlog_entry');

        foreach ($commentlogFields as $commentlogField) {
            foreach ($this->multiFieldDefs as $multiField => $mdefs) {
                $sf = new SearchField($module, $defs['name'], $defs);
                $sf->setPath([$this->searchField, $commentlogField, $multiField]);
                $sfs->addSearchField($sf, $multiField . '_' . $commentlogField);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedTypes()
    {
        return array(self::COMMENTLOG_FIELD);
    }

    /**
     * {@inheritdoc}
     */
    public function processDocumentPreIndex(Document $document, \SugarBean $bean)
    {
        // skip if there is no commentlog field
        if (!isset($bean->field_defs[self::COMMENTLOG_FIELD])) {
            return;
        }
        $defs = $bean->field_defs[self::COMMENTLOG_FIELD];
        if (!$this->isCommentLogField($defs)) {
            return;
        }

        $bean->load_relationship('commentlog_link');

        if (!$bean->commentlog_link) {
            // exit when relationship don't exist
            return;
        }

        $commentlog_beans = $bean->commentlog_link->getBeans();
        $commentlogs = array();

        foreach ($commentlog_beans as $id => $commentlog_bean) {
            $commentlogs[] = $commentlog_bean->entry;
        }

        $document->setDataField($document->getType() . Mapping::PREFIX_SEP . self::COMMENTLOG_FIELD, $commentlogs);
        $document->removeDataField(self::COMMENTLOG_FIELD);

        // Format data for commentlog search fields
        $value = array(
            'commentlog_entry' => array(),
        );

        foreach ($commentlogs as $commentlog) {
            $value['commentlog_entry'][] = $commentlog;
        }

        // Set formatted value in special commentlog search field
        $searchField = $document->getType() . Mapping::PREFIX_SEP . $this->searchField;
        $document->setDataField($searchField, $value);
    }

    /**
     * Check if given field def is an commentlog field
     * @param array $defs Field definition.
     * @return boolean True if this is a commentlog field.
     */
    protected function isCommentLogField(array $defs)
    {
        return $defs['name'] === self::COMMENTLOG_FIELD;
    }
}
