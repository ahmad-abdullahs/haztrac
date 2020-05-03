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
({
    extendsFrom: 'FieldsetField',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    _render: function () {
        this._super('_render');
    },

    _renderFields: function (fields) {
        var plusCodeFields = [
            'shipping_address_plus_code_val',
            'service_site_address_plus_code_val',
        ];

        // On detail view, don't show the plus code field.
        if (this.action == 'detail') {
            fields = _.filter(fields, function (obj) {
                return !_.contains(plusCodeFields, obj.name);
            });
        }

        this._super('_renderFields', [fields]);

        if (this.name == 'billing_address' || this.name == 'shipping_address' ||
                this.name == 'service_site_address_c') {
            _.each(fields, function (field) {
                if (field.name == 'shipping_address_plus_code_cb' || field.name == 'service_site_address_plus_code_cb') {
                    field.handleDependentFieldsVisibility(null, this.model.get(field.name));
                }
//                if (field.name == 'billing_address_third_party_name' || field.name == 'shipping_address_third_party_name') {
//                    this.set3rdPartyVisibility(this.model.get('account_type_cst_c'), field);
//                }
            }, this);
            this.colorAddressFields(this.model.get('account_type_cst_c'));
        }
    },

    bindDataChange: function () {
        if (this.model) {
            this.model.on('change:account_type_cst_c', function (model, value) {
//                this.set3rdPartyVisibility(value);
                this.colorAddressFields(value);
            }, this);
        }

        this._super('bindDataChange');
    },

    colorAddressFields: function (value) {
        if (_.contains(value, "3rd Party")) {
            this.view.$el.find('[data-name=billing_address]').find('input,textarea').css('background-color', '#ddffa8');
            this.view.$el.find('[data-name=shipping_address]').find('input,textarea').css('background-color', '#ddffa8');
            this.view.$el.find('[data-fieldname=billing_address]').find('.address.fieldset').css('background-color', '#ddffa8');
            this.view.$el.find('[data-fieldname=shipping_address]').find('.address.fieldset').css('background-color', '#ddffa8');
        } else {
            this.view.$el.find('[data-name=billing_address]').find('input,textarea').css('background-color', '');
            this.view.$el.find('[data-name=shipping_address]').find('input,textarea').css('background-color', '');
            this.view.$el.find('[data-fieldname=billing_address]').find('.address.fieldset').css('background-color', '');
            this.view.$el.find('[data-fieldname=shipping_address]').find('.address.fieldset').css('background-color', '');
        }

//        if (_.contains(value, "Separate Svc Site")) {
//            this.view.$el.find('[data-name=service_site_address_c]').find('input,textarea').css('background-color', '#ddffa8');
//            this.view.$el.find('[data-fieldname=service_site_address_c]').find('.address.fieldset').css('background-color', '#ddffa8');
//        } else {
//            this.view.$el.find('[data-name=service_site_address_c]').find('input,textarea').css('background-color', '');
//            this.view.$el.find('[data-fieldname=service_site_address_c]').find('.address.fieldset').css('background-color', '');
//        }
    },

    set3rdPartyVisibility: function (value, field) {
        if (_.contains(value, '3rd Party')) {
            this.view.$el.find('[name=billing_address_third_party_name]').parent('span').removeClass('hidden');
            this.view.$el.find('[name=shipping_address_third_party_name]').parent('span').removeClass('hidden');
            this.view.$el.find('[field-name=billing_address_third_party_name]').show();
            this.view.$el.find('[field-name=shipping_address_third_party_name]').show();
        } else {
            this.view.$el.find('[name=billing_address_third_party_name]').parent('span').addClass('hidden');
            this.view.$el.find('[name=shipping_address_third_party_name]').parent('span').addClass('hidden');
            this.view.$el.find('[field-name=billing_address_third_party_name]').hide();
            this.view.$el.find('[field-name=shipping_address_third_party_name]').hide();
            this.model.set('billing_address_third_party_name', '');
            this.model.set('shipping_address_third_party_name', '');
        }
    },
})
