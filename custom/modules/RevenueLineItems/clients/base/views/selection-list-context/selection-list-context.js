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
 *
 * This view displays the selected records at the top of a selection list. It
 * also allows to unselect them.
 *
 * @class View.Views.Base.SelectionListContextView
 * @alias SUGAR.App.view.views.BaseSelectionListContextView
 * @extends View.View
 */

({
    extendsFrom: 'SelectionListContextView',
    className: 'selection-context',
    events: {
        'click [data-close-pill]': 'handleClosePillEvent',
        'click .reset_button': 'removeAllPills'
    },

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this.pills = [];
        /**
         * The maximum number of pills that can be displayed.
         *
         * @property {number}
         */
        this.maxPillsDisplayed = 50;
        this._super('initialize', [options]);
    },

    /**
     * Adds a pill in the template.
     *
     * @param {Data.Bean|Object|Array} models The model, set of model attributes
     * or array of those corresponding to the pills to add.
     */
    addPill: function (models) {

        models = _.isArray(models) ? models : [models];

        if (_.isEmpty(models)) {
            return;
        }

        var pillsAttrs = [];
        var pillsIds = _.pluck(this.pills, 'id');

        _.each(models, function (model) {
            //FIXME : SC-4196 will remove this.
            var modelName = model.get('name') || model.get('full_name') ||
                    app.utils.formatNameLocale(model.attributes) ||
                    model.get('document_name');

            if (modelName && !_.contains(pillsIds, model.id)) {
                pillsAttrs.push({id: model.id, name: modelName});
            }

            // ++
            if (!_.isEmpty(model.get('revenuelineitems_revenuelineitems_1').records)) {
                _.each(model.get('revenuelineitems_revenuelineitems_1').records, function (relatedRLI) {
                    if (relatedRLI.name && relatedRLI.id && !_.contains(pillsIds, relatedRLI.id)) {
                        pillsAttrs.push({
                            id: relatedRLI.id,
                            name: relatedRLI.name,
                            custom_class: 'rli-pill-bcc',
                            virtual: true,
                        });
                    }
                }, this);
            }
        });

        this.pills.push.apply(this.pills, pillsAttrs);

        this._debounceRender();
    },

    /**
     * Removes a pill from the template.
     *
     * @param {Data.Bean|Object|Array} models The model or array of models
     * corresponding to the pills to remove. It can also be an object or array
     * of objects containing the 'id' of the pills to remove.
     *
     */
    removePill: function (models) {
        models = _.isArray(models) ? models : [models];
        var ids = _.pluck(models, 'id');

        // ++
        if (_.isArray(models) && _.isFunction(models[0].get)) {
            if (!_.isEmpty(models[0].get('revenuelineitems_revenuelineitems_1').records)) {
                _.each(models[0].get('revenuelineitems_revenuelineitems_1').records, function (relatedRLI) {
                    if (relatedRLI.name && relatedRLI.id) {
                        ids.push(relatedRLI.id);
                    }
                }, this);
            }
        }

        this.pills = _.reject(this.pills, function (pill) {
            return _.contains(ids, pill.id);
        });

        this._debounceRender();
    },
})
