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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Authentication;

use Psr\Log\LoggerInterface;

use Sugarcrm\IdentityProvider\App\Authentication\BearerAuthentication;
use Sugarcrm\IdentityProvider\App\Authentication\OAuth2Service;
use Sugarcrm\IdentityProvider\Srn;

use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * @coversDefaultClass Sugarcrm\IdentityProvider\App\Authentication\BearerAuthentication
 */
class BearerAuthenticationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JsonResponse
     */
    private $errorResultResponse;

    /**
     * @var array
     */
    private $errorResult = [
        'status' => 'error',
        'error' => 'The request could not be authorized',
    ];

    /**
     * @var string
     */
    private $token = '--token--value--';

    /**
     * @var BearerAuthentication
     */
    private $bearerAuthentication;

    /**
     * @var string
     */
    private $requiredScope = 'https://apis.sugarcrm.com/auth/iam.password';

    /**
     * @var string
     */
    private $legacyScope = 'idp.auth.password';

    /**
     * @var Request | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    /**
     * @var HeaderBag | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestHeaders;

    /**
     * @var LoggerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $logger;

    /**
     * @var OAuth2Service | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $oAuth2Service;

    /**
     * @var Srn\Srn
     */
    protected $tenantSrn;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->errorResultResponse = new JsonResponse($this->errorResult, Response::HTTP_UNAUTHORIZED);

        $this->oAuth2Service = $this->createMock(OAuth2Service::class);

        $this->logger = $this->createMock(LoggerInterface::class);

        $this->request = $this->createMock(Request::class);
        $this->requestHeaders = $this->createMock(HeaderBag::class);
        $this->request->headers = $this->requestHeaders;

        $this->tenantSrn = Srn\Converter::fromString('srn:dev:iam:na:1012725962:tenant');

        $this->bearerAuthentication = new BearerAuthentication(
            $this->oAuth2Service,
            $this->requiredScope,
            $this->logger
        );
    }

    /**
     * @see testInvalidScopeToken
     * @return array
     */
    public function InvalidScopeDataProvider()
    {
        return [
            'invalid token with out scope' => [
                'oAuth2ServiceResult' => [],
                'exception' => new AuthenticationException('Field scope in result not exists'),
            ],
            'invalid token with invalid scope' => [
                'oAuth2ServiceResult' => ['scope' => 'invalidScope'],
                'exception' => new AuthenticationException('Invalid scope'),
            ],
            'invalid token with scope which start like required scope' => [
               'oAuth2ServiceResult' => ['scope' => $this->requiredScope . 'someSuffix'],
               'exception' => new AuthenticationException('Invalid scope'),
            ],
            'valid token with invalid client id' => [
               'oAuth2ServiceResult' => [
                   'scope' => $this->requiredScope,
                   'client_id' => 'WRONG-CLIENT-ID',
               ],
               'exception' => new AuthenticationException('Wrong client id:Invalid number of components in SRN'),
            ],
            'valid token with client id with wrong tenant' => [
               'oAuth2ServiceResult' => [
                   'scope' => $this->requiredScope,
                   'client_id' => 'srn:dev:iam:na:123123123:app:crm:5c4c0477-7ac8-41b0-81eb-02f0cf9adadb',
               ],
               'exception' => new AuthenticationException('Tenants mismatch'),
            ],
        ];
    }

    /**
     * @dataProvider InvalidScopeDataProvider
     * @covers ::authenticateClient
     * @param $oAuth2ServiceResult
     * @param $exception
     */
    public function testInvalidScopeToken($oAuth2ServiceResult, AuthenticationException $exception)
    {
        $this->requestHeaders
            ->expects($this->once())
            ->method('get')
            ->with('Authorization')
            ->willReturn("Bearer {$this->token}");
        $this->oAuth2Service
            ->expects($this->once())
            ->method('introspectToken')
            ->with($this->token)
            ->willReturn($oAuth2ServiceResult);
        $this->logger
            ->expects($this->once())
            ->method('warning')
            ->with(
                'Authentication Exception occurred on client Authentication',
                [
                    'exception' => $exception,
                    'tags' => ['IdM.Bearer.authentication'],
                ]
            );

        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());
        $this->bearerAuthentication->authenticateClient($this->request, $this->tenantSrn);
    }

    /**
     * testing Inactive Token
     * @covers ::authenticateClient
     */
    public function testInactiveToken()
    {
        $exception = new AuthenticationException('OIDC Token is not valid');
        $this->requestHeaders
            ->method('get')
            ->with('Authorization')
            ->willReturn("Bearer $this->token");
        $this->oAuth2Service
            ->expects($this->once())
            ->method('introspectToken')
            ->willThrowException($exception);
        $this->logger
            ->expects($this->once())
            ->method('warning')
            ->with(
                'Authentication Exception occurred on client Authentication',
                [
                    'exception' => $exception,
                    'tags' => ['IdM.Bearer.authentication'],
                ]
            );
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());
        $this->bearerAuthentication->authenticateClient($this->request, $this->tenantSrn);
    }

    /**
     * @see testInvalidHeader
     * @return array
     */
    public function invalidHeaderDataProvider()
    {
        return [
            'no authorization header' => [
                'authorizationHeader' => null,
            ],
            'invalid authorization header type' => [
                'authorizationHeader' => "basic some-token",
            ],
        ];
    }

    /**
     * Testing invalid headers
     * @dataProvider invalidHeaderDataProvider
     * @covers ::authenticateClient
     * @param $authorizationHeader
     */
    public function testInvalidHeader($authorizationHeader)
    {
        $exception = new AuthenticationException('Empty Authorization token received');
        $this->requestHeaders
            ->expects($this->once())
            ->method('get')
            ->with('Authorization')
            ->willReturn($authorizationHeader);
        $this->oAuth2Service
            ->expects($this->never())
            ->method('introspectToken');

        $this->logger
            ->expects($this->once())
            ->method('warning')
            ->with(
                'Authentication Exception occurred on client Authentication',
                [
                    'exception' => new AuthenticationException('Empty Authorization token received'),
                    'tags' => ['IdM.Bearer.authentication'],
                ]
            );

        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());
        $this->bearerAuthentication->authenticateClient($this->request, $this->tenantSrn);
    }

    /**
     * @see testIntrospectionValidToken
     * @return array
     */
    public function validTokenDataProvider()
    {
        return [
            'valid token with one scope' => [
                'input' => [
                    'header' => "Bearer $this->token",
                    'oAuth2ServiceResult' => [
                        'scope' => $this->requiredScope,
                        'client_id' => 'srn:dev:iam:na:1012725962:app:crm:5c4c0477-7ac8-41b0-81eb-02f0cf9adadb',
                    ],
                ],
            ],
            'valid token with lover case authorization type' => [
                'input' => [
                    'header' => "bearer $this->token",
                    'oAuth2ServiceResult' => [
                        'scope' => $this->requiredScope,
                        'client_id' => 'srn:dev:iam:na:1012725962:app:crm:5c4c0477-7ac8-41b0-81eb-02f0cf9adadb',
                    ],
                ],
            ],
            'valid token with more then one scope' => [
                'input' => [
                    'header' => "Bearer $this->token",
                    'oAuth2ServiceResult' => [
                        'client_id' => 'srn:dev:iam:na:1012725962:app:crm:5c4c0477-7ac8-41b0-81eb-02f0cf9adadb',
                        'scope' => implode(
                            BearerAuthentication::SCOPE_DELIMITER,
                            ['Scope1', $this->requiredScope, 'someOtherScope']
                        ),
                    ],
                ],
            ],
        ];
    }

    /**
     * Testing valid cases
     * @dataProvider validTokenDataProvider
     * @covers ::authenticateClient
     * @param array $input
     */
    public function testIntrospectionValidToken(array $input)
    {
        $this->requestHeaders
            ->expects($this->once())
            ->method('get')
            ->with('Authorization')
            ->willReturn($input['header']);
        $this->oAuth2Service
            ->expects($this->once())
            ->method('introspectToken')
            ->with($this->token)
            ->willReturn($input['oAuth2ServiceResult']);
        $this->logger
            ->expects($this->never())
            ->method('warning');

        $this->bearerAuthentication->authenticateClient($this->request, $this->tenantSrn);
    }

    /**
     * @see testIntrospectionValidToken
     * @return array
     */
    public function validLegacyTokenDataProvider()
    {
        return [
            'valid token with one scope' => [
                'input' => [
                    'header' => "Bearer $this->token",
                    'oAuth2ServiceResult' => [
                        'scope' => $this->legacyScope,
                        'client_id' => 'srn:dev:iam:na:1012725962:app:crm:5c4c0477-7ac8-41b0-81eb-02f0cf9adadb',
                    ],
                ],
            ],
            'valid token with lover case authorization type' => [
                'input' => [
                    'header' => "bearer $this->token",
                    'oAuth2ServiceResult' => [
                        'scope' => $this->legacyScope,
                        'client_id' => 'srn:dev:iam:na:1012725962:app:crm:5c4c0477-7ac8-41b0-81eb-02f0cf9adadb',
                    ],
                ],
            ],
            'valid token with more then one scope' => [
                'input' => [
                    'header' => "Bearer $this->token",
                    'oAuth2ServiceResult' => [
                        'scope' => implode(
                            BearerAuthentication::SCOPE_DELIMITER,
                            ['Scope1', $this->legacyScope, 'someOtherScope']
                        ),
                        'client_id' => 'srn:dev:iam:na:1012725962:app:crm:5c4c0477-7ac8-41b0-81eb-02f0cf9adadb',
                    ],
                ],
            ],
        ];
    }

    /**
     * Testing valid cases
     * @dataProvider validLegacyTokenDataProvider
     * @covers ::authenticateClient
     * @param array $input
     */
    public function testIntrospectionValidLegacyToken(array $input)
    {
        $this->requestHeaders
            ->expects($this->once())
            ->method('get')
            ->with('Authorization')
            ->willReturn($input['header']);
        $this->oAuth2Service
            ->expects($this->once())
            ->method('introspectToken')
            ->with($this->token)
            ->willReturn($input['oAuth2ServiceResult']);
        $this->logger
            ->expects($this->once())
            ->method('warning')
            ->with(
                'Clients still use legacy scope',
                [
                    'legacyScope' => $this->legacyScope,
                    'tags' => ['IdM.Bearer.authentication'],
                ]
            );

        $this->bearerAuthentication->authenticateClient($this->request, $this->tenantSrn);
    }
}
