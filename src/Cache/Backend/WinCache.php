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

/**
 * WinCache implementation of the cache backend
 *
 * @link http://pecl.php.net/package/WinCache
 */
final class WinCache implements CacheInterface
{
    /**
     * @codeCoverageIgnore
     *
     * @throws Exception
     */
    public function __construct()
    {
        if (!extension_loaded('wincache')) {
            throw new Exception('WinCache extension is not loaded');
        }

        if (!ini_get('wincache.ucenabled')) {
            throw new Exception('WinCache extension is disabled');
        }

        if (php_sapi_name() === 'cli' && !ini_get('wincache.enablecli')) {
            throw new Exception('WinCache extension is disabled for CLI');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        $value = wincache_ucache_get($key, $success);

        if (!$success) {
            return $default;
        }

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value, $ttl = null)
    {
        return wincache_ucache_set($key, $value, $ttl ?? 0);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($key)
    {
        return wincache_ucache_delete($key);
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        return wincache_ucache_clear();
    }

    /**
     * {@inheritDoc}
     */
    public function getMultiple($keys, $default = null)
    {
        return array_merge(array_fill_keys($keys, $default), wincache_ucache_get($keys));
    }

    /**
     * {@inheritDoc}
     */
    public function setMultiple($values, $ttl = null)
    {
        return wincache_ucache_set($values, null, $ttl ?? 0) === [];
    }

    /**
     * {@inheritDoc}
     */
    public function deleteMultiple($keys)
    {
        wincache_ucache_delete($keys);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function has($key)
    {
        return wincache_ucache_exists($key);
    }
}
