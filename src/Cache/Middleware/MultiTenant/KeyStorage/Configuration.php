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

use Configurator;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use SugarConfig;
use Sugarcrm\Sugarcrm\Cache\Middleware\MultiTenant\KeyStorage;

/**
 * Temporary implementation until we figure how to eliminate the mutual dependency between cache and admin settings
 */
final class Configuration implements KeyStorage
{
    /**
     * @var SugarConfig
     */
    private $config;

    public function __construct(SugarConfig $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey() : ?Uuid
    {
        $key = $this->config->get('cache.encryption_key');

        try {
            return Uuid::fromString($key);
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function updateKey(Uuid $key) : void
    {
        $configurator = new Configurator();
        $configurator->config['cache']['encryption_key'] = $key->toString();
        $configurator->handleOverride();

        $this->config->clearCache();
    }
}
