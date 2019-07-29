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

final class Response
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $body;

    /**
     * @var array
     */
    private $headers;


    /**
     * Response constructor.
     * @param $code
     * @param string $body
     * @param array $headers
     */
    public function __construct($code, $body = '', $headers = [])
    {
        $this->code = $code;
        $this->body = $body;
        $this->headers = $headers;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s, %s', $this->code, $this->body);
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}