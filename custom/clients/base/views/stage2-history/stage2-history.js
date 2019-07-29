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
({
    plugins: ['EllipsisInline', 'Stage2CssLoader'],

    css: ['hint-history'],

    _modules: {
        Meetings: {
            icon: 'calendar',
        },
        Calls: {
            icon: 'phone',
        },
        Emails: {
            icon: 'envelope',
        },
    },

    initialize: function(options) {
        var self = this;
        options.collection = this._createCollection();
        // skipping fetch for now, since this needs to be rewritten in 7.8+
        options.context.set('forceNew', true);
        options.context.set('skipFetch', true);

        this._super('initialize', [options]);
        this.context.parent.on('change:model', function(ctx, model) {
            this._getHistory(model);
        }, this);

        this._getHistory(this.context.parent.get('model'));
    },

    _createCollection: function() {
        var self = this;
        var HistoryCollection = app.data.mixedBeanCollection.extend({

            _buildURL: _.bind(function(params) {
                params = params || {};

                var url = app.api.serverUrl + '/' +
                    self._parentModule + '/' +
                    self._parentId + '/' +
                    'link/history';

                params = $.param(params);
                if (params.length > 0) {
                    url += '?' + params;
                }
                return url;
            }, this),

            sync: function(method, model, options) {
                options = app.data.parseOptionsForSync(method, model, options);
                var url = this._buildURL(options.params);
                var callbacks = app.data.getSyncCallbacks(method, model, options);

                app.api.call(method, url, options.attributes, callbacks);
            }
        });

        HistoryCollection.module_list = _.keys(this._modules);
        return new HistoryCollection();
    },

    _getHistory: function(model) {
        var self = this;
        this._parentModule = model.module;
        this._parentId = model.id;
        this.isHintRequestLoading = true;
        this.render();
        if (!this.collection) return;
        this.collection.fetch({
            module_list: _.keys(self._modules),
            //SF-724, explicitly specifying name field causes 500 on oracle..
            fields: [],
            success: _.bind(function() {
                if (!this.disposed) {
                    async.forEach(this.collection.models, function(model, callback) {
                        model.fetch({
                            success: function() {
                                var date = _.isUndefined(model.get('date_start')) ? app.date(model.get('date_sent')) : app.date(model.get('date_start'));

                                // set dynamic attributes for easy hbs file... this should be done with fields...
                                model.set({
                                    '_icon': self._modules[model.module] ? self._modules[model.module].icon : 'chevron-right',
                                    '_date_record': date,
                                    '_link': '#' + model.module + '/' + model.get('id'),
                                    'status': app.lang.getAppListStrings(app.metadata.getModule(model.module, 'fields').status.options)[model.get('status')],
                                });

                                callback.call();
                            }
                        });
                    }, function() {
                        self.isHintRequestLoading = false;
                        // Sort the models in collection by date.
                        self.collection.comparator = function(model) {
                            return -(new Date(model.get('_date_record')).getTime());
                        };
                        self.collection.sort();
                        self.render();
                    });
                }
            }, this)
        });
    },

});
