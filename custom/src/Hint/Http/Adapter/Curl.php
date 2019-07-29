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
namespace Sugarcrm\Sugarcrm\custom\Hint\Http\Adapter;

use Sugarcrm\Sugarcrm\custom\Hint\Http\ClientInterface;
use Sugarcrm\Sugarcrm\custom\Hint\Http\Exception\NetworkException;
use Sugarcrm\Sugarcrm\custom\Hint\Http\Exception\RequestException;
use Sugarcrm\Sugarcrm\custom\Hint\Http\Request;
use Sugarcrm\Sugarcrm\custom\Hint\Http\Response;

class Curl implements ClientInterface
{
    /**
     * cURL options.
     *
     * @var array
     */
    private $curlOptions = [];

    /**
     * cURL synchronous requests handle.
     *
     * @var resource|null
     */
    private $handle;


    /**
     * HttpClient constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $default = [
            // general
            // the contents of the "Accept-Encoding: " header (empty string - all supported encoding types)
            CURLOPT_ENCODING => '',
            // follow any "Location: " header that the server sends as part of the HTTP header
            CURLOPT_FOLLOWLOCATION => true,
            // the maximum amount of HTTP redirections to follow
            CURLOPT_MAXREDIRS => 10,

            // timeouts (in seconds)
            // the maximum number of seconds to allow cURL functions to execute
            CURLOPT_TIMEOUT => 60,
            // the number of seconds to wait while trying to connect (0 to wait indefinitely)
            CURLOPT_CONNECTTIMEOUT => 30,

            // ssl
            // verify the peer's certificate
            CURLOPT_SSL_VERIFYPEER => true,
            // 1 to check the existence of a common name in the SSL peer certificate
            // 2 to check the existence of a common name and also verify that it matches the hostname provided
            // 0 to not check the names.
            CURLOPT_SSL_VERIFYHOST => 2,
        ];

        $required = [
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ];

        $this->curlOptions = array_replace($default, $options, $required);
    }

    /**
     * Release resources if still active.
     */
    public function __destruct()
    {
        if (is_resource($this->handle)) {
            curl_close($this->handle);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function sendRequest(Request $request): Response
    {
        if (is_resource($this->handle)) {
            curl_reset($this->handle);
        } else {
            $this->handle = curl_init();
        }

        $options = array_replace($this->curlOptions, $this->prepareRequestOptions($request));
        curl_setopt_array($this->handle, $options);

        // this function is called by curl for each header received
        $headers = [];
        $headerParser = function($ch, $header) use (&$headers) {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            // ignore invalid headers
            if (count($header) < 2) {
                return $len;
            }

            $name = strtolower(trim($header[0]));
            $headers[$name] = $headers[$name] ?? [];
            $headers[$name][] = trim($header[1]);

            return $len;
        };

        curl_setopt($this->handle, CURLOPT_HEADERFUNCTION, $headerParser);

        $curlResponse = curl_exec($this->handle);

        $errno = curl_errno($this->handle);
        switch ($errno) {
            case CURLE_OK:
                // All OK, no actions needed.
                break;
            case CURLE_COULDNT_RESOLVE_PROXY:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_COULDNT_CONNECT:
            case CURLE_OPERATION_TIMEOUTED:
            case CURLE_SSL_CONNECT_ERROR:
                throw new NetworkException(curl_error($this->handle), $request);
            default:
                throw new RequestException(curl_error($this->handle), $request);
        }

        $code = curl_getinfo($this->handle, CURLINFO_RESPONSE_CODE);
        $body = trim(mb_substr($curlResponse, curl_getinfo($this->handle, CURLINFO_HEADER_SIZE)));

        return new Response($code, $body, $headers);
    }

    /**
     * Updates cURL options for given request
     *
     * @param Request $request
     * @return array
     */
    private function prepareRequestOptions(Request $request): array
    {
        $options = [];

        // Request headers
        // ---------------

        $options[CURLOPT_URL] = (string)$request->getUri();
        /*
         * cURL adds "Expect" header by default.
         * We can not suppress it, but we can set it to empty.
         */
        $options[CURLOPT_HTTPHEADER] = array_merge($request->getHeaders(), ['Expect:']);

        // Request body
        // ------------

        /*
         * Some HTTP methods cannot have payload:
         *
         * - GET — cURL will automatically change method to PUT or POST if we set CURLOPT_UPLOAD or
         *   CURLOPT_POSTFIELDS.
         * - HEAD — cURL treats HEAD as GET request with a same restrictions.
         * - TRACE — According to RFC7231: a client MUST NOT send a message body in a TRACE request.
         */
        if (!in_array($request->getMethod(), ['GET', 'HEAD', 'TRACE'], true)) {
            $body = $request->getBody();
            if ($body) {
                // Small body can be loaded into memory
                $options[CURLOPT_POSTFIELDS] = (string)$body;
            }
        }

        if ($request->getMethod() === 'HEAD') {
            // This will set HTTP method to "HEAD".
            $options[CURLOPT_NOBODY] = true;
        } elseif ($request->getMethod() !== 'GET') {
            // GET is a default method. Other methods should be specified explicitly.
            $options[CURLOPT_CUSTOMREQUEST] = $request->getMethod();
        }

        return $options;
    }
}
