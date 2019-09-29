/**
 * @class View.Views.Base.Accounts.CreateView
 * @alias SUGAR.App.view.views.AccountsCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'RecordView',

    /**
     * Used by the alert openRLICreate method
     */
    createdModel: undefined,

    /**
     * Used by the openRLICreate method
     */
    listContext: undefined,

    /**
     * The original success message to call from the new one we set in the getCustomSaveOptions method
     */
    originalSuccess: undefined,

    /**
     * Holds a reference to the alert this view triggers
     */
    alert: undefined,

    /**
     * Does the current user has access to RLI's?
     */
    hasRliAccess: true,

    /**
     * If subpanel models are valid
     */
    validSubpanelModels: true,
    productBundle: [],
    productBundleIds: [],
    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this.plugins = _.union(this.plugins, ['LinkedModel']);

        this.hasRliAccess = app.acl.hasAccess('edit', 'RevenueLineItems');

        this._super('initialize', [options]);

        // ++
        this.model.on('data:sync:complete', function () {
            this.productBundleIds = [];
            this.fetchProductBundle();
        }, this);
        app.events.on('setButtonStates', _.bind(function () {
            this.model.set({is_bundle_product_c: 'parent'}, {silent: true});
            this.model.set({
                cost_price: 0.00,
                discount_price: 0.00,
                list_price: 0.00,
                cost_usdollar: 0.00,
                discount_usdollar: 0.00,
                list_usdollar: 0.00,
            });
            this.setButtonStates(this.STATE.EDIT);
        }, this), this);
    },

    toggleEdit: function (isEdit) {
        this._super('toggleEdit', [isEdit]);
        // On the ProductTemplates record view, when the edit button is clicked
        // make all the rows in subpanel-for-producttemplates-create editable.
        if (isEdit) {
            this.context.trigger('edit:full:subpanel-for-producttemplates-create:cstm', 'edit');
        }
    },

    cancelClicked: function () {
        this._super('cancelClicked');
        this.fetchProductBundle();
//        this.context.trigger('cancel:full:subpanel-for-producttemplates-create:cstm', 'cancel');
    },

    fetchProductBundle: function () {
        var self = this;
        this.model._relatedCollections.product_templates_product_templates_1.fetch({
            view: 'subpanel-for-producttemplates-create',
            relate: true,
            limit: -1,
            success: function (data) {
                self.productBundleIds = [];
                self.productBundle = _.clone(data.models);
                _.each(data.models, function (model, key) {
                    self.productBundleIds.push(model.get('id'));
                }, this);

                _.each(self.model._relatedCollections.product_templates_product_templates_1.models, function (model) {
                    model.on('change', function (model) {
                        app.events.trigger('setButtonStates');
                    });
                });
            },
            error: _.bind(function () {
                App.logger.error('Failed to fetch relatedCollection for producttemplates_revenuelineitems_1.');
            }, this),
        }, this);
    },

    validationComplete: function (isValid) {
        this.toggleButtons(true);
        if (isValid) {
            // this.handleSave();
            this.initiateSave(_.bind(function () {
                this.handleSave();
            }, this));
        }
    },

    handleSave: function () {
        if (this.disposed) {
            return;
        }

        this._saveModel();
        this.$('.record-save-prompt').hide();

        if (!this.disposed) {
            this.setButtonStates(this.STATE.VIEW);
            this.action = 'detail';
            this.setRoute();
            this.unsetContextAction();
            this.toggleEdit(false);
            this.inlineEditMode = false;
        }
    },

    /**
     * @inheritdoc
     */
    initiateSave: function (callback) {
        if (this.model._relatedCollections.product_templates_product_templates_1.length) {
            this.model.set({
                cost_price: 0.00,
                discount_price: 0.00,
                list_price: 0.00,
                cost_usdollar: 0.00,
                discount_usdollar: 0.00,
                list_usdollar: 0.00,
            });
        }

        // this.disableButtons();

        async.waterfall([
            _.bind(function (cb) {
                async.parallel([
                    _.bind(this.validateSubpanelModelsWaterfall, this),
                    _.bind(this.validateModelWaterfall, this)
                ], function (err) {
                    // err is undefined if no errors
                    cb(!_.isUndefined(err));
                });
            }, this),
                    // _.bind(this.dupeCheckWaterfall, this),
                    // _.bind(this.createRecordWaterfall, this)
        ], _.bind(function (error) {
            // this.enableButtons();
            // this.alerts.showInvalidModel();
            if (error && error.status == 412 && !error.request.metadataRetry) {
                this.handleMetadataSyncError(error);
            } else if (!error && !this.disposed) {
                this.context.lastSaveAction = null;
                callback();
            }
        }, this));
    },

    /**
     * Check to see if all fields are valid
     *
     * @inheritdoc
     */
    validateModelWaterfall: function (callback) {
        // override this.model.doValidate() to display error if subpanel model validation failed
        this.model.trigger('validation:start');
        this.model.isValidAsync(this.getFields(this.module), _.bind(function (isValid, errors) {
            if (this.validSubpanelModels && isValid) {
                this.model.trigger('validation:success');
            } else if (!this.validSubpanelModels) {
                this.model.trigger('error:validation');
            }
            this.model.trigger('validation:complete', this.model._processValidationErrors(errors));
            callback(!isValid);
        }, this));
    },

    /**
     * Check to see if there are subpanel create models on this view
     * And trigger an event to tell the subpanel to validate itself
     *
     * @inheritdoc
     */
    validateSubpanelModelsWaterfall: function (callback) {
        this.hasSubpanelModels = false;
        this.validSubpanelModels = true;
        _.each(this.context.children, function (child) {
            if (child.get('isCreateSubpanel')) {
                this.hasSubpanelModels = true;
                this.context.trigger('subpanel:validateCollection:' + child.get('link'),
                        _.bind(function (notValid) {
                            if (this.validSubpanelModels && notValid) {
                                this.validSubpanelModels = false;
                            }
                            callback(notValid);
                        }, this),
                        // -- Change made to skip the validation in case there is no model to validate.
                        true
                        );
            }
        }, this);

        // If there are no subpanel models, callback false so the waterfall can continue
        if (!this.hasSubpanelModels) {
            return callback(false);
        }
    },

    /**
     * Custom logic to make sure that none of the rli records have changed
     *
     * @inheritdoc
     */
    hasUnsavedChanges: function () {
        var ret = this._super('hasUnsavedChanges');

        // now lets check for RLI's
        var rli_context = this.context.getChildContext({link: 'product_templates_product_templates_1'});
        rli_context.prepare();

        var _ret = false;
        if (this.productBundleIds.length != this.model._relatedCollections.product_templates_product_templates_1.length) {
            _ret = true;
        }

        if (!_ret)
            _.each(this.model._relatedCollections.product_templates_product_templates_1.models, function (model) {
                _.each(model.attributes, function (val, key) {
                    if (!_.isEqual(val, model._syncedAttributes[key])) {
                        _ret = true;
                    }
                });
            });

        // if there is more than one record in the related context collection, then return true
        // if (rli_context.get('collection').length > 1) {
        //     ret = true;
        // } else if (rli_context.get('collection').length === 0) {
        //     // if there is no RLI in the related context collection, then return false
        //     ret = false;
        // } else {
        //     // if there is only one model, we need to verify that the model is not dirty.
        //     // check the non default attributes to make sure they are not empty.
        //     var model = rli_context.get('collection').at(0),
        //             attr_keys = _.difference(_.keys(model.attributes), ['id']),
        //             // if the value is not empty and it doesn't equal the default value
        //             // we have a dirty model
        //             unsavedRliChanges = _.find(attr_keys, function (attr) {
        //                 var val = model.get(attr);
        //                 return (!_.isEmpty(val) && (model._defaults[attr] !== val));
        //             });

        //     ret = (!_.isUndefined(unsavedRliChanges));
        // }

        return ret || _ret;
    },

    /**
     * @inheritdoc
     */
    getCustomSaveOptions: function (options) {
        this.createdModel = this.model;
        // since we are in a drawer
        this.listContext = this.context.parent || this.context;
        this.originalSuccess = options.success;

        if (app.metadata.getModule(this.module).isTBAEnabled === true) {
            // make sure new RLIs inherit opportunity's teamset and selected teams
            var addedRLIs = this.createdModel.get('product_templates_product_templates_1') || false;
            if (addedRLIs && addedRLIs.create && addedRLIs.create.length) {
                _.each(addedRLIs.create, function (data) {
                    data.team_name = this.createdModel.get('team_name');
                }, this);
            }
        }

        var success = _.bind(function (model) {
            this.originalSuccess(model);
        }, this);

        return {
            success: success
        };
    },

    _saveModel: function () {
        var options,
                successCallback = _.bind(function () {
                    // Loop through the visible subpanels and have them sync. This is to update any related
                    // fields to the record that may have been changed on the server on save.
                    _.each(this.context.children, function (child) {
                        if (child.get('isSubpanel') && !child.get('hidden')) {
                            if (child.get('collapsed')) {
                                child.resetLoadFlag({recursive: false});
                            } else {
                                child.reloadData({recursive: false});
                            }
                        }
                    });
                    if (this.createMode) {
                        app.navigate(this.context, this.model);
                    } else if (!this.disposed && !app.acl.hasAccessToModel('edit', this.model)) {
                        //re-render the view if the user does not have edit access after save.
                        this.render();
                    }
                }, this);

        //Call editable to turn off key and mouse events before fields are disposed (SP-1873)
        this.turnOffEvents(this.fields);

        options = {
            showAlerts: true,
            success: successCallback,
            error: _.bind(function (model, error) {
                if (error.status === 412 && !error.request.metadataRetry) {
                    this.handleMetadataSyncError(error);
                } else if (error.status === 409) {
                    app.utils.resolve409Conflict(error, this.model, _.bind(function (model, isDatabaseData) {
                        if (model) {
                            if (isDatabaseData) {
                                successCallback();
                            } else {
                                this._saveModel();
                            }
                        }
                    }, this));
                } else if (error.status === 403 || error.status === 404) {
                    this.alerts.showNoAccessError.call(this);
                } else {
                    this.editClicked();
                }
            }, this),
            lastModified: this.model.get('date_modified'),
            viewed: true
        };

        // ensure view and field are sent as params so collection-type fields come back in the response to PUT requests
        // (they're not sent unless specifically requested)
        options.params = options.params || {};
        if (this.context.has('dataView') && _.isString(this.context.get('dataView'))) {
            options.params.view = this.context.get('dataView');
        }

        if (this.context.has('fields')) {
            options.params.fields = this.context.get('fields').join(',');
        }

        // Check if this has subpanel create models
        if (this.hasSubpanelModels) {
            _.each(this.context.children, function (child) {
                if (child.get('isCreateSubpanel')) {
                    // create the child collection JSON structure to save
                    var childCollection = {
                        create: [],
                        update: [],
                        delete: [],
                    },
                            linkName = child.get('link');
                    if (this.model.has(linkName)) {
                        // the model already has the link name, there must be rollup formulas
                        // on the create form between the model and the subpanel
                        childCollection = this.model.get(linkName);
                        if (linkName == 'product_templates_product_templates_1') {
                            childCollection['create'] = [];
                            childCollection['update'] = [];
                            childCollection['delete'] = [];
                        }
                        // make sure there is a create key on the childCollection
                        if (!_.has(childCollection, 'create')) {
                            childCollection['create'] = [];
                            childCollection['update'] = [];
                            childCollection['delete'] = [];
                        }
                    }
                    // loop through the models in the collection and push each model's JSON
                    // data to the 'create' array
                    _.each(child.get('collection').models, function (model) {
                        if (child.get('link') == 'product_templates_product_templates_1') {
                            if (_.contains(this.productBundleIds, model.get('id'))) {
                                childCollection.update.push(model.toJSON());
                                this.productBundleIds = this.arrayRemove(this.productBundleIds, model.get('id'));
                            } else {
                                childCollection.create.push(model.toJSON());
                            }
                        } else {
                            childCollection.create.push(model.toJSON());
                        }
                    }, this);

                    if (child.get('link') == 'product_templates_product_templates_1') {
                        if (this.productBundleIds.length) {
                            _.each(this.productBundleIds, function (val, key) {
                                childCollection.delete.push(val);
                            }, this);
                        }
                    }

                    // set the child JSON collection data to the model
                    this.model.set(linkName, childCollection);
                }
            }, this);
        }

        options = _.extend({}, options, this.getCustomSaveOptions(options));
        this.model.save({}, options);
    },

    arrayRemove: function (arr, value) {
        return arr.filter(function (ele) {
            return ele != value;
        });
    },

    /**
     * @inheritdoc
     */
    _dispose: function () {
        if (this.alert) {
            this.alert.getCloseSelector().off('click');
        }

        this._super('_dispose', []);
    }
})