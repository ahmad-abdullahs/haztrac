({
    extendsFrom: 'DashablelistView',

    _defaultSettings: {
        limit: 5,
        intelligent: '0'
    },

    /**
     * @inheritdoc
     */
    initDashlet: function (view) {
        this._super('initDashlet', [view]);
        this.settings.on('change:filter', _.bind(this.reApplyFilter, this), this);
    },

    /**
     * @Override
     */
    reApplyFilter: function () {
        if (this.disposed || this.meta.config) {
            return;
        }

        this._displayDashlet();
    },

    /**
     * @Override
     */
    _displayDashlet: function (filterDef) {
        filterDef = [{
                'exp_date': {
                    '$dateRange': this.settings.get('filter')
                }
            }];

        this._super('_displayDashlet', [filterDef]);
    },

    /**
     * @Override
     */
    updateDashletFilterAndSave: function (filterModel) {
        var componentType = this.dashModel.get('componentType') || 'view';

        // Adding a new dashlet requires componentType to be set on the model.
        if (!this.dashModel.get('componentType')) {
            this.dashModel.set('componentType', componentType);
        }

        app.drawer.close(this.dashModel);
        app.events.trigger('dashlet:filter:save', this.dashModel.get('module'));
    },

    /**
     * @Override
     */
    _addFilterComponent: function () {}
})
