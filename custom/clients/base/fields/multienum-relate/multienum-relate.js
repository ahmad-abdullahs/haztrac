({
    extendsFrom: "EnumField",

    initialize: function (options) {
        var self = this;
        this._super('initialize', [options]);

        if (!this.model.get('lr_lab_reports_templates_list')) {
            var lr_lab_reports_templates_list = {};
            var collection = app.data.createBeanCollection('LR_Lab_Reports_Templates');
            collection.fetch({
                'showAlerts': false,
                'fields': _.union(['id', 'name'], _.keys(this.def.populate_list)),
                // 'lab_analysis', 'analysis_metals', 'special_instructions', 'instructions'
                'limit': -1,
                'success': _.bind(function (data) {
                    _.each(data.models, function (model) {
                        lr_lab_reports_templates_list[model.get('id')] = model.attributes;
                    });
                    self.model.set('lr_lab_reports_templates_list', lr_lab_reports_templates_list);
                }, this)
            });
        }
    },

    bindDataChange: function () {
        this.model.on('change:' + this.name, this.autoPopulateFields, this);
        this._super('bindDataChange');
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

    autoPopulateFields: function (model, value) {
        // This check is added to avoid its execution on detail view loading...
        if (this.tplName == 'detail' || this.action == 'detail' || !this.tplName || !this.action) {
            return;
        }
        // This check is added to avoid its execution on cancel button clicked...
        if (this.view.currentState == 'view') {
            return;
        }

        var lab_analysis = [],
                analysis_metals = [],
                special_instructions = [],
                instructions = [];
        var lr_lab_reports_templates_list = this.model.get('lr_lab_reports_templates_list');

        // We can make this more generic by adding another loop for the fields, 
        // so that we dont have the field names hardcoded. 
        if (lr_lab_reports_templates_list) {
            _.each(value, function (val, key) {
                var lab_reports_template = lr_lab_reports_templates_list[val];
                lab_analysis.push(lab_reports_template.lab_analysis);
                analysis_metals.push(lab_reports_template.analysis_metals);
                special_instructions.push(lab_reports_template.special_instructions);
                instructions.push(lab_reports_template.instructions);
            }, this);
        }

        // Flattening is important to convert the multiple arrays to a single array...
        // Filtering is important to avoid the null and empty stuff...
        lab_analysis = _.flatten(_.filter(lab_analysis)),
                analysis_metals = _.flatten(_.filter(analysis_metals)),
                special_instructions = _.filter(special_instructions),
                instructions = _.filter(instructions);

        this.model.set({
            'lab_analysis_c': lab_analysis,
            'analysis_metals_c': analysis_metals,
            'special_instructions_c': special_instructions.join('\n'),
            'instructions_c': instructions.join('\n'),
        });
    },
})