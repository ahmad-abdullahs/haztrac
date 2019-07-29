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
 * @class View.Fields.Base.RevenueLineItems.CurrencyField
 * @alias SUGAR.App.view.fields.BaseRevenueLineItemsCurrencyField
 * @extends View.Fields.Base.CurrencyField
 */
({
    extendsFrom: 'BaseCurrencyField',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        // Enabling currency dropdown on RLIl ist views
        this.hideCurrencyDropdown = false;
    }
})
