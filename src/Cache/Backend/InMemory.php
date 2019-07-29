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

/**
 * In-memory cache middleware
 */
final class InMemory implements CacheInterface
{
    /**
     * Cached data
     *
     * @var mixed[]
     */
    private $data = [];

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value, $ttl = null)
    {
        $this->data[$key] = $value;

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($key)
    {
        unset($this->data[$key]);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        $this->data = [];

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getMultiple($keys, $default = null)
    {
        foreach ($keys as $key) {
            yield $key => array_key_exists($key, $this->data) ? $this->data[$key] : $default;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setMultiple($values, $ttl = null)
    {
        $this->data = array_merge($this->data, $values);

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            unset($this->data[$key]);
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function has($key)
    {
        return array_key_exists($key, $this->data);
    }
}
