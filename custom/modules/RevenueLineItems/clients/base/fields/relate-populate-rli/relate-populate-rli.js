({
    extendsFrom: "RelateField",
    events: {
        'click .relate-populate-rli': 'addRLIBundleToList',
    },
    initialize: function (options) {
        this.plugins = _.union(this.plugins || [], ['PopulateRLIS']);
        this._super('initialize', [options]);
    },
    addRLIBundleToList: function () {
        var model = this.view.raRLIs.get(this.model.id);
        this.prepopulateData(this, model, model.attributes);
    },
})