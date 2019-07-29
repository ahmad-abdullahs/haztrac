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

namespace Sugarcrm\IdentityProvider\App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\EventListenerProviderInterface;
use Sugarcrm\IdentityProvider\App\Subscriber\TranslationSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Formatter\MessageFormatter;
use Symfony\Component\Translation\Loader\XliffFileLoader;

class TranslationServiceProvider implements ServiceProviderInterface, EventListenerProviderInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $localeParamName;

    /**
     * LocaleSubscriberProvider constructor.
     * @param array $config
     * @param string $localeParamName
     */
    public function __construct(array $config, $localeParamName)
    {
        $this->config = $config;
        if (empty($this->config['default'])) {
            throw new \LogicException('Can\'t init translation without default locale');
        }
        $this->config['fallback'] = $this->config['fallback'] ?? [explode('-', $this->config['default'])[0]];
        $this->config['resources'] = $this->config['resources'] ?? [];

        $this->localeParamName = $localeParamName;
    }

    public function register(Container $app)
    {
        $app['translator'] = function ($app) {
            $translator = new Translator(
                $app['app.locale'],
                $app['translator.message_selector'],
                $this->joinPaths($app->getRootDir(), '/var/cache/translation'),
                $app['debug']
            );
            $translator->setFallbackLocales($this->config['fallback']);
            $translator->addLoader('xliff', new XliffFileLoader());

            // add application translation
            foreach ($this->config['resources'] as $resourceLocale => $resource) {
                $translator->addResource('xliff', $this->joinPaths($app->getRootDir(), $resource), $resourceLocale);
            }

            $this->addValidatorTranslation($translator, $app->getRootDir(), $app['app.locale']);

            return $translator;
        };

        $app['translator.message_selector'] = function () {
            return new MessageFormatter();
        };

        $app['translation.subscriber'] = function ($app) {
            return new TranslationSubscriber($app, $this->localeParamName);
        };
        $app['locale'] = $this->config['default'];
        $app['app.locale'] = explode('-', $app['locale'])[0];
    }

    public function subscribe(Container $app, EventDispatcherInterface $dispatcher)
    {
        $dispatcher->addSubscriber($app['translation.subscriber']);
    }

    /**
     * join path parts
     * @param string ...$args
     * @return string
     */
    protected function joinPaths(...$args)
    {
        $path = rtrim($args[0], DIRECTORY_SEPARATOR) ?? '';
        for ($i = 1; $i < count($args); $i++) {
            $path .= DIRECTORY_SEPARATOR . ltrim($args[$i], DIRECTORY_SEPARATOR);
        }
        return $path;
    }

    /**
     * add validator resource to translation
     * @param Translator $translator
     * @param $appRootDir
     * @param $locale
     */
    protected function addValidatorTranslation(Translator $translator, $appRootDir, $locale)
    {
        $basePath = $this->joinPaths($appRootDir, '/vendor/symfony/validator/Resources/translations');
        $file = $basePath . DIRECTORY_SEPARATOR . 'validators.' . $locale . '.xlf';
        if (file_exists($file)) {
            $translator->addResource('xliff', $file, $locale, 'validators');
        }
        return;
    }
}
