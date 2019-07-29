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

use Sugarcrm\Sugarcrm\MetaData\ViewdefManager;

class QuotesConfigApi extends ConfigModuleApi
{
    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function registerApiRest()
    {
        return
            array(
                'quotesConfigGet' => array(
                    'reqType' => 'GET',
                    'path' => array('Quotes', 'config'),
                    'pathVars' => array('module', ''),
                    'minVersion' => '11.3',
                    'method' => 'config',
                    'shortHelp' => 'Retrieves the config settings for a given module',
                    'longHelp' => 'modules/Quotes/clients/base/api/help/quotes_module_config_get_help.html',
                ),
                'quotesConfigCreate' => array(
                    'reqType' => 'POST',
                    'path' => array('Quotes', 'config'),
                    'pathVars' => array('module', ''),
                    'minVersion' => '11.3',
                    'method' => 'configSave',
                    'shortHelp' => 'Save the config settings for the Quotes Module',
                    'longHelp' => 'modules/Quotes/clients/base/api/help/quotes_module_config_post_help.html',
                ),
            );
    }

    /**
     * {@inheritdoc}
     */
    public function config(ServiceBase $api, array $args)
    {
        $viewdefManager = $this->getViewdefManager();

        $quotesConfig = parent::config($api, $args);
        $quotesConfig['dependentFields'] = $this->getDependentFields();
        $quotesConfig['relatedFields'] = $this->getRelatedFieldsMap();

        $parser = ParserFactory::getParser(
            MB_LISTVIEW,
            'Products',
            null,
            null,
            'base'
        );

        $defaultDiscountAmt = array(
            'name' => 'discount',
            'type' => 'fieldset',
            'css_class' => 'quote-discount-percent',
            'label' => 'LBL_DISCOUNT_AMOUNT',
            'fields' => array(
                array(
                    'name' => 'discount_amount',
                    'label' => 'LBL_DISCOUNT_AMOUNT',
                    'type' => 'discount',
                    'convertToBase' => true,
                    'showTransactionalAmount' => true,
                ),
                array(
                    'type' => 'discount-select',
                    'name' => 'discount_select',
                    'no_default_action' => true,
                    'buttons' => array(
                        array(
                            'type' => 'rowaction',
                            'name' => 'select_discount_amount_button',
                            'label' => 'LBL_DISCOUNT_AMOUNT',
                            'event' => 'button:discount_select_change:click',
                        ),
                        array(
                            'type' => 'rowaction',
                            'name' => 'select_discount_percent_button',
                            'label' => 'LBL_DISCOUNT_PERCENT',
                            'event' => 'button:discount_select_change:click',
                        ),
                    ),
                ),
            ),
        );

        $quotesConfig['defaultWorksheetColumns'] = $viewdefManager->loadViewdef('base', 'Products', 'quote-data-group-list', true);

        $quotesConfig['productsFields'] = array_merge(
            $parser->getAvailableFields(),
            $parser->getDefaultFields(),
            array('discount' => $defaultDiscountAmt)
        );

        $parser = ParserFactory::getParser(
            MB_LISTVIEW,
            'Quotes',
            null,
            null,
            'base'
        );
        $quotesConfig['quotesFields'] = array_merge($parser->getAvailableFields(), $parser->getDefaultFields());

        return $quotesConfig;
    }

    /**
     * Quotes Override since we have custom logic that needs to be ran
     *
     * {@inheritdoc}
     */
    public function configSave(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, array('worksheet_columns', 'worksheet_columns_related_fields'));
        $settings = parent::configSave($api, $args);
        $this->applyWorksheetColumnsConfig();
        $this-> applySummaryColumnsConfig();
        $this-> applyFooterRowsConfig();

        MetaDataManager::refreshModulesCache(array('Quotes', 'Products'));

