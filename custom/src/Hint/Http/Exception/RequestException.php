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
namespace Sugarcrm\Sugarcrm\custom\Hint\Http\Exception;

use Sugarcrm\Sugarcrm\custom\Hint\Http\Request;

class RequestException extends \RuntimeException
{
    /**
     * @var Request
     */
    private $request;


    /**
     * RequestException constructor.
     * @param string $message
     * @param Request $request
     */
    public function __construct(string $message, Request $request)
    {
        $this->request = $request;

        parent::__construct($message);
    }

    /**
     * Returns the request.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
