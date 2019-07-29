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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Listener\Success;

use Pimple\Container;
use Sugarcrm\IdentityProvider\App\Subscriber\TranslationSubscriber;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Subscriber\TranslationSubscriber
 */
class TranslationSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Container
     */
    protected $application;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Request
     */
    protected $request;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Response
     */
    protected $response;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | ParameterBag
     */
    protected $requestQuery;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | ParameterBag
     */
    protected $requestCookies;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | ResponseHeaderBag
     */
    protected $responseHeaders;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | GetResponseEvent
     */
    protected $getResponseEvent;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | FilterResponseEvent
     */
    protected $filterResponseEvent;


    protected function setUp()
    {
        $this->application = new Container();

        $this->request = $this->createMock(Request::class);

        $this->requestQuery = $this->createMock(ParameterBag::class);
        $this->request->query = $this->requestQuery;

        $this->requestCookies = $this->createMock(ParameterBag::class);
        $this->request->cookies = $this->requestCookies;

        $this->getResponseEvent = $this->createMock(GetResponseEvent::class);
        $this->getResponseEvent->expects($this->any())->method('getRequest')->willReturn($this->request);

        $this->responseHeaders = $this->createMock(ResponseHeaderBag::class);

        $this->response = $this->createMock(Response::class);
        $this->response->headers = $this->responseHeaders;

        $this->filterResponseEvent = $this->createMock(FilterResponseEvent::class);
        $this->filterResponseEvent->expects($this->any())->method('getResponse')->willReturn($this->response);
        $this->filterResponseEvent->expects($this->any())->method('getRequest')->willReturn($this->request);

        parent::setUp();
    }

    /**
     * @covers ::onKernelRequest
     */
    public function testOnKernelRequestDefaultLocale()
    {
        $paramName = 'locale';

        $this->requestQuery->expects($this->once())
            ->method('has')
            ->with($paramName)
            ->willReturn(false);

        $this->requestCookies->expects($this->once())
            ->method('has')
            ->with($paramName)
            ->willReturn(false);

        $this->application['locale'] = 'en-US';

        $subscriber = new TranslationSubscriber($this->application, $paramName);
        $subscriber->onKernelRequest($this->getResponseEvent);

        $this->assertEquals('en-US', $this->application['locale']);
        $this->assertEquals('en', $this->application['app.locale']);
    }

    /**
     * @covers ::onKernelRequest
     */
    public function testOnKernelRequestQueryLocale()
    {
        $paramName = 'locale';

        $this->requestQuery->expects($this->once())
            ->method('has')
            ->with($paramName)
            ->willReturn(true);

        $this->requestQuery->expects($this->once())
            ->method('get')
            ->with($paramName)
            ->willReturn('de-DE');

        $this->requestCookies->expects($this->never())
            ->method('has')
            ->with($paramName)
            ->willReturn(false);

        $this->application['locale'] = 'en-US';

        $subscriber = new TranslationSubscriber($this->application, $paramName);
        $subscriber->onKernelRequest($this->getResponseEvent);

        $this->assertEquals('de-DE', $this->application['locale']);
        $this->assertEquals('de', $this->application['app.locale']);
    }

    /**
     * @covers ::onKernelRequest
     */
    public function testOnKernelRequestCookieLocale()
    {
        $paramName = 'locale';

        $this->requestQuery->expects($this->once())
            ->method('has')
            ->with($paramName)
            ->willReturn(false);

        $this->requestCookies->expects($this->once())
            ->method('has')
            ->with($paramName)
            ->willReturn(true);

        $this->requestCookies->expects($this->once())
            ->method('get')
            ->with($paramName)
            ->willReturn('fr-FR');

        $this->application['locale'] = 'en-US';

        $subscriber = new TranslationSubscriber($this->application, $paramName);
        $subscriber->onKernelRequest($this->getResponseEvent);

        $this->assertEquals('fr-FR', $this->application['locale']);
        $this->assertEquals('fr', $this->application['app.locale']);
    }

    /**
     * @covers ::onKernelResponse
     */
    public function testOnKernelResponse()
    {
        $paramName = 'locale';
        $this->application['locale'] = 'en-US';

        $this->request->expects($this->once())
            ->method('getHost')
            ->willReturn('http://test.url');

        $this->responseHeaders->expects($this->once())
            ->method('setCookie')
            ->with($this->callback(function ($cookie) use ($paramName) {
                /** @var Cookie $cookie */
                $this->assertEquals('en-US', $cookie->getValue());
                $this->assertEquals($paramName, $cookie->getName());
                return true;
            }));

        $subscriber = new TranslationSubscriber($this->application, $paramName);
        $subscriber->onKernelResponse($this->filterResponseEvent);
    }
}
