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
                    if (!(_.contains(['end_date_option_c', 'recurring_end_date_c'], field.name) || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        field.$el.parent().css('padding-top', 5);
                        this.model.set(field.name, '');
                    }
                } else if (this.model.get('end_date_option_c') == 'End after occurrences') {
                    if (!(_.contains(['end_date_option_c', 'occurrences_c'], field.name) || field.def.exclude_inline)) {
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
                    if (!(_.contains(['daily_repeats_on_c', 'daily_after_no_of_days_c'], field.name) || field.def.exclude_inline)) {
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
                    if (!(_.contains(['weekly_repeats_on_c', 'weekly_after_no_of_weeks_c'], field.name) || field.def.exclude_inline)) {
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
                    if (!(_.contains(['monthly_repeats_on_c', 'monthly_after_no_of_months_c'], field.name) || field.def.exclude_inline)) {
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
                if (this.model.get('monthly_on_the_specific_day_of_month_c') == 'On the specific day of month') {
                    if (!(_.contains(['monthly_on_the_specific_day_of_month_c', 'monthly_specific_day_of_month_c', 'monthly_skip_weekends_c'], field.name) || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                } else {
                    if (!(field.name == 'monthly_on_the_specific_day_of_month_c' || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                }
            }, this);
        } else if (this.name == 'monthly_repeat_on_three') {
            _.each(fields, function (field) {
                if (this.model.get('monthly_by_day_of_week_on_c') == 'On') {
                    if (!(_.contains(['monthly_by_day_of_week_on_c', 'monthly_week_no_c', 'monthly_month_day_c'], field.name) || field.def.exclude_inline)) {
                        field.$el.addClass('vis_action_hidden');
                        this.model.set(field.name, '');
                    }
                } else {
                    if (!(field.name == 'monthly_by_day_of_week_on_c' || field.def.exclude_inline)) {
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
                    if (!(_.contains(['yearly_on_specific_date_c', 'yearly_on_specific_month_c', 'yearly_date_of_month_c', 'yearly_skip_weekends_c'], field.name) || field.def.exclude_inline)) {
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
                    if (!(_.contains(['yearly_by_day_of_the_week_c', 'yearly_week_no_c', 'yearly_by_day_of_the_week_li_c', 'yearly_by_day_of_week_month_c'], field.name) || field.def.exclude_inline)) {
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
