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
 * @class View.Views.Base.Calls.CreateView
 * @alias SUGAR.App.view.views.CallsCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'CreateView',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        var self = this;
        this._super('initialize', [options]);
        this.model.on('change:quest_is_usepa_hazardous_c', this.hideUsepaHazardousDependentFields, this);
        this.model.on('change:quest_animal_waste_c', this.hideAnimalWasteDependentFields, this);
        app.api.call('read', App.api.buildURL('getWasteProfileNum'), {}, {
            success: function (data) {
                self.model.set('waste_profile_num_c', data);
            },
            error: function (e) {
                throw e;
            }
        });
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
})
