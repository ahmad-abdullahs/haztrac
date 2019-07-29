({
    tests: [],

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        var context = this.context || this.context.parent;
        var model = context.get('model');

        model.on('change', _.bind(this.render, this));
    },

    /**
     * @Override
     */
    render: function() {
        this.tests = [];

        var context = this.context || this.context.parent;
        var model = context.get('model');

        var recordMeta = app.metadata.getView('LR_Lab_Reports','record');
        if (!_.isUndefined(recordMeta.panels) && !_.isUndefined(recordMeta.panels[3])) {
            _.each(recordMeta.panels[3].fields, _.bind(function(field){
                if (model.get(field.name)) {
                    this.tests.push(app.lang.get(field.label, 'LR_Lab_Reports'));
                }
            }, this), this);
        }
        if (!_.isUndefined(recordMeta.panels) && !_.isUndefined(recordMeta.panels[4])) {
            _.each(recordMeta.panels[4].fields, _.bind(function(field){
                if (model.get(field.name)) {
                    this.tests.push(app.lang.get(field.label, 'LR_Lab_Reports'));
                }
            }, this), this);
        }

        this._super('render');
    }
})
