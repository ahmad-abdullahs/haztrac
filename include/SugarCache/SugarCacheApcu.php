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

use Sugarcrm\Sugarcrm\Cache\Backend\APCu;

/**
 * APCu cache backend
 *
 * @deprecated Use Sugarcrm\Sugarcrm\Cache\Backend\APCu instead
 */
class SugarCacheApcu extends SugarCachePsr
{
    public function __construct()
    {
        parent::__construct(APCu::class, 935, 'external_cache_disabled_apcu');
    }
}
