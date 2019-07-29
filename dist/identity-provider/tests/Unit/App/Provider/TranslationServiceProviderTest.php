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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Provider;

use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Provider\TranslationServiceProvider;
use Sugarcrm\IdentityProvider\App\Subscriber\TranslationSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Provider\TranslationServiceProvider
 */
class TranslationServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Application
     */
    protected $application;

    /**
     * set up
     */
    protected function setUp()
    {
        parent::setUp();

        $this->application = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'getRootDir'
            ])
            ->getMock();

        $this->application->expects($this->any())
            ->method('getRootDir')
            ->willReturn(realpath(__DIR__ . '/../../../..'));
    }

    /**
     * @covers ::subscribe
     */
    public function testSubscribe()
    {
        $this->application['translation.subscriber'] = $this->createMock(TranslationSubscriber::class);
        $dispatcher = $this->createMock(EventDispatcherInterface::class);
        $dispatcher->expects($this->once())
            ->method('addSubscriber')
            ->with($this->isInstanceOf(TranslationSubscriber::class));

        $provider = new TranslationServiceProvider(['default' => 'en-US'], 'locale');
        $provider->subscribe($this->application, $dispatcher);
    }

    /**
     * @covers ::register
     * @expectedException \LogicException
     */
    public function testRegisterWithoutDefault()
    {
        new TranslationServiceProvider([], 'locale');
    }

    /**
     * @covers ::register
     * @expectedException \LogicException
     */
    public function testRegister()
    {
        $provider = new TranslationServiceProvider([
            'default' => 'en-US',
        ], 'locale');
        $provider->register($this->application);
        $this->assertInstanceOf(TranslationServiceProvider::class, $this->application->getTranslator());
    }
}
