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

use Grpc\UnaryCall;
use Psr\Log\LoggerInterface;
use Sugarcrm\Apis\Iam\User\V1alpha\SendEmailForResetPasswordRequest;
use Sugarcrm\Apis\Iam\User\V1alpha\UserAPIClient;
use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Authentication\OAuth2Service;
use Sugarcrm\IdentityProvider\App\Controller\ForgotPasswordController;
use Sugarcrm\IdentityProvider\App\Entity\UserProvider;
use Sugarcrm\IdentityProvider\App\Repository\UserProvidersRepository;
use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\Authentication\UserProvider\LocalUserProvider;
use Sugarcrm\IdentityProvider\Srn\Manager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Controller\ForgotPasswordController
 */
class ForgotPasswordControllerTest extends \PHPUnit_Framework_TestCase
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
     * @var Request | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    /**
     * @var ForgotPasswordController
     */
    protected $forgotPasswordController;

    /**
     * @var CsrfTokenManager | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $csrfTokenManager;

    /**
     * @var UserProvidersRepository | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $userProvidersRepository;

    /**
     * @var ValidatorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $validator;

    /**
     * @var UrlGeneratorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $urlGenerator;

    /**
     * @var OAuth2Service | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $oAuth2Service;

    /**
     * @var UserAPIClient | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $grpcUserApi;

    /**
     * @var UnaryCall | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $unaryCall;

    /**
     * @var UserProvider
     */
    protected $userProviderInfo;

    /**
     * @var LocalUserProvider
     */
    protected $localUserProvider;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->twig = $this->createMock(\Twig_Environment::class);

        $this->logger = $this->createMock(LoggerInterface::class);
        $this->flashBag = $this->createMock(FlashBagInterface::class);

        $this->sessionService = $this->createMock(Session::class);
        $this->sessionService->method('getFlashBag')->willReturn($this->flashBag);

        $this->csrfTokenManager = $this->createMock(CsrfTokenManager::class);
        $this->csrfTokenManager->method('getToken')->willReturn('csrfToken');
        $this->csrfTokenManager->method('isTokenValid')->willReturn(true);

        $this->userProvidersRepository = $this->createMock(UserProvidersRepository::class);

        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $this->urlGenerator->expects($this->once())->method('generate')->willReturn('http://test.com');

        $this->oAuth2Service = $this->createMock(OAuth2Service::class);

        $this->grpcUserApi = $this->createMock(UserAPIClient::class);
        $this->unaryCall = $this->createMock(UnaryCall::class);

        $this->application = $this->createPartialMock(
            Application::class,
            [
                'getTwigService',
                'getUserProvidersRepository',
                'getCsrfTokenManager',
                'getSession',
                'getLogger',
                'getValidatorService',
                'getUrlGeneratorService',
                'getOAuth2Service',
                'getGrpcUserApi',
                'getSrnManager',
                'getConfig',
            ]
        );

        $this->application->method('getTwigService')->willReturn($this->twig);
        $this->application->method('getUserProvidersRepository')->willReturn($this->userProvidersRepository);
        $this->application->method('getCsrfTokenManager')->willReturn($this->csrfTokenManager);
        $this->application->method('getSession')->willReturn($this->sessionService);
        $this->application->method('getLogger')->willReturn($this->logger);
        $this->application->method('getValidatorService')->willReturn($this->validator);
        $this->application->method('getUrlGeneratorService')->willReturn($this->urlGenerator);
        $this->application->method('getOAuth2Service')->willReturn($this->oAuth2Service);
        $this->application->method('getGrpcUserApi')->willReturn($this->grpcUserApi);
        $this->application->method('getSrnManager')->willReturn(new Manager(['partition' => 'dev']));
        $this->application->method('getConfig')->willReturn([
            'honeypot' => [
                'name' => 'first_name',
            ],
            'recaptcha' => [
                'secretkey' => '1111',
            ],
            'idm' => [
                'region' => 'region',
            ],
        ]);

        $this->request = $this->createMock(Request::class);

        $this->request->method('get')->willReturnMap([
            ['tid', null, '0000000001'],
            ['user_name', null, 'username'],
            ['csrf_token', null, 'csrfToken'],
        ]);

        $this->userProviderInfo = UserProvider::fromArray([
            'tenant_id' => '0000000001',
            'user_id' => 'userId',
            'provider_code' => 'local',
            'identity_value' => 'username',
        ]);

        $this->localUserProvider = $this->createMock(LocalUserProvider::class);

        $this->forgotPasswordController = $this->getMockBuilder(ForgotPasswordController::class)
            ->setMethods(['getUserProvider'])
            ->getMock();
        $this->forgotPasswordController->method('getUserProvider')
            ->willReturn($this->localUserProvider);
    }

    /**
     * @covers ::forgotPasswordAction
     */
    public function testForgotPasswordActionTestUserProviderNotFound(): void
    {
        $this->userProvidersRepository->expects($this->once())
            ->method('findLocalByTenantAndIdentity')
            ->with('0000000001', 'username')
            ->willThrowException(new \RuntimeException());

        $this->validator->method('validate')->willReturn([]);

        $this->flashBag->expects($this->once())->method('add')->with('error', $this->anything());

        $this->forgotPasswordController->forgotPasswordAction($this->application, $this->request);
    }

    /**
     * @covers ::forgotPasswordAction
     */
    public function testForgotPasswordActionTestEmailSendError(): void
    {
        $this->userProvidersRepository->expects($this->once())
            ->method('findLocalByTenantAndIdentity')
            ->with('0000000001', 'username')
            ->willReturn($this->userProviderInfo);

        $this->validator->method('validate')->willReturn([]);

        $status = new \stdClass();
        $status->code = 2;
        $status->details = "Invalid token";
        $this->grpcUserApi->expects($this->once())
            ->method('SendEmailForResetPassword')
            ->willReturn($this->unaryCall);

        $this->unaryCall->method('wait')->willReturn([null, $status]);

        $this->oAuth2Service->expects($this->once())
            ->method('refreshAccessToken')
            ->willReturn(true);

        $this->flashBag->expects($this->once())->method('add')->with('error', $this->anything());

        $this->forgotPasswordController->forgotPasswordAction($this->application, $this->request);
    }

    /**
     * @covers ::forgotPasswordAction
     */
    public function testForgotPasswordActionTestEmailSendSuccess(): void
    {
        $this->userProvidersRepository->expects($this->once())
            ->method('findLocalByTenantAndIdentity')
            ->with('0000000001', 'username')
            ->willReturn($this->userProviderInfo);

        $this->validator->method('validate')->willReturn([]);

        $status = new \stdClass();
        $status->code = 0;
        $this->grpcUserApi->expects($this->once())
            ->method('SendEmailForResetPassword')
            ->willReturnCallback(function (SendEmailForResetPasswordRequest $sendEmailRequest) {
                $this->assertEquals('srn:dev:iam::0000000001:user:userId', $sendEmailRequest->getName());
                return $this->unaryCall;
            });

        $this->unaryCall->method('wait')->willReturn([null, $status]);

        $user = $this->createMock(User::class);
        $user->method('getAttribute')
            ->willReturn(['email' => 'test@example.com']);
        $this->localUserProvider->expects($this->once())
            ->method('loadUserByUsername')
            ->willReturn($user);

        $this->flashBag->expects($this->never())->method('add');

        $this->forgotPasswordController->forgotPasswordAction($this->application, $this->request);
    }
}
