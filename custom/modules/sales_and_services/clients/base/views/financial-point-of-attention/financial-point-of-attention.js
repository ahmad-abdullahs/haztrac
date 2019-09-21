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
    /*
     * custom/modules/Opportunities/clients/base/views/archive-service/archive-service.js 
     */
    extendsFrom: 'sales_and_servicesCustomPointOfAttentionView',
    initialize: function (options) {
        this._super('initialize', [options]);

        // Set empty to these values to avoid the No-Data text in the field
        this.model.set({
            'rli_extd_price': '',
            'extd_cost': '',
            'extd_list': '',
            'profit': '',
            'profit_margin': '',
            'commission': '',
        });
    },
    render: function () {
        this._super('render');
    },
    bindDataChange: function () {
        this._super('bindDataChange');
    },
})
