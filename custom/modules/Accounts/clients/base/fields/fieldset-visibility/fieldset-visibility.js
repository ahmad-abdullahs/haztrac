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
 * A fieldset is a field that contains one or more child fields.
 * The hbs template sets the placeholders of child fields but the creation of
 * child fields reside in the controller.
 *
 * Accessibility is checked against each child field as well as the fieldset.
 * We do not hide the fieldset in the event that the fieldset is accessible and
 * all child fields are not.
 *
 * Supported properties:
 *
 * - {Array} fields List of fields that are part of the fieldset.
 * - {boolean} show_child_labels Set to `true` to show labels on child fields in
 * the record view.
 * - {boolean} inline Set to `true` to render the fieldset inline.
 * - {boolean} equal_spacing When in inline mode, setting `true` will make the
 * fields inside fieldsets to have equal spacing, rather than being left aligned.
 *
 * Example usage:
 *
 *      array(
 *          'name' => 'date_entered_by',
 *          'type' => 'fieldset',
 *          'label' => 'LBL_DATE_ENTERED',
 *          'fields' => array(
 *              array(
 *                  'name' => 'date_entered',
 *              ),
 *              array(
 *                  'type' => 'label',
 *                  'default_value' => 'LBL_BY',
 *              ),
 *              array(
 *                  'name' => 'created_by_name',
 *              ),
 *          )
 *      )
 *
 * @class View.Fields.Base.FieldsetField
 * @alias SUGAR.App.view.fields.BaseFieldsetField
 * @extends View.Fields.Base.BaseField
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
        this._super('_renderFields', [fields]);

        if (this.name == 'billing_address' || this.name == 'shipping_address') {
            /*_.each(fields, function (field) {
             if (field.name == 'billing_address_third_party_name' || field.name == 'shipping_address_third_party_name') {
             this.set3rdPartyVisibility(this.model.get('account_type_cst_c'), field);
             }
             }, this);*/
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
