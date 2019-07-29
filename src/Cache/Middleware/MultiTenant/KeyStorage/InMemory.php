<?php declare(strict_types=1);
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

namespace Sugarcrm\Sugarcrm\Cache\Middleware\MultiTenant\KeyStorage;

use Ramsey\Uuid\Uuid;
use Sugarcrm\Sugarcrm\Cache\Middleware\MultiTenant\KeyStorage;

/**
 * In-memory implementation of the key storage
 */
final class InMemory implements KeyStorage
{
    /**
     * @var Uuid|null
     */
    private $key;

    /**
     * {@inheritDoc}
     */
    public function getKey() : ?Uuid
    {
        return $this->key;
    }

    /**
     * {@inheritDoc}
     */
    public function updateKey(Uuid $key) : void
    {
        $this->key = $key;
    }
}
