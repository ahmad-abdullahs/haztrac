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
 * Custom Subpanel Layout for Revenue Line Items.
 *
 * @class View.Views.Base.RevenueLineItems.SubpanelForOpportunitiesCreate
 * @alias SUGAR.App.view.views.BaseRevenueLineItemsSubpanelForOpportunitiesCreate
 * @extends View.Views.Base.SubpanelListCreateView
 */
// This view is used on ProductTemplates record view for bundle creation.
// @see screenshots 4.png
({
    extendsFrom: 'SubpanelListCreateView',
    _isEdit: null,

    initialize: function (options) {
        this._isEdit = null;
        this._super('initialize', [options]);

        // undo flex-list's hardcoding and re-hardcode to use the subpanel-list-create.hbs
        this.template = app.template.getView(this.name, 'ProductTemplates');

        this.context.parent.on('edit:full:subpanel-for-producttemplates-create:cstm', this._toggleFields, this);
        this.context.parent.on('cancel:full:subpanel-for-producttemplates-create:cstm', this._toggleFields, this);

        var _self = this;

        // This is called only for the convert-create view drawer, which is checked on the basis of options.context.parent.get('parentModelId')
        // Once the view is initialized, fetch the related RLIs to populate in the subpanel-for-producttemplates-create
        if (options.context.parent.get('parentModelId')) {
            var rliModel = app.data.createBean('RevenueLineItems', {id: options.context.parent.get('parentModelId')});
            var rliRelatedRLIColl = app.data.createRelatedCollection(rliModel, 'revenuelineitems_revenuelineitems_1');
            rliRelatedRLIColl = rliRelatedRLIColl.fetch({
                relate: true,
                limit: -1,
                // Fetched in descending order because when the items are added in the subpanel-for-producttemplates-create
                // they stacked in the view over each other. in order to keep the same line order we fetch in desc order.
                params: {
                    order_by: "line_number:desc",
                    view: 'list',
                },
                success: function (coll) {
                    _.each(coll.models, function (model) {
                        _self._massageDataBeforeSendingToRecord(model.attributes);

                        var viewDetails = _self.closestComponent('convert-create');
                        if (!_.isUndefined(viewDetails)) {
                            app.controller.context.trigger(viewDetails.cid + ':productCatalogDashlet:add', model.attributes);
                        }
                    })
                },
            });
        }
    },

    _massageDataBeforeSendingToRecord: function (data) {
        data.position = 0;
        data._forcePosition = true;

        // remove ID/etc since we dont want Template ID to be the record id
        delete data.id;
        delete data.status;
        delete data.date_entered;
        delete data.date_modified;
        delete data.pricing_formula;
    },

    bindDataChange: function () {
        this._super('bindDataChange');

        if (this.context.parent.get('parentModelId')) {
            var viewDetails = this.closestComponent('convert-create');
            if (!_.isUndefined(viewDetails)) {
                app.controller.context.on(viewDetails.cid + ':productCatalogDashlet:add', this.onAddFromProductCatalog, this);
            }
        }
    },

    /**
     * Click handler for the Add (+) button.
     * Validates each model on the collection and if they all validate, calls
     */
    onAddRow: function () {
        this._isEdit = 'edit';
        this._super('onAddRow');
        app.events.trigger('setButtonStates');
    },

    /**
     * Handler for when the delete button is clicked
     *
     * @param model
     */
    onDeleteRow: function (model) {
        this._isEdit = 'edit';
        this._super('onDeleteRow', [model]);
        app.events.trigger('setButtonStates');
    },

    onAddFromProductCatalog: function (data) {
        this._isEdit = 'edit';
        this._super('onAddFromProductCatalog', [data]);
        app.events.trigger('setButtonStates');
    },

    /**
     * Overriding to add the commit_stage field to the bean
     *
     * @inheritdoc
     */
    _addCustomFieldsToBean: function (bean, skipCurrency) {
        var dom;
        var attrs;
        var userCurrencyId;
        var userCurrency = app.user.getCurrency();
        var createInPreferred = userCurrency.currency_create_in_preferred;
        var currencyFields;
        var currencyFromRate;

        if (bean.has('sales_stage')) {
            dom = app.lang.getAppListStrings('sales_probability_dom');
            attrs = {
                probability: dom[bean.get('sales_stage')]
            };
        }

        if (skipCurrency && createInPreferred) {
            // force the line item to the user's preferred currency and rate
            attrs.currency_id = userCurrency.currency_id;
            attrs.base_rate = userCurrency.currency_rate;

            // get any currency fields on the model
            currencyFields = _.filter(this.model.fields, function (field) {
                return field.type === 'currency';
            });
            currencyFromRate = bean.get('base_rate');

            _.each(currencyFields, function (field) {
                // if the field exists on the bean, convert the value to the new rate
                // do not convert any base currency "_usdollar" fields
                if (bean.has(field.name) && field.name.indexOf('_usdollar') === -1) {
                    attrs[field.name] = app.currency.convertWithRate(
                            bean.get(field.name),
                            currencyFromRate,
                            userCurrency.currency_rate
                            );
                }
            }, this);
        } else if (!skipCurrency) {
//            userCurrencyId = userCurrency.currency_id || app.currency.getBaseCurrencyId();
//            attrs.currency_id = userCurrencyId;
//            attrs.base_rate = app.metadata.getCurrency(userCurrencyId).conversion_rate;
        }

        if (!_.isEmpty(attrs)) {
            // we need to set the defaults
            bean.setDefault(attrs);
            // just to make sure that any attributes that were already set, are set again.
            bean.set(attrs);
        }

        bean.set('is_bundle_product_c', 'child');

        return bean;
    },

    bindDataChange: function () {
        this._super("bindDataChange");
        var self = this;
        if (this.collection) {
            this.collection.on('reset', function () {
                this.render();
            }, this);
        }
    },

    _toggleFields: function (isEdit) {
        if (this._isEdit == 'edit') {
            isEdit = 'edit';
        }
        var _isEdit = isEdit;
        // If its the custom trigger fired with edit directive, so each field needs to be editable.
        isEdit = isEdit == 'edit' ? true : isEdit == 'cancel' ? false : isEdit;
        isEdit = isEdit || false;

        // toggle the fields in the list to be in edit mode
        _.each(this.collection.models, function (model) {
            // We are stopping all fields in the panel to be in editable form, only let the 
            // subpanel-for-producttemplates-create [+] [-] buttons to be in 
            // editable form (when the record view is in detail view)
            // If record view is in edit view, make each field of 
            // subpanel-for-producttemplates-create in edit mode.
            var fieldsList = this.rowFields[model.get('id')];
            if (_isEdit != 'edit') {
                fieldsList = _.filter(this.rowFields[model.get('id')], function (field) {
                    if (field.def.type == 'fieldset') {
                        return true;
                    }
                    return false;
                });
            }

            this.toggleFields(fieldsList, isEdit);
            if (_isEdit == 'edit') {
                // this is a subpanel specific logic: when the subpanel is back to edit mode,
                // manually fire the dependency trigger on all its models
                this.context.trigger("list:editrow:fire", model, {def: {}});
            }
        }, this);
        this._isEdit = null;
    },

    _render: function () {
        var sortableItems;
        var cssClasses;

        this._super('_render');
        sortableItems = this.$('tbody');
        if (sortableItems.length) {
            _.each(sortableItems, function (sortableItem) {
                $(sortableItem).sortable({
                    // allow draggable items to be connected with other tbody elements
                    connectWith: 'tbody',
                    // allow drag to only go in Y axis direction
                    axis: 'y',
                    // the items to make sortable
                    items: 'tr.sortable',
                    // make the "helper" row (the row the user actually drags around) a clone of the original row
                    helper: 'clone',
                    // adds a slow animation when "dropping" a group, removing this causes the row
                    // to immediately snap into place wherever it's sorted
                    revert: true,
                    // the CSS class to apply to the placeholder underneath the helper clone the user is dragging
                    placeholder: 'ui-state-highlight',
                    // handler for when dragging starts
                    start: _.bind(this._onDragStart, this),
                    // handler for when dragging stops; the "drop" event
                    stop: _.bind(this._onDragStop, this),
                    // handler for when dragging an item into a group
                    over: _.bind(this._onGroupDragTriggerOver, this),
                    // handler for when dragging an item out of a group
                    out: _.bind(this._onGroupDragTriggerOut, this),
                    // the cursor to use when dragging
                    cursor: 'move'
                });
            }, this);
        }

        //wrap in container div for scrolling
//        if (!this.$el.parent().hasClass('flex-list-view-content')) {
//            cssClasses = 'flex-list-view-content';
//            if (this.isCreateView) {
//                cssClasses += ' create-view';
//            }
//            this.$el.wrap(
//                    '<div class="' + cssClasses + '"></div>'
//                    );
//            this.$el.parent().wrap(
//                    '<div class="flex-list-view left-actions quote-data-table-scrollable"></div>'
//                    );
//        }
    },

    _onDragStart: function (evt, ui) {
        // console.log('_onDragStart : ', this, evt, ui);
    },

    _onDragStop: function (evt, ui) {
        // console.log('_onDragStop : ', this, evt, ui);
        // set the line number of the rows and save it, because it will be used as it is in printing.
        var lineNumber = 1;
        _.each(this.$('tbody > tr'), function (tr) {
            var name = $(tr).attr('name').split('_');
            var id = name[1];
            this.collection.get(id).set('line_number', lineNumber, {'silent': true});
            this.collection.get(id)._rowIndex = lineNumber;
            lineNumber++;
        }, this);

        // this sort is added to keep the collection sorted, 
        // without that, if user delete the row sorting of collection disturbs.
        this.collection.comparator = function (model) {
            return model._rowIndex;
        };
        this.collection.sort();
        app.events.trigger('setButtonStates');
    },

    _onGroupDragTriggerOver: function (evt, ui) {
        // console.log('_onGroupDragTriggerOver : ', this, evt, ui);
    },

    _onGroupDragTriggerOut: function (evt, ui) {
        // console.log('_onGroupDragTriggerOut : ', this, evt, ui);
    },

    resetSubpanel: function () {
        this.collection.reset();
        // Code added to avoid the first autopopulated line in the subpanel-for-producttemplates-create 
        this._addBeanToList(false);
    },

    /**
     * We have to overwrite this method completely, since there is currently no way to completely disable
     * a field from being displayed
     *
     * @returns {{default: Array, available: Array, visible: Array, options: Array}}
     */
    parseFields: function () {
        var catalog = this._super('parseFields'),
                config = app.metadata.getModule('Forecasts', 'config'),
                isForecastSetup = config.is_setup;

        // if forecast is not setup, we need to make sure that we hide the commit_stage field
        _.each(catalog, function (group, i) {
            if (isForecastSetup) {
                catalog[i] = _.filter(group, function (fieldMeta) {
                    if (fieldMeta.name.indexOf('_case') != -1) {
                        var field = 'show_worksheet_' + fieldMeta.name.replace('_case', '');
                        return (config[field] == 1);
                    }

                    return true;
                });
            } else {
                catalog[i] = _.filter(group, function (fieldMeta) {
                    return (fieldMeta.name != 'commit_stage');
                });
            }
        });

        return catalog;
    }
})
