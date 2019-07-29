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

use GuzzleHttp;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class Recaptcha extends Assert\All
{
    private const RECAPTCHA_URL = 'https://www.google.com';
    private const URI_VERIFY = 'recaptcha/api/siteverify';

    /**
     * @var string
     */
    private $secretKey;

    /**
     * Recaptcha constructor.
     * @param string $secretKey
     */
    public function __construct(string $secretKey)
    {
        parent::__construct(['constraints' => [
            new Assert\NotBlank(),
            new Assert\Callback(['callback' => [$this, 'checkRecaptcha']]),
        ]]);
        $this->secretKey = $secretKey;
    }

    /**
     * Checks if Recaptcha response is correct
     *
     * @param $value
     * @param ExecutionContextInterface $context
     */
    public function checkRecaptcha($value, ExecutionContextInterface $context)
    {
        $response = $this->verifyAnswer($value);
        if (empty($response['success'])) {
            $context->buildViolation(sprintf(
                'Invalid recaptcha response: %s',
                implode(', ', $response['error-codes'])
            ))->addViolation();
        }
    }

    /**
     * @return string
     */
    public function validatedBy()
    {
        return ChainValidator::class;
    }

    /**
     * @param $answer
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    protected function verifyAnswer($answer): array
    {
        $http = new GuzzleHttp\Client([
            'base_uri' => self::RECAPTCHA_URL,
            'timeout' => 2.0,
        ]);
        $response = $http->post(self::URI_VERIFY, [
            'form_params' => [
                'secret' => $this->secretKey,
                'response' => $answer,
            ]
        ])->getBody();

        return GuzzleHttp\json_decode($response->getContents(), true);
    }
}
