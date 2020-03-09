/**
 * @class View.Views.Base.Accounts.CreateView
 * @alias SUGAR.App.view.views.AccountsCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'CreateView',
    executeGroupLogic: 0,
    exeuteBundleLogic: 0,

    initialize: function (options) {
        this._super('initialize', [options]);
        app.controller.context.on('productCatalogDashlet:populate:RLI', this.onPopulateFromProductCatalog, this);
    },

    buildSuccessMessage: function (model) {
        var modelAttributes,
                successLabel = 'LBL_RECORD_SAVED_SUCCESS',
                successMessageContext;

        //if we have model attributes, use them to build the message, otherwise use a generic message
        if (model && model.attributes) {
            modelAttributes = model.attributes;
        } else {
            modelAttributes = {};
            successLabel = 'LBL_RECORD_SAVED';
        }

        if (this.executeGroupLogic == 1) {
            successLabel = 'LBL_RECORD_SAVED';
        }

        //use the model attributes combined with data from the view to build the success message context
        successMessageContext = _.extend({
            module: this.module,
            moduleSingularLower: app.lang.getModuleName(this.module).toLowerCase()
        }, modelAttributes);

        return app.lang.get(successLabel, this.module, successMessageContext);
    },

    validateModelWaterfall: function (callback) {
        var self = this;
        this.model.doValidate(this.getFields(this.module), function (isValid) {
            if (self.context.parent.get('model').module == 'sales_and_services') {
                callback(!isValid || !self.checkTSDFValidity());
            } else {
                callback(!isValid);
            }
        });
    },

    checkTSDFValidity: function () {
        var isValidTSDF = true;
        var facilitiesInfo = {};

        // Subpanel RLIs
        _.each(this.context.parent.get('model')._relatedCollections.sales_and_services_revenuelineitems_1.models, function (model, key) {
            this.warnIfDifferentFacilities(model, facilitiesInfo);
        }, this);

        // The RLI which we are creating  right now in the create drawer.
        if (!this.warnIfDifferentFacilities(this.model, facilitiesInfo, true, true)) {
            isValidTSDF = false;
        }

        return isValidTSDF;
    },

    warnIfDifferentFacilities: function (model, facilitiesInfo, checkValidation, evaluateIt) {
        // Put RLI id and facility id in an object
        if (!_.isEmpty(model.attributes.v_vendors_id_c) && model.attributes.is_bundle_product_c != 'parent' && model.attributes.manifest_required_c) {
            facilitiesInfo[model.attributes.id] = model.attributes.v_vendors_id_c;
        }

        // If all the RLIs has been looped through and this is the last RLI
        // get the facilities ids and make then unique to check do we 
        // have multiple facilities or not
        if (evaluateIt) {
            if (_.unique(_.compact(_.values(facilitiesInfo))).length > 1) {
                app.alert.dismiss('multifacility-warning');
                app.alert.show('multifacility-warning', {
                    level: 'warning',
                    messages: 'You can\'t create an items which has different Ship To / TSDF, Please create a new Sales and Service for this Item.',
                    closeable: true,
                    autoClose: true,
                    autoCloseDelay: 12000,
                });

                if (checkValidation) {
                    return false;
                }
            }
        }
        return true;
    },

    onPopulateFromProductCatalog: function (data) {
        data = data || {};
        data.likely_case = data.discount_price;
        data.best_case = data.discount_price;
        data.worst_case = data.discount_price;
        data.assigned_user_id = app.user.get('id');
        data.assigned_user_name = app.user.get('name');

        if (data.is_group_item_c == true) {
            data.executeGroupLogic = 1;
            this.executeGroupLogic = 1;
        } else {
            data.exeuteBundleLogic = 1;
            this.exeuteBundleLogic = 1;
        }

        var bean;

        bean = app.data.createBean('RevenueLineItems');
        bean.set(data);
        bean._module = bean.attributes._module = 'RevenueLineItems';
        delete bean.attributes.id;
        delete bean.id;

        // check the parent record to see if an assigned user ID/name has been set
        if (this.context && this.context.has('model')) {
            var rliModel = this.context.get('model'),
                    userId = rliModel.get('assigned_user_id'),
                    userName = rliModel.get('assigned_user_name');

            if (userId) {
                bean.setDefault('assigned_user_id', userId);
            }

            if (userName) {
                bean.setDefault('assigned_user_name', userName);
            }

            rliModel.set(bean.attributes);
        }

        // Piece of code is added to reset the related revenueline item subpanel create list every time
        // when a product template is selected from the dashlet.
        if (this.context) {
            var rli_context = this.context.getChildContext({link: 'revenuelineitems_revenuelineitems_1'});
            rli_context.prepare();
            if (rli_context.get('collection').length > 0) {
                rli_context.get('collection').reset();
            }
        }
    },

    validateSubpanelModelsWaterfall: function (callback) {
        this.hasSubpanelModels = false;
        _.each(this.context.children, function (child) {
            if (child.get('isCreateSubpanel')) {
                this.hasSubpanelModels = true;
                this.context.trigger('subpanel:validateCollection:' + child.get('link'), callback, true);
            }
        }, this);

        // If there are no subpanel models, callback false so the waterfall can continue
        if (!this.hasSubpanelModels) {
            return callback(false);
        } else {
            // ++ 
            // Saving is hacked to save the single Revenuelineitem (because when revenue line item is created in a drawer
            // bundle is saved from the above return callback(false) condition, so for a single revenue line item, we have
            // to write this code.)
            var rli_context = this.context.getChildContext({link: 'revenuelineitems_revenuelineitems_1'});
            rli_context.prepare();
            if (rli_context.get('collection').length == 0) {
                return callback(false);
            }
        }
    },

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

                    // loop through the models in the collection and push each model's JSON
                    // data to the 'create' array
//                    var lineNumber = 1, setLineNumber = false;
                    _.each(child.get('collection').models, function (model) {
                        // Set the Sales and Service Account, Opportunity account, account ID, to every RLI model in
                        // bundle which is going to create...
                        if (self.context.parent.get('module') == 'Accounts') {
                            model.set('account_id', self.context.parent.get('model').get('id'));
                        } else if (self.context.parent.get('module') == 'sales_and_services') {
                            model.set('account_id', self.context.parent.get('model').get('accounts_sales_and_services_1accounts_ida'));
                            model.set('sales_and_services_revenuelineitems_1sales_and_services_ida', self.context.parent.get('model').get('id'));
                        } else if (self.context.parent.get('module') == 'Opportunities') {
                            model.set('account_id', self.context.parent.get('model').get('account_id'));
                        }
                        // Check if line_number is not set to first model, 
                        // It means it is not set for any of these, (set line_number for revenuelineitems)
//                        if (child.get('collection').models[0].get('line_number') == 0) {
//                            setLineNumber = true;
//                        }
//
//                        if (setLineNumber) {
//                            model.set('line_number', lineNumber, {'silent': true});
//                        }

                        childCollection.create.push(model.toJSON());
//                        lineNumber++;
                    }, this);

                    // set the child JSON collection data to the model
                    this.model.set(linkName, childCollection);
                }
            }, this);
        }

        options = _.extend({}, options, self.getCustomSaveOptions(options));
        self.model.save(null, options);
    },
})