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

namespace Sugarcrm\IdentityProvider\Saml2\Response;

use OneLogin\Saml2\LogoutResponse;
use OneLogin\Saml2\Utils;

class LogoutPostResponse extends LogoutResponse
{
    /**
     * last error
     * @var string
     */
    protected $lastError;

    /**
     * @inheritdoc
     */
    public function isValid($requestId = null, $retrieveParametersFromServer = false): bool
    {
        $isValid = parent::isValid($requestId, $retrieveParametersFromServer);

        if (!$isValid) {
            return $isValid;
        }

        $idpData = $this->_settings->getIdPData();
        $securityData = $this->_settings->getSecurityData();
        if (!empty($securityData['wantMessagesSigned'])) {
            try {
                $isValid = Utils::validateSign(
                    $this->document,
                    $idpData['x509cert'],
                    null,
                    null
                );
            } catch (\Exception $e) {
                $this->setLastError($e->getMessage());
                return false;
            }
        }

        return $isValid;
    }

    /**
     * Return SAML response error
     * Only one error(parent or self) can be set at one moment
     * @return string
     */
    public function getError(): string
    {
        return $this->lastError . parent::getError();
    }

    /**
     * set error
     * @param string $lastError
     *
     * @return LogoutPostResponse
     */
    public function setLastError($lastError): LogoutPostResponse
    {
        $this->lastError = $lastError;

        return $this;
    }
}
