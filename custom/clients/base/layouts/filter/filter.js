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
 * Layout for filtering a collection.
 *
 * Composed of a module dropdown(optional), a filter dropdown and an input.
 *
 * @class View.Layouts.Base.FilterLayout
 * @alias SUGAR.App.view.layouts.BaseFilterLayout
 * @extends View.Layout
 */
({
    extendsFrom: 'FilterLayout',
    initialize: function (opts) {
        this._super('initialize', [opts]);
    },

    /**
     * Retrieves the appropriate list of filters from cache if found, otherwise
     * from the server.
     *
     * @param {String} moduleName The module name.
     * @param {String} [defaultId] The filter `id` to select once loaded.
     */
    getFilters: function (moduleName, defaultId) {
        if (moduleName === 'all_modules') {
            this.selectFilter('all_records');
            return;
        }
        var filterOptions = this.context.get('filterOptions') || {};

        if (this.filters) {
            this.filters.dispose();
        }

        // Remove deprecated cache entries.
        this.removeDeprecatedCache(moduleName);

        this.filters = app.data.createBeanCollection('Filters');
        this.filters.setModuleName(moduleName);
        this.filters.setFilterOptions(filterOptions);
        this.filters.load({
            success: _.bind(function () {
                if (this.disposed) {
                    return;
                }
                defaultId = defaultId || this.filters.collection.defaultFilterFromMeta;
                this.selectFilter(defaultId);
                // ++ Adding filter tabs system wide...
                if (!_.isUndefined(this.layout._components[4])) {
                    this.layout._components[4].filterCollection = this.layout._components[4].filters;
                    this.layout._components[4].render();
                }
            }, this)
        });
    },

})
