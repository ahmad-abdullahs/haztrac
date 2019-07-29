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

use Grpc\UnaryCall;
use Psr\Log\LoggerInterface;
use Sugarcrm\Apis\Iam\User\V1alpha\RevokeTokensRequest;
use Sugarcrm\Apis\Iam\User\V1alpha\UserAPIClient;
use Sugarcrm\Apis\Rpc;
use Sugarcrm\IdentityProvider\App\Authentication\RevokeAccessTokensService;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Authentication\RevokeAccessTokensService
 */
class RevokeAccessTokensServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserAPIClient | \PHPUnit_Framework_MockObject_MockObject
     */
    private $grpcUserApi;

    /**
     * @var UnaryCall | \PHPUnit_Framework_MockObject_MockObject
     */
    private $unaryCall;

    /**
     * @var LoggerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $logger;

    /**
     * @var TokenInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $token;

    /**
     * @var RevokeAccessTokensService | \PHPUnit_Framework_MockObject_MockObject
     */
    private $service;

    protected function setUp()
    {
        $this->token = $this->createMock(TokenInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->grpcUserApi = $this->createMock(UserAPIClient::class);
        $this->unaryCall = $this->createMock(UnaryCall::class);
        $this->service = new RevokeAccessTokensService($this->grpcUserApi, $this->logger);
    }

    /**
     * @covers ::revokeAccessTokens
     */
    public function testRevokeAccessTokens()
    {
        $userSrn = 'srn:user';

        $this->logger
            ->expects($this->once())
            ->method('info')
            ->with('Sending revoke tokens {user_srn} of tenant {tid_srn}');
        $this->logger
            ->expects($this->never())
            ->method('warning');

        $this->grpcUserApi->expects($this->once())
            ->method('RevokeAccessTokens')
            ->with($this->callback(function (RevokeTokensRequest $request) use ($userSrn) {
                return $request->getName() == $userSrn;
            }))
            ->willReturn($this->unaryCall);

        $token = $this->createMock(TokenInterface::class);
        $token->method('getAttribute')
            ->will(
                $this->returnValueMap([
                    ['srn', $userSrn],
                    ['tenantSrn', 'srn:tenant'],
                ])
            );

        $status = new \stdClass();
        $status->code = \Grpc\CALL_OK;
        $response = new Rpc\Status();
        $response->setCode(Rpc\Code::OK);
        $this->unaryCall->method('wait')->willReturn([$response, $status]);

        $this->service->revokeAccessTokens($token);
    }

    /**
     * @covers ::revokeAccessTokens
     */
    public function testRevokeAccessTokensWithInvalidResponse()
    {
        $this->logger
            ->expects($this->once())
            ->method('info')
            ->with('Sending revoke tokens {user_srn} of tenant {tid_srn}');
        $this->logger
            ->expects($this->once())
            ->method('warning')
            ->with('Incorrect response by revoke tokens');

        $this->grpcUserApi->expects($this->once())
            ->method('RevokeAccessTokens')
            ->willReturn($this->unaryCall);

        $token = $this->createMock(TokenInterface::class);
        $token->method('getAttribute')
            ->will(
                $this->returnValueMap([
                    ['srn', 'srn:user'],
                    ['tenantSrn', 'srn:tenant'],
                ])
            );

        $status = new \stdClass();
        $status->code = \Grpc\CALL_ERROR;
        $response = new Rpc\Status();
        $response->setCode(Rpc\Code::UNKNOWN);
        $this->unaryCall->method('wait')->willReturn([$response, $status]);

        $this->service->revokeAccessTokens($token);
    }
}
