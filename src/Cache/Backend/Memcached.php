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

namespace Sugarcrm\Sugarcrm\Cache\Backend;

use Memcached as Client;
use Sugarcrm\Sugarcrm\Cache\Exception;
use Symfony\Component\Cache\Simple\MemcachedCache;

/**
 * Memcached implementation of the cache backend
 *
 * @link http://pecl.php.net/package/memcached
 */
final class Memcached extends MemcachedCache
{
    /**
     * @param string|null $host
     * @param int|null $port
     *
     * @throws Exception
     * @codeCoverageIgnore
     */
    public function __construct(?string $host, ?int $port = null)
    {
        if (!extension_loaded('memcached')) {
            throw new Exception('The memcached extension is not loaded');
        }

        $client = new Client();
        $client->addServer($host ?? '127.0.0.1', $port ?? 11211);

        // force connection to detect availability before the backend is declared available
        // it is only needed until backend election is the old cache API is supported
        if ($client->getVersion() === false) {
            throw new Exception('Unable to connect to memcached server');
        }

        parent::__construct($client);
    }
}
