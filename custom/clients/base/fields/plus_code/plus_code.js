/**
 * @class View.Fields.Base.BoolField
 * @alias SUGAR.App.view.fields.BaseBoolField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'BoolField',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    bindDataChange: function () {
        if (this.model) {
            this.model.on('change:' + this.name, function (model, value) {
                this.handleDependentFieldsVisibility(model, value);
            }, this);
        }

        this._super('bindDataChange');
    },

    handleDependentFieldsVisibility: function (model, value) {
        // Get the list of fields to work with.
        var toggleFields = [];
        _.each(this.def.toggleFields, function (field) {
            var _field = this.view.getField(field);
            if (_field) {
                toggleFields.push(_field);
            }
        }, this);

        if (value) {
            // Show dependent Fields
            _.each(toggleFields, function (field) {
                field.show();
                this.view.$el.find('div[data-name=' + field.name + ']').show();
            }, this);
            this.view.$el.find('div[data-name=' + this.def.group + '_lat_lon]').show();
        } else {
            // Hide dependent Fields
            _.each(toggleFields, function (field) {
                field.hide();
                this.view.$el.find('div[data-name=' + field.name + ']').hide();
            }, this);
            this.view.$el.find('div[data-name=' + this.def.group + '_lat_lon]').hide();
        }
    },

})
