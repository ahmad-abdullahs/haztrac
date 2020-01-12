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
    extendsFrom: 'RecordView',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
        this.model.on('change:quest_is_usepa_hazardous_c', this.hideDependentFields, this);
    },

    hideDependentFields: function (model, fieldValue) {
        if (fieldValue == 'No') {
            this.$('[data-fieldname="quest_waste_from_facility_c"]').parent('div').parent('div').hide();
            this.$('[data-fieldname="quest_total_annual_benzene_c"]').parent('div').parent('div').hide();
        } else {
            this.$('[data-fieldname="quest_waste_from_facility_c"]').parent('div').parent('div').show();
            this.$('[data-fieldname="quest_total_annual_benzene_c"]').parent('div').parent('div').show();
        }
    },
})
