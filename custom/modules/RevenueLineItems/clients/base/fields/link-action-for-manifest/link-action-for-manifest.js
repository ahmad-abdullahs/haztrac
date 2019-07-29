({
    extendsFrom: 'LinkActionField',

    getDrawerOptions: function() {
        var parentModel = this.context.get('parentModel');
        var linkModule = this.context.get('module');
        var link = this.context.get('link');
        var sales_and_service_ids = [];

        // getting sales & service ids
        var url = app.api.buildURL('HT_Manifest/' + parentModel.get('id') + '/link/ht_manifest_sales_and_services_1');
        app.api.call('read', url, null, {
            success: _.bind(function(data) {
                if (!_.isUndefined(data) && _.isArray(data.records)) {
                    _.each(data.records, function(record) {
                        sales_and_service_ids.push(record.id);
                    }, this);
                }
            }, this)
        }, {
            async: false
        });

        if (sales_and_service_ids.length == 0) {
            sales_and_service_ids.push('no-sales-and-service-linked');
        }

        var filterOptions = new App.utils.FilterOptions().config({
            'initial_filter': 'filterBySalesService',
            'filter_populate': {
                'sales_and_services_revenuelineitems_1sales_and_services_ida': sales_and_service_ids
            }
        });

        return {
            layout: 'multi-selection-list-link',
            context: {
                module: linkModule,
                recParentModel: parentModel,
                recLink: link,
                recContext: this.context,
                recView: this.view,
                independentMassCollection: true,
                filterOptions: filterOptions.format()
            }
        };
    }
})
