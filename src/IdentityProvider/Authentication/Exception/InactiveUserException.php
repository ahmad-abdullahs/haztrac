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

namespace Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * User with status inactive auth exception
 */
class InactiveUserException extends AuthenticationException
{
    /**
     * @var \User
     */
    protected $user;

    /**
     * InactiveUserException constructor.
     * @param string $message
     * @param int $code
     * @param $previous
     * @param \User|null $user
     */
    public function __construct(string $message = '', int $code = 0, $previous = null, \User $user = null)
    {
        parent::__construct($message, $code, $previous);
        $this->user = $user;
    }

    /**
     * @return \User
     */
    public function getSugarUser(): ?\User
    {
        return $this->user;
    }
}
