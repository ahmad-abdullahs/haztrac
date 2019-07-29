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

namespace Sugarcrm\IdentityProvider\App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Sugarcrm\IdentityProvider\App\Repository\ConsentRepository;
use Sugarcrm\IdentityProvider\App\Repository\OneTimeTokenRepository;
use Sugarcrm\IdentityProvider\App\Repository\TenantRepository;
use Sugarcrm\IdentityProvider\App\Repository\UserProvidersRepository;

class RepositoriesProvider implements ServiceProviderInterface
{
    public function register(Container $app): void
    {
        $app['consentRepository'] = function ($app) {
            return new ConsentRepository($app['db']);
        };

        $app['tenantRepository'] = function ($app) {
            return new TenantRepository($app['db']);
        };

        $app['oneTimeTokenRepository'] = function ($app) {
            return new OneTimeTokenRepository($app['db']);
        };

        $app['userProvidersRepository'] = function ($app) {
            return new UserProvidersRepository($app['db']);
        };
    }
}
