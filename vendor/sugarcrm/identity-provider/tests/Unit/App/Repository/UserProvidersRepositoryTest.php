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
use Doctrine\DBAL\DBALException;
use Sugarcrm\IdentityProvider\App\Repository\UserProvidersRepository;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Repository\UserProvidersRepository
 */
class UserProvidersRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Connection | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $db;

    /**
     * @var UserProvidersRepository
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
        $this->repository = new UserProvidersRepository($this->db);
    }

    /**
     * @expectedException \RuntimeException
     *
     * @covers ::findLocalByTenantAndIdentity
     */
    public function testFindLocalByTenantAndIdentityDbException(): void
    {
        $this->db->expects($this->once())->method('fetchAssoc')->with(
            'SELECT * FROM user_providers WHERE tenant_id = ? AND provider_code = ? AND identity_value = ?',
            ['0000000001', 'local', 'identityValue']
        )->willThrowException(new DBALException());

        $this->repository->findLocalByTenantAndIdentity('1', 'identityValue');
    }

    /**
     * @expectedException \RuntimeException
     *
     * @covers ::findLocalByTenantAndIdentity
     */
    public function testFindLocalByTenantAndIdentityProviderNotFound(): void
    {
        $this->db->expects($this->once())->method('fetchAssoc')->with(
            'SELECT * FROM user_providers WHERE tenant_id = ? AND provider_code = ? AND identity_value = ?',
            ['0000000001', 'local', 'identityValue']
        )->willReturn(null);

        $this->repository->findLocalByTenantAndIdentity('1', 'identityValue');
    }

    /**
     * @covers ::findLocalByTenantAndIdentity
     */
    public function testFindLocalByTenantAndIdentity(): void
    {
        $this->db->expects($this->once())->method('fetchAssoc')->with(
            'SELECT * FROM user_providers WHERE tenant_id = ? AND provider_code = ? AND identity_value = ?',
            ['0000000001', 'local', 'identityValue']
        )->willReturn([
            'tenant_id' => '0000000001',
            'user_id' => 'userId',
            'provider_code' => 'local',
            'identity_value' => 'identityValue',
        ]);

        $userProvider = $this->repository->findLocalByTenantAndIdentity('01', 'identityValue');

        $this->assertEquals('0000000001', $userProvider->getTenantId());
        $this->assertEquals('userId', $userProvider->getUserId());
        $this->assertEquals('identityValue', $userProvider->getIdentityValue());
        $this->assertEquals('local', $userProvider->getProviderCode());
    }
}
