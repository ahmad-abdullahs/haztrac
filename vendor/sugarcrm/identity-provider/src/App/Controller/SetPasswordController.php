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
use Sugarcrm\IdentityProvider\App\Constraints as CustomAssert;
use Sugarcrm\IdentityProvider\Authentication\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Class SetPasswordController
 * @package Sugarcrm\IdentityProvider\App\Controller
 */
class SetPasswordController
{
    /**
     * Special char list
     */
    const SPECIAL_CHARS = '|}{~!@#$%^&*()_+=-';

    /**
     * @param Application $app
     * @param Request $request
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function showSetPasswordForm(Application $app, Request $request): string
    {
        $token = $request->get('token');
        if (!$token) {
            throw new BadRequestHttpException('Required parameters missing', null, 400);
        }

        $oneTimeTokenRepository =  $app->getOneTimeTokenRepository();
        try {
            $oneTimeTokenRepository->findUserByTokenAndTenant($token, $request->get('tid'));
        } catch (\RuntimeException $e) {
            throw new BadRequestHttpException('Invalid parameters', null, 400);
        }
        return $this->renderSetPasswordForm($app, $request);
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function buildPasswordCheckConstraints(Application $app): array
    {
        $translator = $app->getTranslator();
        $constraints = [
            new Assert\NotBlank(['message' => $translator->trans('Password is empty')]),
        ];
        $config = $app->getConfig();
        $passwordSettings = $config['local']['password_requirements'];
        $minMax = array_filter(
            [
                'min' => $passwordSettings['minimum_length'],
                'max' => $passwordSettings['maximum_length'],
                'minMessage' => $translator->trans(
                    'Password is too short. It should have {{ limit }} characters or more.'
                ),
                'maxMessage' => $translator->trans(
                    'Password is too long. It should have {{ limit }} characters or less.'
                ),
            ]
        );
        if (!empty($minMax['min']) || !empty($minMax['max'])) {
            $constraints[] = new Assert\Length($minMax);
        }

        if ($passwordSettings['require_upper']) {
            $constraints[] = new Assert\Regex([
                'pattern' => '/[A-Z]+/',
                'message' => $translator->trans('Password should contains at least one upper-case letter'),
            ]);
        }

        if ($passwordSettings['require_lower']) {
            $constraints[] = new Assert\Regex([
                'pattern' => '/[a-z]+/',
                'message' => $translator->trans('Password should contains at least one lower-case letter'),
            ]);
        }

        if ($passwordSettings['require_number']) {
            $constraints[] = new Assert\Regex([
                'pattern' => '/\d+/',
                'message' => $translator->trans('Password should contains at least one number'),
            ]);
        }

        if ($passwordSettings['require_special']) {
            $constraints[] = new Assert\Regex([
                'pattern' => '/[' . preg_quote(self::SPECIAL_CHARS) . ']+/',
                'message' => $translator->trans(
                    'Password should contains at least one special character'
                ) . ' "' . self::SPECIAL_CHARS . '"',
            ]);
        }

        return $constraints;
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return string
     * @throws \Throwable
     */
    public function setPassword(Application $app, Request $request): string
    {
        $translator = $app->getTranslator();
        $token = $request->get('token');
        if (!$token) {
            throw new BadRequestHttpException('Required parameters missing', null, 400);
        }

        /** @var Session $sessionService */
        $sessionService = $app->getSession();
        $flashBag = $sessionService->getFlashBag();

        $data = [
            'tid' => $request->get('tid'),
            'token' => $token,
            'newPassword' => $request->get('newPassword'),
            'confirmPassword' => $request->get('confirmPassword'),
            'csrf_token' => $request->get('csrf_token'),
        ];

        $constraint = new Assert\Collection([
            'tid' => [new Assert\NotBlank()],
            'token' => [new Assert\NotBlank()],
            'newPassword' => $this->buildPasswordCheckConstraints($app),
            'confirmPassword' => [
                new Assert\NotBlank(['message' => $translator->trans('Password confirmation is empty')]),
                new Assert\EqualTo([
                    'value' => $data['newPassword'],
                    'message' => $translator->trans('Password and password confirmation don\'t match'),
                ]),
            ],
            'csrf_token' => [new CustomAssert\Csrf($app->getCsrfTokenManager())],
        ]);

        $violations = $app->getValidatorService()->validate($data, $constraint);
        if (\count($violations) > 0) {
            $errors = array_map(
                function (ConstraintViolation $violation) {
                    return $violation->getMessage();
                },
                iterator_to_array($violations)
            );
            $app->getLogger()->debug(
                'Invalid form with errors',
                [
                    'errors' => $errors,
                    'tags' => ['IdM.password'],
                ]
            );
            $flashBag->add('error', $errors[0]);
            return $this->showSetPasswordForm($app, $request);
        }

        $tid = $request->get('tid');

        $oneTimeTokenRepository =  $app->getOneTimeTokenRepository();
        try {
            $oneTimeToken = $oneTimeTokenRepository->findUserByTokenAndTenant($token, $tid);
        } catch (\RuntimeException $e) {
            throw new BadRequestHttpException('Invalid parameters', null, 400);
        }

        $this->updateUserPassword($app, $oneTimeToken->getTenantId(), $oneTimeToken->getUserId(), $data['newPassword']);
        $oneTimeTokenRepository->delete($oneTimeToken);

        return $app->getTwigService()->render('password/success.html.twig', []);
    }

    /**
     * update user password hash in DB
     * @param Application $app
     * @param string $id
     * @param string $tenantId
     * @param string $password
     */
    protected function updateUserPassword(Application $app, $tenantId, $id, $password): void
    {
        $password = $app->getEncoderFactory()->getEncoder(User::class)->encodePassword($password, '');
        $app->getDoctrineService()->update(
            'users',
            [
                'password_hash' => $password,
                'password_last_changed' => (new \DateTime())->format('Y-m-d H:i:s'),
                'login_attempts' => 0,
            ],
            ['tenant_id' => $tenantId, 'id' => $id]
        );
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    protected function renderSetPasswordForm(Application $app, Request $request): string
    {
        return $app->getTwigService()->render(
            'password/set.html.twig',
            [
                'tid' => $request->get('tid'),
                'token' => $request->get('token'),
                'csrf_token' => $app->getCsrfTokenManager()->getToken(CustomAssert\Csrf::FORM_TOKEN_ID),
            ]
        );
    }
}
