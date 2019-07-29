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

class HttpClient implements ClientInterface
{
    /**
     * @var ClientInterface
     */
    private $adapter;


    /**
     * HttpClient constructor.
     * @param ClientInterface $adapter
     */
    public function __construct(ClientInterface $adapter = null)
    {
        if (is_null($adapter)) {
            $proxySettings = new ProxySettings();
            $adapter = new Adapter\Curl($proxySettings->toCurlOpts());
        }

        $this->adapter = $adapter;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function sendRequest(Request $request): Response
    {
        return $this->adapter->sendRequest($request);
    }
}
