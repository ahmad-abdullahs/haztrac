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

use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\App\Repository\Exception\ConsentNotFoundException;
use Sugarcrm\IdentityProvider\App\Repository\TenantRepository;
use Sugarcrm\IdentityProvider\Authentication\Tenant;
use Sugarcrm\IdentityProvider\Srn;

use Sugarcrm\Apis\Iam\App\V1alpha as AppApi;

use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentRestService;
use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentToken;
use Sugarcrm\IdentityProvider\App\Repository\ConsentRepository;
use Sugarcrm\IdentityProvider\Authentication\Consent;
use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\Tests\IDMFixturesHelper;
use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Authentication\JoseService;
use Sugarcrm\IdentityProvider\App\Authentication\OAuth2Service;
use Sugarcrm\IdentityProvider\App\Controller\ConsentController;
use Sugarcrm\IdentityProvider\App\User\PasswordChecker;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Controller\ConsentController
 */
class ConsentControllerTest extends \PHPUnit_Framework_TestCase
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
     * @var ConsentRepository | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $consentRepository;

    /**
     * @var TenantRepository | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $tenantRepository;

    /**
     * @var Consent
     */
    protected $consent;

    /**
     * @var OAuth2Service | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $oAuth2Service;

    /**
     * @var JoseService | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $joseService;

    /**
     * @var ParserInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $consentRequestParser;

    /**
     * @var ParserFactory | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $consentRequestParserFactory;

    /**
     * @var Session | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $sessionService;

    /**
     * @var Request | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    /**
     * @var RequestInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $oAuth2Request;

    /**
     * @var ConsentController | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $consentController;

    /**
     * @var string
     */
    protected $challenge;

    /**
     * @var string
     */
    protected $invalidChallenge;

    /**
     * @var TokenInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $userToken;

    /**
     * @var ConsentRestService | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $consentRestService;

    /**
     * @var ConsentToken | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $consentToken;

    /**
     * @var ParameterBag | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestQueryBug;

    /**
     * @var Srn\Manager | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $srnManager;

    /**
     * @var array
     */
    protected $publicKey = [
        'use' => 'sig',
        'kty' => 'RSA',
        'kid' => 'public',
        'n' => 'pdtMaSmWnAYx8rXUssH0Aa',
        'e' => 'AQAB',
    ];

    /**
     * @var array
     */
    protected $privateKey = [
        'use' => 'sig',
        'kty' => 'RSA',
        'kid' => 'private',
        'n' => 'pdtMaSmWnAYx8rXUssH0Aa',
        'e' => 'AQAB',
    ];

    /**
     * @var LoggerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $logger;

    /**
     * @var AppApi\AppAPIClient | \PHPUnit_Framework_MockObject_MockObject
     */
    private $grpcAppApi;

    /**
     * @var UnaryCall | \PHPUnit_Framework_MockObject_MockObject
     */
    private $unaryCall;

    /**
     * @var UnaryCall | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $apiApp;

    /**
     * @var PasswordChecker | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $passwordChecker;

    /**
     * @var UrlGenerator | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $urlGenerator;

    /**
     * @var FlashBagInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $flashBag;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->application = $this->createMock(Application::class);

        $this->grpcAppApi = $this->createMock(AppApi\AppAPIClient::class);
        $this->unaryCall = $this->createMock(UnaryCall::class);
        $this->apiApp = $this->createMock(AppApi\App::class);

        $this->logger = $this->createMock(LoggerInterface::class);

        $this->twig = $this->createMock(\Twig_Environment::class);
        $this->application->expects($this->any())->method('getTwigService')->willReturn($this->twig);

        $this->consentRepository = $this->createMock(ConsentRepository::class);
        $this->consentRestService = $this->createMock(ConsentRestService::class);
        $this->consentToken = $this->createMock(ConsentToken::class);

        $this->consent = new Consent();
        $this->application->expects($this->any())->method('getConsentRepository')->willReturn($this->consentRepository);

        $this->tenantRepository = $this->createMock(TenantRepository::class);
        $this->application->expects($this->any())->method('getTenantRepository')->willReturn($this->tenantRepository);

        $this->srnManager = $this->createMock(Srn\Manager::class);
        $this->application->expects($this->any())->method('getSrnManager')->willReturn($this->srnManager);

        $this->oAuth2Service = $this->createMock(OAuth2Service::class);
        $this->joseService = $this->createMock(JoseService::class);
        $this->sessionService = $this->createMock(Session::class);

        $this->flashBag = $this->createMock(FlashBagInterface::class);
        $this->sessionService->expects($this->any())->method('getFlashBag')->willReturn($this->flashBag);

        $this->request = $this->createMock(Request::class);
        $this->requestQueryBug = $this->createMock(ParameterBag::class);
        $this->request->query = $this->requestQueryBug;

        $this->oAuth2Request = $this->createMock(RequestInterface::class);
        $this->userToken = $this->createMock(AbstractToken::class);
        $this->userToken
            ->method('getUser')
            ->willReturn($this->createMock(User::class));
        $this->application->method('offsetGet')
            ->willReturnMap(
                [
                    ['JoseService', $this->joseService],
                    ['oAuth2Service', $this->oAuth2Service],
                    ['session', $this->sessionService],
                ]
            );

        $this->application->method('getUrlGeneratorService')
            ->willReturn($this->createMock(UrlGeneratorInterface::class));

        $this->application->method('getConsentRestService')
            ->willReturn($this->consentRestService);

        $this->application->method('getConfig')->willReturn(['grpc' => ['disabled' => false]]);

        $this->consentController = new ConsentController($this->application);
        $this->challenge = IDMFixturesHelper::getValidJWT();
        $this->invalidChallenge = IDMFixturesHelper::getExpiredJWT();

        $this->application->method('getOAuth2Service')->willReturn($this->oAuth2Service);
        $this->application->method('getLogger')->willReturn($this->logger);
        $this->application->method('getGrpcAppApi')->willReturn($this->grpcAppApi);

        $this->passwordChecker = $this->createMock(PasswordChecker::class);
        $this->application->method('getUserPasswordChecker')->willReturn($this->passwordChecker);

        $this->urlGenerator = $this->createMock(UrlGenerator::class);
        $this->application->method('getUrlGeneratorService')->willReturn($this->urlGenerator);
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     *
     * @covers ::consentInitAction
     */
    public function testConsentInitActionNoConsentParameter(): void
    {
        $this->consentController->consentInitAction($this->application, $this->request);
    }

    public function testConsentInitAction(): void
    {
        $tenantId = '0000000001';
        $tenantSrn = 'srn:cloud:iam:eu:' . $tenantId . ':tenant';

        $srn = new Srn\Srn();
        $srn->setPartition('cloud')
            ->setService('iam')
            ->setRegion('eu')
            ->setTenantId($tenantId)
            ->setResource(['tenant']);

        $tenant = Tenant::fromSrn($srn);

        $this->requestQueryBug->expects($this->once())
            ->method('has')
            ->with($this->equalTo('consent'))
            ->willReturn(true);

        $this->requestQueryBug->expects($this->once())
            ->method('get')
            ->with($this->equalTo('consent'))
            ->willReturn($consent = 'test_consent');

        $this->consentRestService->expects($this->once())
            ->method('getToken')
            ->with($this->equalTo($consent))
            ->willReturn($this->consentToken);

        $this->tenantRepository->expects($this->once())
            ->method('findTenantById')
            ->with($tenantId)
            ->willReturn($tenant);

        $this->srnManager->expects($this->once())
            ->method('createTenantSrn')
            ->with($tenantId)
            ->willReturn($srn);

        $this->consentToken->expects($this->once())
            ->method('getTenantSRN')
            ->willReturn($tenantId);

        $this->consentToken->expects($this->exactly(2))
            ->method('getUsername')
            ->willReturn($username = 'max');

        $this->sessionService->expects($this->exactly(2))
            ->method('set')
            ->withConsecutive(
                [$this->equalTo('tenant'), $this->equalTo($tenantSrn)],
                [$this->equalTo('consent'), $this->isInstanceOf(ConsentToken::class)]
            );
        $this->application->expects($this->once())->method('redirect');
        $this->consentController->consentInitAction($this->application, $this->request);
    }

    /**
     * Checks logic when JWT was not saved after init.
     *
     * @covers ::consentFinishAction
     * @expectedException \Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException
     */
    public function testConsentFinishActionWithoutSavedConsentToken()
    {
        $this->sessionService->expects($this->once())
            ->method('get')
            ->with('consent')
            ->willReturn(null);

        $this->application->expects($this->never())->method('redirect');

        $this->consentController->consentFinishAction($this->application, $this->request);
    }

    /**
     * Checks logic when user was not authenticated.
     *
     * @covers ::consentFinishAction
     * @expectedException \Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException
     */
    public function testConsentFinishActionWithoutAuthenticatedUser()
    {
        $this->sessionService->expects($this->exactly(2))
            ->method('get')
            ->willReturnMap(
                [
                    ['consent', null, $this->consentToken],
                    ['authenticatedUser', null, null],
                ]
            );

        $this->application->expects($this->never())->method('redirect');

        $this->consentController->consentFinishAction($this->application, $this->request);
    }

    /**
     * Checks consent finish flow.
     *
     * @covers ::consentFinishAction
     */
    public function testConsentFinishActionConsentScopesDoNotMatch()
    {
        $this->sessionService->expects($this->exactly(2))
            ->method('get')
            ->willReturnMap(
                [
                    ['consent', null, $this->consentToken],
                    ['authenticatedUser', null, $this->userToken],
                ]
            );

        $this->consentToken->expects($this->once())
            ->method('getTenantSRN')
            ->willReturn('srn:cloud:iam:eu:0000000001:tenant');

        $this->consentToken->expects($this->exactly(2))
            ->method('getScopes')
            ->willReturn(['not_match']);

        $this->consentToken->expects($this->once())
            ->method('getClientId')
            ->willReturn($clientId = 'srn:staging:iam:na:0000000001:app:login');

        $this->consentRepository->expects($this->once())
            ->method('findConsentByClientIdAndTenantId')
            ->with($clientId, '0000000001')
            ->willReturn($this->consent);

        $this->consent->setScopes(['notMatch']);

        $this->twig->expects($this->once())
            ->method('render')
            ->with('consent/app_consent_restricted.html.twig')
            ->willReturn('html');

        $this->consentController->consentFinishAction($this->application, $this->request);
    }

    /**
     * Checks consent finish flow.
     *
     * @covers ::consentFinishAction
     */
    public function testConsentFinishActionPasswordIsExpired()
    {
        $this->sessionService->expects($this->exactly(2))
            ->method('get')
            ->willReturnMap(
                [
                    ['consent', null, $this->consentToken],
                    ['authenticatedUser', null, $this->userToken],
                ]
            );

        $this->consentToken->expects($this->exactly(2))
            ->method('getTenantSRN')
            ->willReturn('srn:cloud:iam:eu:0000000001:tenant');

        $this->consentToken->expects($this->once())
            ->method('getScopes')
            ->willReturn(['match']);

        $this->consentToken->expects($this->once())
            ->method('getClientId')
            ->willReturn($clientId = 'srn:staging:iam:na:0000000001:app:login');

        $this->consentRepository->expects($this->once())
            ->method('findConsentByClientIdAndTenantId')
            ->with($clientId, '0000000001')
            ->willReturn($this->consent);

        $this->consent->setScopes(['match']);

        $this->passwordChecker->expects($this->once())
            ->method('isPasswordExpired')
            ->with($this->userToken)
            ->willReturn(true);

        $this->sessionService->expects($this->once())
            ->method('set')
            ->with(TenantConfigInitializer::SESSION_KEY, 'srn:cloud:iam:eu:0000000001:tenant');

        $this->application->expects($this->once())
            ->method('redirect')
            ->willReturn(new RedirectResponse('http://login-service-change-pass-test.url'));

        $this->consentController->consentFinishAction($this->application, $this->request);
    }

    /**
     * Checks consent finish flow.
     *
     * @covers ::consentFinishAction
     */
    public function testConsentFinishActionRestFlowAcceptRequest()
    {
        $this->sessionService->expects($this->exactly(2))
            ->method('get')
            ->willReturnMap(
                [
                    ['consent', null, $this->consentToken],
                    ['authenticatedUser', null, $this->userToken],
                ]
            );

        $this->consentToken->expects($this->once())
            ->method('getRedirectUrl')
            ->willReturn('http://oauth.server/?state=123&consent=encodedToken');

        $this->consentToken->expects($this->once())
            ->method('getTenantSRN')
            ->willReturn('srn:cloud:iam:eu:0000000001:tenant');

        $this->consentToken->expects($this->once())
            ->method('getScopes')
            ->willReturn(['match']);

        $this->consentToken->expects($this->once())
            ->method('getClientId')
            ->willReturn($clientId = 'srn:staging:iam:na:0000000001:app:login');

        $this->consentRepository->expects($this->once())
            ->method('findConsentByClientIdAndTenantId')
            ->with($clientId, '0000000001')
            ->willReturn($this->consent);

        $this->consent->setScopes(['match']);

        $this->passwordChecker->expects($this->once())
            ->method('isPasswordExpired')
            ->with($this->userToken)
            ->willReturn(false);

        $this->oAuth2Service->expects($this->once())
            ->method('acceptConsentRequest')
            ->with($this->consentToken, $this->userToken);

        $this->application->expects($this->once())
            ->method('redirect')
            ->with('http://oauth.server/?state=123&consent=encodedToken');

        $this->consentController->consentFinishAction($this->application, $this->request);
    }

    /**
     * Checks consent finish flow.
     *
     * @covers ::consentFinishAction
     */
    public function testConsentFinishActionRestFlowRejectRequest()
    {
        $this->consentToken->expects($this->once())
            ->method('getRequestId')
            ->willReturn($requestId = 'test_consent_request_id');

        $this->consentToken->expects($this->once())
            ->method('getRedirectUrl')
            ->willReturn('http://oauth.server/?state=123&consent=encodedToken');

        $this->sessionService->expects($this->once())
            ->method('get')
            ->with('consent')
            ->willReturn($this->consentToken);

        $this->flashBag->expects($this->once())
            ->method('get')
            ->with('error', ['No consent'])
            ->willReturn(['Tenant isn\'t active']);

        $this->oAuth2Service->expects($this->once())
            ->method('rejectConsentRequest')
            ->with($requestId, 'Tenant isn\'t active');

        $this->application->expects($this->once())
            ->method('redirect')
            ->with('http://oauth.server/?state=123&consent=encodedToken');

        $this->consentController->consentCancelAction($this->application, $this->request);
    }

    public function testConsentConfirmationActionAppConsentRestricted()
    {
        $this->sessionService->expects($this->once())
            ->method('get')
            ->with('consent')
            ->willReturn($this->consentToken);

        $this->consentToken->expects($this->once())
            ->method('getTenantSRN')
            ->willReturn('srn:cloud:iam:eu:0000000001:tenant');

        $this->consentToken->expects($this->exactly(2))
            ->method('getScopes')
            ->willReturn(['not match']);

        $this->consentToken->expects($this->once())
            ->method('getClientId')
            ->willReturn($clientId = 'srn:staging:iam:na:0000000001:app:login');

        $this->consentRepository->expects($this->once())
            ->method('findConsentByClientIdAndTenantId')
            ->with($clientId, '0000000001')
            ->willReturn($this->consent);

        $this->consent->setScopes(['notMatch']);

        $this->twig->expects($this->once())
            ->method('render')
            ->with('consent/app_consent_restricted.html.twig')
            ->willReturn('restricted');

        $this->consentController->consentConfirmationAction($this->application, $this->request);
    }

    public function testConsentConfirmationActionPasswordIsExpired()
    {
        $this->sessionService->expects($this->exactly(2))
            ->method('get')
            ->willReturnMap(
                [
                    ['consent', null, $this->consentToken],
                    ['authenticatedUser', null, $this->userToken],
                ]
            );

        $this->consentToken->expects($this->once())
            ->method('getTenantSRN')
            ->willReturn('srn:cloud:iam:eu:0000000001:tenant');

        $this->consentToken->expects($this->once())
            ->method('getScopes')
            ->willReturn(['match']);

        $this->consentToken->expects($this->once())
            ->method('getClientId')
            ->willReturn($clientId = 'srn:staging:iam:na:0000000001:app:login');

        $this->consentRepository->expects($this->once())
            ->method('findConsentByClientIdAndTenantId')
            ->with($clientId, '0000000001')
            ->willReturn($this->consent);

        $this->consent->setScopes(['match']);

        $this->passwordChecker->expects($this->once())
            ->method('isPasswordExpired')
            ->with($this->userToken)
            ->willReturn(true);

        $this->application->expects($this->once())
            ->method('redirect')
            ->willReturn(new RedirectResponse('http://login-service-change-pass-test.url'));

        $this->consentController->consentConfirmationAction($this->application, $this->request);
    }

    public function testConsentConfirmationActionConsentNotFound()
    {
        $this->sessionService->expects($this->once())
            ->method('get')
            ->with('consent')
            ->willReturn($this->consentToken);

        $this->consentToken->expects($this->once())
            ->method('getTenantSRN')
            ->willReturn('srn:cloud:iam:eu:0000000001:tenant');

        $this->consentToken->expects($this->never())
            ->method('getScopes');

        $this->consentToken->expects($this->once())
            ->method('getClientId')
            ->willReturn($clientId = 'srn:staging:iam:na:0000000001:app:login');

        $this->consentRepository->expects($this->once())
            ->method('findConsentByClientIdAndTenantId')
            ->with($clientId, '0000000001')
            ->willThrowException(new ConsentNotFoundException());

        $this->consent->setScopes(['match']);

        $this->twig->expects($this->once())
            ->method('render')
            ->with('consent/app_consent_restricted.html.twig')
            ->willReturn('restricted');

        $this->consentController->consentConfirmationAction($this->application, $this->request);
    }

    /**
     * @see testConsentConfirmationActionAuthAutoAcceptConsent
     * @return array
     */
    public function autoApprovedApplications(): array
    {
        return [
            'crm' => ['clientId' => 'srn:dev:iam:na:0000000001:app:crm:bd0f3e90-9570-47c9-bb11-6233225ee099'],
            'web' => ['clientId' => 'srn:dev:iam:na:0000000002:app:web:f7cf6d39-f557-4feb-b088-e0eb3fb55af8'],
        ];
    }

    /**
     * @covers ::consentConfirmationAction
     * @dataProvider autoApprovedApplications
     * @param string $clientId
     */
    public function testConsentConfirmationActionAuthAutoAcceptConsent(string $clientId): void
    {
        $consentRedirectUrl = 'https://console.sugar.multiverse/api/callback';
        $this->consentToken
            ->method('getClientId')
            ->willReturn($clientId);
        $this->consentToken
            ->method('getTenantSRN')
            ->willReturn('srn:dev:iam:na:0000000001:tenant');
        $this->consentToken
            ->method('getScopes')
            ->willReturn(['match']);
        $this->consentToken->method('getRedirectUrl')
            ->willReturn($consentRedirectUrl);
        $this->consentRepository
            ->method('findConsentByClientIdAndTenantId')
            ->willReturn($this->consent);
        $this->consent->setScopes(['match']);
        $this->sessionService
            ->method('get')
            ->willReturnMap(
                [
                    ['consent', null, $this->consentToken],
                    ['authenticatedUser', null, $this->userToken],
                ]
            );

        $this
            ->logger
            ->expects($this->once())
            ->method('info')
            ->with('Automatically approved consent');

        $this->oAuth2Service
            ->expects($this->once())
            ->method('acceptConsentRequest')
            ->with(
                $this->equalTo($this->consentToken),
                $this->equalTo($this->userToken)
            );
        $this->application
            ->expects($this->once())
            ->method('redirect')
            ->with($consentRedirectUrl);
        $this->twig->expects($this->never())
            ->method('render');

        $this->consentController->consentConfirmationAction($this->application, $this->request);
    }

    /**
     * @see testConsentConfirmationActionWithNotAutoApprovedApp
     * @return array
     */
    public function notAutoApprovedApplications(): array
    {
        return [
            'native'        => [
                'clientId' => 'srn:dev:iam:na:0000000001:app:native:c023f52-460-4a2-81a7-99c975694f2e',
                'appName' => 'native app name',
            ],
            'userAgent'     => [
                'clientId' => 'srn:dev:iam:na:0000000002:app:ua:264588c3-74df-4f3a-a61a-4f3bf109791c',
                'appName' => '',
            ],
            'someNewType'   => [
                'clientId' => 'srn:dev:iam:na:0000000003:app:some-new-type:4c74bc07-4953-4a09-a61a',
                'appName' => 'other app name',
            ],
            'globalNative'   => [
                'clientId' => 'srn:dev:iam:::app:native:28c6160b-d737-443e-992b-445a4c96b4b7',
                'appName' => 'global native app name',
            ],
        ];
    }

    /**
     * @covers ::consentConfirmationAction
     * @dataProvider  notAutoApprovedApplications
     * @param string $clientId
     * @param string $appName
     */
    public function testConsentConfirmationActionWithNotAutoApprovedApp(string $clientId, string $appName): void
    {
        $this->consentToken
            ->method('getClientId')
            ->willReturn($clientId);
        $this->consentToken
            ->method('getTenantSRN')
            ->willReturn('srn:dev:iam:na:0000000001:tenant');
        $this->consentToken
            ->method('getScopes')
            ->willReturn(['match']);
        $this->consentRepository
            ->method('findConsentByClientIdAndTenantId')
            ->willReturn($this->consent);
        $this->consent->setScopes(['match']);
        $this->sessionService
            ->method('get')
            ->willReturnMap(
                [
                    ['consent', null, $this->consentToken],
                    ['authenticatedUser', null, $this->userToken],
                ]
            );

        $status = new \StdClass();
        $status->code = \Grpc\CALL_OK;

        $this->grpcAppApi->expects($this->once())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class))
            ->willReturn($this->unaryCall);
        $this->unaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiApp, $status]);
        $this->apiApp->method('getClientName')->willReturn($appName);

        $this->oAuth2Service
            ->expects($this->never())
            ->method('acceptConsentRequest');
        $this->application
            ->expects($this->never())
            ->method('redirect');
        $this->twig->expects($this->once())
            ->method('render')
            ->with('consent/confirmation.html.twig');

        $this->consentController->consentConfirmationAction($this->application, $this->request);
    }

    /**
     * @covers ::consentConfirmationAction
     */
    public function testConsentConfirmationActionWrongGrpcResponseStatus(): void
    {
        $clientId = 'srn:dev:iam:na:0000000001:app:native:c023f52-460-4a2-81a7-99c975694f2e';
        $this->consentToken
            ->method('getClientId')
            ->willReturn($clientId);
        $this->consentToken
            ->method('getTenantSRN')
            ->willReturn('srn:dev:iam:na:0000000001:tenant');
        $this->consentToken
            ->method('getScopes')
            ->willReturn(['match']);
        $this->consentRepository
            ->method('findConsentByClientIdAndTenantId')
            ->willReturn($this->consent);
        $this->consent->setScopes(['match']);
        $this->sessionService
            ->method('get')
            ->willReturnMap(
                [
                    ['consent', null, $this->consentToken],
                    ['authenticatedUser', null, $this->userToken],
                ]
            );

        $status = new \StdClass();
        $status->code = \Grpc\CALL_ERROR;

        $this->grpcAppApi->expects($this->once())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class))
            ->willReturn($this->unaryCall);
        $this->unaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([null, $status]);
        $this->apiApp->expects($this->never())->method('getClientName')->willReturn(null);

        $this->oAuth2Service
            ->expects($this->never())
            ->method('acceptConsentRequest');
        $this->application
            ->expects($this->never())
            ->method('redirect');
        $this->twig->expects($this->once())
            ->method('render')
            ->with('consent/confirmation.html.twig');

        $this->consentController->consentConfirmationAction($this->application, $this->request);
    }
}
