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
namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Repository;

use Doctrine\DBAL\Connection;
use Sugarcrm\IdentityProvider\App\Repository\TenantRepository;
use Sugarcrm\IdentityProvider\Authentication\Tenant;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Repository\TenantRepository
 */
class TenantRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Connection | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $db;

    /**
     * @var TenantRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $tenantId = '1';

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->db = $this->createMock(Connection::class);
        $this->repository = new TenantRepository($this->db);
    }

    /**
     * @expectedException \RuntimeException
     *
     * @covers ::findTenantById
     */
    public function testFindTenantByIdTenantNotFound(): void
    {
        $this->db->expects($this->once())->method('fetchAssoc')->with(
            'SELECT * FROM tenants WHERE id = ?',
            ['0000000001']
        )->willReturn([]);

        $this->repository->findTenantById($this->tenantId);
    }

    /**
     * @covers ::findTenantById
     */
    public function testFindTenantByIdTenantFound(): void
    {
        $this->db->expects($this->once())->method('fetchAssoc')->with(
            'SELECT * FROM tenants WHERE id = ?',
            ['0000000001']
        )->willReturn(['id' => '0000000001', 'region' => 'us', 'display_name' => 'Local Test Tenant', 'logo' => null]);

        $tenant = $this->repository->findTenantById($this->tenantId);

        $this->assertEquals('0000000001', $tenant->getId());
        $this->assertEquals('us', $tenant->getRegion());
        $this->assertEquals('Local Test Tenant', $tenant->getDisplayName());
        $this->assertEquals('', $tenant->getLogo());
        $this->assertEquals(Tenant::STATUS_ACTIVE, $tenant->getStatus());
        $this->assertTrue($tenant->isActive());
    }
}
