<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 SugarCRM Inc. All rights reserved.
//
namespace Sugarcrm\Apis\Iam\Sa\V1alpha;

/**
 */
class ServiceAccountAPIClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create a new service account. Service accounts are used for system-to-
     * system communication - aka 2 legged OAuth. Rather than using delegated
     * identities from users, systems represent themselves. Note that the
     * system needs to be able to securely store its secret. A service account
     * can ony get tokens for itself, unless domain wide delegation is granted.
     *
     * Example SRN:
     *  srn:cloud:iam::1234567890:sa:ec99e82d-caa7-407d-b968-985bf740a5a3
     *
     * Hydra Setttings:
     *  - response_type: none
     *  - grant_type: client_credentials
     *  - public: false
     *  - redirect URI: n/a
     * @param \Sugarcrm\Apis\Iam\Sa\V1alpha\CreateServiceAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateServiceAccount(\Sugarcrm\Apis\Iam\Sa\V1alpha\CreateServiceAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.sa.v1alpha.ServiceAccountAPI/CreateServiceAccount',
        $argument,
        ['\Sugarcrm\Apis\Iam\Sa\V1alpha\ServiceAccount', 'decode'],
        $metadata, $options);
    }

    /**
     * Get service account.
     * @param \Sugarcrm\Apis\Iam\Sa\V1alpha\GetServiceAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetServiceAccount(\Sugarcrm\Apis\Iam\Sa\V1alpha\GetServiceAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.sa.v1alpha.ServiceAccountAPI/GetServiceAccount',
        $argument,
        ['\Sugarcrm\Apis\Iam\Sa\V1alpha\ServiceAccount', 'decode'],
        $metadata, $options);
    }

    /**
     * Update existing service account.
     * @param \Sugarcrm\Apis\Iam\Sa\V1alpha\UpdateServiceAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateServiceAccount(\Sugarcrm\Apis\Iam\Sa\V1alpha\UpdateServiceAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.sa.v1alpha.ServiceAccountAPI/UpdateServiceAccount',
        $argument,
        ['\Sugarcrm\Apis\Iam\Sa\V1alpha\ServiceAccount', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete an existing service account.
     * @param \Sugarcrm\Apis\Iam\Sa\V1alpha\DeleteServiceAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteServiceAccount(\Sugarcrm\Apis\Iam\Sa\V1alpha\DeleteServiceAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.sa.v1alpha.ServiceAccountAPI/DeleteServiceAccount',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * List all service accounts.
     * @param \Sugarcrm\Apis\Iam\Sa\V1alpha\ListServiceAccountsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListServiceAccounts(\Sugarcrm\Apis\Iam\Sa\V1alpha\ListServiceAccountsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.sa.v1alpha.ServiceAccountAPI/ListServiceAccounts',
        $argument,
        ['\Sugarcrm\Apis\Iam\Sa\V1alpha\ListServiceAccountsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Regenerate secret for the given service account.
     * @param \Sugarcrm\Apis\Iam\Sa\V1alpha\RegenerateSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RegenerateSecret(\Sugarcrm\Apis\Iam\Sa\V1alpha\RegenerateSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.sa.v1alpha.ServiceAccountAPI/RegenerateSecret',
        $argument,
        ['\Sugarcrm\Apis\Iam\Sa\V1alpha\ServiceAccount', 'decode'],
        $metadata, $options);
    }

}
