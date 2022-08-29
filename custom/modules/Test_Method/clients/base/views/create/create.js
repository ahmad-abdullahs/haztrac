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
({
    extendsFrom: 'CreateView',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    bindDataChange: function () {
        this._super('bindDataChange');

        this.model.on("change:test_name", _.bind(this.setTestMethodName, this, "test_name"), this);
        this.model.on("change:uom", _.bind(this.setTestMethodName, this, "uom"), this);
        this.model.on("change:method", _.bind(this.setTestMethodName, this, "method"), this);
    },

    /*
     * Set the Test Method name as per the format (Test Name | UOM | Method)
     * @param {type} innerFieldName
     * @param {type} model
     * @param {type} value
     * @returns {undefined}
     */
    setTestMethodName: function (innerFieldName, model, value) {
        var name = '';
        // Test Name | UOM | Method
        var test_name = this.model.get('test_name');
        var uom = this.model.get('uom');
        var method = this.model.get('method');

        if (test_name) {
            name = test_name.toUpperCase();
        }
        if (uom) {
            if (name) {
                name = name + ' | ';
            }
            name = name + uom.toUpperCase();
        }
        if (method) {
            if (name) {
                name = name + ' | ';
            }
            name = name + method.toUpperCase();
        }

        this.model.set('name', name);
    },

})
