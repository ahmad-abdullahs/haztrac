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

/**
 * Exports a Business Process Management Business Ruleset
 *
 * @package PMSE
 * @codeCoverageIgnore
 */
class PMSEBusinessRuleExporter extends PMSEExporter
{
    /**
     * @inheritDoc
     */
    protected $beanModule = 'pmse_Business_Rules';

    /**
     * @inheritDoc
     */
    protected $uid = 'id';

    /**
     * @inheritDoc
     */
    protected $name = 'name';

    /**
     * @inheritDoc
     */
    protected $extension = 'pbr';
}
