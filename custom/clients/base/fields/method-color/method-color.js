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

    getSelect2Options: function (optionsKeys) {
        var select2Options = this._super('getSelect2Options', [optionsKeys]);
        var self = this;

        select2Options = _.extend(select2Options, {
            formatResultCssClass: _.bind(function (color) {
                if (color.id) {
                    return 'select2-result-css-' + color.text;
                }
            }, self),
        });

        return select2Options;
    },
})
