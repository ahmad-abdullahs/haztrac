<?php

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Authentication\ConsentRequest;

use Jose\Object\JWSInterface;
use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentToken;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentToken
 */
class ConsentTokenTest extends \PHPUnit_Framework_TestCase
{
    public function testFillByConsentRequestData()
    {
        $token = (new ConsentToken())->fillByConsentRequestData([
            'id' => 'test_request_id',
            'requestedScopes' => ['offline', 'openid', 'hydra.*'],
            'clientId' => 'testLocal1',
            'redirectUrl' => 'http://test/?tenant_hint=srn:cloud:idp:eu:2000000001:tenant&login_hint=max',
        ]);
        $this->assertEquals('srn:cloud:idp:eu:2000000001:tenant', $token->getTenantSRN());
        $this->assertEquals('max', $token->getUsername());
        $this->assertEquals(
            'http://test/?tenant_hint=srn:cloud:idp:eu:2000000001:tenant&login_hint=max',
            $token->getRedirectUrl()
        );
        $this->assertEquals('testLocal1', $token->getClientId());
        $this->assertEquals('test_request_id', $token->getRequestId());
        $this->assertEquals(['offline', 'openid', 'hydra.*'], $token->getScopes());
        $token->setTenantSRN('srn:cloud:idp:eu:3000000001:tenant');
        $this->assertEquals('srn:cloud:idp:eu:3000000001:tenant', $token->getTenantSRN());
    }

    public function testFillByConsentRequestNoTenant()
    {
        $token = (new ConsentToken())->fillByConsentRequestData([
            'id' => 'test_request_id',
            'requestedScopes' => ['offline', 'openid', 'hydra.*'],
            'clientId' => 'testLocal1',
            'redirectUrl' => 'http://test/',
        ]);
        $this->assertNull($token->getTenantSRN());
    }
}
