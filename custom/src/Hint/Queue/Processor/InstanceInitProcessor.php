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
namespace Sugarcrm\Sugarcrm\custom\Hint\Queue\Processor;

class InstanceInitProcessor extends SimpleEventProcessor
{
    /**
     * Converts processor data to ISS command
     *
     * [
     *   ['command' => 'ISS command', ...]
     * ]
     *
     * @param array $data
     * @return array
     */
    public function __invoke(array $data): array
    {
        $systemInfo = \SugarSystemInfo::getInstance();
        $config = \SugarConfig::getInstance();

        return [
            'command' => $this->getCommandName(),
            'companyId' => $systemInfo->getLicenseKey(),
            'sugarVersion' => $systemInfo->getAppInfo()['sugar_version'],
            'siteURL' => $config->get('site_url', ''),
            'uniqueKey' => $config->get('unique_key', ''),
        ];
    }
}
