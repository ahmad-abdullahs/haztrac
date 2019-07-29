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
use Psr\Log\LoggerInterface;
use Silex\Provider\ValidatorServiceProvider;
use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Controller\SetPasswordController;
use Sugarcrm\IdentityProvider\App\Repository\OneTimeTokenRepository;
use Sugarcrm\IdentityProvider\Authentication\OneTimeToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Translation\Translator;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Controller\SetPasswordController
 */
class SetPasswordControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $application;

    /**
     * @var \Twig_Environment | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $twig;

    /**
     * @var Request | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    /**
     * @var SetPasswordController
     */
    protected $setPasswordController;

    /**
     * @var OneTimeTokenRepository | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $oneTimeTokenRepository;

    /**
     * @var OneTimeToken | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $oneTimeToken;

    /**
     * @var CsrfTokenManager | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $csrfTokenManager;

    /**
     * @var FlashBagInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $flashBag;

    /**
     * @var Session | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $sessionService;

    /**
     * @var LoggerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $logger;

    /**
     * @var EncoderFactory | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $encoderFactory;

    /**
     * @var PasswordEncoderInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $encoder;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var Connection | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $db;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->encoderFactory = $this->createMock(EncoderFactory::class);
        $this->encoder = $this->createMock(PasswordEncoderInterface::class);
        $this->encoderFactory->method('getEncoder')->willReturn($this->encoder);

        $this->db = $this->createMock(Connection::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->flashBag = $this->createMock(FlashBagInterface::class);

        $this->sessionService = $this->createMock(Session::class);
        $this->sessionService->method('getFlashBag')->willReturn($this->flashBag);

        $this->oneTimeToken = $this->createMock(OneTimeToken::class);

        $this->csrfTokenManager = $this->createMock(CsrfTokenManager::class);
        $this->csrfTokenManager->method('getToken')->willReturn('csrfToken');
        $this->csrfTokenManager->method('isTokenValid')->willReturn(true);

        $this->oneTimeTokenRepository = $this->createMock(OneTimeTokenRepository::class);
        $this->twig = $this->createMock(\Twig_Environment::class);

        $this->translator = new Translator('en');

        $this->application = $this->createPartialMock(
            Application::class,
            [
                'getTwigService',
                'getOneTimeTokenRepository',
                'getCsrfTokenManager',
                'getSession',
                'getConfig',
                'getLogger',
                'getEncoderFactory',
                'getDoctrineService',
                'getTranslator'
            ]
        );

        $this->application->register(new ValidatorServiceProvider());

        $this->application->method('getTwigService')->willReturn($this->twig);
        $this->application->method('getOneTimeTokenRepository')->willReturn($this->oneTimeTokenRepository);
        $this->application->method('getCsrfTokenManager')->willReturn($this->csrfTokenManager);
        $this->application->method('getSession')->willReturn($this->sessionService);
        $this->application->method('getLogger')->willReturn($this->logger);
        $this->application->method('getEncoderFactory')->willReturn($this->encoderFactory);
        $this->application->method('getDoctrineService')->willReturn($this->db);
        $this->application->method('getTranslator')->willReturn($this->translator);

        $this->application->method('getConfig')->willReturn(
            [
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
            ]
        );

        $this->request = $this->createMock(Request::class);

        $this->setPasswordController = new SetPasswordController();
    }

    /**
     * @covers ::showSetPasswordForm
     *
     * @expectedException Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testShowSetPasswordFormTokenNotFoundInRequest(): void
    {
        $this->request->expects($this->once())->method('get')->with('token')->willReturn(null);

        $this->setPasswordController->showSetPasswordForm($this->application, $this->request);
    }

    /**
     * @covers ::showSetPasswordForm
     *
     * @expectedException Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testShowSetPasswordFormTokenNotFoundInDatabase(): void
    {
        $this->request->method('get')->willReturnMap([
            ['token', null, 'token'],
            ['tid', null, '0000000001'],
        ]);

        $this->oneTimeTokenRepository->expects($this->once())
            ->method('findUserByTokenAndTenant')
            ->with('token', '0000000001')
            ->willThrowException(new \RuntimeException());

        $this->setPasswordController->showSetPasswordForm($this->application, $this->request);
    }

    /**
     * @covers ::showSetPasswordForm
     */
    public function testShowSetPasswordForm(): void
    {
        $this->request->method('get')->willReturnMap([
            ['token', null, 'token'],
            ['tid', null, '0000000001'],
        ]);

        $this->oneTimeTokenRepository->expects($this->once())
            ->method('findUserByTokenAndTenant')
            ->with('token', '0000000001')
            ->willReturn($this->oneTimeToken);

        $this->twig->expects($this->once())
            ->method('render')
            ->with('password/set.html.twig', [
                    'tid' => '0000000001',
                    'token' => 'token',
                    'csrf_token' => 'csrfToken',
                ])->willReturn('template');

        $this->setPasswordController->showSetPasswordForm($this->application, $this->request);
    }

    /**
     * @covers ::setPassword
     *
     * @expectedException Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testSetPasswordTokenNotFoundInRequest(): void
    {
        $this->request->expects($this->once())->method('get')->with('token')->willReturn(null);

        $this->setPasswordController->setPassword($this->application, $this->request);
    }

    /**
     * Provides data for testSetPasswordInvalidInput
     *
     * @return array
     */
    public function setPasswordInvalidInputProvider(): array
    {
        return [
            'emptyPassword' => [
                'request' => [
                    ['token', null, 'token'],
                    ['tid', null, '0000000001'],
                    ['newPassword', null, ''],
                    ['confirmPassword', null, '1234'],
                    ['csrf_token', null, 'csrfToken'],
                ],
                'error' => 'Password is empty',
            ],
            'passwordTooShort' => [
                'request' => [
                    ['token', null, 'token'],
                    ['tid', null, '0000000001'],
                    ['newPassword', null, '1'],
                    ['confirmPassword', null, '1'],
                    ['csrf_token', null, 'csrfToken'],
                ],
                'error' => 'Password is too short. It should have 3 characters or more.',
            ],
            'passwordTooLong' => [
                'request' => [
                    ['token', null, 'token'],
                    ['tid', null, '0000000001'],
                    ['newPassword', null, '111111111111111111'],
                    ['confirmPassword', null, '111111111111111111'],
                    ['csrf_token', null, 'csrfToken'],
                ],
                'error' => 'Password is too long. It should have 6 characters or less.',
            ],
            'passwordHaveNoUpper' => [
                'request' => [
                    ['token', null, 'token'],
                    ['tid', null, '0000000001'],
                    ['newPassword', null, '1a3!5'],
                    ['confirmPassword', null, '1a3!5'],
                    ['csrf_token', null, 'csrfToken'],
                ],
                'error' => 'Password should contains at least one upper-case letter',
            ],
            'passwordHaveNoLower' => [
                'request' => [
                    ['token', null, 'token'],
                    ['tid', null, '0000000001'],
                    ['newPassword', null, '1A3!5'],
                    ['confirmPassword', null, '1A3!5'],
                    ['csrf_token', null, 'csrfToken'],
                ],
                'error' => 'Password should contains at least one lower-case letter',
            ],
            'passwordHaveNoNumber' => [
                'request' => [
                    ['token', null, 'token'],
                    ['tid', null, '0000000001'],
                    ['newPassword', null, 'aAc!b'],
                    ['confirmPassword', null, 'aAc!b'],
                    ['csrf_token', null, 'csrfToken'],
                ],
                'error' => 'Password should contains at least one number',
            ],
            'passwordHaveNoSpecial' => [
                'request' => [
                    ['token', null, 'token'],
                    ['tid', null, '0000000001'],
                    ['newPassword', null, 'aAcdb1'],
                    ['confirmPassword', null, 'aAcdb1'],
                    ['csrf_token', null, 'csrfToken'],
                ],
                'error' => 'Password should contains at least one special character "|}{~!@#$%^&*()_+=-"',
            ],
            'passwordAndConfirmDonNotMatch' => [
                'request' => [
                    ['token', null, 'token'],
                    ['tid', null, '0000000001'],
                    ['newPassword', null, 'aAc!b1'],
                    ['confirmPassword', null, 'aAc!b11'],
                    ['csrf_token', null, 'csrfToken'],
                ],
                'error' => 'Password and password confirmation don\'t match',
            ],
        ];
    }

    /**
     * @param array $request
     * @param string $error
     *
     * @covers ::setPassword
     *
     * @dataProvider setPasswordInvalidInputProvider
     *
     * @throws \Throwable
     */
    public function testSetPasswordInvalidInput(array $request, string $error): void
    {
        $this->request->method('get')->willReturnMap($request);

        $this->twig->expects($this->once())
            ->method('render')
            ->with('password/set.html.twig', [
                'tid' => '0000000001',
                'token' => 'token',
                'csrf_token' => 'csrfToken',
            ])->willReturn('template');

        $this->flashBag->expects($this->once())
            ->method('add')
            ->with('error', $error);

        $this->setPasswordController->setPassword($this->application, $this->request);
    }

    /**
     * @covers ::setPassword
     *
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testSetPasswordTokenNotFoundInDatabase(): void
    {
        $this->request->method('get')->willReturnMap([
            ['token', null, 'token'],
            ['tid', null, '0000000001'],
            ['newPassword', null, 'aAc!b1'],
            ['confirmPassword', null, 'aAc!b1'],
            ['csrf_token', null, 'csrfToken'],
        ]);

        $this->oneTimeTokenRepository->expects($this->once())
            ->method('findUserByTokenAndTenant')
            ->with('token', '0000000001')
            ->willThrowException(new \RuntimeException());

        $this->setPasswordController->setPassword($this->application, $this->request);
    }

    /**
     * @covers ::setPassword
     */
    public function testSetPassword(): void
    {
        $this->request->method('get')->willReturnMap([
            ['token', null, 'token'],
            ['tid', null, '0000000001'],
            ['newPassword', null, 'aAc!b1'],
            ['confirmPassword', null, 'aAc!b1'],
            ['csrf_token', null, 'csrfToken'],
        ]);
        $this->oneTimeToken->method('getUserId')->willReturn('userId');
        $this->oneTimeToken->expects($this->once())->method('getTenantId')->willReturn('0000000001');

        $this->oneTimeTokenRepository->expects($this->once())
            ->method('findUserByTokenAndTenant')
            ->with('token', '0000000001')
            ->willReturn($this->oneTimeToken);

        $this->encoder->expects($this->once())
            ->method('encodePassword')
            ->with('aAc!b1', '')
            ->willReturn('encodedPassword');

        $this->db->expects($this->once())->method('update')->with(
            $this->equalTo('users'),
            $this->callback(function ($data) {
                $this->assertEquals('encodedPassword', $data['password_hash']);
                return true;
            }),
            $this->equalTo(['tenant_id'=> '0000000001', 'id' => 'userId'])
        );

        $this->oneTimeTokenRepository->expects($this->once())->method('delete')->with($this->oneTimeToken);

        $this->twig->expects($this->once())
            ->method('render')
            ->with('password/success.html.twig', [])
            ->willReturn('template');

        $this->setPasswordController->setPassword($this->application, $this->request);
    }
}
