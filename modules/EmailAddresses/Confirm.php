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

use Sugarcrm\Sugarcrm\Security\InputValidation\InputValidation;
use Sugarcrm\Sugarcrm\DependencyInjection\Container;
use Sugarcrm\Sugarcrm\Security\Context;
use Sugarcrm\Sugarcrm\Security\Subject\EmailAddressConfirmationLink;

$request = InputValidation::getService();
$id = $request->getValidInputRequest('email_address_id', 'Assert\Guid');

global $current_user, $sugar_config;

// Retrieve admin user so that team queries are bypassed
if (empty($current_user) || empty($current_user->id)) {
    $current_user = BeanFactory::newBean('Users')->getSystemUser();
}

$ea = BeanFactory::retrieveBean('EmailAddresses', $id);
if (!empty($ea)) {
    if ($ea->opt_out) {
        $ea->opt_out = 0;
        $subject = new EmailAddressConfirmationLink($ea);
        $context = Container::getInstance()->get(Context::class);

        try {
            $context->activateSubject($subject);
            $ea->save();
        } finally {
            $context->deactivateSubject($subject);
        }
    }
}

$redirectUrl = '';
if (!empty($sugar_config['email_address_confirmation_redirect_url'])) {
    $redirectUrl = $sugar_config['email_address_confirmation_redirect_url'];
}

if (headers_sent() || empty($redirectUrl) || strlen($redirectUrl) > 2083) {
    @ob_clean();
    ob_start();
    include_once 'modules/EmailAddresses/Confirmed.php';
    $output_html = ob_get_contents();
    ob_end_clean();
    echo $output_html;
    sugar_cleanup(true);
} else {
    header("Location: {$redirectUrl}");
}
