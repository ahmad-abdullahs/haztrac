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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Psr\Log\LoggerInterface;
use Sugarcrm\IdentityProvider\Srn;

class BearerAuthentication
{
    const SCOPE_DELIMITER = ' ';

    /**
     * @var OAuth2Service
     */
    protected $oAuth2Service;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var string
     */
    protected $requiredScope;

    /**
     * @var string
     */
    protected $legacyScope = 'idp.auth.password';

    /**
     * BearerAuthentication constructor.
     * @param oAuth2Service $oAuth2Service
     * @param string $requiredScope
     * @param LoggerInterface $logger
     */
    public function __construct(oAuth2Service $oAuth2Service, string $requiredScope, LoggerInterface $logger)
    {
        $this->oAuth2Service = $oAuth2Service;
        $this->requiredScope = $requiredScope;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Srn\Srn $tenantSrn
     * @throws AuthenticationException
     */
    public function authenticateClient(Request $request, Srn\Srn $tenantSrn)
    {
        try {
            $accessToken = $this->getToken($request);
            $result = $this->oAuth2Service->introspectToken($accessToken);
            $this->checkIsClientAllowed($result, $tenantSrn);
        } catch (AuthenticationException $exception) {
            $this->logger->warning('Authentication Exception occurred on client Authentication', [
                'exception' => $exception,
                'tags' => ['IdM.Bearer.authentication'],
            ]);
            throw $exception;
        }
    }

    /**
     * Return Bearer in authentication header if it present.
     *
     * @param Request $request
     * @return string
     * @throws AuthenticationException
     */
    protected function getToken(Request $request)
    {
        if (preg_match('~^Bearer (.*)$~i', $request->headers->get('Authorization'), $matches)) {
            $token = $matches[1];
        } else {
            throw new AuthenticationException('Empty Authorization token received');
        }
        return $token;
    }

    /**
     * Check result of introspection
     * @param array $result
     * @param Srn\Srn $tenantSrn
     * @throws AuthenticationException
     */
    protected function checkIsClientAllowed(array $result, Srn\Srn $tenantSrn)
    {
        if (!array_key_exists('scope', $result)) {
            throw new AuthenticationException('Field scope in result not exists');
        }

        $res = array_intersect(
            [$this->requiredScope, $this->legacyScope],
            explode(self::SCOPE_DELIMITER, $result['scope'])
        );
        if (empty($res)) {
            throw new AuthenticationException('Invalid scope');
        }
        if (!in_array($this->requiredScope, $res)) {
            $this->logger->warning('Clients still use legacy scope', [
                'legacyScope' => $this->legacyScope,
                'tags' => ['IdM.Bearer.authentication'],
            ]);
        }

        try {
            $clientSrn = Srn\Converter::fromString($result['client_id']);
        } catch (\Exception $e) {
            throw new AuthenticationException('Wrong client id:' . $e->getMessage());
        }

        if ($clientSrn->getTenantId() != $tenantSrn->getTenantId()) {
            throw new AuthenticationException('Tenants mismatch');
        }
    }
}
