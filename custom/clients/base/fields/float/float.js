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

    initialize: function (options) {
        this._super('initialize', [options]);
        //add validation tasks
        this.model.addValidationTask(this.name + '_ValidationTask', _.bind(this._doValidateFloatField, this));
    },

    _doValidateFloatField: function (fields, errors, callback) {
        var value = this.model.get(this.name);
        if (this.def.format && value) {
            if (value.toString().includes('%')) {
                value = value.toString().replace(/%/g, "");
                this.model.set(this.name, value, {
                    'silent': true
                });

                if (!_.isNaN(Number(value))) {
                    delete errors[this.name];
                }
            }
        }

        callback(null, fields, errors);
    },

    format: function (value) {
        var format = '';
        if (this.def.format && value) {
            if (!value.toString().includes('%')) {
                format = '%'
            }
        }

        if (this.def.disable_num_format || _.isNull(value) || _.isUndefined(value) || _.isNaN(value)) {
            return value;
        }

        var number_grouping_separator = app.user.getPreference('number_grouping_separator') || ',';
        var decimal_separator = app.user.getPreference('decimal_separator') || '.';

        if (_.isUndefined(this.def.precision) || !this.def.precision) {
            return app.utils.addNumberSeparators(value.toString(), number_grouping_separator, decimal_separator) + format;
        }

        return app.utils.formatNumber(value, this.def.precision, this.def.precision, number_grouping_separator, decimal_separator) + format;
    },
})
