/* Custom create view for inline subpanels*/
({
    fieldss: null,
    grid: null,
    fieldsList: [
//        'accounts_competitor_cost_1_name',
//        'product_uom',
//        'cost_price',
    ],

    events: {
        'click #oaf_save_button': 'saveModel',
        'click #oaf_cancel_button': 'hideView',
    },

    initialize: function (options) {
        this.plugins = _.union(this.plugins || [], ['OrderUtils']);
        this.fieldss = new Array;
        this.grid = new Array;
        app.view.View.prototype.initialize.call(this, options);
        for (var i in this.meta.panels[0].fields) {
            var groupField = this.meta.panels[0].fields[i];
            this.grid[i] = new Array;
            for (var j in groupField) {
                var field = groupField[j]['name'];
                this.fieldss.push(this.model.fields[field]);

                if (field != "") {
                    var fieldd = this.model.fields[field];
                } else {
                    var fieldd = {};
                }

                if (fieldd.type == "text") {
                    fieldd.type = "textarea";
                }

                fieldd['span'] = groupField[j]['span'];

                if (groupField[j]['dismiss_label']) {
                    fieldd['dismiss_label'] = groupField[j]['dismiss_label'];
                }

                if (groupField[j]['type']) {
                    fieldd['type'] = groupField[j]['type'];
                }

                this.grid[i].push(_.extend(fieldd, groupField[j]));
            }
        }

        _.map(_.flatten(this.grid), function (field) {
            if (_.has(field, 'required')) {
                if (field.required == true || field.required == 'true') {
                    this.fieldsList.push(field.name);
                }
            }
        }, this);

        this.handleValidationTask();
    },

    handleValidationTask: function () {
        // register handle validation for required fields.
        _.each(this.fieldsList, function (requiredField) {
            this.model.addValidationTask(requiredField, _.bind(this.addValidation, this));
        }, this);
    },

    /*
     Either of Quanity new and Quanity port is require.
     1. determine if any of Qs is filled. IF yes remove validation
     */
    addValidation: function (fields, errors, callback) {
        _.each(this.fieldsList, function (requiredField) {
            // var requiredField = 'accounts_competitor_cost_1_name';
            var value = this.model.get(requiredField);
            var addErrorCond1 = _.isEmpty(value);
            if (addErrorCond1) {
                errors[requiredField] = errors[requiredField] || {};
                errors[requiredField].required = true;
            } else {
                delete errors[requiredField];
            }
        }, this);
        callback(null, fields, errors);
    },

    render: function () {
        this._super('render');
    },

    hideView: function (e) {
        this.model.parent.trigger('create:btn:enable', false);
        this.model.revertAttributes();
        this.dispose();
    },

    saveModel: function (e) {
        var fields = {};
        var self = this;
        _.each(this.fieldss, function (field, i) {
            if (field && field.name) {
                fields[field.name] = field;
            }
        });
        // set name field from copy over name_field
        if (!_.isUndefined(this.meta.panels[0].name_field)) {
            this.model.set('name', this.model.get(this.meta.panels[0].name_field));
        }
        this.model.doValidate(fields, function (isValid) {
            if (isValid) {
                $('#oaf_save_button').hide();
                $('#oaf_save_button_dummy').show();

                var modelToSave = self.model;
//                // Add Competitor relationship between Competitor Cost and RevenueLineItem 
//                self.model.set('competitor_cost_revenuelineitemsrevenuelineitems_ida', self.context.get('modelId'));

                // self.saveRecord(modelToSave);
                app.alert.show('saving_record', {level: 'process', title: 'Saving'});
                modelToSave.save({}, {
                    success: function (model, response) {
                        app.alert.dismiss('saving_record', {level: 'process', title: 'Saving'});
                        app.alert.show('saved', {level: 'success', messages: "Record Saved", autoClose: true, autoCloseDelay: 8000});
                        self.model.parent.trigger('field:model_saved:fire');
                    },
                    error: function (model, response, options) {
                        app.alert.dismiss('saving_record', {level: 'process', title: 'Saving'});
                        app.alert.show('not_saved', {level: 'error', messages: "Record not saved", autoClose: true, autoCloseDelay: 8000});
                        self.model.parent.trigger('field:model_saved:fire');
                        $('#oaf_save_button').show();
                        $('#oaf_save_button_dummy').hide();
                    }
                });
            } else {
                return false;
            }
        });
    },

    /**
     *
     * @param {Function} _dispose
     *
     */
    _dispose: function () {
        this.model.off('change:assoc_location_name');
        this.model.off('change:billing_address_state');
        this._super("_dispose");
    },
})