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
 * Module menu provides a reusable and easy render of a module Menu.
 *
 * This also helps doing customization of the menu per module and provides more
 * metadata driven features.
 *
 * @class View.Views.Base.ModuleMenuView
 * @alias SUGAR.App.view.views.BaseModuleMenuView
 * @extends View.View
 */
({
    extendsFrom: 'ModuleMenuView',

    // ++
    menuTierFlag: false,
    menuTierTitle: '',
    menuTierDivision: {
        'HRM_Employee_Training': 'HR Management',
    },

    initialize: function (options) {
        this.menuTierFlag = false;
        this.menuTierTitle = '';
        this._super('initialize', [options]);
    },

    _renderHtml: function () {
        if (this.menuTierDivision[this.module]) {
            this.menuTierFlag = true;
            this.menuTierTitle = this.menuTierDivision[this.module];
        }
        this._super('_renderHtml');
    },

    /**
     * This triggers router navigation on both menu actions and module links.
     *
     * Since we normally trigger the drawer for some actions, we prevent it
     * when using the click with the `ctrlKey` (or `metaKey` in Mac OS).
     * We also prevent the routing to be fired when this happens.
     *
     * When we are triggering the same route that we already are in, we just
     * trigger a {@link Core.Routing#refresh}.
     *
     * @param {Event} event The event that triggered this (normally a click
     *   event).
     */
    handleRouteEvent: function (event) {
        var currentRoute,
                $currentTarget = this.$(event.currentTarget),
                route = $currentTarget.data('route');

        event.preventDefault();
        if ((!_.isUndefined(event.button) && event.button !== 0) || event.ctrlKey || event.metaKey || $currentTarget.data('openwindow') === true) {
            event.stopPropagation();
            window.open(route, '_blank');
            return false;
        }

        currentRoute = '#' + Backbone.history.getFragment();

        // ++ Code added for Product Template action menu default filters.
        if (route == '#filterProducts' || route == '#ProductTemplates') {
            route = '#ProductTemplates';
            app.router.initial_filter = {
                'initial_filter': 'filterProducts',
                'initial_filter_label': app.lang.get('LBL_FILTER_PRODUCTS', 'ProductTemplates'),
                'filter_populate': {
                    'is_bundle_product_c': ['parent'],
                }
            };
        } else if (route == '#filterBundleProducts') {
            route = '#ProductTemplates';
            app.router.initial_filter = {
                'initial_filter': 'filterBundleProducts',
                'initial_filter_label': app.lang.get('LBL_FILTER_BUNDLE_PRODUCTS', 'ProductTemplates'),
                'filter_populate': {
                    'is_bundle_product_c': ['parent'],
                    'is_group_item_c': 0, // true or false will not work here...
                }
            };
        } else if (route == '#filterGroupProducts') {
            route = '#ProductTemplates';
            app.router.initial_filter = {
                'initial_filter': 'filterGroupProducts',
                'initial_filter_label': app.lang.get('LBL_FILTER_GROUP_PRODUCTS', 'ProductTemplates'),
                'filter_populate': {
                    'is_bundle_product_c': ['parent'],
                    'is_group_item_c': 1,
                }
            };
        } else if (route == '#createBundle') {
            route = '#ProductTemplates/create';
            app.router.productBundleCreation = true;
        } else if (route == '#createGroup') {
            route = '#ProductTemplates/create';
            app.router.productGroupCreation = true;
        } else if (route == '#filterRevenueLineItems' || route == '#RevenueLineItems') {
            route = '#RevenueLineItems';
            app.router.initial_filter = {
                'initial_filter': 'filterRevenueLineItems',
                'initial_filter_label': app.lang.get('LBL_FILTER_REVENUELINEITEMS', 'RevenueLineItems'),
                'filter_populate': {
                    'is_bundle_product_c': ['parent'],
                }
            };
        } else if (route == '#filterBundleRevenueLineItems') {
            route = '#RevenueLineItems';
            app.router.initial_filter = {
                'initial_filter': 'filterBundleRevenueLineItems',
                'initial_filter_label': app.lang.get('LBL_FILTER_BUNDLE_REVENUELINEITEMS', 'RevenueLineItems'),
                'filter_populate': {
                    'is_bundle_product_c': ['parent'],
                }
            };
        } else if (route == '#RevenueLineItems/bundleCreate') {
            route = '#RevenueLineItems/create';
            app.router.bundleCreation = true;
        }

        (currentRoute === route) ? app.router.refresh() : app.router.navigate(route, {trigger: true});
    }

})
