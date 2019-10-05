({
    extendsFrom: 'DashablelistView',

    _getListMeta: function (module) {
        return app.metadata.getView(module, 'point-of-attention-list');
    },

    // Reload the Dashlet when the Record model is changed and re-synced.
    bindDataChange: function () {
        this._super('bindDataChange');
        this.model.on('data:sync:complete', function () {
            this._displayDashlet();
        }, this);
    },

    /**
     * @inheritdoc
     */
    initDashlet: function (view) {
        if (this.meta.config) {
            // keep the display_columns and label fields in sync with the selected module when configuring a dashlet
            this.settings.on('change:module', function (model, moduleName) {
                var label = (model.get('filter_id') === 'assigned_to_me') ? 'TPL_DASHLET_MY_MODULE' : 'LBL_MODULE_NAME';
                // -- // Code commented for reason
                // model.set('label', app.lang.get(label, moduleName, {
                //     module: app.lang.getModuleName(moduleName, {plural: true})
                // }));

                // Re-initialize the filterpanel with the new module.
                this.dashModel.set('module', moduleName);
                this.dashModel.set('filter_id', 'assigned_to_me');
                this.layout.trigger('dashlet:filter:reinitialize');

                this._updateDisplayColumns();
                this.updateLinkedFields(moduleName);
            }, this);
            this.settings.on('change:intelligent', function (model, intelligent) {
                this.setLinkedFieldVisibility('1', intelligent);
            }, this);
            this.on('render', function () {
                var isVisible = !_.isEmpty(this.settings.get('linked_fields')) ? '1' : '0';
                this.setLinkedFieldVisibility(isVisible, this.settings.get('intelligent'));
            }, this);
        }
        this._initializeSettings();
        this.metaFields = this._getColumnsForDisplay();

        if (this.settings.get('intelligent') == '1') {

            var link = this.settings.get('linked_fields'),
                    model = app.controller.context.get('model'),
                    module = this.settings.get('module'),
                    options = {
                        link: {
                            name: link,
                            bean: model
                        }
                    };
            this.collection = app.data.createBeanCollection(module, null, options);
            this.collection.setOption('relate', true);
            this.context.set('collection', this.collection);
            this.context.set('link', link);
        } else {
            this.context.unset('link');
        }

        this.before('render', function () {
            if (!this.moduleIsAvailable) {
                this.$el.html(this._noAccessTemplate());
                return false;
            }
            if (!this.filterIsAccessible) {
                this._displayNoFilterAccess();
                return false;
            }
        });

        // the pivot point for the various dashlet paths
        if (this.meta.config) {
            this._configureDashlet();
            this.listenTo(this.layout, 'init', this._addFilterComponent);
            this.listenTo(this.layout.context, 'filter:add', this.updateDashletFilterAndSave);
            this.layout.before('dashletconfig:save', function () {
                this.saveDashletFilter();
                // NOTE: This prevents the drawer from closing prematurely.
                return false;
            }, this);

        } else if (this.moduleIsAvailable) {
            var filterId = this.settings.get('filter_id');
            if (!filterId || this.meta.preview) {
                this._displayDashlet();
                return;
            }

            var filters = app.data.createBeanCollection('Filters');
            filters.setModuleName(this.settings.get('module'));
            filters.load({
                success: _.bind(function () {
                    if (this.disposed) {
                        return;
                    }
                    var filter = filters.collection.get(filterId);
                    var filterDef = filter && filter.get('filter_definition');
                    if (_.isUndefined(filterDef)) {
                        this.filterIsAccessible = false;
                        this._displayNoFilterAccess();
                    } else {
                        this._displayDashlet(filterDef);
                    }
                }, this),
                error: _.bind(function () {
                    if (this.disposed) {
                        return;
                    }
                    this._displayDashlet();
                }, this)
            });
        }
    },

    /**
     * @Override
     */
    _displayDashlet: function (filterDef) {
        // Just Load one record in the view, Actually this record in list view 
        // is the same record which is in record view.
        filterDef = [{
                'id': this.model.get('id'),
            }];

        this._super('_displayDashlet', [filterDef]);
    },
})
