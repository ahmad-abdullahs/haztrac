({
    extendsFrom: 'HistoryView',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
    },

    /**
     * @inheritdoc
     */
    refreshTabsForModule: function(module) {
        this.loadDataForTabs(this.tabs, {});
    }
})
