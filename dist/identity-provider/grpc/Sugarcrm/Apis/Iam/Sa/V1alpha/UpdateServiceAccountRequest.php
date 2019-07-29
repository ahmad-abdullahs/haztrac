<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: apis/iam/sa/v1alpha/sa.proto

namespace Sugarcrm\Apis\Iam\Sa\V1alpha;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>sugarcrm.apis.iam.sa.v1alpha.UpdateServiceAccountRequest</code>
 */
class UpdateServiceAccountRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * The service account to be updated. The name (SRN) is required to be set.
     * Use a `FieldMask` to send partial field list.
     *
     * Generated from protobuf field <code>.sugarcrm.apis.iam.sa.v1alpha.ServiceAccount service_account = 1;</code>
     */
    private $service_account = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Sugarcrm\Apis\Iam\Sa\V1alpha\ServiceAccount $service_account
     *           The service account to be updated. The name (SRN) is required to be set.
     *           Use a `FieldMask` to send partial field list.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Apis\Iam\Sa\V1Alpha\Sa::initOnce();
        parent::__construct($data);
    }

    /**
     * The service account to be updated. The name (SRN) is required to be set.
     * Use a `FieldMask` to send partial field list.
     *
     * Generated from protobuf field <code>.sugarcrm.apis.iam.sa.v1alpha.ServiceAccount service_account = 1;</code>
     * @return \Sugarcrm\Apis\Iam\Sa\V1alpha\ServiceAccount
     */
    public function getServiceAccount()
    {
        return $this->service_account;
    }

    /**
     * The service account to be updated. The name (SRN) is required to be set.
     * Use a `FieldMask` to send partial field list.
     *
     * Generated from protobuf field <code>.sugarcrm.apis.iam.sa.v1alpha.ServiceAccount service_account = 1;</code>
     * @param \Sugarcrm\Apis\Iam\Sa\V1alpha\ServiceAccount $var
     * @return $this
     */
    public function setServiceAccount($var)
    {
        GPBUtil::checkMessage($var, \Sugarcrm\Apis\Iam\Sa\V1alpha\ServiceAccount::class);
        $this->service_account = $var;

        return $this;
    }

}

