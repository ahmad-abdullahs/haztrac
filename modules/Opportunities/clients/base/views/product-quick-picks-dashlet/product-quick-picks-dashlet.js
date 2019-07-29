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
 * @class View.Views.Base.Opportunities.ProductQuickPicksDashletView
 * @alias SUGAR.App.view.views.BaseOpportunitiesProductQuickPicksDashletView
 * @extends View.Views.Base.Opportunities.ProductQuickPicksView
 */
({
    extendsFrom: 'OpportunitiesProductQuickPicksView',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.plugins = _.union(this.plugins || [], ['Tooltip']);
        this._super('initialize', [options]);
    },

    /**
     * Calls the render method in parent class
     * assign class name to the dashlet component
     * @inheritdoc
     */
    render: function() {
        if (!this.meta.config) {
            this._super('render');
            if (this.closestComponent('dashlet-cell').$el) {
                this.closestComponent('dashlet-cell').$el.parents().eq(1).addClass('product-catalog-quick-picks');
            }
        }
    },

    /**
     * @inheritdoc
     */
    toggleLoading: function(startLoading) {
        if (this.layout.disposed === true) {
            return;
        }
        var $el = this.layout.$('i[data-action=loading]');
        if (startLoading) {
            $el.removeClass('fa-cog');
            $el.addClass('fa-refresh fa-spin');
        } else {
            $el.removeClass('fa-refresh fa-spin');
            $el.addClass('fa-cog');
        }
    }
})
