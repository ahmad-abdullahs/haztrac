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
use Sugarcrm\IdentityProvider\App\Constraints as CustomAssert;
use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\Authentication\UserProvider\LocalUserProvider;
use Sugarcrm\IdentityProvider\Srn;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ChangePasswordController extends SetPasswordController
{
    /**
     * Pre-checks for change password
     * @param Request $request
     * @param Application $app
     * @return RedirectResponse|null
     */
    public function preCheck(Request $request, Application $app):? RedirectResponse
    {
        $token = $app->getRememberMeService()->retrieve();
        if (is_null($token)) {
            $app->getSession()->getFlashBag()->add('error', 'Only authorized users can change password');
            return $app->redirect($app->getUrlGeneratorService()->generate('loginRender'));
        }

        if (!$token instanceof UsernamePasswordToken
            || $token->getProviderKey() != AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL) {
            $app->getSession()->getFlashBag()->add('error', 'Only local users can change password');
            return $app->redirect($app->getUrlGeneratorService()->generate('loginRender'));
        }

        if (!$token->getUser() instanceof User) {
            $app->getSession()->getFlashBag()->add('error', 'No user is found');
            return $app->redirect($app->getUrlGeneratorService()->generate('loginRender'));
        }

        return null;
    }

    /**
     * Show change password form
     * @param Application $app
     * @param Request $request
     * @return string
     */
    public function showChangePasswordForm(Application $app, Request $request): string
    {
        if (!$app->getConfig()['grpc']['disabled']) {
            $app->getRevokeAccessTokensService()->revokeAccessTokens($app->getRememberMeService()->retrieve());
        }
        return $this->renderChangePasswordForm($app);
    }

    /**
     * Change user password
     * @param Application $app
     * @param Request $request
     * @return string
     */
    public function changePasswordAction(Application $app, Request $request): string
    {
        $data = [
            'oldPassword' => $request->get('oldPassword'),
            'newPassword' => $request->get('newPassword'),
            'confirmPassword' => $request->get('confirmPassword'),
            'csrf_token' => $request->get('csrf_token'),
        ];

        $newPasswordConstraints = $this->buildPasswordCheckConstraints($app);
        $newPasswordConstraints[] = new Assert\NotEqualTo([
            'value' => $data['oldPassword'],
            'message' => 'New password must be different from previous password',
        ]);

        $constraint = new Assert\Collection([
            'oldPassword' => [new Assert\NotBlank(['message' => 'Old password is empty'])],
            'newPassword' => $newPasswordConstraints,
            'confirmPassword' => [
                new Assert\NotBlank(['message' => 'Password confirmation is empty']),
                new Assert\EqualTo([
                    'value' => $data['newPassword'],
                    'message' => 'Password and password confirmation don\'t match',
                ]),
            ],
            'csrf_token' => [new CustomAssert\Csrf($app->getCsrfTokenManager())],
        ]);

        $violations = $app->getValidatorService()->validate($data, $constraint);
        if (count($violations)) {
            $errors = array_map(function (ConstraintViolationInterface $violation) {
                return $violation->getMessage();
            }, iterator_to_array($violations));
            $app->getSession()->getFlashBag()->set('error', $errors);
            return $this->renderChangePasswordForm($app);
        }
        /** @var UsernamePasswordToken $token */
        $token = $app->getRememberMeService()->retrieve();
        /** @var User $user */
        $user = $token->getUser();

        $encoder = $app->getEncoderFactory()->getEncoder(User::class);
        if (!$encoder->isPasswordValid($user->getAttribute('password_hash'), $data['oldPassword'], '')) {
            $app->getSession()->getFlashBag()->set('error', 'Old password isn\'t valid');
            return $this->renderChangePasswordForm($app);
        }
        $tenantSrn = Srn\Converter::fromString($token->getAttribute('tenantSrn'));
        $this->updateUserPassword(
            $app,
            $tenantSrn->getTenantId(),
            $user->getAttribute('id'),
            $data['newPassword']
        );

        $this->refreshUser($app, $tenantSrn, $user, $token);
        return $app->getTwigService()->render('password/success.change.html.twig');
    }

    /**
     * Render change password form
     * @param Application $app
     * @return string
     */
    protected function renderChangePasswordForm(Application $app)
    {
        return $app->getTwigService()->render(
            'password/change.html.twig',
            ['csrf_token' => $app->getCsrfTokenManager()->getToken(CustomAssert\Csrf::FORM_TOKEN_ID)]
        );
    }

    /**
     * refresh user in stored token
     * @param Application $app
     * @param Srn\Srn $tenant
     * @param User $user
     * @param UsernamePasswordToken $token
     */
    protected function refreshUser(Application $app, Srn\Srn $tenant, User $user, UsernamePasswordToken $token): void
    {
        $localProvider = new LocalUserProvider($app->getDoctrineService(), $tenant->getTenantId());
        $user = $localProvider->refreshUser($user);
        $token->setUser($user);
        $app->getRememberMeService()->store($token);
    }
}
