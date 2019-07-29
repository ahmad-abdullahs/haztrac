<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 SugarCRM Inc. All rights reserved.
//
namespace Sugarcrm\Apis\Iam\Usersync\V1alpha;

/**
 */
class UserSyncServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * UserMessages service only can receive user messages, processes it and push rto queue
     * @param \Sugarcrm\Apis\Iam\Usersync\V1alpha\PushUserRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PushUser(\Sugarcrm\Apis\Iam\Usersync\V1alpha\PushUserRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/sugarcrm.apis.iam.usersync.v1alpha.UserSyncService/PushUser',
        $argument,
        ['\Sugarcrm\Apis\Rpc\Status', 'decode'],
        $metadata, $options);
    }

}
