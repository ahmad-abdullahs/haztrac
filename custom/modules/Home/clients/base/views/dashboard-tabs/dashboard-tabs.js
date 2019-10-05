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
 * @class View.Views.Base.Home.ModuleMenuView
 * @alias SUGAR.App.view.views.BaseHomeModuleMenuView
 * @extends View.Views.Base.ModuleMenuView
 */
({
    extendsFrom: 'HomeModuleMenuView',

    /**
     * The collection used to list dashboards on the dropdown.
     *
     * This is initialized on {@link #_initCollections}.
     *
     * @property
     * @type {Data.BeanCollection}
     */
    dashboards: null,

    /**
     * Default settings used when none are supplied through metadata.
     *
     * Supported settings:
     * - {Number} dashboards Number of dashboards to show on the dashboards
     *   container. Pass 0 if you don't want to support dashboards listed here.
     * - {Number} favorites Number of records to show on the favorites
     *   container. Pass 0 if you don't want to support favorites.
     * - {Number} recently_viewed Number of records to show on the recently
     *   viewed container. Pass 0 if you don't want to support recently viewed.
     * - {Number} recently_viewed_toggle Threshold of records to use for
     *   toggling the recently viewed container. Pass 0 if you don't want to
     *   support recently viewed.
     *
     * Example:
     * ```
     * // ...
     * 'settings' => array(
     *     'dashboards' => 10,
     *     'favorites' => 5,
     *     'recently_viewed' => 9,
     *     'recently_viewed_toggle' => 4,
     *     //...
     * ),
     * //...
     * ```
     *
     * @protected
     */
    _defaultSettings: {
        dashboards: 20,
        favorites: 3,
    },

    /**
     * @inheritdoc
     *
     * Initializes the collections that will be used when the dropdown is
     * opened.
     *
     * Initializes Legacy dashboards.
     *
     * Sets the recently viewed toggle key to be ready to use when the dropdown
     * is opened.
     */
    initialize: function (options) {
        this._super('initialize', [options]);
        this._initCollections();
        this._initLegacyDashboards();
        this.populateMenu();
    },

    /**
     * Creates the collections needed for list of dashboards and recently
     * viewed.
     *
     * The views' collection is pointing to the Home module and we might need
     * to use that later for something that could be populated from that
     * module. Therefore, we create other collections to be used for extra
     * information that exists on the Home dropdown menu.
     *
     * @chainable
     * @private
     */
    _initCollections: function () {
        this.dashboards = app.data.createBeanCollection('Dashboards');
        return this;
    },

    /**
     * Sets the legacy dashboards link if it is configured to be enabled.
     *
     * We are not using the `hide_dashboard_bwc` form, because we don't provide
     * this feature by default and it is enabled only on upgrades from 6.x..
     * This will be removed in the future, when all dashlets are available in
     * 7.x..
     *
     * @chainable
     * @private
     */
    _initLegacyDashboards: function () {
        if (app.config.enableLegacyDashboards && app.config.enableLegacyDashboards === true) {
            this.dashboardBwcLink = app.bwc.buildRoute(this.module, null, 'bwc_dashboard');
        }
        return this;
    },

    /**
     * @inheritdoc
     *
     * Adds the title and the class for the Home module (Sugar cube).
     */
    _renderHtml: function () {
        this._super('_renderHtml');
        this.$el.attr('title', app.lang.get('LBL_TABGROUP_HOME', this.module));
        this.$el.addClass('home btn-group');
    },

    /**
     * Filters menu actions by ACLs for the current user.
     *
     * @param {Array} meta The menu metadata to check access.
     * @return {Array} Returns only the list of actions the user has access.
     */
    // Code is overriden to stop rendering the ActivityStream, Manage Dashboard and Create Dashoards from the Dashboard-Tabs.
    filterByAccess: function (meta) {
        var result = [];

        _.each(meta, function (menuItem) {
            if (app.acl.hasAccess(menuItem.acl_action, menuItem.acl_module)) {
                // in case of divider menuItem.type is already set to divider.
                if (!_.has(menuItem, 'type')) {
                    menuItem.type = 'display_none';
                }
                result.push(menuItem);
            }
        });

        return result;
    },

    /**
     * @override
     *
     * Populates all available dashboards when opening the menu. We override
     * this function without calling the parent one because we don't want to
     * reuse any of it.
     *
     * **Attention** We only populate up to 20 dashboards.
     *
     * TODO We need to keep changing the endpoint until SIDECAR-493 is
     * implemented.
     */
    populateMenu: function () {
        var pattern = /^(LBL|TPL|NTC|MSG)_(_|[a-zA-Z0-9])*$/;
        this.$('.active').removeClass('active');

        // First render the dashboard what we have in the collection.
        // After that go for the fetch call
        if (!_.isNull(app.dashboards) && !_.isUndefined(app.dashboards)) {
            this._renderPartial('dashboards', {
                collection: app.dashboards,
                active: this.context.get('module') === 'Home' && this.context.get('model')
            });
        }

        this.dashboards.fetch({
            'limit': this._settings['dashboards'],
            'filter': [{
                    'dashboard_module': 'Home',
                    '$or': [
                        {'$favorite': ''},
                        {'default_dashboard': 1}
                    ]
                }],
            'order_by': {'date_modified': 'DESC'},
            'showAlerts': false,
            'success': _.bind(function (data) {
                var module = this.module;
                _.each(data.models, function (model) {
                    if (pattern.test(model.get('name'))) {
                        model.set('name', app.lang.get(model.get('name'), module));
                    }
                    // hardcode the module to `Home` due to different link that
                    // we support
                    model.module = 'Home';
                });

                // Save in the App for render before fetch call.
                app.dashboards = this.dashboards;

                this._renderPartial('dashboards', {
                    collection: this.dashboards,
                    active: this.context.get('module') === 'Home' && this.context.get('model')
                });

            }, this),
            'endpoint': function (method, model, options, callbacks) {
                app.api.records(method, 'Dashboards', model.attributes, options.params, callbacks);
            }
        });
    },

    _renderPartial: function (tplName, options) {
        if (this.disposed) {
            return;
        }
        options = options || {};

        var tpl = app.template.getView(this.name + '.' + tplName, this.module) ||
                app.template.getView(this.name + '.' + tplName);

        var self = this;
        var collection = this.getCollection(tplName);
        _.each(collection.models, function (model) {
            if (app.utils.isNameErased(model)) {
                model.set('erased', true);
                model.set('erasedText', app.lang.get('LBL_VALUE_ERASED'));
            }
        });

        var $placeholder = this.$('[data-container="' + tplName + '"]');
        var $old = $placeholder.nextUntil('.divider');

        //grab the focused element's route (if exists) for later re-focusing
        var focusedRoute = $old.find(document.activeElement).data('route');

        //replace the partial using newly updated collection
        $old.remove();
        $placeholder.after(tpl(_.extend({'collection': collection}, options)));

        //if there was a focused element previously, restore its focus
        if (focusedRoute) {
            var $new = $placeholder.nextUntil('.divider');
            var focusSelector = '[data-route="' + focusedRoute + '"]';
            var $newFocus = $new.find(focusSelector);
            if ($newFocus.length > 0) {
                $newFocus.focus();
            }
        }
    },
})
