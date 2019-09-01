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
 * @class View.Views.Base.MassLinkView
 * @alias SUGAR.App.view.views.BaseMassLinkView
 * @extends View.Views.Base.MassupdateView
 */
({
    extendsFrom: 'MassLinkView',
    massUpdateViewName: 'masslink-progress',
    _defaultLinkSettings: {
        mass_link_chunk_size: 20
    },

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    /**
     * Overrides parent. Sets mass link related events
     */
    delegateListFireEvents: function () {
        this.layout.on('list:masslink:fire', _.bind(this.beginMassLink, this));
    },

// Only in case of Sales and Service, Add the (Account ID) field in that 
// to link the RLIs with S&S and Account 
// /var/www/html/haztrac/clients/base/api/RelateRecordApi.php (Need to customize this API)
    /*linkData = {
     link_name: link,
     ids: _.union(_.pluck(this.chunks, 'id'), relatedIds)
     },*/




    /**
     * Link multiple records in chunks
     */
    beginMassLink: function (options) {
        var self = this;
        var parentModel = this.context.get('recParentModel'),
                link = this.context.get('recLink'),
                massLink = this.getMassUpdateModel(this.module),
                progressView = this.getProgressView();

        massLink.setChunkSize(this._settings.mass_link_chunk_size);

        //Extend existing model with a link function
        massLink = _.extend({}, massLink, {
            maxLinkAllowAttempt: options && options.maxLinkAllowAttempt || this.maxAllowAttempt,
            link: function (options) {
                //Slice a new chunk of models from the mass collection
                this.updateChunk();
                var relatedIds = [];
                _.each(this.chunks, function (model) {
                    if (!_.isEmpty(model.get('revenuelineitems_revenuelineitems_1').records)) {
                        _.each(model.get('revenuelineitems_revenuelineitems_1').records, function (relatedRLI) {
                            if (relatedRLI.id) {
                                relatedIds.push({
                                    'id': relatedRLI.id,
                                    // This OR condition is added to populate the account_id in both the cases.
                                    // 1. When RevenueLineItems records is selected in selection drawer from sales and service record view.
                                    // 2. When RevenueLineItems records is selected in selection drawer from RevenueLineItems record view.
                                    'account_id': parentModel.get('accounts_sales_and_services_1accounts_ida') || parentModel.get('account_id'),
                                });
                            }
                        });
                    }
                });

                _.each(_.pluck(this.chunks, 'id'), function (id) {
                    relatedIds.push({
                        'id': id,
                        'account_id': parentModel.get('accounts_sales_and_services_1accounts_ida') || parentModel.get('account_id'),
                    });
                });

                var model = this,
                        apiMethod = 'create',
                        // ++ 
                        // Custom API to hit copy_and_link...
                        linkCmd = self.context.get('copyLinkRecords') ? 'copy_and_link' : 'link',
                        parentData = {
                            id: parentModel.id
                        },
                        url = app.api.buildURL(parentModel.module, linkCmd, parentData),
                        linkData = {
                            link_name: link,
                            ids: relatedIds,
                            copyLinkRecords: self.context.get('copyLinkRecords') ? true : false,
                        },
                        callbacks = {
                            success: function (data, response) {
                                model.attempt = 0;
                                model.updateProgress();
                                if (model.length === 0) {
                                    model.trigger('massupdate:end');
                                    if (_.isFunction(options.success)) {
                                        options.success(model, data, response);
                                    }
                                } else {
                                    model.trigger('massupdate:always');
                                    model.link(options);
                                }
                            },
                            error: function () {
                                model.attempt++;
                                model.trigger('massupdate:fail');
                                if (model.attempt <= this.maxLinkAllowAttempt) {
                                    model.link(options);
                                } else {
                                    app.alert.show('error_while_mass_link', {
                                        level: 'error',
                                        title: app.lang.get('ERR_INTERNAL_ERR_MSG'),
                                        messages: ['ERR_HTTP_500_TEXT_LINE1', 'ERR_HTTP_500_TEXT_LINE2']
                                    });
                                }
                            }
                        };
                app.api.call(apiMethod, url, linkData, callbacks);
            }
        });

        progressView.initCollection(massLink);
        massLink.link({
            success: _.bind(function (model, data, response) {
                this.layout.trigger('list:masslink:complete', model, data, response);
            }, this)
        });
    },
})
