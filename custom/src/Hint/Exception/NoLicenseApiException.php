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
namespace Sugarcrm\Sugarcrm\custom\Hint\Exception;

/**
 * This action is not allowed for this user due to missing Hint license
 */
class NoLicenseApiException extends \SugarApiException
{
    public $httpCode = 402;
    public $errorLabel = 'no_license';
    public $messageLabel = 'EXCEPTION_NO_LICENSE';
}
