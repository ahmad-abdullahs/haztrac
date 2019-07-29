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
use Sugarcrm\IdentityProvider\Authentication\OneTimeToken;
use Sugarcrm\IdentityProvider\Srn\Converter;

class OneTimeTokenRepository
{
    private const TABLE = 'one_time_token';

    /**
     * @var Connection
     */
    private $db;

    /**
     * Consent repository constructor.
     *
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $token
     * @param string $tenantId
     * @return OneTimeToken
     * @throws \RuntimeException
     */
    public function findUserByTokenAndTenant(string $token, string $tenantId): OneTimeToken
    {
        try {
            $data = $this->db->fetchAssoc(
                sprintf(
                    'SELECT * FROM %s WHERE token = ? and tenant_id = ? AND expire_time > NOW()',
                    self::TABLE
                ),
                [$token, Converter::normalizeTenantId($tenantId)]
            );
        } catch (DBALException $e) {
            throw new \RuntimeException('One time token not found');
        }


        if (empty($data)) {
            throw new \RuntimeException('One time token not found');
        }

        return (new OneTimeToken())
            ->setToken($data['token'])
            ->setTenantId($data['tenant_id'])
            ->setUserId($data['user_id']);
    }

    /**
     * @param OneTimeToken $token
     * @throws DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function delete(OneTimeToken $token): void
    {
        $this->db->delete(
            self::TABLE,
            ['token' => $token->getToken(), 'tenant_id' => $token->getTenantId()]
        );
    }
}
