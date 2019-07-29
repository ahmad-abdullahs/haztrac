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
use Sugarcrm\IdentityProvider\Srn\Manager;

class SrnManagerServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritdoc
     */
    public function register(Container $app): void
    {
        $app['SrnManager'] = $app->protect(function (string $region) use ($app) {
            if (empty($app['config']['idm']['partition'])) {
                throw new \InvalidArgumentException('Partition MUST be set');
            }
            $managerConfig = [
                'partition' => $app['config']['idm']['partition'],
                'region' => $region,
            ];
            return new Manager($managerConfig);
        });
    }
}
