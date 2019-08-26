({
    // This view is used for showing up the dashlet on right side of the drawer for listing the Related 
    // RLI of selected account on the drawer.
    // @see screenshots 1.png
    extendsFrom: 'ListView',

    parentModel: null,

    raRLIs: null,

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this.raRLIs = {};
        this.viewName = 'related-account-revenuelineitems';

        options = _.extend({}, {module: 'RevenueLineItems'}, options || {});
        this.parentModel = options.context.parent.get('model')

        // If we enable the super call it will take the view to list view.
        // this._super('initialize', [options]);


        /**/
        //Grab the list of fields to display from the main list view (assuming initialize is being called from a subclass)
        var listViewMeta = app.metadata.getView(options.module, 'related-account-revenuelineitems') || {};
        //Extend from an empty object to prevent polution of the base metadata
        options.meta = _.extend({}, listViewMeta, options.meta || {});
        // FIXME: SC-5622 we shouldn't manipulate metadata this way.
        options.meta.type = options.meta.type || 'related-account-revenuelineitems';
        options.meta.action = 'related-account-revenuelineitems';
        options = this.parseFieldMetadata(options);

        app.view.View.prototype.initialize.call(this, options);

        this.viewName = 'related-account-revenuelineitems';

        if (this.dataViewName) {
            app.logger.warn('`dataViewName` is deprecated, please use `dataView`.');
            this.context.set('dataView', 'related-account-revenuelineitems');
        }

        this.attachEvents();
        this.orderByLastStateKey = app.user.lastState.key('order-by', this);
        this.orderBy = this._initOrderBy();
        if (this.collection) {
            this.collection.orderBy = this.orderBy;
        }
        // Dashboard layout injects shared context with limit: 5.
        // Otherwise, we don't set so fetches will use max query in config.
        this.limit = this.context.has('limit') ? this.context.get('limit') : null;
        this.metaFields = this.meta.panels ? _.first(this.meta.panels).fields : [];

        this.registerShortcuts();
        /**/


        this.raRLIs = App.data.createBeanCollection('RevenueLineItems');

        this.raRLIs.setOption('endpoint', _.bind(function (method, model, options, callbacks) {
            options.params.filter = [{
                    account_id: {
                        '$equals': this.parentModel.get('accounts_sales_and_services_1accounts_ida')
                    },
                    is_bundle_product_c: {
                        '$not_in': ['child']
                    },
                }];
            options.params.view = 'related-account-revenuelineitems';

            return SUGAR.App.api.records(
                    method,
                    model.module,
                    model.attributes,
                    options.params,
                    callbacks,
                    options.apiOptions
                    );
        }, this));

        this.parentModel.on('change:accounts_sales_and_services_1accounts_ida', _.bind(this.reloadList, this), this);
    },

    reloadList: function () {
        this.raRLIs.fetch({
            'limit': -1,
            'success': _.bind(function (data) {
                this.render();
            }, this)
        });
    }
})
