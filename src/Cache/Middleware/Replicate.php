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
use stdClass;

/**
 * Replicates data between two backends
 */
final class Replicate implements CacheInterface
{
    /**
     * Source backend
     *
     * @var CacheInterface
     */
    private $source;

    /**
     * Replica backend
     *
     * @var CacheInterface
     */
    private $replica;

    /**
     * @var object
     */
    private $miss;

    /**
     * @param CacheInterface $source
     * @param CacheInterface $replica
     */
    public function __construct(CacheInterface $source, CacheInterface $replica)
    {
        $this->source = $source;
        $this->replica = $replica;
        $this->miss = new stdClass();
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        $miss = is_object($default) ? $default : $this->miss;

        $value = $this->replica->get($key, $miss);

        if ($value !== $miss) {
            return $value;
        }

        $value = $this->source->get($key, $miss);

        if ($value === $miss) {
            return $default;
        }

        $this->replica->set($key, $value/*, $ttl is currently irrelevant*/);

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value, $ttl = null)
    {
        return $this->source->set($key, $value, $ttl)
            && $this->replica->set($key, $value, $ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($key)
    {
        return $this->source->delete($key)
            && $this->replica->delete($key);
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        return $this->source->clear()
            && $this->replica->clear();
    }

    /**
     * {@inheritDoc}
     */
    public function getMultiple($keys, $default = null)
    {
        $miss = is_object($default) ? $default : $this->miss;
        $missingKeys = array_flip($keys);

        foreach ($this->replica->getMultiple($keys, $miss) as $key => $value) {
            if ($value !== $miss) {
                unset($missingKeys[$key]);
            }

            yield $key => $value;
        }

        $todo = [];

        foreach ($this->replica->getMultiple(array_keys($missingKeys), $miss) as $key => $value) {
            if ($value !== $miss) {
                $todo[$key] = $value;
            } else {
                $value = $default;
            }

            yield $key => $value;
        }

        $this->replica->setMultiple($todo/*, $ttl is currently irrelevant*/);
    }

    /**
     * {@inheritDoc}
     */
    public function setMultiple($values, $ttl = null)
    {
        return $this->source->setMultiple($values, $ttl)
            && $this->replica->setMultiple($values, $ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteMultiple($keys)
    {
        return $this->source->deleteMultiple($keys)
            && $this->replica->deleteMultiple($keys);
    }

    /**
     * {@inheritDoc}
     */
    public function has($key)
    {
        return $this->replica->has($key)
            || $this->source->has($key);
    }
}
