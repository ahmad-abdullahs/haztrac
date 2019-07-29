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

use Sugarcrm\Sugarcrm\custom\Hint\Exception\LicenseExpiredApiException;
use Sugarcrm\Sugarcrm\custom\Hint\Exception\NoLicenseApiException;
use Sugarcrm\Sugarcrm\custom\Hint\Logger\Logger as HintLogger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

// DEPRECATED: use HttpClient instead!!!

/**
 * Class Client
 *
 * HTTP REST API client for Sugar's Hint service.
 */
class Client implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    //
    //  Public properties
    //
    public $endpoint;
    public $accessToken;
    public $instanceId;
    public $licenseKey;

    //
    //  Public instance methods
    //

    /**
     * Constructor
     *
     * @param string $endpoint Endpoint on which Stage2 service is to be found.
     */
    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
        $this->setLogger(new HintLogger());
    }

    /**
     * Proxy to service's ping method.
     *
     * @return void
     * @throws \SugarApiException
     * @throws \SugarApiExceptionError
     * @throws \SugarApiExceptionInvalidGrant
     * @throws \SugarApiExceptionNotAuthorized
     * @throws \SugarApiExceptionNotFound
     * @throws \Zend_Http_Client_Exception
     */
    public function ping()
    {
        $this->callNoAuthorization('GET', '/ping');
    }

    /**
     * Proxy to service's authorize endpoint.
     *
     * @return array Response body when successful
     * @throws \SugarApiException
     * @throws \SugarApiExceptionError
     * @throws \SugarApiExceptionInvalidGrant
     * @throws \SugarApiExceptionNotAuthorized
     * @throws \SugarApiExceptionNotFound
     * @throws \Zend_Http_Client_Exception
     */
    public function newToken()
    {
        //  Make the request.
        $response = $this->call('POST', '/hint/data-enrichment/v1/token');

        //  Return decoded body.
        return json_decode($response->getBody(), true);
    }

    /**
     * Proxy to notifications service's authorize endpoint.
     *
     * @param $body
     * @return array Response body when successful
     * @throws \SugarApiException
     * @throws \SugarApiExceptionError
     * @throws \SugarApiExceptionInvalidGrant
     * @throws \SugarApiExceptionNotAuthorized
     * @throws \SugarApiExceptionNotFound
     * @throws \Zend_Http_Client_Exception
     */
    public function createNotificationsServiceToken($body)
    {
        //  Make the request.
        $response = $this->callNoAuthorization('POST', '/hint/notifications-service/v1/createToken',
            $body);

        //  Return decoded body.
        return json_decode($response->getBody(), true);
    }

    //
    //  Raw access methods
    //

    /**
     * Makes a non-authorized HTTP request to instance-relative endpoint.
     *
     * @param string $method HTTP method (e.g. 'get')
     * @param string $path Relative path of REST API endpoint
     * @param array $body Request body converted to JSON for request purposes
     * @param int $timeout
     * @return \Zend_Http_Response HTTP response returned by Zend HTTP client
     * @throws \SugarApiException
     * @throws \SugarApiExceptionError
     * @throws \SugarApiExceptionInvalidGrant
     * @throws \SugarApiExceptionNotAuthorized
     * @throws \SugarApiExceptionNotFound
     * @throws \Zend_Http_Client_Exception
     */
    public function callNoAuthorization($method, $path, array $body = array(), $timeout = 10)
    {
        return $this->call($method, $path, $body, $timeout, false);
    }

    /**
     * Makes an HTTP request with the given HTTP method.
     *
     * @param string $method HTTP method (e.g. 'get')
     * @param string $path Relative path of REST API endpoint
     * @param array $body Request body converted to JSON for request purposes
     * @param int $timeout
     * @param bool $authorization True if authorization should be used for the request.
     *
     * @return \Zend_Http_Response HTTP response returned by Zend HTTP client
     * @throws \SugarApiException
     * @throws \SugarApiExceptionError
     * @throws \SugarApiExceptionInvalidGrant
     * @throws \SugarApiExceptionNotAuthorized
     * @throws \SugarApiExceptionNotFound
     * @throws \Zend_Http_Client_Exception
     */
    public function call($method, $path, array $body = array(), $timeout = 10, $authorization = true)
    {
        $client = new \Zend_Http_Client();
        $client->setMethod($method);

        $uri = $this->endpoint . $path;

        $client->setUri($uri);

        $client->setConfig(array(
            'timeout' => $timeout
        ));

        if ($authorization) {
            //  If we have access token use bearer authentication
            //  otherwise use basic authentication.
            if (isset($this->accessToken)) {
                $client->setHeaders(
                    'authorization',
                    'bearer ' . $this->accessToken
                );
            } else {
                if (!isset($this->instanceId) || !isset($this->licenseKey)) {
                    throw new \SugarApiException('Either accessToken or instanceId/licenseKey need to be set in client\'s options.');
                }

                $client->setHeaders(
                    'authorization',
                    'Basic ' . base64_encode($this->instanceId . ':' . $this->licenseKey)
                );
            }
        }

        // apply proxy settings
        $proxySettings = $this->getProxySettings();
        if ($proxySettings->isProxyEnabled()) {
            $adapter = new \Zend_Http_Client_Adapter_Proxy();
            $adapter->setConfig($proxySettings->toZendConfig());
            $client->setAdapter($adapter);
        }

        //  Set the request's body as JSON if given.
        if (!empty($body)) {
            $client->setRawData(json_encode($body));
            $client->setHeaders('Content-Type', 'application/json');
        }

        //  Make the request.
        $response = $client->request();

        //  Analyze the response.
        switch ($response->getStatus()) {
            case 401:
                throw new \SugarApiExceptionInvalidGrant();
            case 402:
                $body = json_decode($response->getBody(), true);
                if (is_null($body) || is_null($body['message'])) {
                    $this->logger->alert('Invalid response from Hint /token endpoint');
                    throw new NoLicenseApiException();
                }

                // In the message we can find the reason for the failure.
                // Consult SubscriptionServiceClient class on Hint backend for details.
                switch ($body['message']) {
                    case 'ExpiredSugarCRMLicense':
                    case 'ExpiredHintLicense':
                        throw new LicenseExpiredApiException();
                    case 'NoHintLicense':
                    default:
                        throw new NoLicenseApiException();
                }
                break;
            case 403:
                throw new \SugarApiExceptionNotAuthorized();
            case 404:
                throw new \SugarApiExceptionNotFound();
            case 200:
                return $response;
            default:
                throw new \SugarApiExceptionError();
        }
    }

    /**
     * Get proxy settings
     * @return ProxySettings
     */
    protected function getProxySettings(): ProxySettings
    {
        return new ProxySettings();
    }
}
