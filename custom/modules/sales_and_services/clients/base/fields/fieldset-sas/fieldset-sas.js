/*
 * @class View.Fields.Base.FieldsetField
 * @alias SUGAR.App.view.fields.BaseFieldsetField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'FieldsetField',

    /*
     * 
     * @param {type} options
     * @returns {undefined}
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    /*
     * 
     * @param {type} fields
     * @returns {undefined}
     */
    _render: function () {
        this._super('_render');
        this.$el.css('display', '-webkit-box');
    },

    /**
     * Renders the children fields in their respective placeholders.
     *
     * @param {Array} fields The children fields.
     * @protected
     */
    _renderFields: function (fields) {
        this._super('_renderFields', [fields]);

        /*Need to set those fields empty which are hidden*/

        // Let the _renderFields function do what ever its doing, 
        // after that we are doing to make the fields visually hidden which are not required to be shown.
        // This code is written to make the fields work at time for record edit or cancel, 
        // otherwise the field depemdency is taking care of that on normal radio options change.
        if (this.name == 'timings') {
            _.each(fields, function (field) {
                if (this.model.get('end_date_option_c') == 'End date') {
                    if (!(field.name == 'end_date_option_c' || field.name == 'recurring_end_date_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        field.$el.parent().css('padding-top', 5);
                        this.model.set(field.name, '');
                    }
                } else if (this.model.get('end_date_option_c') == 'End after occurrences') {
                    if (!(field.name == 'end_date_option_c' || field.name == 'occurrences_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        field.$el.parent().css('padding-top', 5);
                        this.model.set(field.name, '');
                    }
                } else {
                    if (!(field.name == 'end_date_option_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        field.$el.parent().css('padding-top', 5);
                        this.model.set(field.name, '');
                    }
                }
            }, this);
        } else if (this.name == 'daily_repeat_on') {
            _.each(fields, function (field) {
                if (this.model.get('daily_repeats_on_c') == 'Every next no of day') {
                    if (!(field.name == 'daily_repeats_on_c' || field.name == 'after_no_of_days_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                } else {
                    if (!(field.name == 'daily_repeats_on_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                }
            }, this);
        } else if (this.name == 'weekly_repeat_on') {
            _.each(fields, function (field) {
                if (this.model.get('weekly_repeats_on_c') == 'Every next no of week') {
                    if (!(field.name == 'weekly_repeats_on_c' || field.name == 'after_no_of_weeks_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                } else {
                    if (!(field.name == 'weekly_repeats_on_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                }
            }, this);
        } else if (this.name == 'monthly_repeat_on_one') {
            _.each(fields, function (field) {
                if (this.model.get('monthly_repeats_on_c') == 'Every next no of month') {
                    if (!(field.name == 'monthly_repeats_on_c' || field.name == 'after_no_of_months_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                } else {
                    if (!(field.name == 'monthly_repeats_on_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                }
            }, this);
        } else if (this.name == 'monthly_repeat_on_two') {
            _.each(fields, function (field) {
                if (this.model.get('on_the_specific_day_of_month_c') == 'On the specific day of month') {
                    if (!(field.name == 'on_the_specific_day_of_month_c' || field.name == 'specific_day_of_month_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                } else {
                    if (!(field.name == 'on_the_specific_day_of_month_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                }
            }, this);
        } else if (this.name == 'monthly_repeat_on_three') {
            _.each(fields, function (field) {
                if (this.model.get('by_day_of_week_on_c') == 'On') {
                    if (!(field.name == 'by_day_of_week_on_c' || field.name == 'week_no_c' || field.name == 'month_day_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                } else {
                    if (!(field.name == 'by_day_of_week_on_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                }
            }, this);
        } else if (this.name == 'yearly_repeat_on_one') {
            _.each(fields, function (field) {
                if (!(field.name == 'yearly_repeat_every_year_c' || field.def.exclude_inline)) {
                    field.$el.addClass('vis_action_hidden');
                    this.model.set(field.name, '');
                }
            }, this);
        } else if (this.name == 'yearly_repeat_on_two') {
            _.each(fields, function (field) {
                if (this.model.get('yearly_on_specific_date_c') == 'On') {
                    if (!(field.name == 'yearly_on_specific_date_c' || field.name == 'yearly_on_specific_month_c' || field.name == 'yearly_date_of_month_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                } else {
                    if (!(field.name == 'yearly_on_specific_date_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                }
            }, this);
        } else if (this.name == 'yearly_repeat_on_three') {
            _.each(fields, function (field) {
                if (this.model.get('yearly_by_day_of_the_week_c') == 'On') {
                    if (!(field.name == 'yearly_by_day_of_the_week_c' || field.name == 'yearly_week_no_c' || field.name == 'yearly_by_day_of_the_week_li_c' || field.name == 'yearly_by_day_of_week_month_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                } else {
                    if (!(field.name == 'yearly_by_day_of_the_week_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                }
            }, this);
        }
    },
})
