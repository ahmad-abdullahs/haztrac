({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    bindDataChange: function () {
        this._super('bindDataChange');

        // On the sales_and_services record view, when the _relatedCollections revenuelineitems subpannel is fetched.
        // make all the rows in that pannel editable.
        if (this.model._relatedCollections.sales_and_services_revenuelineitems_1) {
            this.model._relatedCollections.sales_and_services_revenuelineitems_1.on('data:sync:complete', function () {
                _.each(this.model._relatedCollections.sales_and_services_revenuelineitems_1.models, function (model) {
                    this.context.trigger('edit:full:subpanel:cstm', model, {'def': {}});
                }, this)
            }, this);
        }
    }
})