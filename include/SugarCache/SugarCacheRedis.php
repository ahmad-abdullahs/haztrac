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

use Sugarcrm\Sugarcrm\Cache\Backend\Redis;

/**
 * Redis SugarCache backend, using the PHP Redis C library at http://github.com/nicolasff/phpredis
 *
 * @deprecated Use Sugarcrm\Sugarcrm\Cache\Backend\Redis instead
 */
class SugarCacheRedis extends SugarCachePsr
{
    public function __construct()
    {
        parent::__construct(Redis::class, 920, 'external_cache_disabled_redis');
    }
}
