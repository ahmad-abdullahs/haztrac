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

namespace Sugarcrm\Sugarcrm\Cache\Middleware;

use Psr\SimpleCache\CacheInterface;

/**
 * Provides default TTL for cache entries
 */
final class DefaultTTL implements CacheInterface
{
    /**
     * @var CacheInterface
     */
    private $backend;

    /**
     * TTL in seconds
     *
     * @var int
     */
    private $ttl;

    public function __construct(CacheInterface $backend, int $ttl)
    {
        $this->backend = $backend;
        $this->ttl = $ttl;
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    public function get($key, $default = null)
    {
        return $this->backend->get($key, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value, $ttl = null)
    {
        return $this->backend->set($key, $value, $ttl ?? $this->ttl);
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    public function delete($key)
    {
        return $this->backend->delete($key);
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    public function clear()
    {
        return $this->backend->clear();
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    public function getMultiple($keys, $default = null)
    {
        return $this->backend->getMultiple($keys, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function setMultiple($values, $ttl = null)
    {
        return $this->backend->setMultiple($values, $ttl ?? $this->ttl);
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    public function deleteMultiple($keys)
    {
        return $this->backend->deleteMultiple($keys);
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    public function has($key)
    {
        return $this->backend->has($key);
    }
}
