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

namespace Sugarcrm\Sugarcrm\Security\Subject;

use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\ServiceAccount\ServiceAccount;
use Sugarcrm\Sugarcrm\Security\Subject;

/**
 * Identity Service Account subject
 * @package Sugarcrm\Sugarcrm\Security\Subject
 */
class IdentityAwareServiceAccount implements Subject
{
    /**
     * @var ApiClient
     */
    private $client;

    /**
     * @var ServiceAccount
     */
    private $serviceAccount;

    /**
     * Constructor
     *
     * @param ApiClient $client
     * @param ServiceAccount $serviceAccount
     */
    public function __construct(ServiceAccount $serviceAccount, ApiClient $client)
    {
        $this->client = $client;
        $this->serviceAccount = $serviceAccount;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return [
            '_type' => 'identity-aware-sa',
            'id' => $this->serviceAccount->getSrn(),
            'client' => $this->client->jsonSerialize(),
        ];
    }
}
