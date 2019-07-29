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
 * Imports a record of encrypted file.
 *
 * This class extends the class ADAMImporter to import
 * records to an encrypted file BPMEmailTemplate table.
 * @package PMSE
 * @codeCoverageIgnore
 */
class PMSEEmailTemplateImporter extends PMSEImporter
{
    /**
     * @inheritDoc
     */
    protected $beanModule = 'pmse_Emails_Templates';

    /**
     * @inheritDoc
     */
    protected $id = 'id';

    /**
     * @inheritDoc
     */
    protected $name = 'name';

    /**
     * @inheritDoc
     */
    protected $suffix = '';

    /**
     * @inheritDoc
     */
    protected $extension = 'pet';

    /**
     * @inheritDoc
     */
    protected $module = 'base_module';
}
