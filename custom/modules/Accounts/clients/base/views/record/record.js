({
    extendsFrom: 'AccountsRecordView',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    getActiveTab: function (options) {
        return false;
    },

    bindDataChange: function () {
        this.model.on('change:account_status_c', this.colorTheTabs, this);
        this.model.on('change:different_service_site_c', this.addValidationOnServiceSiteAddress, this);
        this.model.on('change:account_type_cst_c', this.addValidationOnServiceSiteAddress, this);
        this._super('bindDataChange');
    },

    addValidationOnServiceSiteAddress: function (model, value) {
        var fieldsList = [
            'service_site_address_name',
            'service_site_address_street_c',
            'service_site_address_city_c',
            'service_site_address_state_c',
            'service_site_address_postalcode_c',
            'service_site_address_country_c',
        ], isRequired = false;

        if (_.contains(this.model.get('account_type_cst_c'), "Separate Svc Site") && this.model.get('different_service_site_c') == true) {
            isRequired = true;
        }
        _.each(fieldsList, function (fieldName) {
            this.setRequired(fieldName, isRequired);
        }, this);
    },

    setRequired: function (target, required) {
        //Force required to be boolean true or false
        required = SUGAR.expressions.Expression.isTruthy(required);
        var field = this.getField(target, this.model);
        if (field) {
            field.def.required = required;
            field.render();
        }
    },

    colorTheTabs: function (model, value) {
        if (value == 'Account On Hold') {
            this.$el.find('#recordTab').css('background-color', 'red');
        } else {
            this.$el.find('#recordTab').css('background-color', '#f6f6f6');
        }
    },
})
