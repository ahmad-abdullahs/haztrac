({
    extendsFrom: 'PlannedActivitiesView',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    _getFilters: function (index) {

        var today = app.date().formatServer(true);
        var tab = this.tabs[index];
        var filter = {};
        var filters = [];
        var defaultFilters = {
            today: {$lte: today},
            future: {$gt: today}
        };

        filter[tab.filter_applied_to] = defaultFilters[this.getDate()];
        if (this.tabs[index].module == "sales_and_services") {
            filter['accounts_sales_and_services_1accounts_ida'] = {$equals: this.model.get('id')};
        } else if (_.contains(["Meetings", "Calls", "Tasks", /*"Emails"*/], this.tabs[index].module)) {
            filter['parent_type'] = {$equals: "Accounts"};
            filter['parent_id'] = {$equals: this.model.get('id')};
        }

        filters.push(filter);

        return filters;
    },

    /**
     * @inheritdoc
     */
    heldActivity: function (model) {
        var self = this;
        var name = Handlebars.Utils.escapeExpression(app.utils.getRecordName(model)).trim();
        var context = app.lang.getModuleName(model.module).toLowerCase() + ' ' + name;

        var statusToSet = {status: 'Held'};
        if (model.module == 'Tasks') {
            statusToSet = {status: 'Completed'};
        } else if (model.module == 'sales_and_services') {
            statusToSet = {status_c: 'Complete'};
        }

        app.alert.show('close_activity_confirmation:' + model.get('id'), {
            level: 'confirmation',
            messages: app.utils.formatString(app.lang.get('LBL_PLANNED_ACTIVITIES_DASHLET_CONFIRM_CLOSE'), [context]),
            onConfirm: function () {
                model.save(statusToSet, {
                    showAlerts: true,
                    success: self._getRemoveModelCompleteCallback()
                });
            }
        });
    },

    /**
     * @inheritdoc
     */
    refreshTabsForModule: function (module) {
        this.loadDataForTabs(this.tabs, {});
    },

    /**
     * @inheritdoc
     */
    _renderHtml: function () {
        this._super('_renderHtml');

        this.$el.children().find('div.tab-content').css({
            height: '140px'
        });

        if (this.meta.config) {
            this._super('_renderHtml');
            return;
        }

        var tab = this.tabs[this.settings.get('activeTab')];
        if (_.isEmpty(tab.invitation_actions)) {
            this._renderAvatars();
        }
    }
})
