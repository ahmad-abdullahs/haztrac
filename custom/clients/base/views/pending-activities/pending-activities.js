({
    extendsFrom: 'PlannedActivitiesView',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
    },

    /**
     * @inheritdoc
     */
    heldActivity: function(model) {
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
            onConfirm: function() {
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
    refreshTabsForModule: function(module) {
        this.loadDataForTabs(this.tabs, {});
    },

    /**
     * @inheritdoc
     */
    _renderHtml: function() {
        this._super('_renderHtml');

        var tab = this.tabs[this.settings.get('activeTab')];
        if (_.isEmpty(tab.invitation_actions)) {
            this._renderAvatars();
        }
    }
})
