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

namespace Sugarcrm\IdentityProvider\App;

use Doctrine\DBAL\Connection;
use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\AbstractConfigAdapter;
use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\ConfigAdapterFactory;
use Sugarcrm\IdentityProvider\Srn\Srn;
use Sugarcrm\IdentityProvider\Authentication\Tenant;

/**
 * Initialize configuration special for tenant.
 * Class TenantConfiguration
 * @package Sugarcrm\IdentityProvider\App
 */
class TenantConfiguration
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * @var ConfigAdapterFactory
     */
    protected $configAdapterFactory;

    /**
     * TenantConfiguration constructor.
     * @param Connection $db
     * @param ConfigAdapterFactory $configAdapterFactory
     */
    public function __construct(Connection $db, ConfigAdapterFactory $configAdapterFactory)
    {
        $this->db = $db;
        $this->configAdapterFactory = $configAdapterFactory;
    }

    /**
     * Merge tenant configuration with base config.
     * @param Srn $tenant
     * @param array $config
     * @return array
     * @throws \LogicException
     */
    public function merge(Srn $tenant, array $config)
    {
        $tenantConfig = $this->get($tenant);
        return array_replace_recursive($tenantConfig, $config);
    }

    /**
     * Getting tenant config.
     * @param Srn $tenant
     * @return array
     * @throws \LogicException
     */
    protected function get(Srn $tenant)
    {
        if (empty($tenantId = $tenant->getTenantId())) {
            throw new \RuntimeException('Tenant id is empty');
        }

        $qb = $this->db->createQueryBuilder()
            ->select('tenants.providers as enabled_providers, tenants.status, tenant_providers.provider_code, '
                . 'tenant_providers.config, tenant_providers.attribute_map')
            ->from('tenants')
            ->innerJoin(
                'tenants',
                'tenant_providers',
                'tenant_providers',
                'tenant_providers.tenant_id = tenants.id'
            )
            ->andWhere('tenants.id = :tenant_id')
            ->setParameters([
                ':tenant_id' => $tenantId,
            ]);
        $list = $qb->execute()->fetchAll(\PDO::FETCH_ASSOC);

        if (0 == count($list)) {
            throw new \RuntimeException('Tenant not exists or deleted');
        }

        if ($list[0]['status'] != Tenant::STATUS_ACTIVE) {
            throw new \RuntimeException('Tenant isn\'t active');
        }

        return $this->normalize($list);
    }

    /**
     * Normalize config from list presentation.
     *
     * @param $list
     * @return array
     */
    protected function normalize($list)
    {
        $config = ['enabledProviders' => []];
        foreach ($list as $provider) {
            $providerCode = $provider['provider_code'];
            $config['enabledProviders'] = $this->decode($provider['enabled_providers']);
            if (!in_array($providerCode, $config['enabledProviders'])) {
                continue;
            }
            $adapter = $this->configAdapterFactory->getAdapter($providerCode);
            if ($adapter instanceof AbstractConfigAdapter) {
                $config[$providerCode] = $adapter->getConfig($provider['config']);
            } else {
                throw  new \RuntimeException("Unsupported provider: $providerCode");
            }
            if (!empty($provider['attribute_map'])) {
                $config[$providerCode]['user_mapping'] = $this->getAttributeMapping($provider['attribute_map']);
            }
        }
        return $config;
    }

    /**
     * Decodes a JSON string.
     * @param string $encoded
     * @return mixed
     */
    protected function decode($encoded)
    {
        if (empty($encoded)) {
            return [];
        }
        try {
            return \GuzzleHttp\json_decode($encoded, true);
        } catch (\InvalidArgumentException $e) {
            return [];
        }
    }

    /**
     * Decodes attribute mapping
     *
     * @param string $encoded
     * @return array
     */
    private function getAttributeMapping(string $encoded): array
    {
        $list = $this->decode($encoded);
        $out = [];
        foreach ($list as $map) {
            if ($map['overwrite']) {
                $out[$map['source']] = $map['destination'];
            }
        }
        return $out;
    }
}
