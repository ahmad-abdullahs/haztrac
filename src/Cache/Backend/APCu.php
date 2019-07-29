<?php declare(strict_types=1);
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

namespace Sugarcrm\Sugarcrm\Cache\Backend;

use Sugarcrm\Sugarcrm\Cache\Exception;
use Symfony\Component\Cache\Simple\ApcuCache;

/**
 * APCu implementation of the cache backend
 *
 * @link http://pecl.php.net/package/APCu
 */
final class APCu extends ApcuCache
{
    /**
     * @throws Exception
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        parent::__construct();

        if (PHP_SAPI === 'cli' && !ini_get('apc.enable_cli')) {
            throw new Exception('The APCu extension is disabled for CLI');
        }
    }
}
