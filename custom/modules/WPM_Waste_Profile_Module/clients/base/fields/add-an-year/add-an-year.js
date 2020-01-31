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
 * @class View.Fields.Base.DateField
 * @alias SUGAR.App.view.fields.BaseDateField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'DateField',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    bindDataChange: function () {
        this._super('bindDataChange');
        if (this.model) {
            this.model.on('change:generator_sign_date_c', function (model, value) {
                if (value) {
                    this.model.set('profile_expiration_date_c', (this.getExpirationDate(value)).substring(0, 10));
                } else {
                    this.model.set('profile_expiration_date_c', '');
                }
            }, this);
        }
    },

    /**
     * @param {Function} _render
     * @Description : This function is override to set default date to next month (same day and time) for start date
     */
    getExpirationDate: function (value) {
        var dateValue = new Date(value);
        value = new Date(new Date(dateValue).setMonth(dateValue.getMonth() + 12));
        return this.setDateTimeFormate(app.date(value).format(app.date.convertFormat(this.getUserDateTimeFormat())));
    },

    setDateTimeFormate: function (value) {
        if (!value) {
            return value;
        }
        value = app.date(value, app.date.convertFormat(this.getUserDateTimeFormat()), true);
        if (!value.isValid()) {
            return;
        }
        return value.format();
    },

    /**
     * @param {Function} getUserDateTimeFormat
     * @Description : function to get user date and time format
     */
    getUserDateTimeFormat: function () {
        return app.user.getPreference('datepref') + ' ' + app.user.getPreference('timepref');
    },
})
