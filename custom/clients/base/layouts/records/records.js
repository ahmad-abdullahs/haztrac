({
    extendsFrom: 'RecordsLayout',

    initialize: function (options) {
        this._super('initialize', [options]);
        if (_.has(app.router, 'initial_filter')) {
            if (app.router.initial_filter) {
                this.context.set('filterOptions', this.getFilterOptions());
            }
        } else if (_.contains(['RevenueLineItems', 'ProductTemplates'], this.module)) {
            this.context.set('filterOptions', this.getFilterOptions(this.module));
        }
    },

    getFilterOptions: function (module) {
        var filter = app.router.initial_filter;

        if (module == "RevenueLineItems") {
            filter = {
                'initial_filter': 'filterRevenueLineItems',
                'initial_filter_label': app.lang.get('LBL_FILTER_REVENUELINEITEMS', 'RevenueLineItems'),
                'filter_populate': {
                    'is_bundle_product_c': ['parent'],
                }
            };
        } else if (module == "ProductTemplates") {
            filter = {
                'initial_filter': 'filterProducts',
                'initial_filter_label': app.lang.get('LBL_FILTER_PRODUCTS', 'ProductTemplates'),
                'filter_populate': {
                    'is_bundle_product_c': ['parent'],
                }
            };
        }

        var filterOptions = new app.utils.FilterOptions()
                .config(filter)
                .format();
        app.router.initial_filter = null;

        return filterOptions;
    },

    _dispose: function () {
        // Delete initial_filter so that It should not be miss guided.
        delete  app.router.initial_filter;
        this._super('_dispose');
    },
})