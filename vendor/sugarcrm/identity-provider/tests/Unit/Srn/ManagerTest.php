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

namespace Sugarcrm\IdentityProvider\Tests\Unit\Srn;

use Sugarcrm\IdentityProvider\Srn\Manager;
use Sugarcrm\IdentityProvider\Srn\Converter;

/**
 * @coversDefaultClass Sugarcrm\IdentityProvider\Srn\Manager
 */
class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::createUserSrn
     */
    public function testCreateUserSrnWithoutRegion(): void
    {
        $config = [
            'partition' => 'cluster',
        ];

        $srnManager = new Manager($config);
        $userSrn = $srnManager->createUserSrn('0000000001', 'userId');
        $this->assertEquals('cluster', $userSrn->getPartition());
        $this->assertEquals('iam', $userSrn->getService());
        $this->assertEquals('', $userSrn->getRegion());
        $this->assertEquals('0000000001', $userSrn->getTenantId());
        $this->assertEquals(['user', 'userId'], $userSrn->getResource());
    }

    /**
     * @covers ::createUserSrn
     */
    public function testCreateUserSrnWithRegion(): void
    {
        $config = [
            'partition' => 'cluster',
            'region' => 'by',
        ];

        $srnManager = new Manager($config);
        $userSrn = $srnManager->createUserSrn('0000000001', 'userId');
        $this->assertEquals('cluster', $userSrn->getPartition());
        $this->assertEquals('iam', $userSrn->getService());
        $this->assertEquals('', $userSrn->getRegion());
        $this->assertEquals('0000000001', $userSrn->getTenantId());
        $this->assertEquals(['user', 'userId'], $userSrn->getResource());
    }

    /**
     * Provides data for testCreateManagerWithInvalidConfig
     * @return array
     */
    public function createManagerWithInvalidConfigProvider()
    {
        return [
            [
                'emptyConfig' => [],
            ],
            [
                'noPartition' => [
                    'region' => 'by',
                ],
            ],
        ];
    }

    /**
     * @param array $config
     *
     * @expectedException \InvalidArgumentException
     * @dataProvider createManagerWithInvalidConfigProvider
     */
    public function testCreateManagerWithInvalidConfig(array $config)
    {
        new Manager($config);
    }

    /**
     * @see testIsWeb
     * @see testIsCrm
     * @return array
     */
    public function SRNCheckVariants(): array
    {
        return [
            'crm' => [
                'srn' => 'srn:dev:iam:na:0000000001:app:crm:bd0f3e90-9570-47c9-bb11-6233225ee099',
                'isWeb' => false,
                'isCrm' => true,
            ],
            'web' => [
                'srn' => 'srn:dev:iam:na:0000000002:app:web:f7cf6d39-f557-4feb-b088-e0eb3fb55af8',
                'isWeb' => true,
                'isCrm' => false,
            ],
            'native' => [
                'srn' => 'srn:dev:iam:na:0000000002:app:native:f7cf6d39-f557-4b-b088-e0eb3fb55af8',
                'isWeb' => false,
                'isCrm' => false,
            ],
            'sa' => [
                'srn' => 'srn:dev:iam:na:0000000002:sa:f7cf6d39-f557-4b-b088-e0eb3fb55af8',
                'isWeb' => false,
                'isCrm' => false,
            ],
        ];
    }

    /**
     * @dataProvider SRNCheckVariants
     * @covers ::isWeb
     *
     * @param string $srn
     * @param bool $isWeb
     * @param bool $isCrm
     */
    public function testIsWeb(string $srn, bool $isWeb, bool $isCrm): void
    {
        $this->assertEquals($isWeb, Manager::isWeb(Converter::fromString($srn)));
    }

    /**
     * @dataProvider SRNCheckVariants
     * @covers ::isCrm
     *
     * @param string $srn
     * @param bool $isWeb
     * @param bool $isCrm
     */
    public function testIsCrm(string $srn, bool $isWeb, bool $isCrm): void
    {
        $this->assertEquals($isCrm, Manager::isCrm(Converter::fromString($srn)));
    }
}
