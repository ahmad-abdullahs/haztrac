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
 * @class View.Fields.Base.Products.CurrencyField
 * @alias SUGAR.App.view.fields.BaseProductsCurrencyField
 * @extends View.Fields.Base.CurrencyField
 */
({
    extendsFrom: 'BaseCurrencyField',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        // Enabling currency dropdown on Qli ist views
        this.hideCurrencyDropdown = false;
    },

    /**
     * @inheritdoc
     */
    format: function(value) {
        // Skipping the core currencyField call
        // app.view.Field.prototype.format.call(this, value);
        this._super('format', [value]);

        //Check if in 'Edit' mode
        if (this.tplName === 'edit') {
            //Display just currency value without currency symbol when entering edit mode for the first time
            //We want the correct value in input field corresponding to the currency in the dropdown
            //Example: Dropdown has Euro then display '100.00' instead of '$111.11'
            return app.utils.formatNumberLocale(value);
        }

        var transactionalCurrencyId = this.model.get(this.def.currency_field || 'currency_id');
        var convertedCurrencyId = transactionalCurrencyId;
        var origTransactionValue = value;

        // convert value to Quote preferred currency
        var context = this.context.parent || this.context;
        var quotePreferredCurrencyId = context.get('model').get('currency_id');
        if (quotePreferredCurrencyId !== transactionalCurrencyId) {
            convertedCurrencyId = quotePreferredCurrencyId;

            this.transactionValue = app.currency.formatAmountLocale(
                this.model.get(this.name) || 0,
                transactionalCurrencyId
            );

            value = app.currency.convertWithRate(
                value,
                this.model.get('base_rate'),
                app.metadata.getCurrency(quotePreferredCurrencyId).conversion_rate
            );
        } else {
            // user preferred same as transactional, no conversion required
            this.transactionValue = '';
            convertedCurrencyId = transactionalCurrencyId;
            value = origTransactionValue;
        }
        return app.currency.formatAmountLocale(value, convertedCurrencyId);
    },


    /**
     * @inheritdoc
     */
    updateModelWithValue: function(model, currencyId, val) {
        // Convert the discount amount value only if it is not in %
        // Other values will be converted as usual
        if (val && !(this.name === 'discount_amount' && this.model.get('discount_select'))) {
            this._super('updateModelWithValue',[model, currencyId, val]);
        }
    }
})
