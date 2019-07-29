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
namespace Sugarcrm\IdentityProvider\App\MarketingExtras;

use GuzzleHttp;
use GuzzleHttp\Client;

class MarketingExtrasService
{
    /**
     * Request timeout.
     */
    protected const TIMEOUT = 5;
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $flavor;

    /**
     * MarketingExtrasService constructor.
     * @param array $config
     * @param string $language
     */
    public function __construct(array $config, string $language)
    {
        $this->baseUrl = $config['baseUrl'] ?? null;
        $this->flavor = $config['flavor'] ?? null;
        $this->language = $language;
    }

    /**
     * Gets Marketing content URL from Marketing endpoint
     *
     * @return string|null
     * @throws GuzzleHttp\Exception\GuzzleException
     */
    public function getMarketingContentUrl(): ?string
    {
        if (empty($this->baseUrl)) {
            return null;
        }

        $queryParams = array_filter([
            'language' => $this->language,
            'flavor' => $this->flavor,
        ]);
        $url = $queryParams ? $this->baseUrl . '?' . http_build_query($queryParams) : $this->baseUrl;
        try {
            $response = $this->getHttpClient()->request('GET', $url);
            $responseBody = GuzzleHttp\json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return null;
        }
        return $responseBody['content_url'] ?? null;
    }

    protected function getHttpClient(): Client
    {
        return new Client(['timeout' => self::TIMEOUT]);
    }
}
