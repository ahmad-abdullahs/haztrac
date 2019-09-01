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
 * @class View.Views.Base.SelectionHeaderpaneView
 * @alias SUGAR.App.view.views.BaseSelectionHeaderpaneView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    extendsFrom: 'SelectionHeaderpaneView',

    initialize: function (options) {
        // ++
        // If *Copy Existing Record* button is clicked, we get to know this copyLinkRecords flag,
        // which comes through the custom/modules/RevenueLineItems/clients/base/fields/copy-link-action/copy-link-action.js file.
        // Change the default *Add* button label to *Copy*
        // Futher above flag is used in the custom/modules/RevenueLineItems/clients/base/views/mass-link/mass-link.js file
        // to differentiate and send params to the link API call, not to just the record but first copy the records and then 
        // link them up.
        if (this.options.context.get('copyLinkRecords')) {
            _.each(this.options.meta.buttons, function (_buttons) {
                if (_buttons.name == 'main_dropdown') {
                    _.each(_buttons.buttons, function (_button) {
                        if (_button.name == 'link_button') {
                            _button.label = 'LBL_COPY_RLI_BUTTON';
                        }
                    });
                }
            });
        }

        this._super('initialize', [options]);
    },
})
