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
 * Custom RecordlistView used for SubpanelCreate layouts.
 *
 * @class View.Views.Base.SubpanelListCreateView
 * @alias SUGAR.App.view.views.BaseSubpanelListCreateView
 * @extends View.Views.Base.SubpanelListView
 */
({
    extendsFrom: 'SubpanelListCreateView',

    /**
     * @inheritdoc
     */
    dataView: 'subpanel-list-create',

    contextEvents: {
        'list:deleterow:fire': 'onDeleteRow',
        'list:addrow:fire': 'onAddRow'
    },

    /**
     * Flag if the view has all valid models
     */
    hasValidModels: true,

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);

        // undo flex-list's hardcoding and re-hardcode to use the subpanel-list-create.hbs
        this.template = app.template.getView('subpanel-list-create');

        this.context.set({
            isCreateSubpanel: true
        });

        // ++
        if (options.context.get('parentModule') == 'ProductTemplates') {
            // Re-render the RLI view to fix the styling 
            this.context.parent.get('model').on('data:sync:complete', function () {
                this.render();
            }, this);
        }
    },

    _renderHtml: function () {
        if (this.context.get('parentModule') == 'ProductTemplates') {
            // remove the hidden attribute from the RLI panel.
            this.$el.css('display', 'block');
        }
        this._super('_renderHtml');
    },

    /**
     * Handles when users click to add items from the Product Catalog dashlet to the Opportunity
     *
     * @param {Object} data The ProductCatalog Data
     */
    onAddFromProductCatalog: function (data) {
        var existingModel = this.collection.length === 1 && this.collection.at(0);
        var isEmpty = existingModel &&
                _.isEmpty(existingModel.changedAttributes()) &&
                _.isEmpty(existingModel.get('product_template_id'));

        // ++
        if (this.context.get('parentModule') == 'ProductTemplates') {
            isEmpty = isEmpty && _.isEmpty(existingModel.get('is_bundle_product_c'));
        }

        data.likely_case = data.discount_price;
        data.best_case = data.discount_price;
        data.worst_case = data.discount_price;
        data.assigned_user_id = app.user.get('id');
        data.assigned_user_name = app.user.get('name');

        if (isEmpty) {
            this.collection.remove(existingModel);
        }

        this._addBeanToList(true, data);
    },

    /**
     * Validates the models in the subpanel
     *
     * @param {Function} callback The callback function to call after validation
     * @param {undefined|Boolean} [fromCreateView] If this function is being called from Create view or not
     */
    validateModels: function (callback, fromCreateView) {
        fromCreateView = fromCreateView || false;
        var returnCt = 0;
        this.hasValidModels = true;

        // ++
        if (this.context.get('parentModule') == 'ProductTemplates') {
            // Added to skip the vlidation when there is no model in the record view.
            if (this.collection.models.length == 0) {
                callback(false);
            }
        }

        _.each(this.collection.models, function (model) {
            // loop through all models and call doValidate on each model
            model.doValidate(this.getFields(this.module), _.bind(function (isValid) {
                returnCt++;
                if (this.hasValidModels && !isValid) {
                    // hasValidModels was true, but a model returned false from validation
                    this.hasValidModels = isValid;
                }

                // check if all model validations have occurred
                if (returnCt === this.collection.length) {
                    if (fromCreateView) {
                        // the create waterfall wants the opposite of if this is validated
                        callback(!this.hasValidModels);
                    } else {
                        // this view wants if the models are valid or not
                        callback(this.hasValidModels);
                    }
                }
            }, this));
        }, this);
    },

    bindDataChange: function () {
        this._super('bindDataChange');
    },

})
