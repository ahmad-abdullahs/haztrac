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
 * Abstract class that all data parsers extend from
 * @codeCoverageIgnore
 */
abstract class PMSEAbstractDataParser
{
    /**
     * The criteria token used in evaluations
     * @var stdClass
     */
    protected $criteriaToken;

    /**
     * Sets the criteria token onto this object for use in evaluations
     * @param stdClass $criteriaToken The criteria token being used for evaluation
     */
    public function setCriteriaToken($criteriaToken)
    {
        $this->criteriaToken = $criteriaToken;
    }
}
