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

namespace Sugarcrm\IdentityProvider\App\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Sugarcrm\IdentityProvider\Authentication\Tenant;
use Sugarcrm\IdentityProvider\Srn\Converter;

class TenantRepository
{
    public const TABLE = 'tenants';

    /**
     * @var Connection
     */
    private $db;

    /**
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $id
     * @return Tenant
     *
     * @throws \RuntimeException
     */
    public function findTenantById(string $id): Tenant
    {
        try {
            $data = $this->db->fetchAssoc(
                sprintf('SELECT * FROM %s WHERE id = ?', self::TABLE),
                [Converter::normalizeTenantId($id)]
            );
        } catch (DBALException $e) {
            throw new \RuntimeException('Tenant not found');
        }


        if (empty($data)) {
            throw new \RuntimeException('Tenant not found');
        }

        return Tenant::fromArray($data);
    }
}
