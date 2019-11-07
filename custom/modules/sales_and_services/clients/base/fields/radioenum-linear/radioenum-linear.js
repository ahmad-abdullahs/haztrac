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
        var divsList = [
            "daily_repeat_on",
            "weekly_repeat_on",
            "monthly_repeat_on_one",
            "monthly_repeat_on_two",
            "monthly_repeat_on_three",
            "yearly_repeat_on_one",
            "yearly_repeat_on_two",
            "yearly_repeat_on_three",
        ], divsToHide = [], divsToShow = [], except = '';

        if (_.isEmpty(this.model.get(this.name))) {
            // Hide all occurances.
            divsToHide = divsList;
        } else if (this.model.get(this.name) == 'Daily') {
            divsToShow = ["daily_repeat_on"];
            divsToHide = _.difference(divsList, divsToShow);
        } else if (this.model.get(this.name) == 'Weekly') {
            divsToShow = ["weekly_repeat_on"];
            divsToHide = _.difference(divsList, divsToShow);
        } else if (this.model.get(this.name) == 'Monthly') {
            divsToShow = ["monthly_repeat_on_one", "monthly_repeat_on_two", "monthly_repeat_on_three"];
            divsToHide = _.difference(divsList, divsToShow);
        } else if (this.model.get(this.name) == 'Yearly') {
            divsToShow = ["yearly_repeat_on_one", "yearly_repeat_on_two", "yearly_repeat_on_three"];
            divsToHide = _.difference(divsList, divsToShow);
        }

        except = this.model.get(this.name);
        // By default Hide all occurances.
        this.handleVisibility(divsToHide, divsToShow);
        // By default make all occurances empty.
        this.makeFieldsEmptyExcepty(except);
    },
    handleVisibility: function (divsToHide, divsToShow) {
        _.each(divsToHide, function (name) {
            $('div[data-name=' + name + '].record-cell').addClass('vis_action_hidden');
        });
        _.each(divsToShow, function (name) {
            $('div[data-name=' + name + '].record-cell').removeClass('vis_action_hidden');
        });
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
