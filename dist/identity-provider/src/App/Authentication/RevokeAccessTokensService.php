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

namespace Sugarcrm\IdentityProvider\App\Authentication;

use Psr\Log\LoggerInterface;


use Sugarcrm\Apis\Iam\User\V1alpha\RevokeTokensRequest;
use Sugarcrm\Apis\Iam\User\V1alpha\UserAPIClient;
use Sugarcrm\Apis\Rpc;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class RevokeAccessTokensService
{
    /**
     * @var UserAPIClient
     */
    private $userApi;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * RevokeAccessTokensService constructor.
     * @param UserAPIClient $userApi
     * @param LoggerInterface $logger
     */
    public function __construct(UserAPIClient $userApi, LoggerInterface $logger)
    {
        $this->userApi = $userApi;
        $this->logger = $logger;
    }

    /**
     * @param TokenInterface $token
     */
    public function revokeAccessTokens(TokenInterface $token)
    {
        $this->logger->info('Sending revoke tokens {user_srn} of tenant {tid_srn}', [
            'user_srn' => $token->getAttribute('srn'),
            'tid_srn' => $token->getAttribute('tenantSrn'),
            'tags' => ['IdM.revoke.token'],
        ]);
        $revokeTokensRequest = new RevokeTokensRequest();
        $revokeTokensRequest->setName($token->getAttribute('srn'));
        /** @var $response Rpc\Status */
        [$response, $status] = $this->userApi->RevokeAccessTokens($revokeTokensRequest)->wait();
        $isValid = $status && $status->code === \GRPC\CALL_OK;
        $revokedTokens = $isValid && $response->getCode() === Rpc\Code::OK;
        if (!$revokedTokens) {
            $this->logger->warning('Incorrect response by revoke tokens', [
                'user_srn' => $token->getAttribute('srn'),
                'tid' => $token->getAttribute('tenantSrn'),
                'response' => $response,
                'status' => $status,
                'tags' => ['IdM.revoke.token'],
            ]);
        }
    }
}
