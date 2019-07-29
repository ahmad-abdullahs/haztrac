<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 SugarCRM Inc. All rights reserved.
//
namespace Sugarcrm\Apis\Iam\Tenant\V1alpha;

/**
 * Service that implements the Tenant API
 */
class TenantAPIClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create Tenant
     * @param \Sugarcrm\Apis\Iam\Tenant\V1alpha\CreateTenantRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateTenant(\Sugarcrm\Apis\Iam\Tenant\V1alpha\CreateTenantRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.tenant.v1alpha.TenantAPI/CreateTenant',
        $argument,
        ['\Sugarcrm\Apis\Iam\Tenant\V1alpha\Tenant', 'decode'],
        $metadata, $options);
    }

    /**
     * Update an existing Tenant
     * @param \Sugarcrm\Apis\Iam\Tenant\V1alpha\UpdateTenantRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateTenant(\Sugarcrm\Apis\Iam\Tenant\V1alpha\UpdateTenantRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.tenant.v1alpha.TenantAPI/UpdateTenant',
        $argument,
        ['\Sugarcrm\Apis\Iam\Tenant\V1alpha\Tenant', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve a Tenant
     * @param \Sugarcrm\Apis\Iam\Tenant\V1alpha\GetTenantRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTenant(\Sugarcrm\Apis\Iam\Tenant\V1alpha\GetTenantRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.tenant.v1alpha.TenantAPI/GetTenant',
        $argument,
        ['\Sugarcrm\Apis\Iam\Tenant\V1alpha\Tenant', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete Tenant
     * rpc DeleteTenant (DeleteTenantRequest) returns (google.protobuf.Empty) {}
     *
     * List Tenants
     * @param \Sugarcrm\Apis\Iam\Tenant\V1alpha\ListTenantsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListTenants(\Sugarcrm\Apis\Iam\Tenant\V1alpha\ListTenantsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.tenant.v1alpha.TenantAPI/ListTenants',
        $argument,
        ['\Sugarcrm\Apis\Iam\Tenant\V1alpha\ListTenantsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * ChangeStatus endpoint
     * @param \Sugarcrm\Apis\Iam\Tenant\V1alpha\ChangeStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ChangeStatus(\Sugarcrm\Apis\Iam\Tenant\V1alpha\ChangeStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.tenant.v1alpha.TenantAPI/ChangeStatus',
        $argument,
        ['\Sugarcrm\Apis\Iam\Tenant\V1alpha\Tenant', 'decode'],
        $metadata, $options);
    }

}
