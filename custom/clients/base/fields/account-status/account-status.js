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

    initialize: function (options) {
        this._super("initialize", [options]);
        this.format();
    },

    bindDataChange: function () {
        if (this.model) {
            this.model.on('change:account_status_c', function (model, value) {
                if (value == "Account On Hold") {
                    this.render();
                    this.showBadge = true;
                } else {
                    this.hide();
                }
            }, this);
        }
    },

    format: function (value) {
        value = '';
        if (this.model.get('account_status_c') == "Account On Hold") {
            value = this.label = app.lang.get(this.def.badge_label, this.module);
            this.showBadge = true;
        }

        return value;
    },

    _render: function () {
        this._super("_render");
    },
})
