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
 * @class View.Fields.Base.DatetimecomboField
 * @alias SUGAR.App.view.fields.BaseDatetimecomboField
 * @extends View.Fields.Base.DateField
 */
({
    extendsFrom: 'DatetimecomboField',

    bindDataChange: function () {
        if (!this.model) {
            return;
        }

        this.model.on('change:' + this.name, function (model, value) {
            if (this.disposed) {
                return;
            }

            if (this._inDetailMode()) {
                this.render();
                return;
            }

            value = this.format(value) || {'date': '', 'time': ''};

            this.$(this.fieldTag).val(value['date']);
            if (value['date']) {
                if (this.$(this.fieldTag).data('datepicker')) {
                    this.$(this.fieldTag).data('datepicker').setValue(value['date']);
                }
            }
            this.$(this.secondaryFieldTag).val(value['time']);
        }, this);
    },
})
