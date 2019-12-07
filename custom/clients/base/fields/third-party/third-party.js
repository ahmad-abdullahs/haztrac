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

    initialize: function (options) {
        this._super("initialize", [options]);
        this.format();
    },

    bindDataChange: function () {
        if (this.model) {
            this.model.on('change:account_type_cst_c', function (model, value) {
                if (_.contains(value, "3rd Party")) {
                    this.render();
                } else {
                    this.hide();
                }
            }, this);
        }
    },

    format: function (value) {
        value = '';
        if (_.contains(this.model.get('account_type_cst_c'), "3rd Party")) {
            value = this.label = app.lang.get(this.def.label, this.module);
        }

        return value;
    },

    _render: function () {
        this._super("_render");
    },
})
