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

namespace Sugarcrm\IdentityProvider\App;

use GuzzleHttp;
use GuzzleHttp\Client as HttpClient;

/**
 * Discovers URLs of various services.
 *
 * @package Sugarcrm\IdentityProvider\App
 */
class ServiceDiscovery
{
    /**
     * Request timeout.
     */
    const TIMEOUT = 20.0;

    /**
     * @var string
     */
    protected $url;

    /**
     * @param string $discoveryURL
     * @param string $version
     */
    public function __construct(string $discoveryURL, string $version)
    {
        $this->url = rtrim($discoveryURL, '/') . '/' . trim($version, '/');
    }

    /**
     * @param string $name
     * @param string $region
     * @param null|string $type
     * @return null|string
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getServiceURL(string $name, string $region, ?string $type = null): ?string
    {
        $url = $this->url . '/services';

        $response = $this->getHttpClient()->request('GET', $url);
        $responseBody =   GuzzleHttp\json_decode($response->getBody(), true);

        $services = $responseBody['services'] ?? [];
        foreach ($services as $service) {
            if ($service['name'] == $name && (is_null($type) || $service['type'] == $type)) {
                foreach ($service['endpoints'] as $endpoint) {
                    if ($endpoint['region'] == $region) {
                        return rtrim($endpoint['url'], '/');
                    }
                }
            }
        }
        return null;
    }

    /**
     * @return HttpClient
     */
    protected function getHttpClient()
    {
        return new HttpClient(['timeout' => self::TIMEOUT]);
    }
}
