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

namespace Sugarcrm\IdentityProvider\App\Controller;

use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentToken;
use Sugarcrm\IdentityProvider\Authentication\Provider\Providers;
use Sugarcrm\IdentityProvider\App\Constraints as CustomAssert;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\Srn;
use Sugarcrm\IdentityProvider\Authentication\Token\SAML\ResultToken as SAMLResultToken;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Class MainController.
 */
class MainController
{
    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function loginEndPointAction(Application $app, Request $request)
    {
        $providersTitle = [
            AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL => 'Local',
            AuthProviderManagerBuilder::PROVIDER_KEY_LDAP => 'LDAP',
        ];
        $params = [
            'tid' => $request->get('tid'),
            'user_name' => $request->get('user_name'),
            'provider' => $providersTitle[$request->get('provider')],
        ];
        $app->getLogger()->info('Successfully authentication status page render', [
            'params' => $params,
            'tags' => ['IdM.main'],
        ]);
        return $app->getTwigService()->render('main/status.html.twig', $params);
    }

    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function renderFormAction(Application $app, Request $request)
    {
        $token = $app->getRememberMeService()->retrieve();
        $session = $app->getSession();
        if ($token) {
            $session->set(TenantConfigInitializer::SESSION_KEY, $token->getAttribute('tenantSrn'));
            return $this->redirectAuthenticatedUser($app, $token);
        }

        $tenantConfigInitializer = new TenantConfigInitializer($app);
        $params = ['tid' => '', 'user_name' => '', 'show_sso_button' => true, 'ssoLogin' => false];
        if ($tenantConfigInitializer->hasTenant($request)) {

            // handle invalid tenant hint
            try {
                $tenantConfigInitializer->initConfig($request);
            } catch (\RuntimeException $e) {
                $app->getLogger()->debug('Invalid tenant id', [
                    'errors' => $e->getMessage(),
                    'tags' => ['IdM.main'],
                ]);
                return $this->processUnauthenticatedUser($app, $e->getMessage());
            }

            $config = $app->getConfig();

            $tenant = Srn\Converter::fromString($session->get(TenantConfigInitializer::SESSION_KEY));
            $params['tid'] = $tenant->getTenantId();

            // Do not show SSO-login button if SAML is not configured for tenant.
            $params['show_sso_button'] = in_array(Providers::SAML, $config['enabledProviders']);

            if (!empty($config['saml'])) {
                $params['ssoLogin'] = true;
                $params['show_sso_button'] = false;
            }
        }

        if ($request->query->has('login_hint')) {
            $params['user_name'] = $request->query->get('login_hint');
        }

        return $this->renderLoginForm($app, $params);
    }

    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function postFormAction(Application $app, Request $request)
    {
        /** @var Session $sessionService */
        $sessionService = $app->getSession();
        $flashBag = $sessionService->getFlashBag();

        // collect data
        $data = [
            'tid' => $request->get('tid'),
            'user_name' => $request->get('user_name'),
            'password' => $request->get('password'),
            'csrf_token' => $request->get('csrf_token'),
        ];

        $app->getLogger()->debug('Validation form data', [
            'data' => $data,
            'tags' => ['IdM.main'],
        ]);
        $constraint = new Assert\Collection([
            'tid' => [new Assert\NotBlank()],
            'user_name' => [new Assert\NotBlank()],
            'password' => [new Assert\NotBlank()],
            'csrf_token' => [new CustomAssert\Csrf($app->getCsrfTokenManager())],
        ]);
        $violations = $app->getValidatorService()->validate($data, $constraint);
        if (count($violations) > 0) {
            $errors = array_map(function (ConstraintViolation $violation) {
                return $violation->getMessage();
            }, iterator_to_array($violations));
            $app->getLogger()->debug('Invalid form with errors', [
                'errors' => $errors,
                'tags' => ['IdM.main'],
            ]);
            $flashBag->add('error', 'All fields are required');
            return new RedirectResponse($app->getUrlGeneratorService()->generate('loginRender', [
                TenantConfigInitializer::REQUEST_KEY => $data['tid'],
                'login_hint' => $data['user_name'],
            ]));
        }

        try {
            $tenantConfigInitializer = new TenantConfigInitializer($app);
            $tenantConfigInitializer($request);

            $token = $app->getUsernamePasswordTokenFactory(
                $data['user_name'],
                $data['password']
            )->createAuthenticationToken();
            $app->getLogger()->info('Authentication token for user:{user_name} in tenant:{tid}', [
                'user_name' => $token->getUsername(),
                'tid' => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
                'tags' => ['IdM.main'],
            ]);
            $token = $app->getAuthManagerService()->authenticate($token);
        } catch (BadCredentialsException $e) {
            $flashBag->add('error', 'Invalid credentials');

            $app->getLogger()->notice('Bad credentials occurred for user:{user_name} in tenant:{tid}', [
                'user_name' => $token->getUsername(),
                'tid' => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
                'tags' => ['IdM.main'],
            ]);
        } catch (AuthenticationException $e) {
            $flashBag->add('error', $e->getMessage());

            $app->getLogger()->warning('Authentication Exception occurred for user:{user_name} in tenant:{tid}', [
                'user_name' => $token->getUsername(),
                'tid' => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
                'exception' => $e,
                'tags' => ['IdM.main'],
            ]);
        } catch (\InvalidArgumentException $e) {
            $flashBag->add('error', 'Invalid credentials');

            $app->getLogger()->warning('User:{user_name} try login with invalid tenant:{tid}', [
                'user_name' => $data['user_name'],
                'tid' => $data['tid'],
                'exception' => $e,
                'tags' => ['IdM.main'],
            ]);
        } catch (\RuntimeException $e) {
            $flashBag->add('error', 'Invalid credentials');

            $app->getLogger()->warning('User:{user_name} try login with not existing tenant:{tid}', [
                'user_name' => $data['user_name'],
                'tid' => $data['tid'],
                'exception' => $e,
                'tags' => ['IdM.main'],
            ]);
        } catch (\Exception $e) {
            $flashBag->add('error', 'APP ERROR: ' . $e->getMessage());

            $app->getLogger()->error('Exception occurred for user:{user_name} in tenant:{tid}', [
                'user_name' => $data['user_name'],
                'tid' => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
                'exception' => $e,
                'tags' => ['IdM.main'],
            ]);
        }

        if (!empty($token) && $token->isAuthenticated()) {
            $tenant = $sessionService->get(TenantConfigInitializer::SESSION_KEY);
            $tenantSrn = Srn\Converter::fromString($tenant);

            $userIdentity = $token->getUser()->getLocalUser()->getAttribute('id');
            $userSrn = $app->getSrnManager($tenantSrn->getRegion())
                ->createUserSrn($tenantSrn->getTenantId(), $userIdentity);
            $user = Srn\Converter::toString($userSrn);

            $token->setAttribute('srn', $user);
            $token->setAttribute('tenantSrn', $tenant);
            $app->getRememberMeService()->store($token);

            $app->getLogger()->info('Authentication success for {user_name} and {tenant} from {ip}', [
                'user_name' =>  $user,
                'tenant' => $tenant,
                'ip' => $request->getClientIp(),
                'tags' => ['IdM.main'],
            ]);

            return $this->redirectAuthenticatedUser($app, $token);
        }

        return new RedirectResponse($app->getUrlGeneratorService()->generate('loginRender', [
            TenantConfigInitializer::REQUEST_KEY => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
            'login_hint' => $data['user_name'],
        ]));
    }

