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

use Psr\SimpleCache\CacheInterface;

/**
 * Sugar Cache manager
 * @api
 */
class SugarCache
{
    const EXTERNAL_CACHE_NULL_VALUE = "SUGAR_CACHE_NULL_ZZ";

    protected static $_cacheInstance;

    /**
     * @var true if the cache has been reset during this request, so we no longer return values from
     *      cache until the next reset
     */
    public static $isCacheReset = false;

    private function __construct() {}

    /**
     * initializes the cache in question
     */
    protected static function _init()
    {
        self::$_cacheInstance = new SugarCachePsr(CacheInterface::class, 1000, null);
    }

    /**
     * Elects a backend based on their priority and availability
     *
     * @return SugarCacheAbstract|null
     */
    public static function electBackend()
    {
        /** @var SugarCacheAbstract $backend */
        $backend = null;
        $lastPriority = 1000;

        $locations = SugarAutoLoader::getFilesCustom('include/SugarCache');

        foreach ($locations as $location) {
            $class = basename($location, '.php');

            if ($class === 'SugarCache' || $class === 'SugarCachePsr') {
                continue;
            }

            require_once $location;

            if (class_exists($class) && is_subclass_of($class, 'SugarCacheAbstract')) {
                $GLOBALS['log']->debug("Found cache backend $class");

                /** @var SugarCacheAbstract $instance */
                $instance = new $class();

                if ($instance->useBackend() && $instance->getPriority() < $lastPriority) {
                    $GLOBALS['log']->debug(sprintf(
                        'Using cache backend %s, since %d is less than %d',
                        $class,
                        $instance->getPriority(),
                        $lastPriority
                    ));

                    $backend = $instance;
                    $lastPriority = $instance->getPriority();
                }
            }
        }

        return $backend;
    }

    /**
     * Returns the instance of the SugarCacheAbstract object, cooresponding to the external
     * cache being used.
     *
     * @return SugarCacheAbstract
     *
     * @deprecated use Psr\SimpleCache\CacheInterface instead
     */
    public static function instance()
    {
        if ( !is_subclass_of(self::$_cacheInstance,'SugarCacheAbstract') )
            self::_init();

        return self::$_cacheInstance;
    }

    /**
     * Try to reset any opcode caches we know about
     *
     * @todo make it so developers can extend this somehow
     */
    public static function cleanOpcodes()
    {
        // APC
        if ( function_exists('apc_clear_cache') && ini_get('apc.stat') == 0 ) {
            apc_clear_cache();
        }
        // Wincache
        if ( function_exists('wincache_refresh_if_changed') ) {
            wincache_refresh_if_changed();
        }
        // Zend
        if ( function_exists('accelerator_reset') ) {
            accelerator_reset();
        }
        // eAccelerator
        if ( function_exists('eaccelerator_clear') ) {
            eaccelerator_clear();
        }
        // XCache
        if ( function_exists('xcache_clear_cache') && !ini_get('xcache.admin.enable_auth') ) {
            $max = xcache_count(XC_TYPE_PHP);
            for ($i = 0; $i < $max; $i++) {
                if (!xcache_clear_cache(XC_TYPE_PHP, $i)) {
                    break;
                }
            }
        }
    }

    /**
     * Try to reset file from caches
     */
    public static function cleanFile( $file )
    {
        // APC
        if ( function_exists('apc_delete_file') && ini_get('apc.stat') == 0 )
        {
            apc_delete_file( $file );
        }
    }
}

/**
 * Retrieve a key from cache.  For the Zend Platform, a maximum age of 5 minutes is assumed.
 *
 * @param string $key The item to retrieve.
 * @return mixed
 */
function sugar_cache_retrieve($key)
{
    return SugarCache::instance()->$key;
}

/**
 * Put a value in the cache under a key
 *
 * @param string $key Global namespace cache.  Key for the data.
 * @param mixed $value The value to store in the cache.
 * @param int|null $ttl
 */
function sugar_cache_put($key, $value, $ttl = null)
{
    SugarCache::instance()->set($key,$value, $ttl);
}

/**
 * Clear a key from the cache.  This is used to invalidate a single key.
 *
 * @param String $key -- Key from global namespace
 */
function sugar_cache_clear($key)
{
    unset(SugarCache::instance()->$key);
}

/**
 * Turn off external caching for the rest of this round trip and for all round
 * trips for the next cache timeout.  This function should be called when global arrays
 * are affected (studio, module loader, upgrade wizard, ... ) and it is not ok to
 * wait for the cache to expire in order to see the change.
 */
function sugar_cache_reset()
{
    SugarCache::instance()->reset();
    SugarCache::cleanOpcodes();
}

/**
 * Flush the cache in its entirety including the local and external store along with the opcodes.
 */
function sugar_cache_reset_full()
{
    SugarCache::instance()->resetFull();
    SugarCache::cleanOpcodes();
}

/**
 * Clean out whatever opcode cache we may have out there.
 */
function sugar_clean_opcodes()
{
    SugarCache::cleanOpcodes();
}
