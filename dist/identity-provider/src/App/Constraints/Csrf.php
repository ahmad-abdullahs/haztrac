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

namespace Sugarcrm\IdentityProvider\App\Constraints;

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class Csrf extends Assert\All
{
    public const FORM_TOKEN_ID = 'form_token';

    /**
     * Csrf constructor.
     * @param CsrfTokenManagerInterface $tokenManager
     */
    public function __construct(CsrfTokenManagerInterface $tokenManager)
    {
        parent::__construct(['constraints' => [
            new Assert\NotBlank(),
            new Assert\Callback([
                'callback' => [$this, 'checkCsrfToken'],
                'payload' => $tokenManager,
            ]),
        ]]);
    }

    /**
     * Checks if CSRF token is valid
     *
     * @param $value
     * @param ExecutionContextInterface $context
     * @param CsrfTokenManagerInterface $csrfManager
     */
    public function checkCsrfToken($value, ExecutionContextInterface $context, CsrfTokenManagerInterface $csrfManager)
    {
        if (!$csrfManager->isTokenValid(new CsrfToken(self::FORM_TOKEN_ID, $value))) {
            $context->buildViolation('CSRF attack detected.')->addViolation();
        }
    }

    /**
     * @return string
     */
    public function validatedBy()
    {
        return ChainValidator::class;
    }
}
