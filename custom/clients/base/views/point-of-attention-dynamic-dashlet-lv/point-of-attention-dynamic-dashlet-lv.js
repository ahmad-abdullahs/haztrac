({
    extendsFrom: 'DashablelistView',

    _defaultSettings: {
        limit: -1,
        filter_id: 'assigned_to_me',
        intelligent: '0'
    },

    _getListMeta: function (module) {
        return app.metadata.getView(module, 'point-of-attention-list');
    },

    // Reload the Dashlet when the Record model is changed and re-synced.
    bindDataChange: function () {
        this._super('bindDataChange');

        if (this.context.parent.get('collection')) {
            this.context.parent.get('collection').on('data:sync:complete', function () {
                this._displayDashlet();
            }, this);
        }

        this.model.on('data:sync:complete', function () {
            this._displayDashlet();
        }, this);

        this.model.on('change', function () {
            this.initDashlet();
        }, this);
    },

    _render: function () {
        // Only render the view when user is admin or the
        // regular user is in Manager: Financial team
        var showDashlet = false;
        if (app.user.get('type') == "user") {
            var myTeams = app.user.get('my_teams');
            _.each(myTeams, function (team) {
                if (team.name == "Manager: Financial") {
                    showDashlet = true;
                }
            });

            // These fields should be hidden from the non-admin users.
            // So when the user is non-admin he will not be able to see these fields 
            // unless he is in Manager: Financial Team 
            var fieldsList = [
                'estimated_rli_total',
                'estimated_rli_cost',
                'estimated_rli_list',
                'estimated_rli_profit',
                'estimated_rli_profit_margin',
                'commission'
            ];

            var flag = true;
            if (this.options.meta && !showDashlet) {
                _.each(this.options.meta.display_columns, function (name) {
                    if (!_.contains(fieldsList, name) && flag) {
                        showDashlet = true;
                    } else {
                        showDashlet = false;
                        flag = false;
                    }
                });
            }
        } else if (app.user.get('type') == "admin") {
            showDashlet = true;
        }

        // This main-pane check is added to render the dashlet edit view 
        // for configuration or field list change
        if (showDashlet || this.layout.name == "main-pane") {
            this._super('_render');
        }
    },

//    _initializeSettings: function () {
//        if (this.intelligent === '0') {
//            _.each(this.dashletConfig.panels, function (panel) {
//                panel.fields = panel.fields.filter(function (el) {
//                    return el.name !== 'intelligent';
//                });
//            }, this);
//            this.settings.set('intelligent', '0');
//            this.dashModel.set('intelligent', '0');
//        } else {
//            if (_.isUndefined(this.settings.get('intelligent'))) {
//                this.settings.set('intelligent', this._defaultSettings.intelligent);
//            }
//        }
//        this.setLinkedFieldVisibility('1', this.settings.get('intelligent'));
//        if (!this.settings.get('limit')) {
//            this.settings.set('limit', this._defaultSettings.limit);
//        }
//        if (!this.settings.get('filter_id')) {
//            this.settings.set('filter_id', this._defaultSettings.filter_id);
//        }
//        this._setDefaultModule();
//        if (!this.settings.get('label')) {
//            this.settings.set('label', 'LBL_MODULE_NAME');
//        }
//    },

//    loadData: function (options) {
//        if (!this.filterIsAccessible) {
//            if (options && _.isFunction(options.complete)) {
//                options.complete();
//            }
//            return;
//        }
//        this.$el.parent('div').parent('div').attr('style', 'min-height:100px');
//        this.$el.parents('div.rows').attr('style', 'padding:0px');
//        this._super('loadData', [options]);
//    },

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
        var idsList = [];
        if (this.context) {
            if (this.context.parent) {
                if (this.context.parent.get('collection')) {
                    _.each(this.context.parent.get('collection').models, function (model) {
                        idsList.push(model.get('id'));
                    }, this);
                }
            }
        }

        if (_.isEmpty(idsList)) {
            idsList = ['fake-id'];
        }

        if (this.context.parent.get('module') == "sales_and_services" &&
                this.context.parent.get('layout') == "records" && this.module == "queue_workorder") {
            filterDef = [{
                    'sales_and_services_queue_workorder_1sales_and_services_ida': {
                        '$in': idsList
                    },
                    'print_status': {
                        '$in': ['Pending', 'Queued']
                    },
                }];
        } else {
            // Just Load one record in the view, Actually this record in list view 
            // is the same record which is in record view.
            filterDef = [{
                    'id': this.model.get('id'),
                }];
        }

        this._super('_displayDashlet', [filterDef]);
    },
})
