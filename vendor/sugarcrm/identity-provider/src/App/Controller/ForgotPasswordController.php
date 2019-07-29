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

use Sugarcrm\Apis\Iam\User\V1alpha\SendEmailForResetPasswordRequest;

use Sugarcrm\IdentityProvider\Authentication\UserProvider\LocalUserProvider;

use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Constraints as CustomAssert;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\Srn;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Class PasswordController
 * @package Sugarcrm\IdentityProvider\App\Controller
 */
class ForgotPasswordController
{
    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function renderForgotPasswordForm(Application $app, Request $request)
    {
        $params = ['tid' => '', 'user_name' => ''];

        /** @var Session $sessionService */
        $sessionService = $app->getSession();
        $flashBag = $sessionService->getFlashBag();

        try {
            $tenantConfigInitializer = new TenantConfigInitializer($app);
            if ($tenantConfigInitializer->hasTenant($request)) {
                $tenantConfigInitializer->initConfig($request);
                $tenant = Srn\Converter::fromString($app->getSession()->get(TenantConfigInitializer::SESSION_KEY));
                $params['tid'] = $tenant->getTenantId();
            }
        } catch (\RuntimeException $e) {
            $flashBag->add('error', 'Invalid tenant ID');
            $app->getLogger()->info('Forgot Password Form: failed to set tenant ID from session', [
                'exception' => $e,
                'tags' => ['IdM.forgot'],
            ]);
        }

        $app->getLogger()->info('Render forgot password form', [
            'params' => $params,
            'tags' => ['IdM.forgot'],
        ]);
        $params = array_merge($params, [
            'csrf_token' => $app->getCsrfTokenManager()->getToken(CustomAssert\Csrf::FORM_TOKEN_ID)
        ]);
        return $app->getTwigService()->render('password/forgot.html.twig', $params);
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return RedirectResponse
     */
    public function forgotPasswordAction(Application $app, Request $request): RedirectResponse
    {
        /** @var Session $sessionService */
        $sessionService = $app->getSession();
        $flashBag = $sessionService->getFlashBag();
        $config = $app->getConfig();

        // collect data
        $data = [
            'tid' => $request->get('tid'),
            'user_name' => $request->get('user_name'),
            'csrf_token' => $request->get('csrf_token'),
            'recaptcha' => $request->get('g-recaptcha-response'),
            'honeypot' => $request->get($config['honeypot']['name']),
        ];

        $app->getLogger()->debug('Validation of "forgot password" form data', [
            'data' => $data,
            'tags' => ['IdM.forgot'],
        ]);
        $constraint = new Assert\Collection([
            'tid' => [new Assert\NotBlank()],
            'user_name' => [new Assert\NotBlank()],
            'csrf_token' => [new CustomAssert\Csrf($app->getCsrfTokenManager())],
            'recaptcha' => [new CustomAssert\Recaptcha($config['recaptcha']['secretkey'])],
            'honeypot' => [new Assert\Blank()],
        ]);
        $violations = $app->getValidatorService()->validate($data, $constraint);
        if (count($violations) > 0) {
            $errors = array_map(function (ConstraintViolation $violation) {
                return $violation->getMessage();
            }, iterator_to_array($violations));
            $app->getLogger()->debug('Invalid form with errors', [
                'errors' => $errors,
                'tags' => ['IdM.forgot'],
            ]);
            $flashBag->add('error', 'All fields are required');

            return new RedirectResponse($app->getUrlGeneratorService()->generate('forgotPasswordRender'));
        }

        // Do a request for sending password reset email to a service that is responsible for it.
        try {
            $userProviderInfo = $app->getUserProvidersRepository()->findLocalByTenantAndIdentity(
                $data['tid'],
                $data['user_name']
            );

            $srn = $app->getSrnManager($config['idm']['region'])->createUserSrn(
                $userProviderInfo->getTenantId(),
                $userProviderInfo->getUserId()
            );

            $userApi = $app->getGrpcUserApi();
            $sendEmailRequest = new SendEmailForResetPasswordRequest();
            $sendEmailRequest->setName(Srn\Converter::toString($srn));

            $app->getLogger()->info('Sending password-recovery email for {user_name} of tenant {tid}', [
                'user_name' => $data['user_name'],
                'tid' => $data['tid'],
                'tags' => ['IdM.forgot'],
            ]);

            [$response, $status] = $userApi->SendEmailForResetPassword($sendEmailRequest)->wait();
            $sent = $status && $status->code === 0;
            if ($status->code === 2) {
                $app->getLogger()->warning(
                    sprintf(
                        'Wrong answer from IDP API, code: %s, details: %s. Trying refresh access code.',
                        $status->code,
                        $status->details
                    ),
                    ['tags' => ['IdM.forgot', 'IdM.oauth.authentication']]
                );
                $app->getOAuth2Service()->refreshAccessToken();
            }
        } catch (\Exception $e) {
            $sent = false;
            $app->getLogger()->error(
                'Error while sending password-recovery email for {user_name} of tenant {tid}',
                [
                    'user_name' => $data['user_name'],
                    'tid' => $data['tid'],
                    'exception' => $e->getMessage(),
                    'tags' => ['IdM.forgot'],
                ]
            );
        }

        if ($sent) {
            $user = $this->getUserProvider($app, $data['tid'])->loadUserByUsername($data['user_name']);
            return new RedirectResponse(
                $app->getUrlGeneratorService()->generate(
                    'forgotPasswordSuccessSent',
                    [
                        TenantConfigInitializer::REQUEST_KEY => $data['tid'],
                        'sentEmail' => $this->decorateEmail($user->getAttribute('attributes')['email']),
                    ]
                )
            );
        } else {
            $flashBag->add('error', 'Failed to send email for password recovery. Please try again.');
            return new RedirectResponse($app->getUrlGeneratorService()->generate('forgotPasswordRender'));
        }
    }

    /**
     * Decorate email
     * @param string $email
     * @return string
     */
    protected function decorateEmail(string $email): string
    {
        $pos = strpos($email, '@');
        if ($pos !== false) {
            return substr($email, 0, 1) . str_repeat('*', 3) . substr($email, $pos);
        }
        return $email;
    }

    /**
     * Get local user provider
     *
     * @param string $tenantId
     * @return LocalUserProvider
     */
    protected function getUserProvider(Application $app, string $tenantId): LocalUserProvider
    {
        return new LocalUserProvider($app->getDoctrineService(), $tenantId);
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function successSent(Application $app, Request $request): string
    {
        $params = [
            'sentEmail' => $request->get('sentEmail'),
        ];
        return $app->getTwigService()->render('password/success.sent.html.twig', $params);
    }
}
