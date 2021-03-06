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
    fieldTag: 'input[data-type=date]',
    direction: 'ltr',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    _dispose: function () {
        if (this._hasDatePicker) {
            if (this.$(this.fieldTag).data('datepicker')) {
                $(window).off('resize', this.$(this.fieldTag).data('datepicker').place);
            }
        }

        this._hasDatePicker = null;
        this._super('_dispose');
    }
})
