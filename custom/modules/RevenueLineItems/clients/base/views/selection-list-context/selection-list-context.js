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
    facilitiesInfo: {},
    events: {
        'click [data-close-pill]': 'handleClosePillEvent',
        'click .reset_button': 'removeAllPills'
    },

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this.pills = [];
        this.facilitiesInfo = {};
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

            if (!_.isEmpty(model.get('v_vendors_id_c')) && model.get('is_bundle_product_c') != 'parent' && model.get('manifest_required_c')) {
                this.facilitiesInfo[model.get('id')] = model.get('v_vendors_id_c');
            }

            if (modelName && !_.contains(pillsIds, model.id)) {
                pillsAttrs.push({
                    id: model.id,
                    name: modelName,
                });
            }

            // ++
            if (!_.isEmpty(model.get('revenuelineitems_revenuelineitems_1').records)) {
                _.each(model.get('revenuelineitems_revenuelineitems_1').records, function (relatedRLI) {
                    if (relatedRLI.name && relatedRLI.id && !_.contains(pillsIds, relatedRLI.id)) {
                        if (!_.isEmpty(relatedRLI.v_vendors_id_c) && relatedRLI.is_bundle_product_c != 'parent' && relatedRLI.manifest_required_c) {
                            facilitiesInfo[relatedRLI.id] = relatedRLI.v_vendors_id_c;
                        }

                        pillsAttrs.push({
                            id: relatedRLI.id,
                            name: relatedRLI.name,
                            custom_class: 'rli-pill-bcc',
                            virtual: true,
                        });
                    }
                }, this);
            }
        }, this);

        this.pills.push.apply(this.pills, pillsAttrs);

        this._debounceRender();
    },

    _debounceRender: _.debounce(function () {
        var self = this;
        $.when(self.render()).then(function () {
            self.ifValidFacilities();
        });
    }, 50),

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
                    this.facilitiesInfo = _.omit(this.facilitiesInfo, relatedRLI.id);
                }, this);
            }
            // Remove the entry from the facilitiesInfo when row is unselected or pill is removed.
            this.facilitiesInfo = _.omit(this.facilitiesInfo, models[0].get('id'));
        }

        this.pills = _.reject(this.pills, function (pill) {
            return _.contains(ids, pill.id);
        });

        this._debounceRender();
    },

    ifValidFacilities: function () {
        var exceptVendors = [];
        // Subpanel RLIs (Put RLI id and facility id in an object)
        if (!_.isUndefined(this.context.parent) && !_.isNull(this.context.parent)) {
            _.each(this.context.parent.get('model')._relatedCollections.sales_and_services_revenuelineitems_1.models, function (model, key) {
                if (!_.isEmpty(model.attributes.v_vendors_id_c) && model.attributes.is_bundle_product_c != 'parent' && model.attributes.manifest_required_c) {
                    this.facilitiesInfo[model.attributes.id] = model.attributes.v_vendors_id_c;
                    exceptVendors.push(model.attributes.v_vendors_id_c);
                }
            }, this);
        }

        // Get the facilities ids and make them unique to check do we 
        // have multiple facilities or not
        // If we have multiple, group them and color the pills.
        // each facility has its own color, this way we will group multiple 
        // rlis with same facility to a common color.
        if (_.unique(_.compact(_.values(this.facilitiesInfo))).length > 1) {
            var facilitiesInfoGroupBy = {};
            _.each(this.facilitiesInfo, function (val, key) {
                if (_.isUndefined(facilitiesInfoGroupBy[val]) || _.isNull(facilitiesInfoGroupBy[val])) {
                    facilitiesInfoGroupBy[val] = [];
                }
                facilitiesInfoGroupBy[val].push(key)
            }, this);

            var colorsList = ['#0679c8', '#6d17e5', '#54cb14', '#ffb600', '#e61718'];
            _.each(facilitiesInfoGroupBy, function (_val, _key) {
                if (!_.contains(exceptVendors, _key)) {
                    var color = colorsList.pop();
                    _.each(_val, function (val) {
                        $('li[data-id=' + val + ']').attr('style', 'background:radial-gradient(' + color + ', ' + color + ');');
                    }, this);
                }
            }, this);
        }
    },
})
