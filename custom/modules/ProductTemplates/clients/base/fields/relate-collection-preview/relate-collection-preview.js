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
                // Sort the list on basis of line number
                value['records'] = _.sortBy(value['records'], 'line_number');
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