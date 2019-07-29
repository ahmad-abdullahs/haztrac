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

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheException;
use Psr\SimpleCache\CacheInterface;
use Sugarcrm\Sugarcrm\Audit\EventRepository;
use Sugarcrm\Sugarcrm\Audit\Formatter as AuditFormatter;
use Sugarcrm\Sugarcrm\Audit\Formatter\CompositeFormatter;
use Sugarcrm\Sugarcrm\Cache\Backend\APCu as APCuCache;
use Sugarcrm\Sugarcrm\Cache\Backend\BackwardCompatible as BackwardCompatibleCache;
use Sugarcrm\Sugarcrm\Cache\Backend\InMemory as InMemoryCache;
use Sugarcrm\Sugarcrm\Cache\Backend\Memcached as MemcachedCache;
use Sugarcrm\Sugarcrm\Cache\Backend\Redis as RedisCache;
use Sugarcrm\Sugarcrm\Cache\Backend\WinCache;
use Sugarcrm\Sugarcrm\Cache\Middleware\DefaultTTL;
use Sugarcrm\Sugarcrm\Cache\Middleware\MultiTenant as MultiTenantCache;
use Sugarcrm\Sugarcrm\Cache\Middleware\MultiTenant\KeyStorage\Configuration as ConfigurationKeyStorage;
use Sugarcrm\Sugarcrm\Cache\Middleware\Replicate;
use Sugarcrm\Sugarcrm\DataPrivacy\Erasure\Repository;
use Sugarcrm\Sugarcrm\Dbal\Logging\DebugLogger;
use Sugarcrm\Sugarcrm\Dbal\Logging\Formatter as DbalFormatter;
use Sugarcrm\Sugarcrm\Dbal\Logging\SlowQueryLogger;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Command\Rebuild;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Command\StateAwareRebuild;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Console\StatusCommand;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Job\RebuildJob;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Listener;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Listener\Builder\StateAwareBuilder;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Listener\Composite;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Listener\Logger;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Listener\PreFetch;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\Listener\StateAwareListener;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\State;
use Sugarcrm\Sugarcrm\Denormalization\TeamSecurity\State\Storage\AdminSettingsStorage;
use Sugarcrm\Sugarcrm\DependencyInjection\Exception\ServiceUnavailable;
use Sugarcrm\Sugarcrm\Logger\Factory as LoggerFactory;
use Sugarcrm\Sugarcrm\Security\Context;
use Sugarcrm\Sugarcrm\Security\Subject\Formatter as SubjectFormatter;
use Sugarcrm\Sugarcrm\Security\Subject\Formatter\BeanFormatter;
use Sugarcrm\Sugarcrm\Security\Validator\Validator;
use UltraLite\Container\Container;

