({
    extendsFrom: 'AccountsRecordView',

    initialize: function (options) {
        this._super('initialize', [options]);
        // Add listener for custom button
        this.context.on('button:close_drawer_button:click', this.closeDrawer, this);
    },

    getActiveTab: function (options) {
        return false;
    },

    _buildGridsFromPanelsMetadata: function (panels) {
        this._super('_buildGridsFromPanelsMetadata', [panels]);

        // Only Add the Close button if this is initiated from the RevenueLineItems (open in drawer) or Maps View.
        var openInDrawer = this.context.get('initiatedByMapView') || false;
        if (!openInDrawer) {
            this.options.meta.buttons = _.reject(this.options.meta.buttons, function (btn) {
                return _.contains(["close_drawer_button"], btn.name);
            }, this);
        }
    },

    editClicked: function () {
        this.setButtonStates(this.STATE.EDIT);
        this.action = 'edit';
        this.toggleEdit(true);
        // Only set the route if its the real record view, not the record view opened in the
        // drawer, like we are opening the record view in drawer for RevenueLineItems or Maps.
        var openInDrawer = this.context.get('initiatedByMapView') || false;
        if (!openInDrawer) {
            this.setRoute('edit');
        }
    },

    cancelClicked: function () {
        this.setButtonStates(this.STATE.VIEW);
        this.action = 'detail';
        this.handleCancel();
        this.clearValidationErrors(this.editableFields);
        // Only set the route if its the real record view, not the record view opened in the
        // drawer, like we are opening the record view in drawer for RevenueLineItems or Maps.
        var openInDrawer = this.context.get('initiatedByMapView') || false;
        if (!openInDrawer) {
            this.setRoute();
        }
        this.unsetContextAction();
    },

    handleSave: function () {
        if (this.disposed) {
            return;
        }
        this._saveModel();
        this.$('.record-save-prompt').hide();

        if (!this.disposed) {
            this.setButtonStates(this.STATE.VIEW);
            this.action = 'detail';
            // Only set the route if its the real record view, not the record view opened in the
            // drawer, like we are opening the record view in drawer for RevenueLineItems or Maps.
            var openInDrawer = this.context.get('initiatedByMapView') || false;
            if (!openInDrawer) {
                this.setRoute();
            }
            this.unsetContextAction();
            this.toggleEdit(false);
            this.inlineEditMode = false;
        }
    },

    closeDrawer: function () {
        app.drawer.close();
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
