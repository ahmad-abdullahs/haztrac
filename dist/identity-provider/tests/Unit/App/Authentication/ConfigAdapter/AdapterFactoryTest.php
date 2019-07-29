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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Authentication\ConfigAdapter;

use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\ConfigAdapterFactory;
use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\LdapConfigAdapter;
use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\LocalConfigAdapter;
use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\SamlConfigAdapter;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class TenantConfigInitializerTest
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\ConfigAdapterFactory
 */
class ConfigAdapterFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;

    /**
     * @var ConfigAdapterFactory
     */
    protected $configAdapterFactory;

    protected function setUp()
    {
        $this->urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $this->configAdapterFactory = new ConfigAdapterFactory($this->urlGenerator);
    }

    public function getAdapterCodesProvider(): array
    {
        return [
            'saml' => [
                'code' => 'saml',
                'class'=> SamlConfigAdapter::class,
            ],
            'local' => [
                'code' => 'local',
                'class'=> LocalConfigAdapter::class,
            ],
            'ldap' => [
                'code' => 'ldap',
                'class'=> LdapConfigAdapter::class,
            ],
        ];
    }

    /**
     * @covers ::getAdapter
     * @dataProvider getAdapterCodesProvider
     * @param string $code
     * @param string $class
     */
    public function testGetAdapter(string $code, string $class): void
    {
        $adapter = $this->configAdapterFactory->getAdapter($code);
        $this->assertInstanceOf($class, $adapter);
    }

    public function testGetAdapterNotExists()
    {
        $adapter = $this->configAdapterFactory->getAdapter('NotExists');
        $this->assertNull($adapter);
    }
}
