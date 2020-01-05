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
 * @class View.Layouts.Base.SubpanelsLayout
 * @alias SUGAR.App.view.layouts.BaseSubpanelsLayout
 * @extends View.Layout
 */
({
    extendsFrom: 'SubpanelsLayout',

    _hiddenSubpanels: [],

    initialize: function (options) {
        this._super('initialize', [options]);
        this.registerModelEvents();
    },

    /**
     * Add the model change events for fields that determine when a subpanel should be hidden
     */
    registerModelEvents: function () {
        this.model.on('change:account_type_cst_c', function (model) {
            var link = 'v_vendors_accounts';
            if (_.contains(model.get('account_type_cst_c'), "Vendor")) {
                this.unhideSubpanel(link);
            } else {
                this.hideSubpanel(link);
            }
        }, this);
    },

    /**
     * Override showSubpanel to re-hide subpanels when outside changes occur, like reordering subpanel
     * @inheritdoc
     */
    showSubpanel: function (linkName) {
        this._super('showSubpanel', [linkName]);

        _.each(this._hiddenSubpanels, function (link) {
            this.hideSubpanel(link);
        }, this);
    },

    /**
     * Helper for getting the Subpanel View for a specific link
     */
    getSubpanelByLink: function (link) {
        return this._components.find(function (component) {
            return component.context.get('link') === link;
        });
    },

    /**
     * Add to the _hiddenSubpanels array, and hide the subpanel
     */
    hideSubpanel: function (link) {
        this._hiddenSubpanels.push(link);
        var component = this.getSubpanelByLink(link);
        if (!_.isUndefined(component)) {
            component.hide();
        }
        this._hiddenSubpanels = _.unique(this._hiddenSubpanels);
    },

    /**
     * Unhide the Subpanel and remove from _hiddenSubpanels array
     */
    unhideSubpanel: function (link) {
        var index = this._hiddenSubpanels.findIndex(function (l) {
            return l == link;
        });
        if (_.isUndefined(index)) {
            delete this._hiddenSubpanels[index];
        }
        var component = this.getSubpanelByLink(link);
        if (!_.isUndefined(component)) {
            component.show();
        }
    }
})