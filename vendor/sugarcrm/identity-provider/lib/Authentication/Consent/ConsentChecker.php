<?php

namespace Sugarcrm\IdentityProvider\Authentication\Consent;

use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentTokenInterface;
use Sugarcrm\IdentityProvider\Authentication\Consent;

class ConsentChecker
{
    /**
     * @var Consent
     */
    protected $consent;

    /**
     * @var ConsentTokenInterface
     */
    protected $token;

    /**
     * @param Consent $consent
     * @param ConsentTokenInterface $token
     */
    public function __construct(Consent $consent, ConsentTokenInterface $token)
    {
        $this->consent = $consent;
        $this->token = $token;
    }

    /**
     * check token consent
     * @return bool
     */
    public function check(): bool
    {
        $restrictedScopes = array_diff($this->token->getScopes(), $this->consent->getScopes());
        return empty($restrictedScopes) || $this->areScopesEmpty();
    }

    /**
     * Are scopes empty?
     * @return bool
     */
    public function areScopesEmpty(): bool
    {
        $scopes = $this->token->getScopes();
        return empty($scopes) || (count($scopes) == 1 && empty($scopes[0]));
    }
}
