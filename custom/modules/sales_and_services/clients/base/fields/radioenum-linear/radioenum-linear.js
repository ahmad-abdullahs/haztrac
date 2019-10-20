/**
 * @class View.Fields.Base.RadioenumField
 * @alias SUGAR.App.view.fields.BaseRadioenumField
 * @extends View.Fields.Base.EnumField
 */
({
// On list-edit template,
// we want the radio buttons to be replaced by a select so each method must call the EnumField method instead.
    extendsFrom: 'RadioenumField',
    fieldMappingForOccurance: {
        'Daily': [
            'daily_repeats_on_c', 'daily_skip_weekends_c', 'daily_after_no_of_days_c',
        ],
        'Weekly': [
            'weekly_repeats_on_c', 'weekly_by_day_of_the_week_c', 'weekly_after_no_of_weeks_c',
        ],
        'Monthly': [
            'monthly_repeats_on_c', 'monthly_after_no_of_months_c', 'monthly_on_the_specific_day_of_month_c',
            'monthly_skip_weekends_c', 'monthly_specific_day_of_month_c', 'monthly_by_day_of_week_on_c', 'monthly_week_no_c',
            'monthly_month_day_c'
        ],
        'Yearly': [
            'yearly_repeat_every_year_c', 'yearly_on_specific_date_c', 'yearly_skip_weekends_c', 'yearly_on_specific_month_c',
            'yearly_date_of_month_c', 'yearly_by_day_of_the_week_c', 'yearly_week_no_c', 'yearly_by_day_of_the_week_li_c',
            'yearly_by_day_of_week_month_c',
        ],
    },
    _render: function () {
        this._super("_render");
        // Show the radio buttons list in linear fashion...
        this.$el.css('display', 'flex');
    },
    bindDomChange: function () {
        this._super("bindDomChange");
        if (this.model.get(this.name) == 'Daily') {
            // Hide all others
            $('div[data-name=daily_repeat_on].record-cell').removeClass('vis_action_hidden');
            $('div[data-name=weekly_repeat_on].record-cell').addClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on_one].record-cell').addClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on_two].record-cell').addClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on_three].record-cell').addClass('vis_action_hidden');
            $('div[data-name=yearly_repeat_on_one].record-cell').addClass('vis_action_hidden');
            $('div[data-name=yearly_repeat_on_two].record-cell').addClass('vis_action_hidden');
            $('div[data-name=yearly_repeat_on_three].record-cell').addClass('vis_action_hidden');
            // Make the hidden fields empty
            this.makeFieldsEmptyExcepty('Daily');
        } else if (this.model.get(this.name) == 'Weekly') {
            // Hide all others
            $('div[data-name=weekly_repeat_on].record-cell').removeClass('vis_action_hidden');
            $('div[data-name=daily_repeat_on].record-cell').addClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on_one].record-cell').addClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on_two].record-cell').addClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on_three].record-cell').addClass('vis_action_hidden');
            $('div[data-name=yearly_repeat_on_one].record-cell').addClass('vis_action_hidden');
            $('div[data-name=yearly_repeat_on_two].record-cell').addClass('vis_action_hidden');
            $('div[data-name=yearly_repeat_on_three].record-cell').addClass('vis_action_hidden');
            this.makeFieldsEmptyExcepty('Weekly');
        } else if (this.model.get(this.name) == 'Monthly') {
            // Hide all others
            $('div[data-name=monthly_repeat_on_one].record-cell').removeClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on_two].record-cell').removeClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on_three].record-cell').removeClass('vis_action_hidden');
            $('div[data-name=daily_repeat_on].record-cell').addClass('vis_action_hidden');
            $('div[data-name=weekly_repeat_on].record-cell').addClass('vis_action_hidden');
            $('div[data-name=yearly_repeat_on_one].record-cell').addClass('vis_action_hidden');
            $('div[data-name=yearly_repeat_on_two].record-cell').addClass('vis_action_hidden');
            $('div[data-name=yearly_repeat_on_three].record-cell').addClass('vis_action_hidden');
            this.makeFieldsEmptyExcepty('Monthly');
        } else if (this.model.get(this.name) == 'Yearly') {
            // Hide all others
            $('div[data-name=yearly_repeat_on_one].record-cell').removeClass('vis_action_hidden');
            $('div[data-name=yearly_repeat_on_two].record-cell').removeClass('vis_action_hidden');
            $('div[data-name=yearly_repeat_on_three].record-cell').removeClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on_one].record-cell').addClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on_two].record-cell').addClass('vis_action_hidden');
            $('div[data-name=monthly_repeat_on_three].record-cell').addClass('vis_action_hidden');
            $('div[data-name=daily_repeat_on].record-cell').addClass('vis_action_hidden');
            $('div[data-name=weekly_repeat_on].record-cell').addClass('vis_action_hidden');
            this.makeFieldsEmptyExcepty('Yearly');
        }
    },
    makeFieldsEmptyExcepty: function (except) {
        _.each(this.fieldMappingForOccurance, function (occurance, key) {
            if (key != except) {
                _.each(occurance, function (field) {
                    this.model.set(field, '');
                }, this);
            }
        }, this);
    },
})
