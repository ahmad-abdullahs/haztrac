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
 * @class View.Fields.Base.BoolField
 * @alias SUGAR.App.view.fields.BaseBoolField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'BoolField',
    initialize: function (options) {
        this._super('initialize', [options]);
    },
    render: function () {
        this._super('render');
        if (this.view instanceof app.view.views.BaseCreateView
                || (this.model.get(this.name) == false || this.model.get(this.name) == 0)) {
            this.visibilityHandle(false);
        }
    },
    bindDataChange: function () {
        this._super('bindDataChange');
        if (this.model) {
            this.model.on('change:' + this.name, function (model, value) {
                this.visibilityHandle(value);
            }, this);
        }
    },
    visibilityHandle: function (value) {
        var fieldName1 = 'waste_profile_relate_c',
                waste_profile_relate_c = this.view.getField(fieldName1);

        if (waste_profile_relate_c) {
            if (value == true || value == 1) {
                waste_profile_relate_c.show();
                $('div.record-cell[data-name=' + fieldName1 + ']').show();
            } else {
                waste_profile_relate_c.hide();
                $('div.record-cell[data-name=' + fieldName1 + ']').hide();
            }
        }
    },

})