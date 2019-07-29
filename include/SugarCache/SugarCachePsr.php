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

use Psr\Container\ContainerExceptionInterface;
use Psr\SimpleCache\CacheInterface;
use Sugarcrm\Sugarcrm\DependencyInjection\Container;

/**
 * Adapter which allows using a PSR-6 cache implementation as an old API backend
 *
 * @internal Used only for forward compatibility with PSR-6
 *
 * @codingStandardsIgnoreFile due to the inherited method names
 */
class SugarCachePsr extends SugarCacheAbstract
{
    /**
     * @var CacheInterface
     */
    private $backend;

    /**
     * @var string|null
     */
    private $disableParameter;

    public function __construct(string $backendService, int $priority, ?string $disableParameter)
    {
        parent::__construct();

        $this->_priority = $priority;
        $this->disableParameter = $disableParameter;

        // prevent further object initialization since it may produce undesired side-effects like a connection attempt
        if ($this->disableParameter && !empty($GLOBALS['sugar_config'][$this->disableParameter])) {
            return;
        }

        try {
            $this->backend = Container::getInstance()->get($backendService);
        } catch (ContainerExceptionInterface $e) {
            // The absence of the backend will prevent the object from being used
        }
    }

    /**
     * {@inheritDoc}
     */
    public function useBackend()
    {
        if (!$this->backend) {
            return false;
        }

        if (!parent::useBackend()) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    protected function _setExternal($key, $value)
    {
        $this->backend->set(
            $this->filterKey($key),
            $value,
            $this->_expireTimeout ?: null
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function _getExternal($key)
    {
        return $this->backend->get($this->filterKey($key));
    }

    /**
     * {@inheritDoc}
     */
    protected function _clearExternal($key)
    {
        $this->backend->delete($this->filterKey($key));
    }

    /**
     * {@inheritDoc}
     */
    protected function _resetExternal()
    {
        $this->backend->clear();
    }

    /**
     * @param string $key
     *
     * @link https://www.php-fig.org/psr/psr-16/
     * @return string
     */
    private function filterKey(string $key) : string
    {
        if (strpbrk($key, '{}()/\@:') !== false) {
            $GLOBALS['log']->warn(
                sprintf('The cache key "%s" contains characters reserved by the PSR-16 standard', $key)
            );
            $key = str_replace(['{', '}', '(', ')', '/', '\\', '@', ':'], '-', $key);
        }

        return $key;
    }
}
