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

use Psr\SimpleCache\CacheInterface;
use Sugarcrm\Sugarcrm\Cache\Exception;
use SugarCache;
use SugarCacheAbstract;

/**
 * Backward compatible cache adapter
 */
final class BackwardCompatible implements CacheInterface
{
    /**
     * Cached backend
     *
     * @var SugarCacheAbstract
     */
    private $backend;

    /**
     * @codeCoverageIgnore
     *
     * @param SugarCacheAbstract $backend
     *
     * @throws Exception
     */
    public function __construct(SugarCacheAbstract $backend)
    {
        if (!$backend->useBackend()) {
            throw new Exception(sprintf('The %s backend is unavailable', $backend));
        }

        $this->backend = $backend;
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        $value = $this->backend->get($key);

        if ($value === null) {
            return $default;
        }

        if ($value === SugarCache::EXTERNAL_CACHE_NULL_VALUE) {
            return null;
        }

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value, $ttl = null)
    {
        $this->backend->set($key, $value, $ttl);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($key)
    {
        $this->backend->__unset($key);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        $this->backend->flush();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getMultiple($keys, $default = null)
    {
        foreach ($keys as $key) {
            yield $key => $this->get($key, $default);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setMultiple($values, $ttl = null)
    {
        $result = true;

        foreach ($values as $key => $value) {
            $result = $this->set($key, $value, $ttl) && $result;
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteMultiple($keys)
    {
        $result = true;

        foreach ($keys as $key) {
            $result = $this->delete($key) && $result;
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function has($key)
    {
        return $this->backend->get($key) !== null;
    }
}
