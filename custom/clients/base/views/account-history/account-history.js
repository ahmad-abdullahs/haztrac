({
    extendsFrom: 'HistoryView',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    /**
     * @inheritdoc
     */
    refreshTabsForModule: function (module) {
        this.loadDataForTabs(this.tabs, {});
    },

    _getFilters: function (index) {
        var filterStr = app.date().subtract(this.settings.get('filter'), 'days').formatServer(true);

        if (this.settings.get('filter') == 0) {
            return [];
        }

        var tab = this.tabs[index],
                filter = {},
                filters = [];

        filter[tab.filter_applied_to] = {$gte: filterStr};

        filters.push(filter);

        return filters;
    },
})
