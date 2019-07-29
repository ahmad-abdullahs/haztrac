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

namespace Sugarcrm\IdentityProvider\Srn;

/**
 * Simple operations with srn.
 */
class Manager
{
    const USERS_SERVICE = 'iam';

    // Resource types
    const RESOURCE_TYPE_APPLICATION = 'app';

    // Application types
    const APPLICATION_TYPE_WEB = 'web';
    const APPLICATION_TYPE_NATIVE = 'native';
    const APPLICATION_TYPE_USER_AGENT = 'ua';
    const APPLICATION_TYPE_CRM = 'crm';

    /**
     * @var array
     */
    protected $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        if (empty($config['partition'])) {
            throw new \InvalidArgumentException('Partition MUST be set');
        }

        if (empty($config['region'])) {
            $config['region'] = '';
        }

        $this->config = $config;
    }

    /**
     * Create User Srn based on Srn prototype.
     *
     * @param string $tenantId Tenant id
     * @param string $userId
     * @return Srn
     */
    public function createUserSrn($tenantId, $userId)
    {
        $srn = new Srn();
        return $srn->setPartition($this->config['partition'])
            ->setService(static::USERS_SERVICE)
            ->setRegion('')
            ->setTenantId($tenantId)
            ->setResource(['user', $userId]);
    }

    /**
     * Create tenant SRN based on SRN prototype.
     *
     * @param string $tenantId Tenant id
     * @return Srn
     */
    public function createTenantSrn($tenantId)
    {
        $srn = new Srn();
        return $srn->setPartition($this->config['partition'])
            ->setService(static::USERS_SERVICE)
            ->setRegion($this->config['region'])
            ->setTenantId($tenantId)
            ->setResource(['tenant']);
    }

    /**
     * Checks whether the given srn belong to web application.
     *
     * @param Srn $srn
     * @return bool
     */
    public static function isWeb(Srn $srn): bool
    {
        return $srn->getResource()[0] === self::RESOURCE_TYPE_APPLICATION
            && $srn->getResource()[1] === self::APPLICATION_TYPE_WEB;
    }

    /**
     * Checks whether the given srn belong to crm application.
     *
     * @param Srn $srn
     * @return bool
     */
    public static function isCrm(Srn $srn): bool
    {
        return $srn->getResource()[0] === self::RESOURCE_TYPE_APPLICATION
            && $srn->getResource()[1] === self::APPLICATION_TYPE_CRM;
    }
}
