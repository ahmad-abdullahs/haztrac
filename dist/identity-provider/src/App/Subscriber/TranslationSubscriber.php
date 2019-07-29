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

namespace Sugarcrm\IdentityProvider\App\Subscriber;

use Pimple\Container;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;

class TranslationSubscriber implements EventSubscriberInterface
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $localeParamName;

    public function __construct(Container $app, $localeParamName)
    {
        $this->app = $app;
        $this->locale =  $this->app['locale'];
        $this->localeParamName = $localeParamName;
    }

    /**
     * On kernel request subscriber
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        switch (true) {
            case $request->query->has($this->localeParamName):
                $this->locale = $request->query->get($this->localeParamName);
                break;
            case $request->cookies->has($this->localeParamName):
                $this->locale = $request->cookies->get($this->localeParamName);
                break;
        }
        $this->app['locale'] = $this->locale;
        $this->app['app.locale'] = strtolower(explode('-', $this->locale)[0]);
    }

    /**
     * On kernel response subscriber
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $cookie = new Cookie(
            $this->localeParamName,
            $this->locale,
            time() + 84600 * 365,
            '/',
            $event->getRequest()->getHost(),
            false,
            false
        );
        $response->headers->setCookie($cookie);
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 9]],
            KernelEvents::RESPONSE => [['onKernelResponse', 0]],
        ];
    }
}
