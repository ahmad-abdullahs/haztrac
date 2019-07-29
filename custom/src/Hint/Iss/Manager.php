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
namespace Sugarcrm\Sugarcrm\custom\Hint\Iss;

use Sugarcrm\Sugarcrm\custom\Hint\Http\HttpClient;
use Sugarcrm\Sugarcrm\custom\Hint\Http\Request;
use Sugarcrm\Sugarcrm\custom\Hint\Logger\Logger as HintLogger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class Manager implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    const ISS_SERVICE_PATH = '/hint/interest-subscription-service/v1';
    const ISS_ACTION_COMMANDS = 'recordCommands';
    const ISS_ACTION_AUTH = 'createToken';

    /**
     * ISS host
     * @var string
     */
    private $issHost;

    /**
     * ISS auth token
     * @var string
     */
    private $authToken;

    /**
     * ISS auth token expiration time
     * @var string
     */
    private $tokenExpiration;

    /**
     * ISS auth token max requests per second
     * @var string
     */
    private $maxRequestsPerSecond;


    /**
     * Manager constructor.
     * @param string $issHost
     */
    public function __construct(string $issHost)
    {
        $this->issHost = $issHost;

        $this->setLogger(new HintLogger());
    }

    /**
     * Prepares and sends ISS commands
     *
     * @param $commands
     * @throws \Exception
     */
    public function sendCommands($commands)
    {
        if (count($commands) == 0) {
            // nothing to do this round
            return;
        }

        $request = new Request(
            Request::METHOD_POST,
            $this->prepareUrl(self::ISS_ACTION_COMMANDS),
            $this->prepareHeaders(['authtoken: ' . $this->getAuthToken()]),
            $this->preparePayload(['commands' => $commands])
        );

        $this->logger->debug('ISS request: ' . $request);

        $response = $client = $this->getHttpClient()->sendRequest($request);
        if ($response->getCode() !== 200 || !$response->getBody()) {
            // REMIND: distinguish the token expired from true errors, and retry if  the token
            // was expired
            $this->resetAuth();
            $this->logger->alert('ISS request failed: ' . $request);
            $this->logger->alert('ISS response: ' . $response);
            throw new \Exception(sprintf('ISS request failed: %s - %s', $response->getCode(), $response->getBody()));
        }

        $this->logger->debug('ISS response (decoded): ' . var_export(json_decode($response->getBody(), true), true));
    }

    /**
     * Get config instance
     * @return \SugarConfig
     */
    protected function getConfig()
    {
        return \SugarConfig::getInstance();
    }

    /**
     * Get system info instance
     * @return mixed
     */
    protected function getSystemInfo()
    {
        return \SugarSystemInfo::getInstance();
    }

    /**
     * Get http client
     * @return HttpClient
     */
    protected function getHttpClient(): HttpClient
    {
        return new HttpClient();
    }

    /**
     * Get ISS auth token
     * @return string
     * @throws \RuntimeException
     */
    private function getAuthToken(): string
    {
        if (!empty($this->authToken) && time() < $this->tokenExpiration) {
            return $this->authToken;
        }

        $request = new Request(
            Request::METHOD_POST,
            $this->prepareUrl(self::ISS_ACTION_AUTH),
            $this->prepareHeaders(),
            $this->preparePayload()
        );

        $response = $client = $this->getHttpClient()->sendRequest($request);
        $result = json_decode($response->getBody(), true);
        if ($response->getCode() !== 200 || !$result) {
            $this->logger->alert('ISS request failed: ' . $request);
            $this->logger->alert('ISS response: ' . $response);
            throw new \RuntimeException(sprintf('ISS request failed: %s - %s', $response->getCode(), $response->getBody()));
        }

        $this->authToken = $result['token'];
        $this->tokenExpiration = time() + intval($result['ttlMs']) / 1000;
        $this->maxRequestsPerSecond = intval($result['maxReqPerSec']);

        $this->logger->debug('token: ' . $this->authToken);
        $this->logger->debug('expiration: ' . $this->tokenExpiration);
        $this->logger->debug('max req / sec: ' . $this->maxRequestsPerSecond);

        return (string)$this->authToken;
    }

    /**
     * Reset ISS auth
     */
    private function resetAuth()
    {
        $this->authToken = null;
        $this->tokenExpiration = null;
        $this->maxRequestsPerSecond = null;
    }

    /**
     * Prepare ISS payload
     * @param array $payload
     * @return string
     */
    private function preparePayload(array $payload = []): string
    {
        $config = $this->getConfig();
        $systemInfo = $this->getSystemInfo();

        $companyId = $systemInfo->getLicenseKey();
        $sugarVersion = $systemInfo->getAppInfo()['sugar_version'];
        $siteUrl = $config->get('site_url', '');
        $uniqueKey = $config->get('unique_key', '');

        $payloadMetadata = [
            'companyId' => $companyId,
            'sugarVersion' => $sugarVersion,
            'siteURL' => $siteUrl,
            'uniqueKey' => $uniqueKey,
        ];
        $this->logger->info('ISS payload metadata: ' . json_encode($payloadMetadata));

        return json_encode(array_merge($payloadMetadata, $payload));
    }

    /**
     * Prepare ISS action url
     * @param string $action
     * @return string
     */
    private function prepareUrl(string $action): string
    {
        $host = rtrim($this->issHost, '/');
        $path = trim(self::ISS_SERVICE_PATH, '/');

        return sprintf('%s/%s/%s', $host, $path, $action);
    }

    /**
     * Prepare ISS request header
     * @param array $headers
     * @return array
     */
    private function prepareHeaders(array $headers = []): array
    {
        return array_merge([
            'Accept: application/json',
            'Content-Type: application/json',
            'cache-control: no-cache',
        ], $headers);
    }
}