    /**
     * LogOut action
     * @param Application $app
     * @param Request $request
     * @return RedirectResponse
     */
    public function logoutAction(Application $app, Request $request): RedirectResponse
    {
        $token = $app->getRememberMeService()->retrieve();
        if ($token instanceof SAMLResultToken) {
            $user = $token->getUser();
            $url = $app->getUrlGeneratorService()->generate(
                'samlLogoutInit',
                [
                    'nameId' => $user->getAttribute('identityValue'),
                    'redirect_uri' => $app->getLogoutService()->getRedirectUrl($request),
                    'sessionIndex' => $token->getAttribute('IdPSessionIndex'),
                ]
            );
            return RedirectResponse::create($url);
        }
        return $app->getLogoutService()->logout($request);
    }

    /**
     * Redirect user to consent or landing page
     *
     * @param Application $app
     * @param TokenInterface $token Authenticated result token
     * @return RedirectResponse
     */
    protected function redirectAuthenticatedUser(Application $app, TokenInterface $token): RedirectResponse
    {
        if ($app->getUserPasswordChecker()->isPasswordExpired($token)) {
            return $app->redirect($app->getUrlGeneratorService()->generate('showChangePasswordForm'));
        }

        $sessionService = $app->getSession();

        if ($sessionService->get('consent')) {
            /** @var ConsentToken $consentToken */
            $consentToken = $sessionService->get('consent');
            $consentToken->setTenantSRN($token->getAttribute('tenantSrn'));

            $sessionService->set('authenticatedUser', $token);
            return $app->redirect($app->getUrlGeneratorService()->generate('consentConfirmation'));
        }

        $app->getLogger()->info('Redirect user:{user_name} in tenant:{tid} to route:{route}', [
            'user_name' => $token->getUsername(),
            'tid' => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
            'route' => 'loginEndPoint',
            'tags' => ['IdM.main'],
        ]);
        return RedirectResponse::create($app->getUrlGeneratorService()->generate(
            'loginEndPoint',
            [
                'tid' => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
                'user_name' => $token->getUsername(),
                'provider' => $token->getProviderKey(),
            ]
        ));
    }

    /**
     * Process unauthenticated user
     * @param Application $app
     * @param string $error
     * @return RedirectResponse|string
     */
    protected function processUnauthenticatedUser(Application $app, $error)
    {
        $session = $app->getSession();
        $session->getFlashBag()->add('error', $error);
        if ($session->get('consent')) {
            return $app->redirect($app->getUrlGeneratorService()->generate('consentCancel'));
        }

        return $this->renderLoginForm(
            $app,
            ['tid' => '', 'user_name' => '', 'show_sso_button' => true, 'ssoLogin' => false]
        );
    }

    /**
     * @param Application $app
     * @param array $params
     * @return string
     */
    protected function renderLoginForm(Application $app, array $params = [])
    {
        $app->getLogger()->info('Render login form', [
            'params' => $params,
            'tags' => ['IdM.main'],
        ]);
        $params = array_merge($params, [
            'csrf_token' => $app->getCsrfTokenManager()->getToken(CustomAssert\Csrf::FORM_TOKEN_ID)
        ]);
        return $app->getTwigService()->render('main/login.html.twig', $params);
    }
}
