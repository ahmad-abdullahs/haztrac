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
        this._super('initialize', [options]);
    },

    /**
     * Open create inline modal with no dupe check
     * On save, set the selection model which will close the selection-list inline modal
     */
    createAndSelect: function () {
        app.drawer.open({
            layout: 'create-nodupecheck',
            context: {
                module: this.module,
                create: true,
                // This code is added to send the sales and service model data to manifest create drawer, 
                // when manifest is created at the time of sales and service creation, from RLI subpanel create list subpanel.
                immediateParentModel: this.checkAvailability() ? this.layout.layout.layout.options.def.immediateParentModel : {},
            }
        }, _.bind(function (context, model) {
            if (model) {
                this.context.trigger('selection-list:select', context, model);
            }
        }, this));
    },

    checkAvailability: function () {
        if (this.layout) {
            if (this.layout.layout) {
                if (this.layout.layout.layout) {
                    if (this.layout.layout.layout.options) {
                        if (this.layout.layout.layout.options.def) {
                            if (this.layout.layout.layout.options.def.immediateParentModel) {
                                return true;
                            }
                        }
                    }
                }
            }
        }
        return false;
    },
})
