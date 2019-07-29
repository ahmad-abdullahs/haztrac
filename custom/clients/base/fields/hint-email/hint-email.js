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
 * @class View.Fields.Base.EmailField
 * @alias SUGAR.App.view.fields.BaseEmailField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'EmailField',

    /**
     * @inheritdoc
     * @param {Object} options Intialization options.
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.events = _.extend({}, this.events, {
            'change [type="text"]': 'emailFieldChange',
        });

        var newMailEvent = 'app:' + this.module + ':addNewEmail';
        this.context.on(newMailEvent, this.updateEmailFieldWithImportedData, this);
    },

    updateEmailFieldWithImportedData: function(newEmails) {
        _.each(newEmails, this.addNewAddressOnCreate, this);
    },

    /**
     * Add new imported email address.
     * @param {String} email
     */
    addNewAddressOnCreate: function(emailItem) {
        var email = emailItem.email_address.trim();

        if (email !== '') {
            var emailFieldHtml = this._buildEmailFieldHtml({
                email_address: email,
                primary_address: emailItem.primary_address,
                opt_out: false,
                invalid_email: false
            }, this);

            this._getNewEmailField().closest('.email').before(emailFieldHtml);

            if (this.def.required && this._shouldRenderRequiredPlaceholder()) {
                var label = app.lang.get('LBL_REQUIRED_FIELD', this.module),
                    el = this.$(this.fieldTag).last(),
                    placeholder = el.prop('placeholder').replace('(' + label + ') ', '');

                el.prop('placeholder', placeholder.trim()).removeClass('required');
            }
        }
    },

    isValidEmail: function(email) {
        var regEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return email.trim() !== '' && regEx.test(email);
    },

    getEmailAddress: function(event) {
        var eventTarget = this.$(event.currentTarget),
            existingAddress = this.$('.existingAddress');
        return existingAddress.length === 1 ? existingAddress.val() : eventTarget.val();
    },

    hasExistingAddress: function() {
        return this.$('.existingAddress').length === 1;
    },

    emailFieldChange: function(event) {
        var email = this.getEmailAddress(event),
            index = this.$('input').index(this.$(event.currentTarget));

        if ((index === 0 || this.hasExistingAddress()) && this.isValidEmail(email)) {
            this.reloadPreview();
        }
    },

    reloadPreview: function() {
        app.events.trigger('preview:close');
        app.events.trigger('preview:render', this.model);
        app.events.trigger('hint:user-input', true);
    }
});
