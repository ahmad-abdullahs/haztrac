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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Controller;

use OneLogin\Saml2\Error;
use OneLogin\Saml2\Settings;
use Psr\Log\LoggerInterface;
use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Controller\SAMLController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\Translator;

class FailedMetadataSAMLControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SAMLController|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $controller;

    /**
     * @var Request|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $settings;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $generator;

    /**
     * @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $logger;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $application;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->controller = $this->getMockBuilder(SAMLController::class)
            ->setMethods(['getSamlSettings'])
            ->getMock();
        $this->settings = $this->getMockBuilder(Settings::class)
            ->disableOriginalConstructor()
            ->setMethods(['getSPMetadata', 'validateMetadata'])
            ->getMock();
        $this->controller->expects($this->any())
            ->method('getSamlSettings')
            ->willReturn($this->settings);

        $this->generator = $this->createMock(UrlGeneratorInterface::class);
        $this->generator->expects($this->any())
            ->method('generate')
            ->willReturn('test');

        $this->logger = $this->getMockBuilder(LoggerInterface::class)
            ->setMethods(['error'])
            ->getMockForAbstractClass();

        $this->application = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'getUrlGeneratorService',
                'offsetGet',
                'offsetExists',
                'redirect',
                'getLogger',
                'getTranslator'
            ])
            ->getMock();

        $this->application->expects($this->any())
            ->method('getUrlGeneratorService')
            ->willReturn($this->generator);

        $this->application->expects($this->any())
            ->method('offsetExists')
            ->willReturn(true);

        $this->application->expects($this->any())
            ->method('getLogger')
            ->willReturn($this->logger);

        $this->application->expects($this->any())
            ->method('getTranslator')
            ->willReturn($this->translator = new Translator('en'));

        $this->request = $this->createMock(Request::class);
    }

    public function testMetadataActionNoConfig()
    {
        $this->application->expects($this->once())
            ->method('offsetGet')
            ->with($this->equalTo('config'))
            ->willReturn([]);

        $this->application->expects($this->once())
            ->method('redirect')
            ->with($this->equalTo('test'))
            ->willReturn(true);

        $this->settings->expects($this->never())
            ->method('getSPMetadata')
            ->willReturn([]);

        $this->settings->expects($this->never())
            ->method('validateMetadata')
            ->willReturn([]);

        $this->logger->expects($this->once())
            ->method('error')
            ->with('Invalid SAML configuration');

        $this->assertTrue($this->controller->metadataAction($this->application, $this->request));
    }

    public function testMetadataActionWrongConfig()
    {
        $config = ['saml' => ['test']];
        $this->application->expects($this->once())
            ->method('offsetGet')
            ->with($this->equalTo('config'))
            ->willReturn($config);

        $this->application->expects($this->once())
            ->method('redirect')
            ->with($this->equalTo('test'))
            ->willReturn(true);

        $this->settings->expects($this->once())
            ->method('getSPMetadata')
            ->willThrowException(new Error('test'));

        $this->settings->expects($this->never())
            ->method('validateMetadata')
            ->willReturn(['test']);

        $this->logger->expects($this->once())
            ->method('error')
            ->with('test');

        $this->assertTrue($this->controller->metadataAction($this->application, $this->request));
    }

    public function testMetadataActionValidateErrors()
    {
        $config = ['saml' => ['test']];
        $this->application->expects($this->once())
            ->method('offsetGet')
            ->with($this->equalTo('config'))
            ->willReturn($config);

        $this->application->expects($this->once())
            ->method('redirect')
            ->with($this->equalTo('test'))
            ->willReturn(true);

        $this->settings->expects($this->once())
            ->method('getSPMetadata')
            ->willReturn('test');

        $this->settings->expects($this->once())
            ->method('validateMetadata')
            ->willReturn(['test']);

        $this->logger->expects($this->once())
            ->method('error')
            ->with('SAML metadata validation failed: test');

        $this->assertTrue($this->controller->metadataAction($this->application, $this->request));
    }
}
