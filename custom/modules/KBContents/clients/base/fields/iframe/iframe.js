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
 * @class View.Fields.Base.IframeField
 * @alias SUGAR.App.view.fields.BaseIframeField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'IframeField',

    /**
     * @inheritdoc
     */
    _render: function () {
        this._super('_render');
        if (this.tplName == 'preview') {
            if (!this.value) {
                this.$el.parent().parent().css('display', '');
            } else {
                this.$el.parent().parent().css('display', 'block');
            }
        }
    },

    format: function (value) {
        value = this._super('format', [value]);

        if (this.tplName == 'preview') {
            if (!this.value) {
                this.$el.parent().parent().css('display', '');
            } else {
                this.$el.parent().parent().css('display', 'block');
            }
        }

        return value;
    }
})
