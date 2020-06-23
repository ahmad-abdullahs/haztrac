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

class RelatedValueIfExistExpression extends GenericExpression {

    /**
     * Returns the opreation name that this Expression should be
     * called by.
     */
    public static function getOperationName() {
        return array("relatedValueIfExist");
    }

    public function evaluate() {
        $params = $this->getParameters();
        // This should be of relate type, which means an array of SugarBean objects
        $linkField = $params[0]->evaluate();
        $relfield = $params[1]->evaluate();
        $ret = '';

        //if the field or relationship isn't defined, bail
        if (!is_array($linkField) || empty($linkField)) {
            return '';
        }

        // Loop through all the beans and put the value if its not empty
        foreach ($linkField as $bean) {
            if (isset($bean->$relfield)) {
                if (!empty($bean->$relfield)) {
                    $ret = !empty($bean->$relfield) ? $bean->$relfield : $ret;
                }
            } else {
                continue;
            }
        }

        return $ret;
    }

    //todo: javascript version here
    /**
     * Returns the JS Equivalent of the evaluate function.
     */
    public static function getJSEvaluate() {
        return "";
    }

    /**
     * The first parameter is a link and the second is a string.
     */
    public static function getParameterTypes() {
        return array(AbstractExpression::$RELATE_TYPE, AbstractExpression::$STRING_TYPE);
    }

}
