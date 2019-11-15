/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Fields.Base.LabelField
 * @alias SUGAR.App.view.fields.BaseLabelField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'LabelField',
    onChangeFieldList: [
        // Timings
        'end_date_option_c', 'recurring_end_date_c', 'occurrences_c',
        // Occur Field
        'occurs_c',
        // 'Daily'
        'daily_repeats_on_c', 'daily_skip_weekends_c', 'daily_after_no_of_days_c',
        // 'Weekly'
        'weekly_repeats_on_c', 'weekly_by_day_of_the_week_c', 'weekly_after_no_of_weeks_c',
        // 'Monthly'
        'monthly_repeats_on_c', 'monthly_after_no_of_months_c', 'monthly_on_the_specific_day_of_month_c',
        'monthly_skip_weekends_c', 'monthly_specific_day_of_month_c', 'monthly_by_day_of_week_on_c', 'monthly_week_no_c',
        'monthly_month_day_c',
        // 'Yearly'
        'yearly_repeat_every_year_c', 'yearly_on_specific_date_c', 'yearly_skip_weekends_c', 'yearly_on_specific_month_c',
        'yearly_date_of_month_c', 'yearly_by_day_of_the_week_c', 'yearly_week_no_c', 'yearly_by_day_of_the_week_li_c',
        'yearly_by_day_of_week_month_c',
    ],

    labelsList: {
        0: 'To schedule a recurring activity, please specify the date and time range, '
                + 'and then select the occurrence pattern from below.',
    },

    format: function (value) {
        return this.labelsList[0];
    },

    bindDataChange: function () {
        _.each(this.onChangeFieldList, function (fieldName) {
            this.model.on('change:' + fieldName, _.bind(this.UpdateInfoLabel, this, fieldName), this);
        }, this);
    },

    UpdateInfoLabel: function (fieldName, model, value) {
//        console.log('Changed... : ', model, value, fieldName, this.action, this.view.action, this.view.tplName);

        var message = '';
        if (!_.isEmpty(this.model.get('recurring_start_date_c'))) {
            var dateToShow = app.date(this.model.get('recurring_start_date_c'), app.date.convertFormat(this.getUserDateTimeFormat()), true);
            message += 'effective from ' + dateToShow;
        } else {
            message += 'effective from 00/00/0000';
        }
        if (!_.isEmpty(this.model.get('end_date_option_c'))) {
            if (this.model.get('end_date_option_c') == 'End date') {
                if (!_.isEmpty(this.model.get('recurring_end_date_c')))
                    message += ' until ' + this.model.get('recurring_end_date_c');
                else
                    message += ' until 00/00/0000';
            } else {

            }
        } else {
            message += ' until 00/00/0000';
        }

        this.$el.children('div').text(message);
        this.$el.children('div').attr('title', message);
    },

    _render: function () {
        this._super('_render');
        if (this.def.highlight) {
            this.$el.parents('div:first').attr('style', 'background-color:whitesmoke;');
        }
    },

    getUserDateTimeFormat: function () {
        return app.user.getPreference('datepref') + ' ' + app.user.getPreference('timepref');
    },
})
