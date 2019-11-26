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
({
    // This list is used on the Sales and Service create view for RLI bundle creation...
    // @see screenshots 2.png

    // This file is used for sales_and_services, Opportunities and Accounts.
    // So you may found checks specific to module for few functionalities.
    extendsFrom: 'RevenueLineItemsCustomSubpanelListCreateView',

    initialize: function (options) {
        this._super('initialize', [options]);

        // undo flex-list's hardcoding and re-hardcode to use the subpanel-list-create.hbs
        this.template = app.template.getView(this.name, 'RevenueLineItems');
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
        this.collection.sort();
    },

    _onGroupDragTriggerOver: function (evt, ui) {
        // console.log('_onGroupDragTriggerOver : ', this, evt, ui);
    },

    _onGroupDragTriggerOut: function (evt, ui) {
        // console.log('_onGroupDragTriggerOut : ', this, evt, ui);
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
        var parentModel = this.context.parent.get('model');
        var parentModule = this.context.parent.get('module');

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
                            userCurrency.currency_rate);
                }
            }, this);
        } else if (!skipCurrency) {
            userCurrencyId = userCurrency.currency_id || app.currency.getBaseCurrencyId();
            attrs.currency_id = userCurrencyId;
            attrs.base_rate = app.metadata.getCurrency(userCurrencyId).conversion_rate;
        }

        if (!_.isEmpty(attrs)) {
            // we need to set the defaults
            bean.setDefault(attrs);
            // just to make sure that any attributes that were already set, are set again.
            bean.set(attrs);
        }

//        if (bean) {
//            if (bean.get('quantity') == 0) {
//                bean.set('quantity', '');
//            }
//        }

        bean.on('change:discount_price', function (model) {
            model.set({
                'discount_usdollar': model.get('discount_price'),
                'likely_case': model.get('discount_price'),
                'worst_case': model.get('discount_price'),
                'best_case': model.get('discount_price'),
                'cost_price': model.get('discount_price'),
                'cost_usdollar': model.get('discount_price'),
                'list_price': model.get('discount_price'),
                'list_usdollar': model.get('discount_price'),
                'product_template_id': '',
                'product_template_name': '',
            }, {'silent': true});
        }, this);

        // Only keep one checkbox checked at a time... and unset all the others
        bean.on('change:primary_rli', function (model) {
            if (model.get('primary_rli')) {
                _.each(this.collection.models, function (_model) {
                    if (_model.get('primary_rli') && _model.get('id') != model.get('id')) {
                        _model.set('primary_rli', false);
                    } else if (_model.get('primary_rli') && _model.get('id') == model.get('id')) {
                        // Set the sales and service name as primary selected RLI
                        if (parentModule == 'sales_and_services') {
                            parentModel.set('name', _model.get('name'));
                            parentModel.set('mft_part_num', _model.get('mft_part_num'));
                        }
                        if (this.context.parent.get('module') == 'sales_and_services') {
                            this.setTSDFFacility(_model, parentModel);
                        }
                    }
                }, this);
            }
        }, this);

        // if RLI name is changed and it is the primary rli update the sales and service name as well...
        bean.on('change:name', function (model) {
            if (model.get('primary_rli')) {
                if (parentModule == 'sales_and_services') {
                    parentModel.set('name', model.get('name'));
                    parentModel.set('mft_part_num', model.get('mft_part_num'));
                }
                if (this.context.parent.get('module') == 'sales_and_services') {
                    this.setTSDFFacility(model, parentModel);
                }
            }
        }, this);
        return bean;
    },

    /*
     * If the selected RLI is Hazardous Material (Y) or State Regulated (Y)
     then populate the vendor from this line into the sales and service `Ship To / TSDF` field.
     */
    setTSDFFacility: function (model, parentModel) {
        if (model.get('shipping_hazardous_materia_c') || model.get('state_regulated_c')) {
            parentModel.set({
                'account_id1_c': model.get('v_vendors_id_c'),
                'destination_ship_to_c': model.get('product_vendor_c')
            });
        } else {
            parentModel.set({
                'account_id1_c': '',
                'destination_ship_to_c': ''
            });
        }
    },

    checkButtons: function () {
        this._super('checkButtons');
        if (this.disposed) {
            return;
        }

        var facilitiesInfo = {};
        _.each(this.collection.models, function (model, key) {
            this.warnIfDifferentFacilities(model, key, facilitiesInfo);
        }, this);
    },

    warnIfDifferentFacilities: function (model, key, facilitiesInfo, checkValidation) {
        // Put RLI id and facility id in an object
        if (!_.isEmpty(model.attributes.v_vendors_id_c) && model.attributes.is_bundle_product_c != 'parent' && model.attributes.manifest_required_c) {
            facilitiesInfo[model.attributes.id] = model.attributes.v_vendors_id_c;
        }

        // If all the RLIs has been looped through and this is the last RLI
        // get the facilities ids and make then unique to check do we 
        // have multiple facilities or not
        // If we have multiple group them and color them on the view.
        // each facility has its own color, this way we will group multiple 
        // rlis with same facility to a common color.
        if (key + 1 == this.collection.models.length) {
            if (_.unique(_.compact(_.values(facilitiesInfo))).length > 1) {
                app.alert.dismiss('multifacility-warning');
                app.alert.show('multifacility-warning', {
                    level: 'warning',
                    messages: 'You have selected multiple Items which have different Ship To / TSDF',
                    closeable: true,
                    autoClose: true,
                    autoCloseDelay: 12000,
                });

                if (checkValidation) {
                    return false;
                }

                var facilitiesInfoGroupBy = {};
                _.each(facilitiesInfo, function (val, key) {
                    if (_.isUndefined(facilitiesInfoGroupBy[val]) || _.isNull(facilitiesInfoGroupBy[val])) {
                        facilitiesInfoGroupBy[val] = [];
                    }
                    facilitiesInfoGroupBy[val].push(key)
                }, this);

                var colorsList = ['#0679c8', '#6d17e5', '#54cb14', '#ffb600', '#e61718'];
                _.each(facilitiesInfoGroupBy, function (_val) {
                    var color = colorsList.pop();
                    _.each(_val, function (val) {
                        $('tr[name=RevenueLineItems_' + val + ']').attr('style', 'border:groove ' + color + ';border-width: thick;');
                    }, this);
                }, this);
            }
        }
        return true;
    },

    checkTSDFValidity: function () {
        var isValidTSDF = true;
        var facilitiesInfo = {};
        _.each(this.collection.models, function (model, key) {
            if (!this.warnIfDifferentFacilities(model, key, facilitiesInfo, true)) {
                isValidTSDF = false;
            }
        }, this);
        return isValidTSDF;
    },

    validateModels: function (callback, fromCreateView) {
        fromCreateView = fromCreateView || false;

        var returnCt = 0;
        this.hasValidModels = true;

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
                        callback(!this.hasValidModels || !this.checkTSDFValidity());
                    } else {
                        // this view wants if the models are valid or not
                        callback(this.hasValidModels);
                    }
                }
            }, this));
        }, this);
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