        return $settings;
    }

    /**
     * Gets a list of all fields and their related and locked dependencies
     *
     * @return array
     */
    protected function getRelatedFieldsMap()
    {
        $fieldVardefs = array(
            'Products' => VardefManager::getFieldDefs('Products'),
            'Quotes' => VardefManager::getFieldDefs('Quotes'),
        );

        $productsFieldNames = array_keys($fieldVardefs['Products']);
        $quotesFieldNames = array_keys($fieldVardefs['Quotes']);

        $resultArray = array_merge($this->getAllFieldDependencies(
            'Products',
            $productsFieldNames,
            $fieldVardefs
        ), $this->getAllFieldDependencies(
            'Quotes',
            $quotesFieldNames,
            $fieldVardefs
        ));

        return $resultArray;
    }

    /**
     * Finds all dependencies on a field by field name
     *
     * @param string $moduleName The name of the module for the fieldDef we're parsing
     * @param array $fieldNames The names of all the fields to loop over and parse
     * @param array $fieldDefs The collection of all field definitions
     * @return array The map of all field dependencies
     */
    protected function getAllFieldDependencies(string $moduleName, array $fieldNames, array $fieldDefs)
    {
        $retFields = array();
        foreach ($fieldNames as $fieldName) {
            $fieldDef = $fieldDefs[$moduleName][$fieldName];

            if (isset($fieldDef['formula'])) {
                // check variables links
                $fieldsInFormula = Parser::getFieldsFromExpression($fieldDef['formula']);

                if (count($fieldsInFormula)) {
                    $matches = array_unique($fieldsInFormula);

                    foreach ($matches as $lockedField) {
                        if ($fieldName === $lockedField) {
                            continue;
                        }

                        if (!isset($retFields[$moduleName][$fieldName])) {
                            $retFields[$moduleName][$fieldName] = array();
                        }

                        if (!isset($retFields[$moduleName][$fieldName]['locked'])) {
                            $retFields[$moduleName][$fieldName]['locked'] = array();
                        }

                        if (!isset($retFields[$moduleName][$fieldName]['locked'][$lockedField])) {
                            $retFields[$moduleName][$fieldName]['locked'][$lockedField] = array(
                                'module' => $moduleName,
                                'field' => $fieldName,
                                'reason' => 'formula',
                            );
                        }
                    }
                }
            }

            if (isset($fieldDef['related_fields'])) {
                foreach ($fieldDef['related_fields'] as $relatedField) {
                    if (!isset($retFields[$moduleName][$fieldName])) {
                        $retFields[$moduleName][$fieldName] = array();
                    }

                    if (!isset($retFields[$moduleName][$fieldName]['related'])) {
                        $retFields[$moduleName][$fieldName]['related'] = array();
                    }

                    if (!isset($retFields[$moduleName][$fieldName]['related'][$relatedField])) {
                        $retFields[$moduleName][$fieldName]['related'][$relatedField] = array(
                            'module' => $moduleName,
                            'field' => $fieldName,
                            'reason' => 'related_fields',
                        );
                    }
                }
            }
        }

        return $retFields;
    }

    /**
     * Gets the field dependencies list
     *
     * @return array
     */
    protected function getDependentFields()
    {
        $mm = MetaDataManager::getManager();

        $quotesFieldNames = array_merge(
            $mm->getModuleViewFields('Quotes', 'record'),
            $mm->getModuleViewFields('Quotes', 'quote-data-grand-totals-header'),
            $mm->getModuleViewFields('Quotes', 'quote-data-grand-totals-footer')
        );
        $pbFieldNames = array_merge(
            $mm->getModuleViewFields('ProductBundles', 'quote-data-group-header'),
            $mm->getModuleViewFields('ProductBundles', 'quote-data-group-footer')
        );
        $productsFieldNames = $mm->getModuleViewFields('Products', 'quote-data-group-list');

        $fieldVardefs = array(
            'Quotes' => VardefManager::getFieldDefs('Quotes'),
            'ProductBundles' => VardefManager::getFieldDefs('ProductBundles'),
            'Products' => VardefManager::getFieldDefs('Products'),
        );

        $qFields = $this->getDependenciesFromFields(
            'Quotes',
            $quotesFieldNames,
            $fieldVardefs
        );

        $pbFields = $this->getDependenciesFromFields(
            'ProductBundles',
            $pbFieldNames,
            $fieldVardefs
        );
        $pFields = $this->getDependenciesFromFields(
            'Products',
            $productsFieldNames,
            $fieldVardefs
        );

        $retFields = [
            'Quotes' => [],
            'ProductBundles' => [],
            'Products' => [],
        ];

        $retFields['Quotes'] = array_merge(
            $qFields['Quotes'] ?? [],
            $pbFields['Quotes'] ?? [],
            $pFields['Quotes'] ?? []
        );

        $retFields['ProductBundles'] = array_merge(
            $qFields['ProductBundles'] ?? [],
            $pbFields['ProductBundles'] ?? [],
            $pFields['ProductBundles'] ?? []
        );

        $retFields['Products'] = array_merge(
            $qFields['Products'] ?? [],
            $pbFields['Products'] ?? [],
            $pFields['Products'] ?? []
        );

        return $retFields;
    }

    /**
     * Gets the dependencies from a specific field and recurses any fields in it's field dependencies list
     *
     * @param string $moduleName The name of the module for the fieldDef we're parsing
     * @param array $fieldNames The names of all the fields to loop over and parse
     * @param array $fieldDefs The collection of all field definitions
     * @param array $retFields The map of all field dependencies we're returning
     */
    protected function getDependenciesFromFields(string $moduleName, array $fieldNames, array $fieldDefs)
    {
        $retFields = array();
        foreach ($fieldNames as $fieldName) {
            if (isset($fieldDefs[$moduleName][$fieldName])) {
                $fieldDef = $fieldDefs[$moduleName][$fieldName];

                if (isset($fieldDef['formula'])) {
                    $this->parseFieldFormula($moduleName, $fieldDef, $fieldDefs, $retFields);
                }

                if (isset($fieldDef['related_fields'])) {
                    $this->parseFieldRelatedFields($moduleName, $fieldDef, $fieldDefs, $retFields);
                }
            }
        }
        return $retFields;
    }

    /**
     * Parses a fieldDef's formula to pull out any variables or link fields
     *
     * @param string $moduleName The name of the module for the fieldDef we're parsing
     * @param array $fieldDef The Field definition to parse
     * @param array $fieldDefs The collection of all field definitions
     * @param array $retFields The map of all field dependencies we're returning
     */
    protected function parseFieldFormula(string $moduleName, array $fieldDef, array $fieldDefs, array &$retFields)
    {
        $matches = array();
        $fieldName = $fieldDef['name'];

        // check ProductBundles links
        $expr = Parser::evaluate($fieldDef['formula'], $this);
        $fields = Parser::getFormulaRelateFields($expr, 'product_bundles');

        //$fields = Parser::getFormulaRelateFields($fieldDef['formula']);
        if (count($fields)) {
            foreach ($fields as $lockedField) {
                if (!isset($retFields['ProductBundles'][$lockedField])) {
                    $retFields['ProductBundles'][$lockedField] = array();
                }

                if (!isset($retFields['ProductBundles'][$lockedField]['locked'])) {
                    $retFields['ProductBundles'][$lockedField]['locked'] = array();
                }

                if (!isset($retFields['ProductBundles'][$lockedField]['locked'][$fieldName])) {
                    $retFields['ProductBundles'][$lockedField]['locked'][$fieldName] = array(
                        'module' => $moduleName,
                        'field' => $fieldName,
                        'reason' => 'rollup',
                    );
                }

                $rollupField = $fieldDefs['ProductBundles'][$lockedField];
                if (isset($rollupField['formula'])) {
                    $this->parseFieldFormula(
                        'ProductBundles',
                        $rollupField,
                        $fieldDefs,
                        $retFields
                    );
                }
                if (isset($rollupField['related_fields'])) {
                    $this->parseFieldRelatedFields(
                        'ProductBundles',
                        $rollupField,
                        $fieldDefs,
                        $retFields
                    );
                }
            }
        }

        // check Products links
        $expr = Parser::evaluate($fieldDef['formula'], $this);
        $fields = Parser::getFormulaRelateFields($expr, 'products');

        if (count($fields)) {
            foreach ($fields as $lockedField) {
                if (!isset($retFields['Products'][$lockedField])) {
                    $retFields['Products'][$lockedField] = array();
                }

                if (!isset($retFields['Products'][$lockedField]['locked'])) {
                    $retFields['Products'][$lockedField]['locked'] = array();
                }

                if (!isset($retFields['Products'][$lockedField]['locked'][$fieldName])) {
                    $retFields['Products'][$lockedField]['locked'][$fieldName] = array(
                        'module' => $moduleName,
                        'field' => $fieldName,
                        'reason' => 'rollup',
                    );
                }

                $rollupField = $fieldDefs['Products'][$lockedField];
                if (isset($rollupField['formula'])) {
                    $this->parseFieldFormula(
                        'Products',
                        $rollupField,
                        $fieldDefs,
                        $retFields
                    );
                }
                if (isset($rollupField['related_fields'])) {
                    $this->parseFieldRelatedFields(
                        'Products',
                        $rollupField,
                        $fieldDefs,
                        $retFields
                    );
                }
            }
        }

        // check variables links
        $fieldsInFormula = Parser::getFieldsFromExpression($fieldDef['formula']);

        if (count($fieldsInFormula)) {
            $matches = array_unique($fieldsInFormula);

            foreach ($matches as $lockedField) {
                if ($lockedField === 'products' ||
                    $lockedField === 'product_bundles' ||
                    $fieldName === $lockedField) {
                    continue;
                }

                if (!isset($retFields[$moduleName][$lockedField])) {
                    $retFields[$moduleName][$lockedField] = array();
                }

                if (!isset($retFields[$moduleName][$lockedField]['locked'])) {
                    $retFields[$moduleName][$lockedField]['locked'] = array();
                }

                if (!isset($retFields[$moduleName][$lockedField]['locked'][$fieldName])) {
                    $retFields[$moduleName][$lockedField]['locked'][$fieldName] = array(
                        'module' => $moduleName,
                        'field' => $fieldName,
                        'reason' => 'formula',
                    );
                }

                $rollupField = $fieldDefs[$moduleName][$lockedField];
                if (isset($rollupField['formula']) && $fieldName !== $lockedField) {
                    $this->parseFieldFormula(
                        $moduleName,
                        $rollupField,
                        $fieldDefs,
                        $retFields
                    );
                }
                if (isset($rollupField['related_fields']) && $fieldName !== $lockedField) {
                    $this->parseFieldRelatedFields($moduleName, $rollupField, $fieldDefs, $retFields);
                }
            }
        }
    }

    /**
     * Gets any related fields from a fieldDef
     *
     * @param string $moduleName The name of the module for the fieldDef we're parsing
     * @param array $fieldDef The Field definition to parse
     * @param array $fieldDefs The collection of all field definitions
     * @param array $retFields The map of all field dependencies we're returning
     */
    protected function parseFieldRelatedFields(string $moduleName, array $fieldDef, array $fieldDefs, array &$retFields)
    {
        $fieldName = $fieldDef['name'];

        foreach ($fieldDef['related_fields'] as $relatedField) {
            if (!isset($retFields[$moduleName][$relatedField])) {
                $retFields[$moduleName][$relatedField] = array();
            }

            if (!isset($retFields[$moduleName][$relatedField]['related'])) {
                $retFields[$moduleName][$relatedField]['related'] = array();
            }

            if (!isset($retFields[$moduleName][$relatedField]['related'][$fieldName])) {
                $retFields[$moduleName][$relatedField]['related'][$fieldName] = array(
                    'module' => $moduleName,
                    'field' => $fieldName,
                    'reason' => 'related_fields',
                );
            }
        }
    }

    /**
     * Applies the saved Quotes config.
     * This might be necessary to run independently of the config api for cases like updating the
     * quote record view in studio -- that would remove any related_fields updates we made here.
     *
     * @throws SugarApiExceptionInvalidParameter
     */
    public function applyWorksheetColumnsConfig()
    {
        $viewdefManager = $this->getViewdefManager();
        $settings = $this->getSettings();

        if (!array_key_exists('worksheet_columns', $settings) || !is_array($settings['worksheet_columns'])) {
            throw new \SugarApiExceptionInvalidParameter($GLOBALS['app_strings']['EXCEPTION_MISSING_WORKSHEET_COLUMNS']);
        }

        if (!array_key_exists('worksheet_columns_related_fields', $settings) ||
            !is_array($settings['worksheet_columns_related_fields'])) {
            throw new \SugarApiExceptionInvalidParameter($GLOBALS['app_strings']['EXCEPTION_MISSING_WORKSHEET_COLUMNS_RELATED_FIELDS']);
        }

        //update products c/b/v/quote-data-group-list with new fields for worksheet_columns
        //load viewdefs
        $qlidatagrouplistdef = $viewdefManager->loadViewdef('base', 'Products', 'quote-data-group-list');

        //check to see if the key we need to update exists in the loaded viewdef, if not, load the base.
        if (!isset($qlidatagrouplistdef['panels'][0]['fields'])) {
            $qlidatagrouplistdef = $viewdefManager->loadViewdef('base', 'Products', 'quote-data-group-list', true);
        }

        $qlidatagrouplistdef['panels'][0]['fields'] = $settings['worksheet_columns'];
        $viewdefManager->saveViewdef($qlidatagrouplistdef, 'Products', 'base', 'quote-data-group-list');

        $columnNames = array_column($settings['worksheet_columns'], 'name');
        if (in_array('line_num', $columnNames)) {
            $columnNames = array_diff($columnNames, array('line_num'));
        }

        //update quotes c/b/v/record.php name:related_fields, bundles and product_bundle_items with everything added
        //and anything needed for calculating fields -- include any new dependent fields
        //load viewdefs
        $qRecordViewdef = $viewdefManager->loadViewdef('base', 'Quotes', 'record', false);

        //check to see if the key we need to update exists in the loaded viewdef, if not, load the base.
        if (!isset($qRecordViewdef['panels'][0]['fields'][1]['related_fields'][0]['fields'])) {
            $qRecordViewdef = $viewdefManager->loadViewdef('base', 'Quotes', 'record', true);
        }

        //now that we know the related_fields[0]['fields'] exists, we need to search that array for the array def
        //for the product bundle items
        $fieldsIndex = 0;
        foreach ($qRecordViewdef['panels'][0]['fields'][1]['related_fields'][0]['fields'] as $field) {
            if (!is_array($field)) {
                $fieldsIndex++;
                continue;
            } else {
                if (array_key_exists('name', $field) &&
                    $field['name'] == 'product_bundle_items' &&
                    array_key_exists('fields', $field)) {
                    $qRecordViewdef['panels'][0]['fields'][1]['related_fields'][0]['fields'][$fieldsIndex]['fields'] =
                        array_merge($columnNames, $settings['worksheet_columns_related_fields']);
                }
                break;
            }
        }

        //do the same as above for bundles when we're ready for that

        //write out new quotes record.php
        $viewdefManager->saveViewdef($qRecordViewdef, 'Quotes', 'base', 'record');
    }

    /**
     * Applies the saved Quotes config for Summary columns sheet.
     * This might be necessary to run independently of the config api for cases like updating the
     * quote record view in studio -- that would remove any related_fields updates we made here.
     *
     * @throws SugarApiExceptionInvalidParameter
     */
    public function applySummaryColumnsConfig()
    {
        $viewdefManager = $this->getViewdefManager();
        $settings = $this->getSettings();

        if (!array_key_exists('summary_columns', $settings) || !is_array($settings['summary_columns'])) {
            throw new \SugarApiExceptionInvalidParameter($GLOBALS['app_strings']['EXCEPTION_MISSING_SUMMARY_COLUMNS']);
        }

        if (!array_key_exists('summary_columns_related_fields', $settings) ||
            !is_array($settings['summary_columns_related_fields'])) {
            throw new \SugarApiExceptionInvalidParameter($GLOBALS['app_strings']['EXCEPTION_MISSING_SUMMARY_COLUMNS_RELATED_FIELDS']);
        }

        //update products c/b/v/quote-data-grand-totals-header with new fields for summary_columns
        //load viewdefs
        $qlidatagrouplistdef = $viewdefManager->loadViewdef('base', 'Quotes', 'quote-data-grand-totals-header');

        //check to see if the key we need to update exists in the loaded viewdef, if not, load the base.
        if (!isset($qlidatagrouplistdef['panels'][0]['fields'])) {
            $qlidatagrouplistdef = $viewdefManager->loadViewdef('base', 'Quotes', 'quote-data-grand-totals-header', true);
        }

        foreach ($settings['summary_columns'] as $key => $summaryField) {
            if ($summaryField['type'] === 'varchar') {
                unset($settings['summary_columns'][$key]['type']);
            }

            if (isset($summaryField['css_class']) && !empty($summaryField['css_class'])) {
                continue;
            } else {
                $settings['summary_columns'][$key]['css_class'] = 'quote-totals-row-item';
            }
        }

        $qlidatagrouplistdef['panels'][0]['fields'] = $settings['summary_columns'];
        $viewdefManager->saveViewdef($qlidatagrouplistdef, 'Quotes', 'base', 'quote-data-grand-totals-header');
    }

    /**
     * Applies the saved Quotes config for Grand Totals Footer rows.
     *
     * @throws SugarApiExceptionInvalidParameter
     */
    public function applyFooterRowsConfig()
    {
        $viewdefManager = $this->getViewdefManager();
        $settings = $this->getSettings();

        if (!array_key_exists('footer_rows', $settings) || !is_array($settings['footer_rows'])) {
            throw new \SugarApiExceptionInvalidParameter($GLOBALS['app_strings']['EXCEPTION_MISSING_FOOTER_ROWS']);
        }

        if (!array_key_exists('footer_rows_related_fields', $settings) ||
            !is_array($settings['footer_rows_related_fields'])) {
            throw new \SugarApiExceptionInvalidParameter($GLOBALS['app_strings']['EXCEPTION_MISSING_FOOTER_ROWS_RELATED_FIELDS']);
        }

        //update products c/b/v/quote-data-grand-totals-footer with new fields for footer_rows
        //load viewdefs
        $quoteDataGroupListDef = $viewdefManager->loadViewdef('base', 'Quotes', 'quote-data-grand-totals-footer');

        //check to see if the key we need to update exists in the loaded viewdef, if not, load the base.
        if (!isset($quoteDataGroupListDef['panels'][0]['fields'])) {
            $quoteDataGroupListDef = $viewdefManager->loadViewdef('base', 'Quotes', 'quote-data-grand-totals-footer', true);
        }

        $quoteDataGroupListDef['panels'][0]['fields'] = $settings['footer_rows'];
        $viewdefManager->saveViewdef($quoteDataGroupListDef, 'Quotes', 'base', 'quote-data-grand-totals-footer');
    }

    /**
     * abstraction for getting a new instance of ViewdefManager
     *
     * @return Sugarcrm\Sugarcrm\MetaData\ViewdefManager
     */
    protected function getViewdefManager()
    {
        return new ViewdefManager();
    }

    /**
     * abstraction of retreiving settings for the quotes module.
     *
     * @return array settings
     */
    protected function getSettings()
    {
        $admin = BeanFactory::newBean('Administration');
        return $admin->getConfigForModule('Quotes');
    }
}
