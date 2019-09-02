/**
 * @class View.Views.Base.Accounts.CreateView
 * @alias SUGAR.App.view.views.AccountsCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        this._super('initialize', [options]);
        app.controller.context.on('productCatalogDashlet:populate:RLI', this.onPopulateFromProductCatalog, this);
    },

    onPopulateFromProductCatalog: function (data) {
        data = data || {};
        data.likely_case = data.discount_price;
        data.best_case = data.discount_price;
        data.worst_case = data.discount_price;
        data.assigned_user_id = app.user.get('id');
        data.assigned_user_name = app.user.get('name');

        var bean;

        bean = app.data.createBean('RevenueLineItems');
        bean.set(data);
        bean._module = bean.attributes._module = 'RevenueLineItems';
        delete bean.attributes.id;
        delete bean.id;

        // check the parent record to see if an assigned user ID/name has been set
        if (this.context && this.context.has('model')) {
            var rliModel = this.context.get('model'),
                    userId = rliModel.get('assigned_user_id'),
                    userName = rliModel.get('assigned_user_name');

            if (userId) {
                bean.setDefault('assigned_user_id', userId);
            }

            if (userName) {
                bean.setDefault('assigned_user_name', userName);
            }

            rliModel.set(bean.attributes);
        }
    },
})