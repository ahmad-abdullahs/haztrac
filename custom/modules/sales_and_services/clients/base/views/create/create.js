/**
 * @class View.Views.Base.Accounts.CreateView
 * @alias SUGAR.App.view.views.AccountsCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'CreateView',

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

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        var self = this;
        this._viewAlerts = [];
        this.plugins = _.union(this.plugins, ['LinkedModel']);

        this.hasRliAccess = app.acl.hasAccess('edit', 'RevenueLineItems');

        this._super('initialize', [options]);

        this.alerts = _.extend({}, this.alerts, {
            showInvalidModel: function () {
                if (!self instanceof app.view.View) {
                    app.logger.error('This method should be invoked by Function.prototype.call(), passing in as argument' +
                            'an instance of this view.');
                    return;
                }
                var name = 'invalid-data';
                self._viewAlerts.push(name);

                var messages = 'ERR_RESOLVE_ERRORS';
                var nameField = self.getField('name');
                if (!_.isEmpty(nameField._errors) || !self.model.get('name')) {
                    messages = "Select Primary Revenuelineitem to auto-populate Sales & Service name.";
                }

                app.alert.show(name, {
                    level: 'error',
                    messages: messages
                });
            },
            showServerError: function () {
                if (!self instanceof app.view.View) {
                    app.logger.error('This method should be invoked by Function.prototype.call(), passing in as argument' +
                            'an instance of this view.');
                    return;
                }
                var name = 'server-error';
                self._viewAlerts.push(name);
                app.alert.show(name, {
                    level: 'error',
                    messages: 'ERR_GENERIC_SERVER_ERROR'
                });
            },
            showSuccessButDeniedAccess: function () {
                if (!self instanceof app.view.View) {
                    app.logger.error('This method should be invoked by Function.prototype.call(), passing in as argument' +
                            'an instance of this view.');
                    return;
                }
                var name = 'invalid-data';
                self._viewAlerts.push(name);
                app.alert.show(name, {
                    level: 'warning',
                    messages: 'LBL_RECORD_SAVED_ACCESS_DENIED',
                    autoClose: true,
                    autoCloseDelay: 9000
                });
            }
        });

        this.model.off('error:validation');
        this.model.on("error:validation", function () {
            this.alerts.showInvalidModel();
        }, this);
    },

    /**
     * @inheritdoc
     */
    render: function () {
        this._super('render');

        // At time of creating the record, We need to set the default values...
        // We can directly set the values in the model but just to be conscious we have added the if checks 
        if (_.isEmpty(this.model.get('end_date_option_c')) && _.isEmpty(this.model.get('recurring_end_date_c'))) {
            this.model.set('end_date_option_c', 'End date');
            this.model.set('recurring_end_date_c', this.model.get('recurring_start_date_c'));
        }

        if (_.isEmpty(this.model.get('occurs_c')) && _.isEmpty(this.model.get('daily_repeats_on_c'))) {
            this.model.set('occurs_c', 'Daily');
            this.model.set('daily_repeats_on_c', 'Every day');
            this.model.set('daily_skip_weekends_c', true);
        }
    },

    /**
     * @inheritdoc
     */
    initiateSave: function (callback) {
        this.disableButtons();
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
            _.bind(this.dupeCheckWaterfall, this),
            _.bind(this.createRecordWaterfall, this)
        ], _.bind(function (error) {
            this.enableButtons();
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
        var rli_context = this.context.getChildContext({link: 'sales_and_services_revenuelineitems_1'});
        rli_context.prepare();

        // if there is more than one record in the related context collection, then return true
        if (rli_context.get('collection').length > 1) {
            ret = true;
        } else if (rli_context.get('collection').length === 0) {
            // if there is no RLI in the related context collection, then return false
            ret = false;
        } else {
            // if there is only one model, we need to verify that the model is not dirty.
            // check the non default attributes to make sure they are not empty.
            var model = rli_context.get('collection').at(0),
                    attr_keys = _.difference(_.keys(model.attributes), ['id']),
                    // if the value is not empty and it doesn't equal the default value
                    // we have a dirty model
                    unsavedRliChanges = _.find(attr_keys, function (attr) {
                        var val = model.get(attr);
                        return (!_.isEmpty(val) && (model._defaults[attr] !== val));
                    });

            ret = (!_.isUndefined(unsavedRliChanges));
        }

        return ret;
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
            // make sure new RLIs inherit Sales and Services's teamset and selected teams
            var addedRLIs = this.createdModel.get('sales_and_services_revenuelineitems_1') || false;
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

    /**
     * Create a new record
     * @param success
     * @param error
     */
    saveModel: function (success, error) {
        var self = this,
                options;
        options = {
            success: success,
            error: error,
            viewed: true,
            relate: (self.model.link) ? true : null,
            //Show alerts for this request
            showAlerts: {
                'process': true,
                'success': false,
                'error': false //error callback implements its own error handler
            },
            lastSaveAction: this.context.lastSaveAction
        };
        this.applyAfterCreateOptions(options);

        // Check if this has subpanel create models
        if (this.hasSubpanelModels) {
            _.each(this.context.children, function (child) {
                if (child.get('isCreateSubpanel')) {
                    // create the child collection JSON structure to save
                    var childCollection = {
                        create: []
                    },
                            linkName = child.get('link');
                    if (this.model.has(linkName)) {
                        // the model already has the link name, there must be rollup formulas
                        // on the create form between the model and the subpanel
                        childCollection = this.model.get(linkName);
                        // make sure there is a create key on the childCollection
                        if (!_.has(childCollection, 'create')) {
                            childCollection['create'] = [];
                        }
                    }

                    // ++
                    // If there is only one RLI while Sales and Service creation and 
                    // it's name is empty then ignore it, don't save it.
                    // Otherwise it will create a RLI without name which is so annoying.
                    if (linkName == 'sales_and_services_revenuelineitems_1' && child.get('collection').models.length == 1) {
                        if (_.isEmpty(child.get('collection').models[0].get('name'))) {
                            // continue
                            return;
                        }
                    }

                    // loop through the models in the collection and push each model's JSON
                    // data to the 'create' array
                    var lineNumber = 1, setLineNumber = false;
                    _.each(child.get('collection').models, function (model) {
                        // Set the Sales and Service Account to every RLI model which is going to create...
                        model.set('account_id', this.model.get('accounts_sales_and_services_1accounts_ida'));
                        // Check if line_number is not set to first model, 
                        // It means it is not set for any of these, (set line_number for revenuelineitems)
                        if (child.get('collection').models[0].get('line_number') == 0) {
                            setLineNumber = true;
                        }

                        if (setLineNumber) {
                            model.set('line_number', lineNumber, {'silent': true});
                        }

                        childCollection.create.push(model.toJSON());
                        lineNumber++;
                    }, this);

                    // set the child JSON collection data to the model
                    this.model.set(linkName, childCollection);
                }
            }, this);
        }

        options = _.extend({}, options, self.getCustomSaveOptions(options));
        self.model.save(null, options);
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