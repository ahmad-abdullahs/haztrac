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
use Sugarcrm\IdentityProvider\App\Authentication\RevokeAccessTokensService;

class RevokeAccessTokensServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $app): void
    {
        $app['revokeAccessTokensService'] = function ($app) {
            $grpcUserAPI = $app['grpc.userapi'];
            if ($grpcUserAPI) {
                return new RevokeAccessTokensService($grpcUserAPI, $app['logger']);
            }
            return null;
        };
    }
}
