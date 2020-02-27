({
    // This view is used for showing up the dashlet on right side of the drawer for listing the Related 
    // RLI of selected account on the drawer.
    // @see screenshots 1.1.png
    extendsFrom: 'ListView',
    parentModel: null,
    raRLIs: null,
    thisViewName: 'related-account-revenuelineitems-for-revenuelineitems-create',
    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this.raRLIs = {};
        this.viewName = this.thisViewName;

        options = _.extend({}, {module: 'RevenueLineItems'}, options || {});
        this.parentModel = !_.isEmpty(options.context.parent.parent.get('model').get('id'))
                ? options.context.parent.parent.get('model') : options.context.get('parentModel').link.bean;

        // If we enable the super call it will take the view to list view.
        // this._super('initialize', [options]);

        /**/
        //Grab the list of fields to display from the main list view (assuming initialize is being called from a subclass)
        var listViewMeta = app.metadata.getView(options.module, this.thisViewName) || {};
        //Extend from an empty object to prevent polution of the base metadata
        options.meta = _.extend({}, listViewMeta, options.meta || {});
        // FIXME: SC-5622 we shouldn't manipulate metadata this way.
        options.meta.type = options.meta.type || this.thisViewName;
        options.meta.action = this.thisViewName;
        options = this.parseFieldMetadata(options);

        app.view.View.prototype.initialize.call(this, options);

        this.viewName = this.thisViewName;

        if (this.dataViewName) {
            app.logger.warn('`dataViewName` is deprecated, please use `dataView`.');
            this.context.set('dataView', this.thisViewName);
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

        // Only show this dashlet view when RevenuelineItem create dawer 
        // is open on top of the Sales and services module.
        if (this.context.parent.parent.get('module') == 'sales_and_services') {
            this.raRLIs = App.data.createBeanCollection('RevenueLineItems');

            this.raRLIs.setOption('endpoint', _.bind(function (method, model, options, callbacks) {
                options.params.filter = [{
                        account_id: {
                            '$equals': this.parentModel.get('accounts_sales_and_services_1accounts_ida'),
                        },
                        is_bundle_product_c: {
                            '$not_in': ['child'],
                        },
                        rli_as_template_c: {
                            '$equals': 1,
                        },
                    }];
                options.params.view = this.thisViewName;
                options.params.order_by = 'account_line_number:asc';

                return SUGAR.App.api.records(
                        method,
                        model.module,
                        model.attributes,
                        options.params,
                        callbacks,
                        options.apiOptions
                        );
            }, this));

            this.listenTo(options.context.parent.get('model'), 'change:is_bundle_product_c', _.bind(this.reloadList, this), this);
        }
    },

    _render: function () {
        // Only render the view when create drawer is opened from the 
        // revenue line item subpanel under the sales and service record view
        if (this.context.parent.parent.get('module') == 'sales_and_services') {
            this._super('_render');
            if (this.parentModel) {
                if (_.isEmpty(this.parentModel.get('accounts_sales_and_services_1accounts_ida'))) {
                    // Show the warning if no account is selected in the sales and services.
                    app.alert.show('no_account_warning', {
                        level: 'warning',
                        title: 'Warning:',
                        messages: 'Please select an Account in (' +
                                this.parentModel.get('name') + ') to load the Related Revenue Line Items.',
                        autoClose: true,
                        autoCloseDelay: 8000,
                    });
                }
            }
        }
    },

    reloadList: function () {
        this.raRLIs.fetch({
            'limit': -1,
            'success': _.bind(function (data) {
                this.render();
            }, this),
        });
    }
})
