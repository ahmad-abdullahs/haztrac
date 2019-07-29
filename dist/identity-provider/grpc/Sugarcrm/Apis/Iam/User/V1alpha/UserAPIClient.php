<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 SugarCRM Inc. All rights reserved.
//
namespace Sugarcrm\Apis\Iam\User\V1alpha;

/**
 * Service that implements the User API
 */
class UserAPIClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create User
     * @param \Sugarcrm\Apis\Iam\User\V1alpha\CreateUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateUser(\Sugarcrm\Apis\Iam\User\V1alpha\CreateUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.user.v1alpha.UserAPI/CreateUser',
        $argument,
        ['\Sugarcrm\Apis\Iam\User\V1alpha\User', 'decode'],
        $metadata, $options);
    }

    /**
     * Update an existing User
     * @param \Sugarcrm\Apis\Iam\User\V1alpha\UpdateUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateUser(\Sugarcrm\Apis\Iam\User\V1alpha\UpdateUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.user.v1alpha.UserAPI/UpdateUser',
        $argument,
        ['\Sugarcrm\Apis\Iam\User\V1alpha\User', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve a User
     * @param \Sugarcrm\Apis\Iam\User\V1alpha\GetUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetUser(\Sugarcrm\Apis\Iam\User\V1alpha\GetUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.user.v1alpha.UserAPI/GetUser',
        $argument,
        ['\Sugarcrm\Apis\Iam\User\V1alpha\User', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a User
     * @param \Sugarcrm\Apis\Iam\User\V1alpha\DeleteUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteUser(\Sugarcrm\Apis\Iam\User\V1alpha\DeleteUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.user.v1alpha.UserAPI/DeleteUser',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * List Users
     * @param \Sugarcrm\Apis\Iam\User\V1alpha\ListUsersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListUsers(\Sugarcrm\Apis\Iam\User\V1alpha\ListUsersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.user.v1alpha.UserAPI/ListUsers',
        $argument,
        ['\Sugarcrm\Apis\Iam\User\V1alpha\ListUsersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Set the password for an existing User
     * This is only applicable for local users.
     * @param \Sugarcrm\Apis\Iam\User\V1alpha\SetPasswordRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SetPassword(\Sugarcrm\Apis\Iam\User\V1alpha\SetPasswordRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.user.v1alpha.UserAPI/SetPassword',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Generate the password reset link for an existing User
     * This is only applicable for local users.
     * @param \Sugarcrm\Apis\Iam\User\V1alpha\GeneratePasswordResetLinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GeneratePasswordResetLink(\Sugarcrm\Apis\Iam\User\V1alpha\GeneratePasswordResetLinkRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.user.v1alpha.UserAPI/GeneratePasswordResetLink',
        $argument,
        ['\Sugarcrm\Apis\Iam\User\V1alpha\GeneratePasswordResetLinkResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Send the email with one-time token to a specific User with a link for resetting password.
     * This is only applicable for local users.
     * @param \Sugarcrm\Apis\Iam\User\V1alpha\SendEmailForResetPasswordRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SendEmailForResetPassword(\Sugarcrm\Apis\Iam\User\V1alpha\SendEmailForResetPasswordRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.user.v1alpha.UserAPI/SendEmailForResetPassword',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Found duplicates in identity values list and returns them
     * @param \Sugarcrm\Apis\Iam\User\V1alpha\DuplicateUserCheckRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DuplicateUserCheck(\Sugarcrm\Apis\Iam\User\V1alpha\DuplicateUserCheckRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.user.v1alpha.UserAPI/DuplicateUserCheck',
        $argument,
        ['\Sugarcrm\Apis\Iam\User\V1alpha\DuplicateUserCheckResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Revoke access tokens
     * @param \Sugarcrm\Apis\Iam\User\V1alpha\RevokeTokensRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RevokeAccessTokens(\Sugarcrm\Apis\Iam\User\V1alpha\RevokeTokensRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.user.v1alpha.UserAPI/RevokeAccessTokens',
        $argument,
        ['\Sugarcrm\Apis\Rpc\Status', 'decode'],
        $metadata, $options);
    }

}
