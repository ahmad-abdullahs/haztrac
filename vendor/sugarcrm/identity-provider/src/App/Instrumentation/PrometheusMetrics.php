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

namespace Sugarcrm\IdentityProvider\App\Instrumentation;

use Prometheus\CollectorRegistry;
use Prometheus\Exception\StorageException;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\APC;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PrometheusMetrics
{
    /**
     * Metrics endpoint
     *
     * @var string
     */
    private $metricsEndpoint = null;

    /**
     * @var \Prometheus\CollectorRegistry
     */
    private $registry = null;

    /**
     * @param string $metricsEndpoint
     */
    public function __construct(string $metricsEndpoint)
    {
        $this->metricsEndpoint = $metricsEndpoint;
    }

    /**
     * Initialize metrics
     *
     * @param Application $app
     */
    public function initialize(Application $app) : void
    {
        $startTime = microtime(true);
        $app->finish(function (Request $request, Response $response, Application $app) use ($startTime) {
            $endpoint = $request->getPathInfo();
            if ($endpoint == $this->metricsEndpoint) {
                return;
            }
            $labels = ['endpoint', 'code'];
            $labelsValues = [$endpoint, $response->getStatusCode()];
            try {
                $registry = $this->getRegistry();
                $counter = $registry->getOrRegisterCounter('login', 'requests_total', 'Login service requests served per endpoint', $labels);
                $counter->inc($labelsValues);
                $histogram = $registry->getOrRegisterHistogram('login', 'response_time_seconds', 'Login service response time', $labels);
                $histogram->observe(microtime(true) - $startTime, $labelsValues);
            } catch (StorageException $e) {
                $app->getLogger()->warning('Metrics storage is not available');
            }
        });
    }

    /**
     * Render metrics
     *
     * @return callable
     */
    public function render() : callable
    {
        return function () {
            return new Response(
                (new RenderTextFormat())->render($this->getRegistry()->getMetricFamilySamples()),
                Response::HTTP_OK,
                ['Content-Type' => 'text/plain']
            );
        };
    }

    /**
     * @return CollectorRegistry
     */
    private function getRegistry() : CollectorRegistry
    {
        if (is_null($this->registry)) {
            if (!$this->isStorageAvailable()) {
                throw new StorageException('APC storage for metrics is not available');
            }
            $this->registry = new CollectorRegistry(new APC());
        }
        return $this->registry;
    }

    /**
     * Checks if storage available
     *
     * @return bool
     */
    private function isStorageAvailable() : bool
    {
        return ini_get('apc.enabled')
            && ((php_sapi_name() != 'cli') || ini_get('apc.enable_cli'));
    }
}
