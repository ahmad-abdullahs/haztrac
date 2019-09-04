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
//                    var rli = app.data.createBean('RevenueLineItems');
                    var options = this.model.fields.unit_of_measure_c.options;
                    var ddList = app.lang.getAppListStrings(options);
                    var valueToDisplay = ddList[record.unit_of_measure_c];
                    record.unit_of_measure_c = valueToDisplay;
                }, this);
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