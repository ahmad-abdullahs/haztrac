(function (app) {
    app.events.on('app:init', function () {
        app.plugins.register('WasteProfilePlugin', ['view', 'layout', 'field'], {
            fieldsDataChangeBinding: function () {
                this.model.on('change:quest_is_usepa_hazardous_c', this.hideUsepaHazardousDependentFields, this);
                this.model.on('change:quest_animal_waste_c', this.hideAnimalWasteDependentFields, this);
                this.model.on('change:quest_pcb_c', this.hidePCBsDependentFields, this);

                // Don't add heavy logic in this function because it is called once for all 
                // dependencies on the create view at time of creation.
                this.on('sugarlogic:initialize', function () {
                    this.hideUsepaHazardousDependentFields("", this.model.get('quest_is_usepa_hazardous_c'));
                    this.hideAnimalWasteDependentFields("", this.model.get('quest_animal_waste_c'));
                    this.hidePCBsDependentFields("", this.model.get('quest_pcb_c'));
                }, this);
            },

            hideUsepaHazardousDependentFields: function (model, fieldValue) {
                if (fieldValue == 'No') {
                    this.$('[data-fieldname="quest_waste_from_facility_c"]').parent('div').parent('div').hide();
                    this.$('[data-fieldname="quest_total_annual_benzene_c"]').parent('div').parent('div').hide();
                } else {
                    this.$('[data-fieldname="quest_waste_from_facility_c"]').parent('div').parent('div').show();
                    this.$('[data-fieldname="quest_total_annual_benzene_c"]').parent('div').parent('div').show();
                }
            },

            hideAnimalWasteDependentFields: function (model, fieldValue) {
                if (fieldValue == 'No' || fieldValue == 'NA') {
                    this.$('[data-fieldname="acknowledge_0"]').parent('div').parent('div').hide();
                    this.$('[data-fieldname="acknowledge_1_c"]').parent('div').parent('div').hide();
                    this.$('[data-fieldname="acknowledge_2_c"]').parent('div').parent('div').hide();
                } else {
                    this.$('[data-fieldname="acknowledge_0"]').parent('div').parent('div').show();
                    this.$('[data-fieldname="acknowledge_1_c"]').parent('div').parent('div').show();
                    this.$('[data-fieldname="acknowledge_2_c"]').parent('div').parent('div').show();
                }
            },

            hidePCBsDependentFields: function (model, fieldValue) {
                if (fieldValue == 'No') {
                    this.$('[data-fieldname="pcb_present_c"]').parent('div').parent('div').hide();
                    this.$('[data-fieldname="pcb_present_c_1"]').parent('div').parent('div').hide();
                } else {
                    this.$('[data-fieldname="pcb_present_c"]').parent('div').parent('div').show();
                    this.$('[data-fieldname="pcb_present_c_1"]').parent('div').parent('div').show();
                }
            },
        });
    });
})(SUGAR.App);