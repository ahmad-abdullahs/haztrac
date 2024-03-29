({
    extendsFrom: 'AccountsRecordView',

    initialize: function (options) {
        this._super('initialize', [options]);
        // Add listener for custom button
        this.context.on('button:close_drawer_button:click', this.closeDrawer, this);

        // loading maps api if not loaded
        if (typeof (google) == "undefined") {
            var script = document.createElement('script');
            script.src = "//maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyAyAAyXJDGMIgFTJXsmdQdsnoS_XDQu62o";
            document.body.appendChild(script);
        }
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
        this.model.on('change:shipping_address_plus_code_val', _.bind(
                this.getLonLat, this, 'shipping_address_lat', 'shipping_address_lon'), this);
        this.model.on('change:service_site_address_plus_code_val', _.bind(
                this.getLonLat, this, 'service_site_address_lat', 'service_site_address_lon'), this);
//        this.model.on('change:different_service_site_c', this.addValidationOnServiceSiteAddress, this);
//        this.model.on('change:account_type_cst_c', this.addValidationOnServiceSiteAddress, this);
        this._super('bindDataChange');
    },

//    addValidationOnServiceSiteAddress: function (model, value) {
//        var fieldsList = [
//            'service_site_address_name',
//            'service_site_address_street_c',
//            'service_site_address_city_c',
//            'service_site_address_state_c',
//            'service_site_address_postalcode_c',
//            'service_site_address_country_c',
//        ], isRequired = false;
//
//        if (_.contains(this.model.get('account_type_cst_c'), "Separate Svc Site") && this.model.get('different_service_site_c') == true) {
//            isRequired = true;
//        }
//        _.each(fieldsList, function (fieldName) {
//            this.setRequired(fieldName, isRequired);
//        }, this);
//    },

    /*
     * This function is added to find the logitude and latitude on fly from Plus Code.
     * When Plus code field is changed it automatically populate the co-ordinates.
     */
    getLonLat: function (latFieldName, lngFieldName, model, value) {
        var self = this;
        if (!_.isEmpty(value)) {
            if (typeof (google) == "undefined") {
                return;
            }
            //  JW5F+QP Palmdale, CA, USA
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({address: value}, (results, status) => {
                if (status === "OK") {
                    var _lat = results[0].geometry.location.lat(),
                            _lng = results[0].geometry.location.lng();

                    self.model.set({
                        [latFieldName]: _lat,
                        [lngFieldName]: _lng,
                    });
                } else {
                    console.log("Geocode was not successful for the following reason: " + status);
                }
            });
        }
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
            this.$el.find('#recordTab').css('background-color', '#e61718');
        } else {
            this.$el.find('#recordTab').css('background-color', '#f6f6f6');
        }
    },

    hasUnsavedChanges: function () {
        var changedAttributes,
                editableFieldNames = [],
                unsavedFields,
                self = this,
                setAsEditable = function (fieldName) {
                    if (fieldName && _.indexOf(self.noEditFields, fieldName) === -1) {
                        editableFieldNames.push(fieldName);
                    }
                };

        if (this.resavingAfterMetadataSync)
            return false;

        changedAttributes = this.model.changedAttributes(this.model.getSynced());

        if (_.isEmpty(changedAttributes)) {
            return false;
        }

        // #HPMB-220 Ignore these field to avoid the a pop up comes up asking if I want to save changes
        let ignoreFields = ['shipping_address_lat', 'shipping_address_lon'];
        if (_.isEmpty(_.difference(_.keys(changedAttributes), ignoreFields))) {
            return false;
        }

        // get names of all editable fields on the page including fields in a fieldset
        _.each(this.meta.panels, function (panel) {
            _.each(panel.fields, function (field) {
                if (!field.readonly) {
                    setAsEditable(field.name);
                    if (field.fields && _.isArray(field.fields)) {
                        _.each(field.fields, function (field) {
                            setAsEditable(field.name);
                        });
                    }
                }
            });
        });

        // check whether the changed attributes are among the editable fields
        unsavedFields = _.intersection(_.keys(changedAttributes), editableFieldNames);

        return !_.isEmpty(unsavedFields);
    }
})