return new Container([
    SugarConfig::class => function () {
        return SugarConfig::getInstance();
    },
    Connection::class => function () {
        return DBManagerFactory::getConnection();
    },
    SQLLogger::class => function (ContainerInterface $container) : SQLLogger {
        $config = $container->get(SugarConfig::class);

        $channel = LoggerFactory::getLogger('db');

        $logger = new LoggerChain();
        $logger->addLogger(new DebugLogger($channel));

        if ($config->get('dump_slow_queries')) {
            $logger->addLogger(
                new SlowQueryLogger(
                    $channel,
                    $config->get('slow_query_time_msec', 5000)
                )
            );
        }

        DbalFormatter::wrapLogger($channel);

        return $logger;
    },
    LoggerInterface::class => function () {
        return LoggerFactory::getLogger('default');
    },
    LoggerInterface::class . '-denorm' => function () {
        return LoggerFactory::getLogger('denorm');
    },
    LoggerInterface::class . '-security' => function () {
        return LoggerFactory::getLogger('security');
    },
    State::class => function (ContainerInterface $container) {
        $config = $container->get(SugarConfig::class);

        $state = new State(
            $config,
            new AdminSettingsStorage(),
            $container->get(LoggerInterface::class . '-denorm')
        );
        $config->attach($state);

        return $state;
    },
    Listener::class => function (ContainerInterface $container) {
        $conn = $container->get(Connection::class);
        $state = $container->get(State::class);
        $builder = new StateAwareBuilder(
            $container->get(Connection::class),
            $state
        );

        $logger = $container->get(LoggerInterface::class . '-denorm');

        $listener = new StateAwareListener($builder, $logger);
        $state->attach($listener);

        return new Composite(
            new Logger($logger),
            $listener,
            new PreFetch($conn)
        );
    },
    StateAwareRebuild::class => function (ContainerInterface $container) {
        $logger = $container->get(LoggerInterface::class . '-denorm');

        return new StateAwareRebuild(
            $container->get(State::class),
            new Rebuild(
                $container->get(Connection::class),
                $logger
            ),
            $logger
        );
    },
    StatusCommand::class => function (ContainerInterface $container) {
        return new StatusCommand(
            $container->get(State::class)
        );
    },
    RebuildJob::class => function (ContainerInterface $container) {
        return new RebuildJob(
            $container->get(StateAwareRebuild::class)
        );
    },
    Context::class => function (ContainerInterface $container) {
        return new Context(
            $container->get(LoggerInterface::class . '-security')
        );
    },
    Localization::class => function () {
        return Localization::getObject();
    },
    SubjectFormatter::class => function (ContainerInterface $container) {
        return new BeanFormatter(
            $container->get(Localization::class)
        );
    },
    EventRepository::class => function (ContainerInterface $container) {
        return new EventRepository(
            $container->get(Connection::class),
            $container->get(Context::class)
        );
    },
    Repository::class => function (ContainerInterface $container) {
        return new Repository(
            $container->get(Connection::class)
        );
    },
    AuditFormatter::class => function (ContainerInterface $container) {
        $class = \SugarAutoLoader::customClass(CompositeFormatter::class);
        return new $class(
            new \Sugarcrm\Sugarcrm\Audit\Formatter\Date(),
            new \Sugarcrm\Sugarcrm\Audit\Formatter\Enum(),
            new \Sugarcrm\Sugarcrm\Audit\Formatter\Email(),
            new \Sugarcrm\Sugarcrm\Audit\Formatter\Subject($container->get(SubjectFormatter::class))
        );
    },
    Administration::class => function () : Administration {
        return BeanFactory::newBean('Administration');
    },
    CacheInterface::class => function (ContainerInterface $container) : CacheInterface {
        $config = $container->get(SugarConfig::class);

        if ($config->get('external_cache_disabled')) {
            return new InMemoryCache();
        }

        $backend = $container->get(
            $config->get('cache.backend') ?? BackwardCompatibleCache::class
        );

        $backend = new DefaultTTL($backend, $config->get('cache_expire_timeout') ?: 300);

        if ($config->get('cache.multi_tenant')) {
            $backend = new MultiTenantCache(
                $config->get('unique_key'),
                new ConfigurationKeyStorage($config),
                $backend,
                $container->get(LoggerInterface::class)
            );
        }

        return new Replicate(
            $backend,
            new InMemoryCache()
        );
    },
    BackwardCompatibleCache::class => function () : BackwardCompatibleCache {
        return new BackwardCompatibleCache(SugarCache::electBackend());
    },
    ApcuCache::class => function () : ApcuCache {
        try {
            return new ApcuCache();
        } catch (CacheException $e) {
            throw new ServiceUnavailable($e->getMessage(), 0, $e);
        }
    },
    RedisCache::class => function (ContainerInterface $container) : RedisCache {
        $config = $container->get(SugarConfig::class)->get('external_cache.redis');

        try {
            return new RedisCache($config['host'] ?? null, $config['port'] ?? null);
        } catch (CacheException $e) {
            throw new ServiceUnavailable($e->getMessage(), 0, $e);
        }
    },
    MemcachedCache::class => function (ContainerInterface $container) : MemcachedCache {
        $config = $container->get(SugarConfig::class)->get('external_cache.memcache');

        try {
            return new MemcachedCache($config['host'] ?? null, $config['port'] ?? null);
        } catch (CacheException $e) {
            throw new ServiceUnavailable($e->getMessage(), 0, $e);
        }
    },
    WinCache::class => function () : WinCache {
        try {
            return new WinCache();
        } catch (CacheException $e) {
            throw new ServiceUnavailable($e->getMessage(), 0, $e);
        }
    },
    Validator::class => function () {
        return Validator::getService();
    },
]);
