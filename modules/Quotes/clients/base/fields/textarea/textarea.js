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
 * @class View.Fields.Base.Quotes.TextareaField
 * @alias SUGAR.App.view.fields.BaseQuotesTextareaField
 * @extends View.Fields.Base.TextareaField
 */
({
    extendsFrom: 'TextareaField',

    shortName: undefined,

    longName: undefined,

    /**
     * @inheritdoc
     *
     * Format the value to a string.
     * Return an empty string for undefined, null and object types.
     * Convert boolean to 1 or 0.
     * Convert array, int and other types to a string.
     *
     * @param {mixed} value to format
     * @return {string} the formatted value
     */
    format: function(value) {
        this.plugins = _.union(this.plugins, 'Tooltip');

        if (_.isString(value)) {
            this.shortName = value.length > 20 ? value.substr(0,20) + '...' : value;
            this.longName = value;

            return value;
        }

        if (_.isUndefined(value) ||
            _.isNull(value) ||
            (_.isObject(value) && !_.isArray(value))
        ) {
            return '';
        }

        if (_.isBoolean(value)) {
            return value === true ? '1' : '0';
        }

        return value.toString();
    },

    /**
     * @inheritdoc
     *
     * Trim whitespace from value.
     */
    unformat: function(value) {
        return value.trim();
    }
})
