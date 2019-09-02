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
 * @class View.Views.Base.Quotes.ProductCatalogView
 * @alias SUGAR.App.view.views.QuotesProductCatalogView
 * @extends View.View
 */
({
    extendsFrom: 'QuotesProductCatalogView',
    initialize: function (options) {
        this._super('initialize', [options]);
    },
    _sendItemToRecord: function (data) {
        this._massageDataBeforeSendingToRecord(data);

        var viewDetails = this.closestComponent('record') ?
                this.closestComponent('record') :
                this.closestComponent('create');
        // need to trigger on app.controller.context because of contexts changing between
        // the PCDashlet, and Opps create being in a Drawer, or as its own standalone page
        // app.controller.context is the only consistent context to use
        if (!_.isUndefined(viewDetails)) {
            app.controller.context.trigger('productCatalogDashlet:populate:RLI', data);
        }
    },
})