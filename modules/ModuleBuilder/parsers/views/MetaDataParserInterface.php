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

interface MetaDataParserInterface
{
    /**
     * Saves the layout
     *
     * @param bool $populate Whether the layout should be updated with the information from request
     * @param bool $clearCache
     */
    public function handleSave($populate = true, $clearCache = true);

    public function getLayout () ;

    public function getLanguage () ;

    public function getHistory () ;
}
