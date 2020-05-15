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
({
    extendsFrom: 'BaseField',

    colorCodeClasses: {
//        pending: 'label label-pending', // black border
//        upcoming: 'label label-warning', // yellow
//        overdue: 'label label-important', // red
        pending: 'font-size: 10.152px;line-height: 14px;vertical-align: baseline;white-space: nowrap;text-shadow: none;display: inline-block;cursor: default;padding: 2px 4px;background: #555;font-weight: 600;text-align: center;border-radius: 2px;box-sizing: border-box;background-color: #555;background: #555;border: 1px solid #555;color: #fff;', // black border
        upcoming: 'font-size: 10.152px;line-height: 14px;display: inline-block;padding: 2px 4px;background: #555;color: #fff;font-weight: 600;text-align: center;border-radius: 2px;box-sizing: border-box;background-color: #fbc02d;border: 1px solid #fbc02d;', // yellow
        overdue: 'font-size: 10.152px;line-height: 14px;display: inline-block;padding: 2px 4px;background: #555;color: #fff;font-weight: 600;text-align: center;border-radius: 2px;box-sizing: border-box;background-color: #e61718;border: 1px solid #e61718;', // red
    },

    /**
     * @inheritdoc
     *
     * Checks color code conditions to determine if field should have
     * color applied to it.
     */
    _render: function () {
        this.type = 'base'; //use base templates
        this._super('_render');
        this.setColorCoding();
    },

    /**
     * @inheritdoc
     *
     * Listen for status change - set color coding appropriately
     */
    bindDataChange: function () {
        this._super('bindDataChange');
        this.model.on('change:start_date_c', this.setColorCoding, this);
    },

    /**
     * Set color coding based on completion status and date compared to today
     * This is only applied when the action is list (not inline edit on list view)
     */
    setColorCoding: function () {
        var colorCodeClass;

//        this._clearColorCode();
        this._clearColorCodeStyle();

        if (!this.model || !_.contains(['list', 'disabled'], this.action)) {
            return;
        }

        colorCodeClass = this._getColorCodeClass();
//        this._setColorCodeClass(colorCodeClass);
        this._setColorCodeStyle(colorCodeClass);
    },

    /**
     * Get color code class based on the date compared to today
     * If event is today - use 'today' color code
     * If event is yesterday or earlier - use 'overdue' color code
     *
     * @return {String|null} One of the color codes or null if no color code
     * @private
     */
    _getColorCodeClass: function () {
        var startDate, today;

        if (!this.model.get('start_date_c') || this.model.get('complete_date_c')) {
            return null;
        }

        //compare the date with today
        var startDate = moment(this.model.get('start_date_c')).startOf('day');
        var today = moment().startOf('day');
        var days = (today.diff(startDate, 'days', true));

        if (days < 8) {
            return this.colorCodeClasses.pending;
        } else if (days == 8 || days == 9) {
            return this.colorCodeClasses.upcoming;
        } else {
            return this.colorCodeClasses.overdue;
        }
    },

    /**
     * Set the color code class to the field tag or clear out if no
     * color code should be applied (colorCodeClass is null)
     *
     * @param {String|null} colorCodeClass
     * @private
     */
//    _setColorCodeClass: function (colorCodeClass) {
//        if (!_.isNull(colorCodeClass)) {
//            this.$el.addClass(colorCodeClass);
//        }
//    },

    _setColorCodeStyle: function (colorCodeClass) {
        if (!_.isNull(colorCodeClass)) {
            this.$el.attr('style', colorCodeClass);
        }
    },

    /**
     * Clear color coding classes
     *
     * @private
     */
//    _clearColorCode: function () {
//        _.each(this.colorCodeClasses, function (colorCodeClass) {
//            this.$el.removeClass(colorCodeClass);
//        }, this);
//    },

    _clearColorCodeStyle: function () {
        _.each(this.colorCodeClasses, function (colorCodeClass) {
            this.$el.removeAttr('style');
        }, this);
    },
})
