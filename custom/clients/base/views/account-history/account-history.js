({
    extendsFrom: 'HistoryView',

    _defaultSettings: {
        filter: 7,
        limit: 10,
        visibility: 'group',
    },
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

    bindCollectionAdd: function (model) {
        if (model.link) {
            if (model.link.name == "accounts_sales_and_services_1") {
                if (model.get('complete_date_c')) {
                    var completeDate = moment.utc(model.get('complete_date_c')).format('MM/DD/YYYY');
                    model.set('complete_date_c', completeDate);
                }
                if (model.get('primary_rli_uom')) {
                    var ddList = app.lang.getAppListStrings('unit_of_measure_c_list');
                    var valueToDisplay = ddList[model.get('primary_rli_uom')];
                    if (valueToDisplay) {
                        model.set('primary_rli_uom', valueToDisplay);
                    }
                }
            }
        }
        var tab = this._getTab(model.collection);
        model.set('record_date', model.get(tab.record_date));
    },

    _getFilters: function (index) {
        var filterStr = app.date().subtract(this.settings.get('filter'), 'days').formatServer(true);

        if (this.settings.get('filter') == 0) {
            var filter = {},
                    filters = [];

            if (this.tabs[index].module == "sales_and_services") {
                filter['accounts_sales_and_services_1accounts_ida'] = {$equals: this.model.get('id')};
                filters.push(filter);
            } else if (_.contains(["Meetings", "Calls", "Tasks", /*"Emails"*/], this.tabs[index].module)) {
                filter['parent_type'] = {$equals: "Accounts"};
                filter['parent_id'] = {$equals: this.model.get('id')};
                filters.push(filter);
            }
            return filters;
        }

        var tab = this.tabs[index],
                filter = {},
                filters = [];

        filter[tab.filter_applied_to] = {$gte: filterStr};
        if (this.tabs[index].module == "sales_and_services") {
            filter['accounts_sales_and_services_1accounts_ida'] = {$equals: this.model.get('id')};
        } else if (_.contains(["Meetings", "Calls", "Tasks", /*"Emails"*/], this.tabs[index].module)) {
            filter['parent_type'] = {$equals: "Accounts"};
            filter['parent_id'] = {$equals: this.model.get('id')};
        }

        filters.push(filter);

        return filters;
    },

    _renderHtml: function () {
        this._super('_renderHtml');

        this.$el.children().find('div.tab-content').css({
            height: '180px'
        });
    },
})
