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
//        this.template = app.template.getView('subpanel-list-create');
        this.template = app.template.getView('subpanel-list-create', 'RevenueLineItems');

        this.context.set({
            isCreateSubpanel: true
        });
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function () {
        this._super('bindDataChange');
        this.collection.on('sort', this.render, this);
    },

    /**
     * Adds a bean for this.module to the collection
     *
     * @param {Boolean} hasValidModels If this collection has validated models
     * @param {Object} prepopulateData The ProductCatalog data to add prepopulate an RLI
     * @private
     */
    _addBeanToList: function (hasValidModels, prepopulateData) {
        var beanId;
        var bean;
        var addAtZeroIndex;
        prepopulateData = prepopulateData || {};

        if (hasValidModels) {
            beanId = app.utils.generateUUID();
            addAtZeroIndex = !_.isEmpty(prepopulateData);

            prepopulateData.id = beanId;
            bean = app.data.createBean(this.module);
            bean.set(prepopulateData);
            bean._module = this.module;
            bean._rowIndex = 0;

            /**/
            var _rowIndex = 1.000, _backgroundColorClass = '';
            if (prepopulateData.is_bundle_product_c == 'parent') {
                // Get the max rowIndex number from collection and convert to integer, increment it by 1
                if (this.collection.length) {
                    var maxModel = _.max(this.collection.models, function (model) {
                        return model._rowIndex
                    });
                    _rowIndex = parseInt(maxModel._rowIndex) + 1;
//                    _backgroundColorClass = 'rli-td-bcc-' + _rowIndex;
                    _backgroundColorClass = 'rli-td-bcc';
                } else {
                    _rowIndex = 2.000;
//                    _backgroundColorClass = 'rli-td-bcc-' + parseInt(_rowIndex);
                    _backgroundColorClass = 'rli-td-bcc';
                }
            } else if (prepopulateData.is_bundle_product_c == 'child') {
                // Get the max rowIndex number from collection and remain in float, increment it by 0.001
                var maxModel = _.max(this.collection.models, function (model) {
                    return model._rowIndex
                });
                _rowIndex = maxModel._rowIndex + 0.001;
//                _backgroundColorClass = 'rli-td-bcc-' + parseInt(_rowIndex);
                _backgroundColorClass = 'rli-td-bcc';
            } else {
                // It's the stand-alone product so rowType will be undefined
                // Get the min rowIndex number and decrement it by 0.001
                if (this.collection.length) {
                    var maxModel = _.min(this.collection.models, function (model) {
                        return model._rowIndex
                    });
                    _rowIndex = maxModel._rowIndex - 0.001;
                } else {
                    _rowIndex = 1;
                }
                _backgroundColorClass = '';
            }
            bean._rowIndex = _rowIndex;
            bean._backgroundColorClass = _backgroundColorClass;
            /**/

            // check the parent record to see if an assigned user ID/name has been set
            if (this.context.parent && this.context.parent.has('model')) {
                var parentModel = this.context.parent.get('model'),
                        userId = parentModel.get('assigned_user_id'),
                        userName = parentModel.get('assigned_user_name');

                if (userId) {
                    bean.setDefault('assigned_user_id', userId);
                }

                if (userName) {
                    bean.setDefault('assigned_user_name', userName);
                }
            }

            bean = this._addCustomFieldsToBean(bean, addAtZeroIndex);

            // ++ Code is added to keep the Line number of the revenue line item while creation 
            // from the Sales and service, Accounts or Opportunities
            // This line number will be firther used for the printing in work orders or manifest
            var collectionRowIds = [];
            var htmlRowIds = [];

            // get the collection row ids
            _.each(this.collection.models, function (model) {
                collectionRowIds.push(model.get('id'));
            }, this);

            // get the html row ids
            _.each(this.$('tbody > tr'), function (tr) {
                var name = $(tr).attr('name').split('_');
                var id = name[1];
                htmlRowIds.push(id);
            }, this);

            // If collection row ids are not same as html row ids, means the order is changed on the view
            // through drag and drop. We have reindex all the models in the collection and assigned them new indexes
//            if (!_.isEqual(collectionRowIds, htmlRowIds)) {
//                var resetIndex = 1;
//                _.each(htmlRowIds, function (id) {
//                    var model = this.collection.get(id);
//                    model._rowIndex = resetIndex;
//                    model.set('line_number', resetIndex, {'silent': true});
//                    resetIndex++;
//                }, this);
//            }

            // must add to this.collection so the bean shows up in the subpanel list
            if (addAtZeroIndex) {
                this.collection.unshift(bean);
            } else {
                this.collection.add(bean);
            }

            // set checkbox checked and mark the first item name as the sales and service name 
            if (this.collection.length == 1) {
                if (this.context.parent && this.context.parent.has('model')) {
                    var parentModel = this.context.parent.get('model');
                    parentModel.set('name', this.collection.at(0).get('name'));
                    this.collection.at(0).set('primary_rli', 1);
                }
            }

            this.collection.comparator = function (model) {
                return model._rowIndex;
            };
            this.collection.sort();
        }

        this.checkButtons();
    },
})
