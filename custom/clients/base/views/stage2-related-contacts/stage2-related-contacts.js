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
    plugins: ['EllipsisInline', 'Stage2CssLoader', 'EmailClientLaunch'],

    css: ['hint-contacts'],

    events: {
        'click [data-action="show_more"]': 'showMore',
    },
    _contactsLimit: 3,

    initialize: function(options) {
        var self = this;
        options.context.set('forceNew', true);
        options.context.set('skipFetch', true);
        this._super('initialize', [options]);
        this._setRequestLoading(true);
        app.api.call('GET', app.api.buildURL('stage2/params'), null, {
            success: function(data) {
                self.sugarVersion = data.sugarVersion;
                self._stage2url = data.enrichmentServiceUrl;
            },
            error: function(err) {
                app.logger.error('Failed to get Hint params: ' + JSON.stringify(err));
            }
        });
        this.on("changed:isHintRequestLoading", this.render, this);
        this.context.parent.on('change:model', function(ctx, model) {
            self._setRequestLoading(true);
            this._getContacts(model);
        }, this);

        this._getContacts(this.context.parent.get('model'));
    },

    _setRequestLoading: function(value) {
        this.isHintRequestLoading = value;
        this.trigger("changed:isHintRequestLoading");
    },

    _getContacts: function(model) {
        var accountBean;
        var self = this;
        self._parentModule = model.module;
        self._parentId = model.id;
        self._currentModel = model;
        var accountBean = app.data.createBean('Accounts', {
            id: self._parentId
        });
        accountBean.fetch({
            success: function(accountBean) {
                self.collection = app.data.createRelatedCollection(accountBean || self._currentModel, 'contacts');

                self.collection.fetch({
                    relate: true,
                    success: function(data) {
                        if (!self.disposed) {
                            self._showMore = self.collection.models.length > 3 ? true : false;
                            self._setRequestLoading(false);
                        }
                    },
                    error: _.bind(function() {
                        app.logger.error('Failed to fetch relatedCollection for accountBean: ' + JSON.stringify(err));
                        self._setRequestLoading(false);
                    }, this),
                    complete: null,
                    limit: -1,
                });
            },
            error: function() {
                app.logger.error('Failed to fetch accountBean: ' + JSON.stringify(err));
            }
        });
    },

    showMore: function(e) {
        var self = this;
        var _parentModel = self.context.parent.get('model');
        var filters = [{
            "account_name": {
                "$in": [_parentModel.get("name")]
            }
        },];

        self._relatedContacts = app.data.createBeanCollection('Contacts');
        var request = self._relatedContacts.fetch({
            "filter": filters
        });

        request.xhr.success(function(data) {
            app.drawer.open({
                layout: 'selection-list',
                context: {
                    module: 'Contacts',
                    model: self._relatedContacts.models[0],
                    collection: self._relatedContacts,
                    filterOptions: {
                        auto_apply: false
                    },
                }
            },
                function(model) {
                    if (!model) {
                        return;
                    }
                    if (model.id) {
                        app.router.redirect("#Contacts/" + model.id);
                    }
                });
        });
    },

    _dispose: function() {
        this._super('_dispose');
    },

    _retrieveEmailOptionsFromLink: function($el) {
        var email = $el.data('email-to');
        var model = _.find(this.collection.models, function(model) {
            if (_.indexOf(_.pluck(model.get('email'), 'email_address'), email) >= 0) {
                return model;
            }
        }, this);
        if (this.sugarVersion) {
            if (this.sugarVersion.match(/^7\.([89])(\.[\d]+)?(\.[\d]+)?$/)) {
                return {
                    to_addresses: [{
                        email: email,
                        bean: model
                    }]
                };
            } else {
                return {
                    to: [{
                        bean: model
                    }],
                    related: model
                };
            }
        }
    },

    /**
     * @inheritdoc
     */
    _render: function(options) {
        this._super('_render', [options]);
        if (this.collection.models) {
            _.each(this.collection.models, function(model) {
                var id = model.get('id');
                var _erasedFields = model.get('_erased_fields');
                // NOTE: email isn't here because we don't show the Value Erased message for emails currently.
                if (_.contains(_erasedFields, 'title')) {
                    this.$('#' + id).find('.title_erased').removeClass('hidden');
                }
                if (_.contains(_erasedFields, 'phone_mobile')) {
                    this.$('#' + id).find('.phone_erased').removeClass('hidden');
                }
                if (_.contains(_erasedFields, 'first_name') && _.contains(_erasedFields, 'last_name')) {
                    this.$('#' + id).find('span#first_name_erased').removeClass('hidden');
                }
            }, this);
        }
    },

    _renderHtml: function() {
        var self = this;
        if (this.collection.models) {
            _.each(this.collection.models, function(model) {
                var id = model.get('id');
                var link = '#' + model.module + '/' + id;
                var _src = model.get('picture');
                if (!_.isEmpty(_src)) {
                    _src = 'rest/v10/Contacts/' + id + '/file/picture?format=sugar-html-json&platform=base&_hash=' + _src;
                }
                model.set({
                    '_src': _src,
                    '_link': link,
                });
            }, this);

            // Sort the models in collection by date.
            this.collection.comparator = function(model) {
                return -(new Date(model.get('date_modified')).getTime());
            };
            this.collection.sort();
            this.collection.reset(this.collection.first(3));
        }
        return this._super('_renderHtml');
    }

});
