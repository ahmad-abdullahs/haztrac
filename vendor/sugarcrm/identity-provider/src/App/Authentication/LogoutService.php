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

namespace Sugarcrm\IdentityProvider\App\Authentication;

use Pimple\Container;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\Authentication\RememberMe\Service;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
 * Class LogoutService
 * @package Sugarcrm\IdentityProvider\App\Authentication
 */
class LogoutService
{
    /**
     * @var UrlGenerator
     */
    private $generator;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var Service
     */
    private $rememberMe;

    /**
     * @var bool
     */
    private $cookieSecure;

    /**
     * @var string
     */
    private $cookieName;

    /**
     * LogoutService constructor.
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->generator = $app['url_generator'];
        $this->session = $app['session'];
        $this->rememberMe = $app['RememberMe'];

        $logoutConfig = $app['config']['logout.options'];
        $this->cookieName = !empty($logoutConfig['cookie_name']) ? $logoutConfig['cookie_name'] : 'cloud-log';
        $this->cookieSecure = !empty($logoutConfig['cookie_secure']);
    }

    /**
     * Set logout cookies and redirect to specific resource
     *
     * @param Request $request
     * @param string $forceRedirectUrl
     *
     * @return RedirectResponse
     */
    public function logout(Request $request, $forceRedirectUrl = ''): RedirectResponse
    {
        $this->rememberMe->clear();
        $response = new RedirectResponse($forceRedirectUrl ?: $this->getRedirectUrl($request));
        $cookie = new Cookie(
            $this->cookieName,
            1,
            time() + 84600 * 365,
            '/',
            $this->getCookiesPath($request),
            $this->cookieSecure,
            false
        );
        $response->headers->setCookie($cookie);

        if ($this->session->has(TenantConfigInitializer::SESSION_KEY)) {
            $this->session->remove(TenantConfigInitializer::SESSION_KEY);
        }

        return $response;
    }

    /**
     * Delete logout cookies
     *
     * @param Request $request
     * @param Response $response
     *
     * @return void
     */
    public function clearLogoutCookies(Request $request, Response $response): void
    {
        $cookie = new Cookie(
            $this->cookieName,
            null,
            time() - 86400,
            '/',
            $this->getCookiesPath($request),
            $this->cookieSecure,
            false
        );
        $response->headers->setCookie($cookie);
    }

    /**
     * Gets url for redirect
     *
     * @param Request $request
     * @return string
     */
    public function getRedirectUrl(Request $request): string
    {
        $redirect = '';
        if ($request->query->has('redirect_uri')) {
            $redirect = $request->query->get('redirect_uri');
        } elseif ($request->headers->has('referer')) {
            $redirect = $request->headers->get('referer');
        }

        $redirectDomain = parse_url($redirect, PHP_URL_HOST);

        $isValidRedirect = strpos($redirectDomain, $this->getCookiesPath($request));

        return $isValidRedirect === false || $redirectDomain === $request->getHost() ?
            $this->generator->generate('loginRender', [], UrlGenerator::ABSOLUTE_URL) :
            $redirect;
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getCookiesPath(Request $request): string
    {
        $host = $request->getHost();
        if (substr_count($host, '.') > 1) {
            return preg_replace('/^.*\./U', '.', $request->getHost());
        }

        return '.' . $host;
    }
}
