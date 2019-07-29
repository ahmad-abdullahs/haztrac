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

use Sugarcrm\Apis\Iam\App\V1alpha as AppApi;
use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentToken;
use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentTokenInterface;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\App\Repository\Exception\ConsentNotFoundException;
use Sugarcrm\IdentityProvider\Authentication\Consent\ConsentChecker;
use Sugarcrm\IdentityProvider\Authentication\Tenant;
use Sugarcrm\IdentityProvider\Srn;

use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Authentication\JoseService;
use Sugarcrm\IdentityProvider\App\Authentication\OAuth2Service;

use Sugarcrm\IdentityProvider\Srn\Converter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class ConsentController
 * @package Sugarcrm\IdentityProvider\App\Controller
 */
class ConsentController
{
    /**
     * @var JoseService
     */
    protected $joseService;

    /**
     * @var OAuth2Service
     */
    protected $oAuth2Service;

    /**
     * @var Session
     */
    protected $sessionService;

    /**
     * ConsentController constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->joseService = $app['JoseService'];
        $this->oAuth2Service = $app['oAuth2Service'];
        $this->sessionService = $app['session'];
    }

    /**
     * Init consent flow
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function consentInitAction(Application $app, Request $request)
    {
        if (!$request->query->has('consent')) {
            throw new BadRequestHttpException('Consent not found', null, 400);
        }

        $consentToken = $app->getConsentRestService()->getToken($request->query->get('consent'));
        $tenantSrn = $consentToken->getTenantSRN();
        if ($tenantSrn) {
            if (preg_match(Srn\SrnRules::TENANT_REGEX, $tenantSrn)) {
                $storedTenant = $app->getTenantRepository()->findTenantById($tenantSrn);
                $tenantSrn = Srn\Converter::toString(
                    $app->getSrnManager($storedTenant->getRegion())->createTenantSrn($tenantSrn)
                );
                $consentToken->setTenantSRN($tenantSrn);
            }
            $this->sessionService->set(TenantConfigInitializer::SESSION_KEY, $tenantSrn);
        }
        $params = [];
        if ($consentToken->getUsername()) {
            $params['login_hint'] = $consentToken->getUsername();
        }
        $this->sessionService->set('consent', $consentToken);
        return $app->redirect($app->getUrlGeneratorService()->generate('loginRender', $params));
    }

    /**
     * consent confirmation action
     * @param Application $app
     * @param Request $request
     * @throws AuthenticationCredentialsNotFoundException
     * @throws \Twig_Error_Loader  When the template cannot be found
     * @throws \Twig_Error_Syntax  When an error occurred during compilation
     * @throws \Twig_Error_Runtime When an error occurred during rendering
     * @return string
     */
    public function consentConfirmationAction(Application $app, Request $request)
    {
        /** @var ConsentToken $consentToken */
        $consentToken = $this->sessionService->get('consent');

        if (is_null($consentToken)) {
            throw new AuthenticationCredentialsNotFoundException('Consent session not found');
        }
        $consentChecker = $this->getConsentChecker($app, $consentToken);
        if (!$consentChecker || !$consentChecker->check()) {
            return $app->getTwigService()->render('consent/app_consent_restricted.html.twig');
        }

        /** @var UsernamePasswordToken $userToken */
        $userToken = $this->sessionService->get('authenticatedUser');

        if ($app->getUserPasswordChecker()->isPasswordExpired($userToken)) {
            return $app->redirect($app->getUrlGeneratorService()->generate('showChangePasswordForm'));
        }

        $clientId = $consentToken->getClientId();
        if ($this->isConsentAutomaticallyApproved($clientId)) {
            $app->getLogger()->info(
                'Automatically approved consent',
                [
                    'tenant' => $consentToken->getTenantSRN(),
                    'client' => $clientId,
                    'user_name' => $userToken->getUser()->getUsername(),
                    'scopes' => $consentToken->getScopes(),
                    'tags' => ['IdM.consent'],
                ]
            );
            return $this->consentFinishAction($app, $request);
        }
        $clientName = $clientId;
        $clientApp = $this->getClientApp($app, $clientId);
        if ($clientApp && !empty($clientApp->getClientName())) {
            $clientName = $clientApp->getClientName();
        }
        return $app->getTwigService()->render('consent/confirmation.html.twig', [
            'are_scopes_empty' => $consentChecker->areScopesEmpty(),
            'scopes' =>  $app->getConsentRestService()->mapScopes($consentToken->getScopes()),
            'client' => $clientName,
            'tenant' => $this->sessionService->get(TenantConfigInitializer::SESSION_KEY),
        ]);
    }

