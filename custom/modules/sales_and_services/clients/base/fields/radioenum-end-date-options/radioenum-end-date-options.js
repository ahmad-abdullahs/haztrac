/**
 * @class View.Fields.Base.RadioenumField
 * @alias SUGAR.App.view.fields.BaseRadioenumField
 * @extends View.Fields.Base.EnumField
 */
({
    extendsFrom: 'RadioenumField',
    bindDataChange: function () {
        this.model.on('change:' + this.name, this.handleDataChange, this);
        this._super('bindDataChange');
    },
    handleDataChange: function (model, value) {
        // Empty the value for fields which are hidden on option selection
        if (value == 'End date') {
            this.model.set('occurrences_c', '');
        } else if (value == 'End after occurrences') {
            this.model.set('recurring_end_date_c', '');
        } else if (value == ' No end date') {
            this.model.set('occurrences_c', '');
            this.model.set('recurring_end_date_c', '');
        }
    },
})
