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
        var self = this;
        if (this.model) {
            this.model.on('change:' + this.name, function (model, value) {
                var fieldName1 = 'physical_address_account_name',
                        physical_address_account_name = this.view.getField(fieldName1),
                        fieldName2 = 'service_site_address_c',
                        service_site_address_c = this.view.getField(fieldName2);

                if (physical_address_account_name) {
                    if (_.contains(value, "3rd Party")) {
                        physical_address_account_name.show();
                        self.view.$el.find('div.record-cell[data-name=' + fieldName1 + ']').show();
                    } else {
                        physical_address_account_name.hide();
                        self.view.$el.find('div.record-cell[data-name=' + fieldName1 + ']').hide();
                        this.model.set('physical_address_account_id', '');
                        this.model.set('physical_address_account_name', '');
                    }
                }

//                if (service_site_address_c) {
//                    if (_.contains(value, "Separate Svc Site")) {
//                        service_site_address_c.show();
//                        $('div.record-cell[data-name=' + fieldName2 + ']').show();
//                    } else {
//                        service_site_address_c.hide();
//                        $('div.record-cell[data-name=' + fieldName2 + ']').hide();
//                        this.model.set('service_site_address_name', '');
//                        this.model.set('service_site_address_street_c', '');
//                        this.model.set('service_site_address_city_c', '');
//                        this.model.set('service_site_address_state_c', '');
//                        this.model.set('service_site_address_postalcode_c', '');
//                        this.model.set('service_site_address_country_c', '');
//                    }
//                }
            }, this);
        }
    },

})