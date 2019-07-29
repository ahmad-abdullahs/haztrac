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
use Sugarcrm\IdentityProvider\App\Entity\UserProvider;
use Sugarcrm\IdentityProvider\Authentication\Provider\Providers;
use Sugarcrm\IdentityProvider\Srn\Converter;

/**
 * Class UserProvidersRepository
 * @package Sugarcrm\IdentityProvider\App\Repository
 */
class UserProvidersRepository
{
    public const TABLE = 'user_providers';

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
     * @param string $tenantId
     * @param string $identityValue
     * @return UserProvider
     */
    public function findLocalByTenantAndIdentity(string $tenantId, string $identityValue): UserProvider
    {
        try {
            $data = $this->db->fetchAssoc(
                sprintf(
                    'SELECT * FROM %s WHERE tenant_id = ? AND provider_code = ? AND identity_value = ?',
                    self::TABLE
                ),
                [Converter::normalizeTenantId($tenantId), Providers::LOCAL, $identityValue]
            );
        } catch (DBALException $e) {
            throw new \RuntimeException('User not found');
        }


        if (empty($data)) {
            throw new \RuntimeException('User not found');
        }

        return UserProvider::fromArray($data);
    }
}
