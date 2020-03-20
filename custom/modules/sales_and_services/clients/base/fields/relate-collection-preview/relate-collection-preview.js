({
    extendsFrom: 'BaseField',
    initialize: function (options) {
        this._super('initialize', [options]);
    },
    bindDataChange: function () {
        this._super('bindDataChange');
    },
    format: function (value) {
        this._super('format', [value]);
        if (this.view.name == 'preview') {
            if (!_.isUndefined(value) && !_.isNull(value)) {
                _.each(value['records'], function (record) {
                    record.discount_price = '$' + app.utils.formatNumberLocale(record.discount_price || 0);
                    record.total_amount = '$' + app.utils.formatNumberLocale(record.total_amount || 0);
                    record.estimated_total_amount = '$' + app.utils.formatNumberLocale(record.estimated_total_amount || 0);
//                    var options = this.model.fields.product_uom_c.options;
//                    var ddList = app.lang.getAppListStrings(options);
                    var ddList = app.lang.getAppListStrings('unit_of_measure_c_list');
                    var valueToDisplay = ddList[record.product_uom_c];
                    record.product_uom_c = valueToDisplay;
                }, this);

                // Sort the list on basis of line number
//                value['records'] = _.sortBy(value['records'], 'line_number');
            }
        }
        return value;
    },
    _loadTemplate: function () {
        this._super('_loadTemplate');
        if (this.view.name == 'preview') {
            var template = app.template.getField(this.type, 'preview', this.model.module);
            this.template = template || this.template;
        }
    },
})