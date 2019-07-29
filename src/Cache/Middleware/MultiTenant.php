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

use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Sugarcrm\Sugarcrm\Cache\Middleware\MultiTenant\KeyStorage;
use Sugarcrm\Sugarcrm\Security\Crypto\AES256GCM;

/**
 * Multi-tenant cache middleware
 */
final class MultiTenant implements CacheInterface
{
    /**
     * Application instance key
     *
     * @var string
     */
    private $instanceKey;

    /**
     * Encryption key
     *
     * @var Uuid
     */
    private $key;

    /**
     * Encryption key storage
     *
     * @var KeyStorage
     */
    private $keyStorage;

    /**
     * Namespace for hashing cache keys
     *
     * @var Uuid
     */
    private $namespace;

    /**
     * Cryptographic algorithm implementation
     *
     * @var AES256GCM
     */
    private $crypto;

    /**
     * Underlying cache backend
     *
     * @var CacheInterface
     */
    private $backend;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param string $instanceKey
     * @param KeyStorage $keyStorage
     * @param CacheInterface $backend
     * @param LoggerInterface $logger
     */
    public function __construct(string $instanceKey, KeyStorage $keyStorage, CacheInterface $backend, LoggerInterface $logger)
    {
        $this->instanceKey = $instanceKey;
        $this->keyStorage = $keyStorage;
        $this->backend = $backend;
        $this->logger = $logger;

        $this->key = $keyStorage->getKey() ?: $this->generateKey();
        $this->initializeKey();
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        return $this->decrypt($key, $this->backend->get(
            $this->hash($key)
        ), $default);
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value, $ttl = null)
    {
        return $this->backend->set($this->hash($key), $this->encrypt($value), $ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($key)
    {
        return $this->backend->delete($this->hash($key));
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        $this->key = $this->generateKey();
        $this->initializeKey();

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getMultiple($keys, $default = null)
    {
        $hashToKey = $result = [];

        foreach ($keys as $key) {
            $hashToKey[$this->hash($key)] = $key;
        }

        $values = $this->backend->getMultiple(array_keys($hashToKey));

        foreach ($values as $hashedKey => $encryptedValue) {
            $key = $hashToKey[$hashedKey];
            $result[$key] = $this->decrypt($key, $encryptedValue, $default);
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function setMultiple($values, $ttl = null)
    {
        $encryptedAndHashedValues = [];

        foreach ($values as $key => $value) {
            $encryptedAndHashedValues[$this->hash($key)] = $this->encrypt($value);
        }

        return $this->backend->setMultiple($encryptedAndHashedValues, $ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteMultiple($keys)
    {
        return $this->backend->deleteMultiple(array_map(function ($key) {
            return $this->hash($key);
        }, $keys));
    }

    /**
     * {@inheritDoc}
     */
    public function has($key)
    {
        return $this->backend->has($key);
    }

    /**
     * Initializes the updated encryption key
     */
    private function initializeKey() : void
    {
        $this->namespace = Uuid::uuid5($this->instanceKey, $this->key);
        $this->crypto = new AES256GCM($this->key->toString());
    }

    /**
     * Generates a new key and stores it in the storage
     *
     * @return Uuid
     */
    private function generateKey() : Uuid
    {
        $key = Uuid::uuid4();
        $this->keyStorage->updateKey($key);

        return $key;
    }

    /**
     * Hashes the given cache key
     *
     * @param string $key
     * @return string
     */
    private function hash(string $key) : string
    {
        return Uuid::uuid5($this->namespace, $key)->toString();
    }

    /**
     * Encrypts the value to be cached
     *
     * @param mixed $value
     * @return string
     */
    private function encrypt($value) : string
    {
        return $this->crypto->encrypt(serialize($value));
    }

    /**
     * Decrypts the cached value
     *
     * @param string $key
     * @param mixed $value
     * @param mixed $default
     * @return mixed
     */
    private function decrypt($key, $value, $default)
    {
        if ($value === null) {
            return $default;
        }

        try {
            return unserialize($this->crypto->decrypt($value), [
                'allowed_classes' => false,
            ]);
        } catch (RuntimeException $e) {
            $this->logger->warning(sprintf('Failed to decrypt key "%s": %s', $key, $e->getMessage()));

            return $default;
        }
    }
}
