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
 * @class View.Fields.Base.IframeField
 * @alias SUGAR.App.view.fields.BaseIframeField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'IframeField',
    showButton: false,

    initialize: function (options) {
        this.showButton = false;
        this._super('initialize', [options]);
    },

    format: function (value) {
        if (this.model.attributes.popOutFullViewLink) {
            this.showButton = true;
        }
        return this._super('format', [value]);
    },
})
