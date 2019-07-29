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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Twig;

use Sugarcrm\IdentityProvider\App\Application;

use Sugarcrm\IdentityProvider\App\Repository\TenantRepository;
use Sugarcrm\IdentityProvider\App\Twig\Extension;
use Sugarcrm\IdentityProvider\App\Twig\Functions\Tenant as TenantFunction;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\Translator;

/**
 * Class ExtensionTest
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Twig\Extension
 */
class ExtensionTest extends \PHPUnit_Framework_TestCase
{
    private const CONFIG = [
        'recaptcha' => [
            'sitekey' => 'sitekey',
        ],
        'honeypot' => [
            'name' => 'first_name',
        ],
        'locales' => [
            'en-US' => 'English (US)',
        ],
    ];

    /**
     * @var Application|\PHPUnit_Framework_MockObject_MockObject
     */
    private $app;

    /**
     * @var Translator|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $translator;


    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->translator = $this->createMock(Translator::class);

        $this->app = $this->createMock(Application::class);

        $this->app->expects($this->any())->method('getTranslator')->willReturn($this->translator);

        $this->app->method('getSession')->willReturn(
            $this->createMock(Session::class)
        );
        $this->app->method('getTenantRepository')->willReturn(
            $this->createMock(TenantRepository::class)
        );
        $this->app->method('getConfig')->willReturn(self::CONFIG);
    }

    /**
     * @covers ::getFunctions
     */
    public function testGetFunctions()
    {
        $extension = new Extension($this->app);

        $actual = false;
        foreach ($extension->getFunctions() as $function) {
            if (is_object($function) && $function instanceof TenantFunction) {
                $actual = true;
                break;
            }
        }

        $this->assertTrue($actual);
    }

    /**
     * @covers ::getGlobals
     */
    public function testGetGlobals()
    {
        $extension = new Extension($this->app);

        $this->assertArrayHasKey('recaptcha_sitekey', $extension->getGlobals());
    }

    /**
     * @covers ::translateArray
     */
    public function testTranslateArrayString()
    {
        $extension = new Extension($this->app);
        $this->translator->expects($this->once())->method('trans')->with('string1')->willReturn('de.string1');
        $this->assertEquals('de.string1', $extension->translateArray('string1'));
    }

    /**
     * @covers ::translateArray
     */
    public function testTranslateArray()
    {
        $extension = new Extension($this->app);
        $this->translator->expects($this->exactly(2))
            ->method('trans')
            ->withConsecutive(['string1'], ['string2'])
            ->willReturnOnConsecutiveCalls('de.string1', 'de.string2');

        $this->assertEquals(['de.string1', 'de.string2'], $extension->translateArray(['string1', 'string2']));
    }
}
