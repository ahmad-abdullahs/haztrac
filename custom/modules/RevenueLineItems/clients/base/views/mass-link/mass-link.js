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
/**
 * @class View.Views.Base.MassLinkView
 * @alias SUGAR.app.view.views.BaseMassLinkView
 * @extends View.Views.Base.MassupdateView
 */
({
    // background: radial-gradient(#e61718, #e61718);
    extendsFrom: 'MassLinkView',
    copyCount: 0,
    massUpdateViewName: 'masslink-progress',
    _defaultLinkSettings: {
        mass_link_chunk_size: 20
    },

    initialize: function (options) {
        this.copyCount = 0;
        this._super('initialize', [options]);
    },

    /**
     * Overrides parent. Sets mass link related events
     */
    delegateListFireEvents: function () {
        this.layout.on('list:masslink:fire', _.bind(this.beginMassLink, this));
    },

    handleAlerts: function (action, level) {
        switch (level) {
            case 1:
                app.alert[action]('copying_record', {
                    level: 'process',
                    title: 'Copying'
                });
                break;
            case 2:
                app.alert[action]('copyed', {
                    level: 'success',
                    messages: "Record Copied",
                    autoClose: true, autoCloseDelay: 8000
                });
                break;
            case 3:
                $('#sugarcrm').after('<div id="tutorial"><div id="mask" class="mask"></div></div>');
                break;
            case 4:
                $('#sugarcrm').siblings('div#tutorial').remove();
                break;
            case 5:
                app.alert.show('copy_failed', {
                    level: 'error',
                    messages: 'Copy Failed',
                    autoClose: true,
                    autoCloseDelay: 8000
                });
                $('#sugarcrm').siblings('div#tutorial').remove();
                break;
        }
    },

    getRliAndRelatedRLIs: function (massLink) {
        var rliAndRelatedRLIs = [], relatedIds = [],
                facilitiesInfo = {};
        _.each(massLink.models, function (model) {
            relatedIds = [];

            if (!_.isEmpty(model.get('v_vendors_id_c')) && model.get('is_bundle_product_c') != 'parent' && model.get('manifest_required_c')) {
                facilitiesInfo[model.get('id')] = model.get('v_vendors_id_c');
            }

            if (!_.isEmpty(model.get('revenuelineitems_revenuelineitems_1').records)) {
                _.each(model.get('revenuelineitems_revenuelineitems_1').records, function (relatedRLI) {
                    if (relatedRLI.id) {
                        this.copyCount++;
                        relatedIds.push({
                            'id': relatedRLI.id,
                        });

                        if (!_.isEmpty(relatedRLI.v_vendors_id_c) && relatedRLI.is_bundle_product_c != 'parent' && relatedRLI.manifest_required_c) {
                            facilitiesInfo[relatedRLI.id] = relatedRLI.v_vendors_id_c;
                        }

                    }
                }, this);
            }
            this.copyCount++;
            rliAndRelatedRLIs.push({
                [model.get('id')]: relatedIds
            });
        }, this);

        return {
            rliAndRelatedRLIs: rliAndRelatedRLIs,
            facilitiesInfo: facilitiesInfo,
        };
    },

    setParentModelRelations: function (createView, parentModel, bundleID) {
        // We have to make the Opportunity empty otherwise new account id was not attaching.
        if (parentModel.get('_module') == 'RevenueLineItems') {
            createView.model.set({
                'opportunity_id': '',
                'rli_as_template_c': '',
                'account_id': parentModel.get('account_id'),
                'sales_and_services_revenuelineitems_1sales_and_services_ida': parentModel.get('sales_and_services_revenuelineitems_1sales_and_services_ida'),
                'revenuelineitems_revenuelineitems_1revenuelineitems_ida': _.isNull(bundleID) ? parentModel.get('id') : bundleID
            });
        } else if (parentModel.get('_module') == 'sales_and_services') {
            createView.model.set({
                'opportunity_id': '',
                'rli_as_template_c': '',
                'account_id': parentModel.get('accounts_sales_and_services_1accounts_ida'),
                'sales_and_services_revenuelineitems_1sales_and_services_ida': parentModel.get('id'),
                'revenuelineitems_revenuelineitems_1revenuelineitems_ida': _.isNull(bundleID) ? '' : bundleID
            });
        } else if (parentModel.get('_module') == 'Accounts') {
            createView.model.set({
                'opportunity_id': '',
                'rli_as_template_c': '',
                'account_id': parentModel.get('id'),
                'sales_and_services_revenuelineitems_1sales_and_services_ida': '',
                'ht_manifest_revenuelineitems_1ht_manifest_ida': '',
                'quantity': '',
                'estimated_quantity_c': '',
                'revenuelineitems_revenuelineitems_1revenuelineitems_ida': _.isNull(bundleID) ? '' : bundleID
            });
        } else if (parentModel.get('_module') == 'Opportunities') {
            createView.model.set({
                'opportunity_id': parentModel.get('id'),
                'rli_as_template_c': '',
                'account_id': parentModel.get('account_id'),
                'sales_and_services_revenuelineitems_1sales_and_services_ida': '',
                'revenuelineitems_revenuelineitems_1revenuelineitems_ida': _.isNull(bundleID) ? '' : bundleID
            });
        }
    },

    getAdditionalParams: function (parentModel) {
        var addToParam = {};
        if (parentModel.get('_module') == 'RevenueLineItems') {
            addToParam = {'copy_from_rli': true};
        } else if (parentModel.get('_module') == 'sales_and_services') {
            addToParam = {'copy_from_sas': true};
        } else if (parentModel.get('_module') == 'Accounts') {
            addToParam = {'copy_from_account': true};
        } else if (parentModel.get('_module') == 'Opportunities') {
            addToParam = {'copy_from_opp': true};
        }

        return addToParam;
    },

    makeChildRLICopies: function (id, parentModel, justCreatedBundleRLIModel) {
        var self = this;
        var rli = app.data.createBean('RevenueLineItems', {id: id});
        rli.fetch({
            'showAlerts': false,
            'success': _.bind(function (model) {
                var prefill = app.data.createBean('RevenueLineItems');
                prefill.copy(model);
                this._copyNestedCollections(model, prefill);
                prefill.unset('id');

                var createView = app.view.createView({
                    // layout: 'create',
                    // name: 'create',
                    create: true,
                    model: prefill,
                    copiedFromModelId: model.get('id')
                });

                this.setParentModelRelations(createView, parentModel, justCreatedBundleRLIModel.get('id'));

                var addToParam = this.getAdditionalParams(parentModel);

                var options = {
                    success: function (_model) {
                        self.copyCount--;
                        if (self.copyCount == 0) {
                            self.handleAlerts('dismiss', 1);
                            self.handleAlerts('show', 2);
                            self.handleAlerts(null, 4);
                            app.drawer.close(false, {});
                            app.router.refresh();
                        }
                    },
                    error: function (err) {
                        self.handleAlerts(null, 5);
                    },
                    viewed: true,
                    params: {
                        'after_create': {
                            'copy_rel_from': model.get('id')
                        },
                        addToParam,
                    },
                };
                createView.model.save({silent: true}, options);
            }, this)
        }, this);
    },

    makeRLICopies: function (massLink, parentModel) {
        var self = this,
                returnData = {}, facilitiesInfo = {},
                rliAndRelatedRLIsArr = [];

        returnData = this.getRliAndRelatedRLIs(massLink);
        rliAndRelatedRLIsArr = returnData.rliAndRelatedRLIs;
        facilitiesInfo = returnData.facilitiesInfo;

        if (this.context.parent.get('model').module == 'sales_and_services') {
            if (!this.ifValidFacilities(facilitiesInfo)) {
                return;
            }
        }

        self.handleAlerts('show', 1);
        self.handleAlerts(null, 3);

        _.each(rliAndRelatedRLIsArr, function (rliAndRelatedRLIs, key) {
            _.each(rliAndRelatedRLIs, function (relatedRLIsIds, parentRLIid) {
                var rli = app.data.createBean('RevenueLineItems', {id: parentRLIid});
                rli.fetch({
                    'showAlerts': false,
                    'success': _.bind(function (model) {
                        var prefill = app.data.createBean('RevenueLineItems');
                        prefill.copy(model);
                        this._copyNestedCollections(model, prefill);
                        prefill.unset('id');

                        var createView = app.view.createView({
                            // layout: 'create',
                            // name: 'create',
                            create: true,
                            model: prefill,
                            copiedFromModelId: model.get('id')
                        });

                        // Set the Account Id, Sales and Service ID and parent Revenue Line Item according to the record on which the drawer is opened.
                        this.setParentModelRelations(createView, parentModel, null);

                        var addToParam = this.getAdditionalParams(parentModel);

                        // On model save success we have to call the child RLIs to be created to matain the bundle relationship.
                        var options = {
                            success: function (_model) {
                                _.each(relatedRLIsIds, function (val, key) {
                                    if (!_.isEmpty(val)) {
                                        if (!_.isEmpty(val.id)) {
                                            self.makeChildRLICopies(val.id, parentModel, _model);
                                        }
                                    }
                                }, this);
                                self.copyCount--;
                                if (self.copyCount == 0) {
                                    self.handleAlerts('dismiss', 1);
                                    self.handleAlerts('show', 2);
                                    self.handleAlerts(null, 4);
                                    app.drawer.close(false, {});
                                    app.router.refresh();
                                }
                            },
                            error: function (err) {
                                self.handleAlerts(null, 5);
                            },
                            viewed: true,
                            params: {
                                'after_create': {
                                    'copy_rel_from': model.get('id')
                                },
                                addToParam,
                            },
                        };
                        createView.model.save({silent: true}, options);
                    }, this)
                }, this)
            }, this)
        }, this)
    },

    /**
     * Link multiple records in chunks
     */
    beginMassLink: function (options) {
        var self = this;
        var parentModel = this.context.get('recParentModel'),
                link = this.context.get('recLink'),
                massLink = this.getMassUpdateModel(this.module),
                progressView = this.getProgressView();

        massLink.setChunkSize(this._settings.mass_link_chunk_size);

        if (self.context.get('copyLinkRecords')) {
            this.copyCount = 0;
            this.makeRLICopies(massLink, parentModel);
        } else {
            //Extend existing model with a link function
            massLink = _.extend({}, massLink, {
                maxLinkAllowAttempt: options && options.maxLinkAllowAttempt || this.maxAllowAttempt,
                link: function (options) {
                    //Slice a new chunk of models from the mass collection
                    this.updateChunk();
                    var relatedIds = [];
                    _.each(this.chunks, function (model) {
                        if (!_.isEmpty(model.get('revenuelineitems_revenuelineitems_1').records)) {
                            _.each(model.get('revenuelineitems_revenuelineitems_1').records, function (relatedRLI) {
                                if (relatedRLI.id) {
                                    relatedIds.push({
                                        'id': relatedRLI.id,
                                        // This OR condition is added to populate the account_id in all the cases.
                                        // 1. When RevenueLineItems records is selected in selection drawer from sales and service record view.
                                        // 2. When RevenueLineItems records is selected in selection drawer from RevenueLineItems record view.
                                        // 3. When RevenueLineItems records is selected in selection drawer from Opportunities record view.
                                        'account_id': parentModel.get('accounts_sales_and_services_1accounts_ida') || parentModel.get('account_id'),
                                    });
                                }
                            });
                        }
                    });

                    _.each(_.pluck(this.chunks, 'id'), function (id) {
                        relatedIds.push({
                            'id': id,
                            'account_id': parentModel.get('accounts_sales_and_services_1accounts_ida') || parentModel.get('account_id'),
                        });
                    });

                    var model = this,
                            apiMethod = 'create',
                            // ++ 
                            // Custom API to hit copy_and_link...
                            linkCmd = 'link',
                            parentData = {
                                id: parentModel.id
                            },
                            url = app.api.buildURL(parentModel.module, linkCmd, parentData),
                            linkData = {
                                link_name: link,
                                ids: relatedIds,
                            },
                            callbacks = {
                                success: function (data, response) {
                                    model.attempt = 0;
                                    model.updateProgress();
                                    if (model.length === 0) {
                                        model.trigger('massupdate:end');
                                        if (_.isFunction(options.success)) {
                                            options.success(model, data, response);
                                        }
                                    } else {
                                        model.trigger('massupdate:always');
                                        model.link(options);
                                    }
                                },
                                error: function () {
                                    model.attempt++;
                                    model.trigger('massupdate:fail');
                                    if (model.attempt <= this.maxLinkAllowAttempt) {
                                        model.link(options);
                                    } else {
                                        app.alert.show('error_while_mass_link', {
                                            level: 'error',
                                            title: app.lang.get('ERR_INTERNAL_ERR_MSG'),
                                            messages: ['ERR_HTTP_500_TEXT_LINE1', 'ERR_HTTP_500_TEXT_LINE2']
                                        });
                                    }
                                }
                            };
                    app.api.call(apiMethod, url, linkData, callbacks);
                }
            });

            progressView.initCollection(massLink);
            massLink.link({
                success: _.bind(function (model, data, response) {
                    this.layout.trigger('list:masslink:complete', model, data, response);
                }, this)
            });
        }
    },

    _copyNestedCollections: function (source, target) {
        var collections, view;
        if (!_.isFunction(source.getCollectionFieldNames)) {
            return;
        }
        view = this;
        function cloneModel(model) {
            var attributes = _.chain(model.attributes).clone().omit('_action').value();
            return app.data.createBean(model.module, attributes);
        }
        function copyCollection(collection) {
            var field, relatedFields, options;
            function done(sourceCollection, options) {
                var targetCollection = target.get(collection.fieldName);

                if (!targetCollection) {
                    return;
                }

                targetCollection.add(sourceCollection.map(cloneModel));
            }

            field = view.getField(collection.fieldName, source);
            relatedFields = [];

            if (field.def.fields) {
                relatedFields = _.map(field.def.fields, function (def) {
                    return _.isObject(def) ? def.name : def;
                });
            }

            options = {success: done};

            // request the related fields from the field definition if possible
            if (relatedFields.length > 0) {
                options.fields = relatedFields;
            }

            collection.fetchAll(options);
        }

        // get all attributes from the source model that are collections
        collections = _.intersection(source.getCollectionFieldNames(), _.keys(source.attributes));

        _.each(collections, function (name) {
            copyCollection(source.get(name));
        });
    },

    // warn If Different Facilities
    ifValidFacilities: function (facilitiesInfo) {
        // Subpanel RLIs (Put RLI id and facility id in an object)
        if (!_.isUndefined(this.context.parent) && !_.isNull(this.context.parent)) {
            _.each(this.context.parent.get('model')._relatedCollections.sales_and_services_revenuelineitems_1.models, function (model, key) {
                if (!_.isEmpty(model.attributes.v_vendors_id_c) && model.attributes.is_bundle_product_c != 'parent' && model.attributes.manifest_required_c) {
                    facilitiesInfo[model.attributes.id] = model.attributes.v_vendors_id_c;
                }
            }, this);
        }

        // Get the facilities ids and make them unique to check do we 
        // have multiple facilities or not
        // If we have multiple, group them and color the pills.
        // each facility has its own color, this way we will group multiple 
        // rlis with same facility to a common color.
        if (_.unique(_.compact(_.values(facilitiesInfo))).length > 1) {
            app.alert.dismiss('multifacility-warning');
            app.alert.show('multifacility-warning', {
                level: 'warning',
                messages: 'Your selected Item(s) have different Ship To / TSDF, ' +
                        'Please create separate Sales and Service for highlighted items.',
                closeable: true,
                autoClose: true,
                autoCloseDelay: 12000,
            });
            return false;
        }
        return true;
    },
})
