({
    plugins: ['Dashlet'],

    tests: [],

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);

        var context = this.context || this.context.parent;
        var model = context.get('model');

        model.on('change', _.bind(this.render, this));
    },

    /**
     * @Override
     */
    render: function () {
        this.tests = [];
        var labTestfields = ['lab_analysis_c', 'analysis_metals_c'];

        var context = this.context || this.context.parent;
        var model = context.get('model');

        if (!_.isUndefined(model.fields)) {
            // Get the applist of Multiselect
            var labAnalysis = app.lang.getAppListStrings(model.fields.lab_analysis_c.options);
            var analysisMetal = app.lang.getAppListStrings(model.fields.analysis_metals_c.options);

            // Push options to the tests array and render it in the hbs.
            _.each(labTestfields, function (_field) {
                var _test = app.lang.getAppListStrings(model.fields[_field].options);
                _.each(model.get(_field), function (multiselctOption) {
                    var color = '#198cc6';
                    if (_field == 'lab_analysis_c') {
                        color = '#555';
                    }
                    this.tests.push({'text': _test[multiselctOption], 'color': color});
                }, this);
            }, this);
        }

        // Code is added for Test Methods to show them in the Lab Test Dashlet on LR_Lab_Reports Record View
        var labTestData = model.get("labTestData");
        _.each(model.get("lr_lab_reports_test_method"), function (id) {
            if (labTestData[id]) {
                this.tests.push({'text': labTestData[id]['name'], 'color': labTestData[id]['method_color']});
            }
        }, this);

        this._super('render');
    }
})
