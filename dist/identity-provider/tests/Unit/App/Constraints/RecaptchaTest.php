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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App;

use Sugarcrm\IdentityProvider\App\Constraints\Recaptcha;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

/**
 * Class RecaptchaTest
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Constraints\Recaptcha
 */
class RecaptchaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Recaptcha|\PHPUnit_Framework_MockObject_MockObject
     */
    private $recaptcha;

    /**
     * @var ExecutionContextInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $context;


    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->recaptcha = $this->getMockBuilder(Recaptcha::class)
            ->setConstructorArgs(['secret-key'])
            ->setMethods(['verifyAnswer'])
            ->getMock();
        $this->context = $this->createMock(ExecutionContextInterface::class);
    }

    /**
     * @covers ::checkRecaptcha
     */
    public function testCheckRecaptchaValid()
    {
        $this->recaptcha->method('verifyAnswer')->willReturn(['success' => true]);
        $this->recaptcha->expects($this->once())->method('verifyAnswer');

        $this->context->expects($this->never())->method('buildViolation');

        $this->recaptcha->checkRecaptcha('some user response', $this->context);
    }

    /**
     * @covers ::checkRecaptcha
     */
    public function testCheckRecaptchaInvalid()
    {
        $this->recaptcha->method('verifyAnswer')->willReturn([
            'success' => false,
            'error-codes' => ['code1', 'code2'],
        ]);
        $this->recaptcha->expects($this->once())->method('verifyAnswer');

        $violationBuilder = $this->createMock(ConstraintViolationBuilderInterface::class);
        $violationBuilder->expects($this->once())->method('addViolation');

        $this->context->method('buildViolation')->willReturn($violationBuilder);
        $this->context
            ->expects($this->once())
            ->method('buildViolation')
            ->with('Invalid recaptcha response: code1, code2');

        $this->recaptcha->checkRecaptcha('some user response', $this->context);
    }
}
