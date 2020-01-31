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
    color: '',

    initialize: function (options) {
        this._super("initialize", [options]);
        this.format();
    },

    bindDataChange: function () {
        if (this.model) {
            this.model.on('change:profile_acceptance_c', function (model, value) {
//                if (_.contains(['Accepted', 'Expired', 'Pending', 'Rejected'], value)) {
                this.setColor(value);
                this.showBadge = true;
                this.render();
//                } else {
//                    this.hide();
//                }
            }, this);
        }
    },

    format: function (value) {
        value = '';

        var profile_acceptance_c = this.view.getField('profile_acceptance_c');
        if (profile_acceptance_c) {
            var ddList = app.lang.getAppListStrings(profile_acceptance_c.def.options);
            var valueToDisplay = ddList[this.model.get('profile_acceptance_c')];
            value = this.label = app.lang.get(valueToDisplay, this.module);
            this.setColor(this.model.get('profile_acceptance_c'));
            this.showBadge = true;
        }

        return value;
    },

    setColor: function (value) {
        if (_.contains(['Accepted'], value)) {
            this.color = 'green';
        } else if (_.contains(['Expired'], value)) {
            this.color = 'red';
        } else if (_.contains(['Rejected'], value)) {
            this.color = 'black';
        } else if (_.contains(['Pending'], value)) {
            this.color = 'blue';
//            this.color = 'darkgoldenrod';
        }
    },

    _render: function () {
        this._super("_render");
    },
})
