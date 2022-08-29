({
    extendsFrom: "EnumField",

    initialize: function (options) {
        var self = this;
        this._super('initialize', [options]);
    },

    format: function (value) {
        this.models = [];
        if (this.def.isMultiSelect && _.isArray(value) && _.indexOf(value, '') > -1) {
            value = _.clone(value);
            // Delete empty values from the select list
            delete value[''];
        }

        if (this.def.isMultiSelect && _.isString(value)) {
            return this.convertMultiSelectDefaultString(value);
        } else {
            var values = [];
            var self = this;
            _.each(value, function (val, i) {
                if (!_.isUndefined(self.items[val])) {
                    values.push(self.items[val]);
                    var href = '#' + app.router.buildRoute(this.def.module, val);
                    self.models.push({
                        'text': self.items[val],
                        'href': href
                    });
                }
            }, this);

            return this.action == 'edit' ? value : values;
        }
    },
})