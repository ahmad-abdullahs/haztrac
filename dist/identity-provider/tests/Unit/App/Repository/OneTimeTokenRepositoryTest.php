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
use Sugarcrm\IdentityProvider\App\Repository\OneTimeTokenRepository;
use Sugarcrm\IdentityProvider\Authentication\OneTimeToken;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Repository\OneTimeTokenRepository
 */
class OneTimeTokenRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Connection | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $db;

    /**
     * @var OneTimeTokenRepository
     */
    protected $repository;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->db = $this->createMock(Connection::class);
        $this->repository = new OneTimeTokenRepository($this->db);
    }

    /**
     * @expectedException \RuntimeException
     *
     * @covers ::findUserByTokenAndTenant()
     */
    public function testFindUserByTokenAndTenantTokenNotFound(): void
    {
        $this->db->expects($this->once())->method('fetchAssoc')->with(
            'SELECT * FROM one_time_token WHERE token = ? and tenant_id = ? AND expire_time > NOW()',
            ['token', '0000000001']
        )->willReturn([]);

        $this->repository->findUserByTokenAndTenant('token', '0000000001');
    }

    /**
     * @expectedException \RuntimeException
     *
     * @covers ::findUserByTokenAndTenant()
     */
    public function testFindUserByTokenAndTenantDbError(): void
    {
        $this->db->expects($this->once())->method('fetchAssoc')->with(
            'SELECT * FROM one_time_token WHERE token = ? and tenant_id = ? AND expire_time > NOW()',
            ['token', '0000000001']
        )->willThrowException(new DBALException());

        $this->repository->findUserByTokenAndTenant('token', '0000000001');
    }

    /**
     * @covers ::findUserByTokenAndTenant()
     */
    public function testFindUserByTokenAndTenant(): void
    {
        $this->db->expects($this->once())->method('fetchAssoc')->with(
            'SELECT * FROM one_time_token WHERE token = ? and tenant_id = ? AND expire_time > NOW()',
            ['token', '0000000001']
        )->willReturn([
            'token' => 'token',
            'tenant_id' => '0000000001',
            'user_id' => 'userId',
        ]);

        $result = $this->repository->findUserByTokenAndTenant('token', '0000000001');
        $this->assertEquals('token', $result->getToken());
        $this->assertEquals('0000000001', $result->getTenantId());
        $this->assertEquals('userId', $result->getUserId());
    }

    /**
     * @covers ::delete()
     */
    public function testDelete(): void
    {
        $token = (new OneTimeToken())->setToken('token')->setTenantId('0000000001');
        $this->db->expects($this->once())->method('delete')->with(
            'one_time_token',
            ['token' => 'token', 'tenant_id' => '0000000001']
        );

        $this->repository->delete($token);
    }
}
