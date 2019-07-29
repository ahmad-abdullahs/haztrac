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
declare(strict_types=1);

namespace Sugarcrm\Sugarcrm\Marketing;

use SugarConfig;
use Sugarcrm\Sugarcrm\DependencyInjection\Container;
use Sugarcrm\Sugarcrm\Security\Validator\ConstraintBuilder;
use Sugarcrm\Sugarcrm\Security\Validator\Validator;

class MarketingExtras
{
    /**
     * Request the marketing content URL from the marketing extras server.
     * @param null|string $language The requested content language, if any.
     * @return string The URL for marketing content.
     * @throws \Exception If the marketing extras URL is not
     *   provided.
     */
    public function getMarketingContentUrl(?string $language): string
    {
        $sugarDetails = $this->getSugarDetails();
        $queryParams = array(
            'language' => $this->chooseLanguage($language),
            'version' => $sugarDetails['version'],
            'flavor' => strtolower($sugarDetails['flavor']),
            'build' => $sugarDetails['build'],
        );

        $marketingExtrasSandboxTest = $this->getSugarConfig('marketing_extras_sandbox_test');
        if (isset($marketingExtrasSandboxTest)) {
            $queryParams['test'] = $marketingExtrasSandboxTest;
        }

        if ($this->areMarketingExtrasEnabled()) {
            $url = $this->getMarketingExtrasUrl();
            return $this->fetchMarketingContentInfo($url, $queryParams)['content_url'];
        }
        return '';
    }

    /**
     * Check if marketing extras are enabled.
     * @return bool true if marketing extras are enabled, false otherwise.
     */
    public function areMarketingExtrasEnabled(): bool
    {
        return $this->getSugarConfig('marketing_extras_enabled', false);
    }

    /**
     * Make a request to the given URL with the given query parameters, then
     * return the result as an associative array.
     * @param string $url The URL to make a request to.
     * @param array $queryParams Query parameters in key-value form.
     * @return array The result of the request, as an associative array.
     * @throws \Exception If the request or JSON decoding fails.
     */
    public function fetchMarketingContentInfo(string $url, array $queryParams): array
    {
        $marketingContents = $this->openUrl($url, $queryParams);
        $marketingContentArray = $this->getJson($marketingContents);
        return $marketingContentArray;
    }

    /**
     * Get marketing extras URL, with check to make sure it's actually a URL.
     * @return string The marketing extras URL.
     * @throws \Exception If there is an issue with the marketing extras URL.
     */
    public function getMarketingExtrasUrl(): string
    {
        $marketingExtrasUrl = $this->getSugarConfig('marketing_extras_url');
        if (empty($marketingExtrasUrl)) {
            throw new \Exception('marketing_extras_url is not provided');
        }
        $validator = $this->getValidator();
        $constraints = $this->getUrlConstraints();
        $errors = $validator->validate($marketingExtrasUrl, $constraints);
        if (count($errors) > 0) {
            throw new \Exception('marketing_extras_url is not actually an HTTP(S) URL');
        }
        return $marketingExtrasUrl;
    }

    /**
     * Determine the language to request marketing details for.
     * @param null|string $language The client's preferred language.
     * @return string The language to use. If set, uses the client's preferred
     *   language, then falls back to the default language of this Sugar
     *   instance, and finally to en_us.
     */
    public function chooseLanguage(?string $language): string
    {
        if (isset($language)) {
            // because we have strict types, this implies it's a proper string
            return $language;
        }

        // no language given, check for system-wide default
        $defaultLanguage = $this->getSugarConfig('default_language');
        if (isset($defaultLanguage)) {
            return $defaultLanguage;
        }

        // fall back to en_us if there's no default language set
        return 'en_us';
    }

    /**
     * Make a request to the given URL, with the given query parameters.
     * @param string $baseUrl The URL to make the request to.
     * @param array $queryParams Query parameters in key-value form.
     * @return string The body of the HTTP response.
     * @throws \Exception If the request fails.
     */
    private function openUrl(string $baseUrl, array $queryParams): string
    {
        $queryString = http_build_query($queryParams);
        $url = $baseUrl . '?' . $queryString;

        $curlHandle = curl_init($url);
        if ($curlHandle === false) {
            throw new \Exception('Could not open connection to marketing extras server');
        }

        // setting CURLOPT_FAILONERROR so I don't have to check curl_error later
        // and CURLOPT_RETURNTRANSFER so curl_exec returns the page contents
        curl_setopt($curlHandle, CURLOPT_FAILONERROR, true);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);

        $this->configureProxy($curlHandle);

        $contents = curl_exec($curlHandle);
        curl_close($curlHandle);
        if ($contents === false) {
            throw new \Exception('Retrieving URL from marketing extras server failed');
        }

        return $contents;
    }

    /**
     * Configure curl for the system proxy if necessary.
     * @param $ch Curl handle.
     */
    private function configureProxy($ch)
    {
        $proxy_config = \Administration::getSettings('proxy');

        if (!empty($proxy_config) &&
            !empty($proxy_config->settings['proxy_on']) &&
            $proxy_config->settings['proxy_on'] == 1
        ) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy_config->settings['proxy_host']);
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_config->settings['proxy_port']);
            if (!empty($proxy_settings['proxy_auth'])) {
                curl_setopt(
                    $ch,
                    CURLOPT_PROXYUSERPWD,
                    $proxy_settings['proxy_username'] . ':' . $proxy_settings['proxy_password']
                );
            }
        }
    }

    /**
     * Parse JSON and throw an error if it's not valid.
     * @param string $jsonString The string to parse.
     * @return array The decoded JSON string as an associative array.
     * @throws \Exception In the event the JSON is invalid.
     */
    private function getJson(string $jsonString): array
    {
        $array = json_decode($jsonString, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Marketing URL request did not return valid JSON');
        }
        return $array;
    }

    /**
     * Get the sugar_config global variable.
     * @param string $key Key to get.
     * @param * $default Default value.
     * @return * The value of the config flag, or the default.
     */
    private function getSugarConfig(string $key, $default = null)
    {
        $container = Container::getInstance();
        $config = $container->get(SugarConfig::class);
        return $config->get($key, $default);
    }

    /**
     * Retrieves the Symfony validator service.
     * @return \Symfony\Component\Validator\Validator\ValidatorInterface The
     *   validator service.
     */
    private function getValidator()
    {
        $container = Container::getInstance();
        return $container->get(Validator::class);
    }

    /**
     * Creates a Constraint enforcing that an argument is a valid URL.
     * @return \Symfony\Component\Validator\Constraint[] The created constraints.
     */
    private function getUrlConstraints()
    {
        $urlConstraintBuilder = new ConstraintBuilder();
        return $urlConstraintBuilder->build(
            array(
                // only allows HTTP and HTTPS by default, which is what we want
                // (i.e. we don't want file://)
                'Assert\Url',
            )
        );
    }

    /**
     * Retrieve the build number, flavor, and version of this Sugar instance.
     * @return array An array consisting of build number, flavor, and version
     *   details.
     */
    private function getSugarDetails(): array
    {
        global $sugar_build, $sugar_flavor, $sugar_version;

        return array(
            'version' => $sugar_version,
            'flavor' => $sugar_flavor,
            'build' => $sugar_build,
        );
    }
}
