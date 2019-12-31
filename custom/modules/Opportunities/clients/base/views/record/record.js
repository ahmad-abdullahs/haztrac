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
    extendsFrom: 'OpportunitiesRecordView',

    /**
     * Holds a reference to the alert this view triggers
     */
    alert: undefined,

    /**
     * @inheritdoc
     * @param {Object} options
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    /**
     * Add the initListener if RLI's are being used and the current user has Edit access to RLI's
     */
    addInitListener: function () {
        // if we are viewing by RevenueLineItems and we have access to edit/create RLI's then we should
        // display the warning if no rli's exist
        if (app.metadata.getModule('Opportunities', 'config').opps_view_by == 'RevenueLineItems' &&
                app.acl.hasAccess('edit', 'RevenueLineItems')) {
            this.once('init', function () {
                var rlis = this.model.getRelatedCollection('revenuelineitems');
                rlis.once('reset', function (collection) {
                    // check if the RLI collection is empty
                    // and make sure there isn't another RLI warning on the page
                    if (collection.length === 0 && $('#createRLI').length === 0) {
                        // --
                        // This code is commented to avoid the warning shown on the Opportunities record view...
                        // "Warning: An Opportunity must have an associated Revenue Line Item. Create a Revenue Line Item." 
                        // this.showRLIWarningMessage(this.model.module);
                    }
                }, this);
                rlis.fetch({relate: true});
            }, this);
        }
    },
})
