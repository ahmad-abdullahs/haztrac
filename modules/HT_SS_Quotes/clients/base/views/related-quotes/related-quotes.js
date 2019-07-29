({
    extendsFrom: 'ListView',

    parentModel: null,

    /**
     * @inheritdoc
     */
    initialize: function(options) {ara = this;
        options = _.extend({}, {module: 'HT_SS_Quotes'}, options || {});
        this.parentModel = options.context.parent.get('model')

        this._super('initialize', [options]);;

        this.collection.setOption('endpoint', _.bind(function(method, model, options, callbacks) {
            options.params.filter = [{
                '$or':[{
                    shipping_account_id: {'$in': [
                        this.parentModel.get('shipping_account_id'),
                        this.parentModel.get('billing_account_id')
                    ]}
                }, {
                    billing_account_id: {'$in': [
                        this.parentModel.get('shipping_account_id'),
                        this.parentModel.get('billing_account_id')
                    ]}
                }]
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

        this.parentModel.on('change:shipping_account_id', _.bind(this.reloadList, this), this);
        this.parentModel.on('change:billing_account_id', _.bind(this.reloadList, this), this);
    },

    reloadList: function() {
        this.context.resetLoadFlag();
        this.loadData({});
    }
})
