<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 SugarCRM Inc. All rights reserved.
//
namespace Sugarcrm\Apis\Iam\Provider\V1alpha;

/**
 * Service that implements the Provider API
 */
class ProviderAPIClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Configure Local User Provider
     * @param \Sugarcrm\Apis\Iam\Provider\V1alpha\ConfigureLocalProviderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ConfigureLocalProvider(\Sugarcrm\Apis\Iam\Provider\V1alpha\ConfigureLocalProviderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.provider.v1alpha.ProviderAPI/ConfigureLocalProvider',
        $argument,
        ['\Sugarcrm\Apis\Iam\Provider\V1alpha\LocalProvider', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Sugarcrm\Apis\Iam\Provider\V1alpha\GetLocalProviderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetLocalProvider(\Sugarcrm\Apis\Iam\Provider\V1alpha\GetLocalProviderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.provider.v1alpha.ProviderAPI/GetLocalProvider',
        $argument,
        ['\Sugarcrm\Apis\Iam\Provider\V1alpha\LocalProvider', 'decode'],
        $metadata, $options);
    }

    /**
     * Configure LDAP Provider
     * @param \Sugarcrm\Apis\Iam\Provider\V1alpha\ConfigureLdapProviderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ConfigureLdapProvider(\Sugarcrm\Apis\Iam\Provider\V1alpha\ConfigureLdapProviderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.provider.v1alpha.ProviderAPI/ConfigureLdapProvider',
        $argument,
        ['\Sugarcrm\Apis\Iam\Provider\V1alpha\LdapProvider', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Sugarcrm\Apis\Iam\Provider\V1alpha\GetLdapProviderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetLdapProvider(\Sugarcrm\Apis\Iam\Provider\V1alpha\GetLdapProviderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.provider.v1alpha.ProviderAPI/GetLdapProvider',
        $argument,
        ['\Sugarcrm\Apis\Iam\Provider\V1alpha\LdapProvider', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Sugarcrm\Apis\Iam\Provider\V1alpha\DeleteLdapProviderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteLdapProvider(\Sugarcrm\Apis\Iam\Provider\V1alpha\DeleteLdapProviderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.provider.v1alpha.ProviderAPI/DeleteLdapProvider',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Configure SAML Provider
     * @param \Sugarcrm\Apis\Iam\Provider\V1alpha\ConfigureSamlProviderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ConfigureSamlProvider(\Sugarcrm\Apis\Iam\Provider\V1alpha\ConfigureSamlProviderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.provider.v1alpha.ProviderAPI/ConfigureSamlProvider',
        $argument,
        ['\Sugarcrm\Apis\Iam\Provider\V1alpha\SamlProvider', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Sugarcrm\Apis\Iam\Provider\V1alpha\GetSamlProviderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetSamlProvider(\Sugarcrm\Apis\Iam\Provider\V1alpha\GetSamlProviderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.provider.v1alpha.ProviderAPI/GetSamlProvider',
        $argument,
        ['\Sugarcrm\Apis\Iam\Provider\V1alpha\SamlProvider', 'decode'],
        $metadata, $options);
    }

    /**
     * @param \Sugarcrm\Apis\Iam\Provider\V1alpha\DeleteSamlProviderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteSamlProvider(\Sugarcrm\Apis\Iam\Provider\V1alpha\DeleteSamlProviderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.provider.v1alpha.ProviderAPI/DeleteSamlProvider',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