    /**
     * get client application info from APP API
     * @param Application $app
     * @param $appId
     * @return null|AppApi\App
     */
    protected function getClientApp(Application $app, $appId): ?AppApi\App
    {
        if ($app->getConfig()['grpc']['disabled']) {
            return null;
        }
        $grpcAppApi = $app->getGrpcAppApi();
        $grpcGetAppRequest = new AppApi\GetAppRequest();
        $grpcGetAppRequest->setName($appId);
        [$clientApp, $status] = $grpcAppApi->GetApp($grpcGetAppRequest)->wait();
        if ($status && $status->code === \Grpc\CALL_OK) {
            $app->getLogger()->info(sprintf('Application %s information is received.', $appId), ['consent', 'app-api']);
            return $clientApp;
        }
        $app->getLogger()->warning('Invalid app-api response GetApp', ['consent', 'app-api']);
        return null;
    }

    /**
     * Check application type is consent automatically approved
     *
     * @param string $clientId
     * @return bool
     */
    private function isConsentAutomaticallyApproved(string $clientId): bool
    {
        try {
            $srn = Converter::fromString($clientId);
        } catch (\InvalidArgumentException $e) {
            return false;
        }
        return Srn\Manager::isWeb($srn) || Srn\Manager::isCrm($srn);
    }

    /**
     * return filled consent checker
     * @param Application $app
     * @param ConsentTokenInterface $token
     * @return ConsentChecker|null
     */
    protected function getConsentChecker(Application $app, ConsentTokenInterface $token): ?ConsentChecker
    {
        $tenant = Tenant::fromSrn(Converter::fromString($token->getTenantSRN()));
        try {
            $consent = $app->getConsentRepository()->findConsentByClientIdAndTenantId(
                $token->getClientId(),
                $tenant->getId()
            );

            return new ConsentChecker($consent, $token);
        } catch (ConsentNotFoundException $e) {
            return null;
        }
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return RedirectResponse|string
     */
    public function consentFinishAction(Application $app, Request $request)
    {
        /** @var ConsentToken $consentToken */
        $consentToken = $this->getConsent();

        /** @var UsernamePasswordToken $userToken */
        $userToken = $this->getUserToken();

        $consentChecker = $this->getConsentChecker($app, $consentToken);
        if (!$consentChecker || !$consentChecker->check()) {
            return $app->getTwigService()->render('consent/app_consent_restricted.html.twig');
        }

        if ($app->getUserPasswordChecker()->isPasswordExpired($userToken)) {
            $this->sessionService->set(TenantConfigInitializer::SESSION_KEY, $consentToken->getTenantSRN());
            return $app->redirect($app->getUrlGeneratorService()->generate('showChangePasswordForm'));
        }

        $this->oAuth2Service->acceptConsentRequest($consentToken, $userToken);
        return $app->redirect($consentToken->getRedirectUrl());
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function consentCancelAction(Application $app, Request $request)
    {
        $errors = $this->sessionService->getFlashBag()->get('error', ['No consent']);

        /** @var ConsentToken $consentToken */
        $consentToken = $this->getConsent();

        $this->oAuth2Service->rejectConsentRequest($consentToken->getRequestId(), implode(', ', $errors));
        return $app->redirect($consentToken->getRedirectUrl());
    }

    /**
     * Return session consent token and clear session
     * @throws AuthenticationCredentialsNotFoundException
     * @return ConsentToken
     */
    protected function getConsent()
    {
        /** @var ConsentToken $consentToken */
        $consentToken = $this->sessionService->get('consent');

        $this->sessionService->remove(TenantConfigInitializer::SESSION_KEY);
        $this->sessionService->remove('consent');

        if (is_null($consentToken)) {
            throw new AuthenticationCredentialsNotFoundException('Consent session not found');
        }

        return $consentToken;
    }

    /**
     * Return session authenticated user and clear session
     * @throws AuthenticationCredentialsNotFoundException
     * @return UsernamePasswordToken
     */
    protected function getUserToken()
    {
        /** @var UsernamePasswordToken $userToken */
        $userToken = $this->sessionService->get('authenticatedUser');

        $this->sessionService->remove('authenticatedUser');

        if (is_null($userToken)) {
            throw new AuthenticationCredentialsNotFoundException('User is not authenticated');
        }
        return $userToken;
    }
}
