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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Controller;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Driver\Statement;

use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Sugarcrm\IdentityProvider\App\Authentication\RevokeAccessTokensService;
use Sugarcrm\IdentityProvider\App\Controller\ChangePasswordController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\Authentication\RememberMe\Service;
use Sugarcrm\IdentityProvider\App\Constraints as CustomAssert;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Controller\ChangePasswordController
 */
class ChangePasswordControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Application
     */
    protected $application;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Request
     */
    protected $request;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Service
     */
    protected $rememberMeService;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | FlashBagInterface
     */
    protected $flashBag;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | UrlGenerator
     */
    protected $urlGenerator;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | \Twig\Environment
     */
    protected $twig;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | CsrfTokenManagerInterface
     */
    protected $csrfManager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | ValidatorInterface
     */
    protected $validator;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | PasswordEncoderInterface
     */
    protected $encoder;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Connection
     */
    protected $db;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | QueryBuilder
     */
    protected $qb;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Statement
     */
    protected $stmt;

    /**
     * @var ChangePasswordController
     */
    protected $controller;

    /**
     * @var array
     */
    private $config = [
        'local' => [
            'password_requirements' => [
                'minimum_length' => 3,
                'maximum_length' => 6,
                'require_upper' => true,
                'require_lower' => true,
                'require_number' => true,
                'require_special' => true,
            ],
        ],
        'grpc' => [
            'disabled' => true,
        ],
    ];

    /**
     * @var RevokeAccessTokensService | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $revokeAccessTokensService;

    protected function setUp()
    {
        $this->application = $this->createMock(Application::class);
        $this->request = $this->createMock(Request::class);

        $this->revokeAccessTokensService = $this->createMock(RevokeAccessTokensService::class);
        $this->application->method('getRevokeAccessTokensService')->willReturn($this->revokeAccessTokensService);

        $this->rememberMeService = $this->createMock(Service::class);
        $this->application->expects($this->any())->method('getRememberMeService')->willReturn($this->rememberMeService);

        $this->flashBag = $this->createMock(FlashBagInterface::class);
        $session = $this->createMock(Session::class);
        $session->expects($this->any())->method('getFlashBag')->willReturn($this->flashBag);
        $this->application->expects($this->any())->method('getSession')->willReturn($session);

        $this->urlGenerator = $this->createMock(UrlGenerator::class);
        $this->application->expects($this->any())->method('getUrlGeneratorService')->willReturn($this->urlGenerator);

        $this->twig = $this->createMock(\Twig\Environment::class);
        $this->application->expects($this->any())->method('getTwigService')->willReturn($this->twig);

        $this->csrfManager = $this->createMock(CsrfTokenManagerInterface::class);
        $this->application->expects($this->any())->method('getCsrfTokenManager')->willReturn($this->csrfManager);

        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->application->expects($this->any())->method('getValidatorService')->willReturn($this->validator);

        $this->encoderFactory = $this->createMock(EncoderFactoryInterface::class);
        $this->encoder = $this->createMock(PasswordEncoderInterface::class);
        $this->application->expects($this->any())->method('getEncoderFactory')->willReturn($this->encoderFactory);

        $this->db = $this->createMock(Connection::class);
        $this->application->expects($this->any())->method('getDoctrineService')->willReturn($this->db);

        $this->qb = $this->createMock(QueryBuilder::class);
        $this->db->expects($this->any())->method('createQueryBuilder')->willReturn($this->qb);

        $this->stmt = $this->createMock(Statement::class);

        $this->controller = new ChangePasswordController();
    }

    /**
     * @covers ::preCheck
     */
    public function testPreCheckWithoutToken()
    {
        $this->rememberMeService->expects($this->once())
            ->method('retrieve')
            ->willReturn(null);
        $this->flashBag->expects($this->once())
            ->method('add')
            ->with('error', 'Only authorized users can change password');

        $this->urlGenerator->expects($this->once())
            ->method('generate')
            ->with('loginRender')
            ->willReturn($url = 'http://login.test.url');
        $this->application->expects($this->once())
            ->method('redirect')
            ->with($url)
            ->willReturn(RedirectResponse::create($url));

        $this->controller->preCheck($this->request, $this->application);
    }

    /**
     * @covers ::preCheck
     */
    public function testPreCheckWrongToken()
    {
        $token = $this->createMock(TokenInterface::class);
        $this->rememberMeService->expects($this->once())
            ->method('retrieve')
            ->willReturn($token);

        $this->flashBag->expects($this->once())
            ->method('add')
            ->with('error', 'Only local users can change password');

        $this->urlGenerator->expects($this->once())
            ->method('generate')
            ->with('loginRender')
            ->willReturn($url = 'http://login.test.url');
        $this->application->expects($this->once())
            ->method('redirect')
            ->with($url)
            ->willReturn(RedirectResponse::create($url));

        $this->controller->preCheck($this->request, $this->application);
    }

    /**
     * @covers ::preCheck
     */
    public function testPreCheckWrongProvider()
    {
        $token = new UsernamePasswordToken('', '', AuthProviderManagerBuilder::PROVIDER_KEY_SAML);
        $this->rememberMeService->expects($this->once())
            ->method('retrieve')
            ->willReturn($token);

        $this->flashBag->expects($this->once())
            ->method('add')
            ->with('error', 'Only local users can change password');

        $this->urlGenerator->expects($this->once())
            ->method('generate')
            ->with('loginRender')
            ->willReturn($url = 'http://login.test.url');
        $this->application->expects($this->once())
            ->method('redirect')
            ->with($url)
            ->willReturn(RedirectResponse::create($url));

        $this->controller->preCheck($this->request, $this->application);
    }

    /**
     * @covers ::preCheck
     */
    public function testPreCheckWrongUser()
    {
        $token = new UsernamePasswordToken('', '', AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL);
        $this->rememberMeService->expects($this->once())
            ->method('retrieve')
            ->willReturn($token);

        $this->flashBag->expects($this->once())
            ->method('add')
            ->with('error', 'No user is found');

        $this->urlGenerator->expects($this->once())
            ->method('generate')
            ->with('loginRender')
            ->willReturn($url = 'http://login.test.url');
        $this->application->expects($this->once())
            ->method('redirect')
            ->with($url)
            ->willReturn(RedirectResponse::create($url));

        $this->controller->preCheck($this->request, $this->application);
    }

    /**
     * @covers ::preCheck
     */
    public function testPreCheck()
    {
        $token = new UsernamePasswordToken(
            new User('test', 'user', []),
            '',
            AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL
        );
        $this->rememberMeService->expects($this->once())
            ->method('retrieve')
            ->willReturn($token);
        $this->assertNull($this->controller->preCheck($this->request, $this->application));
    }

    /**
     * @covers ::showChangePasswordForm
     */
    public function testShowChangePasswordForm()
    {
        $this->application->method('getConfig')
            ->willReturn($this->config);

        $this->csrfManager->expects($this->once())
            ->method('getToken')
            ->with(CustomAssert\Csrf::FORM_TOKEN_ID)
            ->willReturn('secure-token');

        $this->twig->expects($this->once())
            ->method('render')
            ->with('password/change.html.twig', $this->isType('array'))
            ->willReturn('html');
        $this->controller->showChangePasswordForm($this->application, $this->request);
    }

    /**
     * @covers ::showChangePasswordForm
     */
    public function testShowChangePasswordFormWithEnabledGRPC()
    {
        $this->config['grpc']['disabled'] = false;
        $this->application->method('getConfig')
            ->willReturn($this->config);

        $this->twig->method('render')
            ->willReturn('html');

        $token = $this->createMock(TokenInterface::class);
        $this->rememberMeService
            ->expects($this->once())
            ->method('retrieve')
            ->willReturn($token);
        $this->revokeAccessTokensService
            ->expects($this->once())
            ->method('revokeAccessTokens')
            ->with($token);

        $this->controller->showChangePasswordForm($this->application, $this->request);
    }

    /**
     * @covers ::showChangePasswordForm
     */
    public function testShowChangePasswordFormWithDisabledGRPC()
    {
        $this->config['grpc']['disabled'] = true;
        $this->application->method('getConfig')
            ->willReturn($this->config);

        $this->twig->method('render')
            ->willReturn('html');

        $this->rememberMeService
            ->expects($this->never())
            ->method('retrieve');
        $this->revokeAccessTokensService
            ->expects($this->never())
            ->method('revokeAccessTokens');


        $this->controller->showChangePasswordForm($this->application, $this->request);
    }

    /**
     * @covers ::changePasswordAction
     */
    public function testChangePasswordActionWithViolations()
    {
        $this->application->method('getConfig')
            ->willReturn($this->config);
        $violation = $this->createMock(ConstraintViolationInterface::class);
        $violation->expects($this->once())
            ->method('getMessage')
            ->willReturn('error test');

        $this->request->expects($this->exactly(4))
            ->method('get')
            ->withConsecutive(['oldPassword'], ['newPassword'], ['confirmPassword'], ['csrf_token'])
            ->willReturnOnConsecutiveCalls('old-password', 'new-password', 'confirm-password', 'csrf-token');

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($this->isType('array'), $this->isInstanceOf(Assert\Collection::class))
            ->willReturn(new \ArrayObject([$violation]));

        $this->flashBag->expects($this->once())
            ->method('set')
            ->with('error', ['error test']);

        $this->csrfManager->expects($this->once())
            ->method('getToken')
            ->with(CustomAssert\Csrf::FORM_TOKEN_ID)
            ->willReturn('secure-token');

        $this->twig->expects($this->once())
            ->method('render')
            ->with('password/change.html.twig', $this->isType('array'))
            ->willReturn('html');

        $this->controller->changePasswordAction($this->application, $this->request);
    }

    /**
     * @covers ::changePasswordAction
     */
    public function testChangePasswordActionWrongPassword()
    {
        $this->application->method('getConfig')
            ->willReturn($this->config);

        $user = new User('test', 'user', [
            'password_hash' => 'test_password_hash',
        ]);
        $token = new UsernamePasswordToken($user, '', AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL);

        $this->request->expects($this->exactly(4))
            ->method('get')
            ->withConsecutive(['oldPassword'], ['newPassword'], ['confirmPassword'], ['csrf_token'])
            ->willReturnOnConsecutiveCalls('old-password', 'new-password', 'confirm-password', 'csrf-token');

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($this->isType('array'), $this->isInstanceOf(Assert\Collection::class))
            ->willReturn([]);

        $this->rememberMeService->expects($this->once())
            ->method('retrieve')
            ->willReturn($token);

        $this->encoderFactory->expects($this->once())
            ->method('getEncoder')
            ->with(User::class)
            ->willReturn($this->encoder);

        $this->encoder->expects($this->once())
            ->method('isPasswordValid')
            ->with('test_password_hash', 'old-password', '')
            ->willReturn(false);

        $this->flashBag->expects($this->once())
            ->method('set')
            ->with('error', 'Old password isn\'t valid');

        $this->csrfManager->expects($this->once())
            ->method('getToken')
            ->with(CustomAssert\Csrf::FORM_TOKEN_ID)
            ->willReturn('secure-token');

        $this->twig->expects($this->once())
            ->method('render')
            ->with('password/change.html.twig', $this->isType('array'))
            ->willReturn('html');

        $this->controller->changePasswordAction($this->application, $this->request);
    }

    /**
     * @covers ::changePasswordAction
     */
    public function testChangePasswordAction()
    {
        $this->application->method('getConfig')
            ->willReturn($this->config);

        $user = new User('test-user-id', '', [
            'id' => 'test-user-id',
            'password_hash' => 'test_password_hash',
        ]);
        $token = new UsernamePasswordToken($user, '', AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL);
        $token->setAttribute('tenantSrn', 'srn:dev:iam:na:1144464366:tenant');

        $this->request->expects($this->exactly(4))
            ->method('get')
            ->withConsecutive(['oldPassword'], ['newPassword'], ['confirmPassword'], ['csrf_token'])
            ->willReturnOnConsecutiveCalls('old-password', 'new-password', 'confirm-password', 'csrf-token');

        $this->validator->expects($this->once())
            ->method('validate')
            ->with($this->isType('array'), $this->isInstanceOf(Assert\Collection::class))
            ->willReturn([]);

        $this->rememberMeService->expects($this->once())
            ->method('retrieve')
            ->willReturn($token);

        $this->encoderFactory->expects($this->exactly(2))
            ->method('getEncoder')
            ->with(User::class)
            ->willReturn($this->encoder);

        $this->encoder->expects($this->once())
            ->method('isPasswordValid')
            ->with('test_password_hash', 'old-password', '')
            ->willReturn(true);

        $this->encoder->expects($this->once())
            ->method('encodePassword')
            ->with('new-password', '')
            ->willReturn('encoded-new-password');

        $this->db->expects($this->once())
            ->method('update')
            ->with('users', $this->isType('array'), ['tenant_id' => '1144464366', 'id' => 'test-user-id']);

        $this->qb->method('select')->wilLReturnSelf();
        $this->qb->method('from')->wilLReturnSelf();
        $this->qb->method('innerJoin')->wilLReturnSelf();
        $this->qb->method('andWhere')->wilLReturnSelf();
        $this->qb->method('setMaxResults')->wilLReturnSelf();
        $this->qb->method('setParameters')->wilLReturnSelf();

        $this->qb->expects($this->once())
            ->method('execute')
            ->willReturn($this->stmt);

        $this->stmt->expects($this->once())
            ->method('fetch')
            ->willReturn([
                'identity_value' => 'test-user-id',
                'password_hash' => 'encoded-new-password',
                'attributes' => '',
                'custom_attributes' => '',
            ]);

        $this->rememberMeService->expects($this->once())
            ->method('store')
            ->with($token);

        $this->twig->expects($this->once())
            ->method('render')
            ->with('password/success.change.html.twig')
            ->willReturn('html');

        $this->controller->changePasswordAction($this->application, $this->request);
    }
}
