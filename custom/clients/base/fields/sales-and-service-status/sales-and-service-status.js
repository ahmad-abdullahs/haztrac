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
 * @class View.Fields.Base.FollowField
 * @alias SUGAR.App.view.fields.BaseFollowField
 * @extends View.Fields.Base.RowactionField
 */
({
    /**
     * @inheritdoc
     *
     * This field doesn't support `showNoData`.
     */
    showNoData: false,
    extendsFrom: 'RowactionField',
    showBadge: false,
    color: '#555555',
    colorMap: {
        'Complete': '#8bc34a', // green
        'LostSale': '#e61718', // red
        'Scheduled': '#ffc107', // yellow
    },

    initialize: function (options) {
        this._super("initialize", [options]);
        this.format();
    },

    bindDataChange: function () {
        if (this.model) {
            this.model.on('change:status_c', function (model, value) {
                if (_.contains(["Complete", "LostSale", "Scheduled"], value)) {
                    this.color = this.colorMap[value];
                    this.showBadge = true;
                    this.render();
                } else if (!_.isEmpty(value)) {
                    this.color = '#555555';// DEFAULT grey
                    this.showBadge = true;
                    this.render();
                } else {
                    this.hide();
                }
            }, this);
        }
    },

    format: function (value) {
        value = '';
        var value = this.model.get('status_c');
        if (!_.isEmpty(value) && !_.isUndefined(value)) {
            if (_.contains(["Complete", "LostSale", "Scheduled"], value)) {
                this.color = this.colorMap[value];
            } else if (!_.isEmpty(value)) {
                this.color = '#555555';// DEFAULT grey
            }

            var ddList = app.lang.getAppListStrings('status_list');
            var valueToDisplay = ddList[value];
            value = this.label = valueToDisplay;
            this.showBadge = true;
        }

        return value;
    },

    _render: function () {
        this._super("_render");
    },
})
