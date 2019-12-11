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
    extendsFrom: 'EnumSameKeyAndValueField',
    initialize: function (options) {
        this._super('initialize', [options]);
    },
    bindDataChange: function () {
        this._super('bindDataChange');
        if (this.model) {
            this.model.on('change:quest_usepa_hazardous_waste_c', function (model, value) {
                var usepaWasteCodesList = [];
                if (this.model.get('quest_usepa_hazardous_waste_c') == 'Yes') {
                    var constituent_regulated = this.view.getField('constituent_regulated');
                    var constituent_volatile = this.view.getField('constituent_volatile');
                    var constituent_semivolatile = this.view.getField('constituent_semivolatile');
                    var constituent_pesticide_herbicide = this.view.getField('constituent_pesticide_herbicide');

                    usepaWasteCodesList.push(constituent_regulated.usepaWasteCodes);
                    usepaWasteCodesList.push(constituent_volatile.usepaWasteCodes);
                    usepaWasteCodesList.push(constituent_semivolatile.usepaWasteCodes);
                    usepaWasteCodesList.push(constituent_pesticide_herbicide.usepaWasteCodes);

                    // Merge the existing options if user has made any in the USEPA Hazard waste code field...
                    var notes_usepa_hazardous_waste_list = this.model.get('notes_usepa_hazardous_waste_c') || [];
                    usepaWasteCodesList = _.filter(_.uniq(_.union(usepaWasteCodesList, notes_usepa_hazardous_waste_list)));
                    this.model.set('notes_usepa_hazardous_waste_c', usepaWasteCodesList);
                }
            }, this);
        }
    },

})