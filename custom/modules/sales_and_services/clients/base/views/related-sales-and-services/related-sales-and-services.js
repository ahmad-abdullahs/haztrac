({
    extendsFrom: 'ListView',

    parentModel: null,

    /**
     * @inheritdoc
     */
    initialize: function(options) {ara = this;
        options = _.extend({}, {module: 'sales_and_services'}, options || {});
        this.parentModel = options.context.parent.get('model')

        this._super('initialize', [options]);;

        this.collection.setOption('endpoint', _.bind(function(method, model, options, callbacks) {
            options.params.filter = [{
                accounts_sales_and_services_1accounts_ida: {
                    '$equals': this.parentModel.get('accounts_sales_and_services_1accounts_ida')
                }
            }];

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

    reloadList: function() {
        this.context.resetLoadFlag();
        this.loadData({});
    }
})
