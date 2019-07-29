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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Authentication;

use Pimple\Container;
use Sugarcrm\IdentityProvider\App\Authentication\LogoutService;
use Sugarcrm\IdentityProvider\Authentication\RememberMe\Service;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGenerator;

class LogoutServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LogoutService
     */
    private $logoutService;

    /**
     * @var UrlGenerator | \PHPUnit_Framework_MockObject_MockObject
     */
    private $urlGenerator;

    /**
     * @var Service | \PHPUnit_Framework_MockObject_MockObject
     */
    private $rememberMe;

    /**
     * @var Session | \PHPUnit_Framework_MockObject_MockObject
     */
    private $session;

    protected function setUp()
    {
        $config = [
            'logout.options' => [
                'cookie_secure' => false,
                'cookie_name' => 'logout',
            ],
        ];

        $this->urlGenerator = $this->createMock(UrlGenerator::class);

        $this->urlGenerator
            ->method('generate')
            ->willReturnMap(
                [
                    ['loginRender', [], UrlGenerator::ABSOLUTE_URL, '/login'],
                ]
            );

        $this->rememberMe = $this->createMock(Service::class);
        $this->session = $this->createMock(Session::class);

        $app = $this->createMock(Container::class);
        $app->method('offsetGet')->willReturnMap([
            ['url_generator', $this->urlGenerator],
            ['RememberMe', $this->rememberMe],
            ['config', $config],
            ['session', $this->session],
        ]);

        $this->logoutService = new LogoutService($app);

        parent::setUp();
    }

    /**
     * Provides data for testLogout
     *
     * @return array
     */
    public function logoutProvider(): array
    {
        return [
            'requestWithoutRedirectUriAndReferer' => [
                'query' => [],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'expectedCookieDomain' => '.staging.sugarcrm.io',
                'expectedRedirectUrl' => '/login',
            ],
            'requestWithoutRedirectUriAndRefererTwoComponentsDomain' => [
                'query' => [],
                'server' => [
                    'HTTP_HOST' => 'sugarcrm.io',
                ],
                'expectedCookieDomain' => '.sugarcrm.io',
                'expectedRedirectUrl' => '/login',
            ],
            'requestWithRedirectUriOnLoginService' => [
                'query' => [
                    'redirect_uri' => 'http://login.staging.sugarcrm.io/logout',
                ],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'expectedCookieDomain' => '.staging.sugarcrm.io',
                'expectedRedirectUrl' => '/login',
            ],
            'requestWithRedirectUri' => [
                'query' => [
                    'redirect_uri' => 'http://console.staging.sugarcrm.io/',
                ],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'expectedCookieDomain' => '.staging.sugarcrm.io',
                'expectedRedirectUrl' => 'http://console.staging.sugarcrm.io/',
            ],
            'requestWithNotAllowedRedirectUri' => [
                'query' => [
                    'redirect_uri' => 'http://google.com/',
                ],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                ],
                'expectedCookieDomain' => '.staging.sugarcrm.io',
                'expectedRedirectUrl' => '/login',
            ],
            'requestWithoutRedirectUriButWithReferer' => [
                'query' => [],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                    'HTTP_REFERER' => 'http://api.staging.sugarcrm.io/',
                ],
                'expectedCookieDomain' => '.staging.sugarcrm.io',
                'expectedRedirectUrl' => 'http://api.staging.sugarcrm.io/',
            ],
            'requestWithoutRedirectUriButWithRefererOnLoginService' => [
                'query' => [],
                'server' => [
                    'HTTP_HOST' => 'login.staging.sugarcrm.io',
                    'HTTP_REFERER' => 'http://login.staging.sugarcrm.io/logout',
                ],
                'expectedCookieDomain' => '.staging.sugarcrm.io',
                'expectedRedirectUrl' => '/login',
            ],
        ];
    }

    /**
     * @param array $query
     * @param array $server
     * @param string $expectedCookieDomain
     * @param string $expectedRedirectUrl
     *
     * @dataProvider logoutProvider
     *
     * @return void
     */
    public function testLogout(
        array $query,
        array $server,
        string $expectedCookieDomain,
        string $expectedRedirectUrl
    ): void {
        $request = new Request($query, [], [], [], [], $server);
        Request::setTrustedProxies(['127.0.0.1', 'localhost'], 1);
        $response = $this->logoutService->logout($request);
        $cookies = $response->headers->getCookies();
        $logoutCookie = $cookies[0];
        $this->assertEquals($expectedCookieDomain, $logoutCookie->getDomain());
        $this->assertEquals('logout', $logoutCookie->getName());
        $this->assertEquals('1', $logoutCookie->getValue());
        $this->assertEquals($expectedRedirectUrl, $response->getTargetUrl());
    }

    /**
     * Logout cookie delete logic test
     *
     * @return void
     */
    public function testClearLogoutCookie(): void
    {
        $request = new Request([], [], [], [], [], ['HTTP_HOST' => 'login.staging.sugarcrm.io']);
        $response = new Response();
        $this->logoutService->clearLogoutCookies($request, $response);
        $cookies = $response->headers->getCookies();
        $logoutCookie = $cookies[0];
        $this->assertEquals('.staging.sugarcrm.io', $logoutCookie->getDomain());
        $this->assertLessThan(time(), $logoutCookie->getExpiresTime());
        $this->assertEquals('logout', $logoutCookie->getName());
    }
}
