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
namespace Sugarcrm\Sugarcrm\custom\Hint\Http;

class ProxySettings
{
    /**
     * @var array
     */
    private $settings;


    /**
     * ProxySettings constructor.
     */
    public function __construct()
    {
        $this->settings = $this->getProxySettings();
    }

    /**
     * Get Curl proxy opts
     * @return array
     */
    public function toCurlOpts(): array
    {
        if (!$this->isProxyEnabled()) {
            return [];
        }

        $opts = [
            CURLOPT_PROXY => $this->settings['host'],
            CURLOPT_PROXYPORT => $this->settings['port'],
        ];

        if ($this->isAuthenticationRequired()) {
            $opts[CURLOPT_PROXYUSERPWD] = $this->settings['username'] . ':' . $this->settings['password'];
        }

        return $opts;
    }

    /**
     * Get Zend_Http_Client_Adapter_Proxy compatible config
     * @return array
     */
    public function toZendConfig(): array
    {
        if (!$this->isProxyEnabled()) {
            return [];
        }

        $config = [
            'proxy_host' => $this->settings['host'],
            'proxy_port' => $this->settings['port'],
        ];

        if ($this->isAuthenticationRequired()) {
            $config += [
                'proxy_user' => $this->settings['username'],
                'proxy_pass' => $this->settings['password'],
            ];
        }

        return $config;
    }

    /**
     * Defines if proxy is enabled
     * @return bool
     */
    public function isProxyEnabled(): bool
    {
        return (bool)($this->settings['on'] ?? false);
    }

    /**
     * Defines if proxy requires authentication
     * @return bool
     */
    public function isAuthenticationRequired(): bool
    {
        return $this->isProxyEnabled() && ($this->settings['auth'] ?? false);
    }

    /**
     * Get proxy settings
     * @return array
     */
    protected function getProxySettings(): array
    {
        $settings = [];

        // we want all settings from this category
        $category = 'proxy';

        $sugarSettings = \Administration::getSettings($category)->settings ?? [];

        // we want only a small subset of settings in case the result is cached
        $offset = strlen($category) + 1;
        foreach ($sugarSettings as $k => $v) {
            if (0 === strpos($k, $category . '_')) {
                $settings[substr($k, $offset)] = $v;
            }
        }

        return $settings;
    }
}
