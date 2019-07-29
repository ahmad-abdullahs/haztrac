<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 SugarCRM Inc. All rights reserved.
//
namespace Sugarcrm\Apis\Iam\App\V1alpha;

/**
 */
class AppAPIClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new server side application (type = web). Server side apps are
     * required to use the 3 legged OAuth2 authorization code flow and are also
     * allowed to request and use refresh tokens. Server side apps are usually
     * web server (backend) based systems which can securily store their client
     * secret. When refresh tokens are used, those systems also need to be able
     * to securely store the refresh tokens.
     *
     * Server side apps can use any https://* redirect URI and additionally
     * http://localhost.
     *
     * As a web client can securely prove its identity using the secret, once
     * consent has been granted no additional consent will show up unless
     * additional scopes are being requested or the consent is revoked.
     *
     * Example SRN:
     *  srn:cloud:iam::1234567890:app:web:ec99e82d-caa7-407d-b968-985bf740a5a3
     *
     * Hydra setttings:
     *  - response_type: code, id_token
     *  - grant_type: authorization_code, refresh_token
     *  - public: false
     *  - redirect URI:
     *      - only https://
     *      - http://localhost
     * @param \Sugarcrm\Apis\Iam\App\V1alpha\CreateWebAppRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateWebApp(\Sugarcrm\Apis\Iam\App\V1alpha\CreateWebAppRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.app.v1alpha.AppAPI/CreateWebApp',
        $argument,
        ['\Sugarcrm\Apis\Iam\App\V1alpha\App', 'decode'],
        $metadata, $options);
    }

    /**
     * Registers a new client side application (type = web). Client side apss
     * are typical JScript based application which cannot securely store a
     * secret (this includes Single Page Applications). Client side apps are
     * required to use the 3 legged OAuth2 authorization code flow (without
     * using a secret), however they cannot request refresh tokens.
     *
     * We do not support the so called "implicit" flow because of the fairly
     * insecure way how it is designed. Using the authorization code flow for
     * client side apps is more robust than the pure implicit flow.
     *
     * Client side apps can only register https://* based URL's excluding
     * localhost and the usage of IP addresses.
     *
     * !!! We should only implement/allow this client type when we have
     * !!! proper JScript origin checks. If this is not the case, our only
     * !!! option is to show the user consent screen on every 3LO flow just
     * !!! like we do for native clients which is less convenient as this
     * !!! makes it impossible to get new access tokens in a silent manner.
     *
     * Example SRN:
     *  srn:cloud:iam::1234567890:app:ua:ec99e82d-caa7-407d-b968-985bf740a5a3
     *
     * Setttings:
     *  - response_type: code, id_token
     *  - grant_type: authorization_code
     *  - public: true
     *  - redirect URI:
     *      - only https:// (no localhost, no ip addresses)
     * @param \Sugarcrm\Apis\Iam\App\V1alpha\CreateUserAgentAppRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateUserAgentApp(\Sugarcrm\Apis\Iam\App\V1alpha\CreateUserAgentAppRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.app.v1alpha.AppAPI/CreateUserAgentApp',
        $argument,
        ['\Sugarcrm\Apis\Iam\App\V1alpha\App', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new native application (type = native). Native apps do not
     * have a client secret and are required to use the 3 legged OAuth
     * authorization code flow. Optionally they can request refresh tokens
     * if they can securely store them on their native environment.
     *
     * Native applications are typical mobile and desktop applications. Only
     * custom URI schems or URLs using http://localhost are allowed.
     *
     * A consent screen will always be shown to the end-user even when an
     * administrator consented the client already. We need to rely on the user
     * to confirm that the client identity used is coming from the related
     * application in use.
     *
     * Example SRN:
     *  srn:cloud:iam::1234567890:app:native:ec99e82d-caa7-407d-b968-985bf740a5a3
     *
     * Setttings:
     *  - response_type: code, id_token
     *  - grant_type: authorization_code, refresh_token
     *  - public: true
     *  - redirect URI:
     *      - http://localhost
     * @param \Sugarcrm\Apis\Iam\App\V1alpha\CreateNativeAppRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateNativeApp(\Sugarcrm\Apis\Iam\App\V1alpha\CreateNativeAppRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.app.v1alpha.AppAPI/CreateNativeApp',
        $argument,
        ['\Sugarcrm\Apis\Iam\App\V1alpha\App', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new CRM application.
     *
     * A CRM application is in essence a regular web application and service
     * account combined. Besides having a specific configuration we also want
     * to be able to identity them as such as they are effectively services,
     * albeit not multitenant. A CRM application always has a region. For non-
     * cloud instances, use the "onpremise" region.
     *
     * Example SRN:
     *  srn:cloud:iam:us-east-1:1234567890:app:crm:ec99e82d-caa7-407d-b968-985bf740a5a3
     * @param \Sugarcrm\Apis\Iam\App\V1alpha\CreateCrmAppRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateCrmApp(\Sugarcrm\Apis\Iam\App\V1alpha\CreateCrmAppRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.app.v1alpha.AppAPI/CreateCrmApp',
        $argument,
        ['\Sugarcrm\Apis\Iam\App\V1alpha\CreateCrmAppResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get application details. See the App object properties to learn which
     * values are returned. Note that a secret is only returned on creation
     * time and cannot be retrieved later on.
     * @param \Sugarcrm\Apis\Iam\App\V1alpha\GetAppRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetApp(\Sugarcrm\Apis\Iam\App\V1alpha\GetAppRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.app.v1alpha.AppAPI/GetApp',
        $argument,
        ['\Sugarcrm\Apis\Iam\App\V1alpha\App', 'decode'],
        $metadata, $options);
    }

    /**
     * Update existing application. See the App object properties which fields
     * can be updated and which are read-only.
     * @param \Sugarcrm\Apis\Iam\App\V1alpha\UpdateAppRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateApp(\Sugarcrm\Apis\Iam\App\V1alpha\UpdateAppRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.app.v1alpha.AppAPI/UpdateApp',
        $argument,
        ['\Sugarcrm\Apis\Iam\App\V1alpha\App', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete an existing application.
     * @param \Sugarcrm\Apis\Iam\App\V1alpha\DeleteAppRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteApp(\Sugarcrm\Apis\Iam\App\V1alpha\DeleteAppRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.app.v1alpha.AppAPI/DeleteApp',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * List all registered applications.
     * @param \Sugarcrm\Apis\Iam\App\V1alpha\ListAppsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListApps(\Sugarcrm\Apis\Iam\App\V1alpha\ListAppsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.app.v1alpha.AppAPI/ListApps',
        $argument,
        ['\Sugarcrm\Apis\Iam\App\V1alpha\ListAppsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Regenerate secret for the given application.
     * @param \Sugarcrm\Apis\Iam\App\V1alpha\RegenerateSecretRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RegenerateSecret(\Sugarcrm\Apis\Iam\App\V1alpha\RegenerateSecretRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.app.v1alpha.AppAPI/RegenerateSecret',
        $argument,
        ['\Sugarcrm\Apis\Iam\App\V1alpha\App', 'decode'],
        $metadata, $options);
    }

}
