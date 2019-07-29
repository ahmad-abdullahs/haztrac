<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 SugarCRM Inc. All rights reserved.
//
namespace Sugarcrm\Apis\Iam\Consent\V1alpha;

/**
 * Service that implements the Consent API
 */
class ConsentAPIClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Register consent adds a new consent or updates the existing one.
     * @param \Sugarcrm\Apis\Iam\Consent\V1alpha\RegisterConsentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RegisterConsent(\Sugarcrm\Apis\Iam\Consent\V1alpha\RegisterConsentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.consent.v1alpha.ConsentAPI/RegisterConsent',
        $argument,
        ['\Sugarcrm\Apis\Iam\Consent\V1alpha\Consent', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve consent request for given tenant and application id.
     * @param \Sugarcrm\Apis\Iam\Consent\V1alpha\GetConsentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetConsent(\Sugarcrm\Apis\Iam\Consent\V1alpha\GetConsentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.consent.v1alpha.ConsentAPI/GetConsent',
        $argument,
        ['\Sugarcrm\Apis\Iam\Consent\V1alpha\Consent', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete an existing consent.
     * @param \Sugarcrm\Apis\Iam\Consent\V1alpha\DeleteConsentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteConsent(\Sugarcrm\Apis\Iam\Consent\V1alpha\DeleteConsentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.consent.v1alpha.ConsentAPI/DeleteConsent',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * List available consents for given tenant.
     * @param \Sugarcrm\Apis\Iam\Consent\V1alpha\ListConsentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListConsents(\Sugarcrm\Apis\Iam\Consent\V1alpha\ListConsentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.consent.v1alpha.ConsentAPI/ListConsents',
        $argument,
        ['\Sugarcrm\Apis\Iam\Consent\V1alpha\ListConsentsResponse', 'decode'],
        $metadata, $options);
    }

}
