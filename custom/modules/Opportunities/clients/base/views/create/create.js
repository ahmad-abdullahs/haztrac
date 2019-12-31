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
 * @class View.Views.Base.Opportunities.CreateView
 * @alias SUGAR.App.view.views.OpportunitiesCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'OpportunitiesCreateView',

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
     * What are we viewing by
     */
    viewBy: 'Opportunities',

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
        this._super('initialize', [options]);
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
                    // If there is only one RLI while Opportunities creation and 
                    // it's name is empty then ignore it, don't save it.
                    // Otherwise it will create a RLI without name which is so annoying.
                    if (linkName == 'revenuelineitems' && child.get('collection').models.length == 1) {
                        if (_.isEmpty(child.get('collection').models[0].get('name'))) {
                            // continue
                            return;
                        }
                    }

                    // loop through the models in the collection and push each model's JSON
                    // data to the 'create' array
                    _.each(child.get('collection').models, function (model) {
                        childCollection.create.push(model.toJSON());
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
    getCustomSaveOptions: function (options) {
        if (this.viewBy === 'RevenueLineItems') {
            this.createdModel = this.model;
            // since we are in a drawer
            this.listContext = this.context.parent || this.context;
            this.originalSuccess = options.success;

            if (app.metadata.getModule(this.module).isTBAEnabled === true) {
                // make sure new RLIs inherit opportunity's teamset and selected teams
                var addedRLIs = this.createdModel.get('revenuelineitems') || false;
                if (addedRLIs && addedRLIs.create && addedRLIs.create.length) {
                    _.each(addedRLIs.create, function (data) {
                        data.team_name = this.createdModel.get('team_name');
                    }, this);
                }
            }

            var success = _.bind(function (model) {
                this.originalSuccess(model);
                // --
                // This function is overridden to remove the Warning which comes up when there is no 
                // Revenuelineitem is added in the Opportunity at the time of creation...
                // this._checkForRevenueLineItems(model, options);
            }, this);

            return {
                success: success
            };
        }
    },

})
