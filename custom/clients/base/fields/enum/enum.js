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
 * @class View.Fields.Base.EnumField
 * @alias SUGAR.App.view.fields.BaseEnumField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'EnumField',
    fieldTag: 'input.select2',
    appendValueTag: 'input[name=append_value]',
    isFetchingOptions: false,
    items: null,
    _keysOrder: null,
    initialize: function () {
        this._super('initialize', arguments);
    },
    _render: function () {
        this._super('_render');
        if (this.def.highlight) {
            var $el = this.$(this.fieldTag);
            $el.siblings('div').children('a').attr('style', 'background-color:' + this.def.backcolor + '; color:' + this.def.textcolor);
        }
    },
})
