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
 * @class View.Fields.Base.FloatField
 * @alias SUGAR.App.view.fields.BaseFloatField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'FloatField',
    format: function (value) {
        var value = this._super('format', [value]);
        // Show actual quantity as empty if its zero...
        if (this.name == 'quantity' && (value == 0 || value == 0.00 || value == '0.00')) {
            return;
        }
        return value;
    }
})
