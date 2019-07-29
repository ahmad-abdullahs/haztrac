<?php

namespace Sugarcrm\IdentityProvider\Tests\Unit\Authentication;

use Sugarcrm\IdentityProvider\Authentication\Tenant;
use Sugarcrm\IdentityProvider\Srn\Srn;

class TenantTest extends \PHPUnit_Framework_TestCase
{
    public function testSetAndGet()
    {
        $tenant = Tenant::fromArray([
            'id' => $id = '1234567890',
            'region' => $region = 'us',
            'display_name' => $displayName = 'solarwind',
            'logo' => $logo = 'some_log',
        ]);

        $this->assertEquals($id, $tenant->getId());
        $this->assertEquals($region, $tenant->getRegion());
        $this->assertEquals($displayName, $tenant->getDisplayName());
        $this->assertEquals($logo, $tenant->getLogo());
        $this->assertEquals(Tenant::STATUS_ACTIVE, $tenant->getStatus());
        $this->assertTrue($tenant->isActive());

        $tenant = Tenant::fromArray([
            'id' => $id = '1234567890',
            'region' => $region = 'us',
            'status' => $status = Tenant::STATUS_INACTIVE,
        ]);

        $this->assertEquals($id, $tenant->getId());
        $this->assertEquals($region, $tenant->getRegion());
        $this->assertEquals('', $tenant->getDisplayName());
        $this->assertEquals('', $tenant->getLogo());
        $this->assertEquals(Tenant::STATUS_INACTIVE, $tenant->getStatus());
        $this->assertFalse($tenant->isActive());

        $tenant = Tenant::new($id = '1234567890', $region = 'us');

        $this->assertEquals($id, $tenant->getId());
        $this->assertEquals($region, $tenant->getRegion());
        $this->assertEquals('', $tenant->getDisplayName());
        $this->assertEquals('', $tenant->getLogo());
        $this->assertEquals(Tenant::STATUS_ACTIVE, $tenant->getStatus());
        $this->assertTrue($tenant->isActive());
    }

    public function testFillBySRN()
    {
        $srn = new Srn();
        $srn->setRegion('eu');
        $srn->setTenantId('1234567890');

        $tenant = Tenant::fromSrn($srn);
        $this->assertEquals('1234567890', $tenant->getId());
        $this->assertEquals('eu', $tenant->getRegion());
    }
}
