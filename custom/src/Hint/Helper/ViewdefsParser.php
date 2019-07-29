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
namespace Sugarcrm\Sugarcrm\custom\Hint\Helper;

class ViewdefsParser
{
    /**
     * Updates given components with a new one injecting it
     * right after the sidebar main pane
     *
     * Additionally modifies layout class if required
     *
     * @param array $components
     * @param array $newComponent
     * @param string|null $cssClass
     * @return array
     */
    public static function injectAfterSidebarMainpane(array $components, array $newComponent, string $cssClass = null)
    {
        foreach ($components as $i => $createComponent) {
            // skip wrong component
            if (empty($createComponent['layout']['name']) || $createComponent['layout']['name'] !== 'sidebar') {
                continue;
            }

            // add custom class
            if (!is_null($cssClass)) {
                $components[$i]['layout']['css_class'] = $cssClass;
            }

            $sidebarComponents = $createComponent['layout']['components'] ?? [];
            foreach ($sidebarComponents as $j => $sidebarComponent) {
                // skip wrong component
                if (empty($sidebarComponent['layout']['name']) || $sidebarComponent['layout']['name'] !== 'main-pane') {
                    continue;
                }

                // inject component right after the current one
                array_splice($sidebarComponents, $j + 1, 0, [$newComponent]);
                break;
            }
            $components[$i]['layout']['components'] = $sidebarComponents;
        }

        return $components;
    }

    /**
     * Finds "header" panel and changes the type of "name" field
     * to the given one
     *
     * @param array $panels
     * @param string $type
     * @return array
     */
    public static function updateHeaderPanelNameType(array $panels, string $type)
    {
        foreach($panels as $pkey => $panel) {
            if ($panel['name'] !== 'header' || empty($panel['fields'])) {
                continue;
            }

            $fields = $panel['fields'];
            foreach($fields as $fkey => $field) {
                // array definition
                if (is_array($field) && $field['name'] === 'name') {
                    $fields[$fkey]['type'] = $type;
                    continue;
                }

                // just panel name as a string
                if ($field === 'name') {
                    $fields[$fkey] = [
                        'name' => 'name',
                        'type' => $type,
                    ];
                }
            }
            $panels[$pkey]['fields'] = $fields;
        }

        return $panels;
    }

    /**
     * Filter the Hint fields which should NOT be included in the record metadata.
     * Hint configuration is stored in the configuration module specific to the
     * module in question.
     *
     * @param $module
     * @param $hintPanel
     * @return array
     */
    public static function filterRecordFields($module, $hintPanel)
    {
        $adminBean = \BeanFactory::newBean('Administration');
        $moduleConfig = $adminBean->getConfigForModule($module);

        if (!isset($moduleConfig['hintConfig'])) {
            return $hintPanel['fields'];
        }

        $filteredFields = [];

        $allFieldsThatWillBeDisplayed = array_merge(
            $moduleConfig['hintConfig']['basic'],
            $moduleConfig['hintConfig']['expanded']
        );

        $isAccountsModule = $module === 'Accounts';
        if (!$isAccountsModule) {
            $accountsModuleconfig = $adminBean->getConfigForModule('Accounts');
            $allAccountsFieldsThatWillBeDisplayed = array_merge(
                $accountsModuleconfig['hintConfig']['basic'],
                $accountsModuleconfig['hintConfig']['expanded']
            );
        }


        foreach ($hintPanel['fields'] as $field) {

            $key = is_array($field) ? $field['name'] : $field;
            $whiteList = (is_array($field) && array_key_exists('white_list', $field)) ? $field['white_list'] : false;
            $accountKey = (is_array($field) && array_key_exists('account_key', $field)) ? $field['account_key'] : false;
            $parentKey = (is_array($field) && array_key_exists('parent_key', $field)) ? $field['parent_key'] : false;

            $isFieldConfiguredToBeShown = in_array($key, $allFieldsThatWillBeDisplayed);
            $isParentKeyConfiguredToBeShown = $parentKey && in_array($parentKey, $allFieldsThatWillBeDisplayed);

            //When we're processing modules other than accounts (eg. contacts, leads) we may need to look at fields that are in the accounts metadata since those views are 'composed' of accounts info.  The
            //$isAccountsModule flag adds this restriction so that this logic is not considered when processing the accounts module itself.
            $isFieldInAccountsModuleAndConfiguredToBeShown = !$isAccountsModule
                && (in_array($key, $allAccountsFieldsThatWillBeDisplayed)
                    || ($accountKey
                        && in_array($accountKey, $allAccountsFieldsThatWillBeDisplayed)));

            if ($whiteList || $isFieldConfiguredToBeShown
                || $isParentKeyConfiguredToBeShown || $isFieldInAccountsModuleAndConfiguredToBeShown) {

                $filteredFields[] = $field;
            }
        }

        return $filteredFields;
    }
}
