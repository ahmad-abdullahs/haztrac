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
 * @class View.Fields.Base.RadioenumField
 * @alias SUGAR.App.view.fields.BaseRadioenumField
 * @extends View.Fields.Base.EnumField
 */
({
    // On list-edit template,
    // we want the radio buttons to be replaced by a select so each method must call the EnumField method instead.
    extendsFrom: 'RadioenumField',

    _render: function () {
        this._super("_render");

        // Show the multicheck box list in linear fashion...
        this.$el.css('display', 'flex');
    },
    bindDomChange: function () {
        multicheckbox = this;
        if (this.tplName === 'list-edit') {
            this._super("bindDomChange");
        } else {
            if (!(this.model instanceof Backbone.Model))
                return;
            var self = this;
            var el = this.$el.find(this.fieldTag);
            el.on("change", function () {
                self.model.set(self.name, self.unformat(self.$(self.fieldTag + ":checkbox:checked").val()));
            });
        }
    },
    format: function (value) {
        if (this.tplName === 'list-edit') {
            return this._super("format", [value]);
        } else {
            return app.view.Field.prototype.format.call(this, value);
        }
    },
    unformat: function (value) {
        if (this.tplName === 'list-edit') {
            return this._super("unformat", [value]);
        } else {
            return app.view.Field.prototype.unformat.call(this, value);
        }
    },
})
