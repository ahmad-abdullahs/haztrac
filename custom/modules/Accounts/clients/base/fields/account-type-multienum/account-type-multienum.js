/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    extendsFrom: 'EnumField',
    initialize: function (options) {
        this._super('initialize', [options]);
    },
    render: function () {
        this._super('render');
    },
    bindDataChange: function () {
        this._super('bindDataChange');
        if (this.model) {
            this.model.on('change:' + this.name, function (model, value) {
                var fieldName = 'physical_address_account_name',
                        physical_address_account_name = this.view.getField(fieldName);

                if (physical_address_account_name) {
                    if (_.contains(value, "3rd Party")) {
                        physical_address_account_name.show();
                        $('div.record-cell[data-name=' + fieldName + ']').show();
                    } else {
                        physical_address_account_name.hide();
                        $('div.record-cell[data-name=' + fieldName + ']').hide();
                        this.model.set('physical_address_account_id', '');
                        this.model.set('physical_address_account_name', '');
                    }
                }
            }, this);
        }
    },

})