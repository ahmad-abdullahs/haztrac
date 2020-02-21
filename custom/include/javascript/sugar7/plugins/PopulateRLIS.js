(function (app) {
    app.events.on('app:init', function () {
        app.plugins.register('PopulateRLIS', ['view', 'layout', 'field'], {
            prepopulateData: function (thisOfCall, rliModel, data) {
                var _self = this;
                this._massageDataBeforeSendingToRecord(data);

                if (data.is_bundle_product_c == 'parent') {
                    data.date_closed = (this.getExpectedCloseDate()).substring(0, 10);
                }

                var viewDetails = thisOfCall.closestComponent('record') ?
                        thisOfCall.closestComponent('record') :
                        thisOfCall.closestComponent('create');
                // need to trigger on app.controller.context because of contexts changing between
                // the PCDashlet, and Opps create being in a Drawer, or as its own standalone page
                // app.controller.context is the only consistent context to use
                if (thisOfCall.context.parent.get('copyFeature')) {
                    if (data.is_bundle_product_c != 'parent' && !_.isUndefined(viewDetails)) {
                        // Unset the Manifest from revenuelineitem at time of copy.
                        data.ht_manifest_revenuelineitems_1ht_manifest_ida = '';
                        data.ht_manifest_revenuelineitems_1_name = '';
                        app.controller.context.trigger(viewDetails.cid + ':productCatalogDashlet:add', data);
                    }
                    // On copy of S&S set the status to Draft.
                    var pModel = thisOfCall.context.parent.get('model');
                    pModel.set('status_c', 'Draft');
                } else {
                    if (!_.isUndefined(viewDetails)) {
                        app.controller.context.trigger(viewDetails.cid + ':productCatalogDashlet:add', data);
                    }
                }

                if (data.is_bundle_product_c == 'parent') {
                    // var productTemplates = App.data.createBean('ProductTemplates', {id: clickedTarget.id});
                    // productTemplates.fetch();
                    var rliRelatedRLIColl = rliModel.getRelatedCollection('revenuelineitems_revenuelineitems_1');
                    rliRelatedRLIColl = rliRelatedRLIColl.fetch({
                        relate: true,
                        limit: -1,
                        // Fetched in descending order because when the items are added in the subpanel-for-rli-create
                        // they stacked in the view over each other. in order to keep the same line order we fetch in desc order.
                        params: {
                            order_by: "line_number:asc",
                        },
                        success: function (coll) {
                            if (thisOfCall.context.parent.get('copyFeature')) {
                                // Unset the Manifest from revenuelineitem at time of copy.
                                data.ht_manifest_revenuelineitems_1ht_manifest_ida = '';
                                data.ht_manifest_revenuelineitems_1_name = '';
                                app.controller.context.trigger(viewDetails.cid + ':productCatalogDashlet:add', data);
                            }
                            _.each(coll.models, function (model) {
                                _self._massageDataBeforeSendingToRecord(model.attributes);

                                var viewDetails = _self.closestComponent('record') ?
                                        _self.closestComponent('record') :
                                        _self.closestComponent('create');
                                // need to trigger on app.controller.context because of contexts changing between
                                // the PCDashlet, and Opps create being in a Drawer, or as its own standalone page
                                // app.controller.context is the only consistent context to use
                                if (!_.isUndefined(viewDetails)) {
                                    // To add the relationship between the revenuelineitems
                                    model.attributes.revenuelineitems_revenuelineitems_1revenuelineitems_ida = data.id;
//                                    model.attributes.product_template_id = '';
//                                    model.attributes.product_template_name = '';
                                    if (thisOfCall.context.parent.get('copyFeature')) {
                                        // Unset the Manifest from revenuelineitem at time of copy.
                                        model.attributes.ht_manifest_revenuelineitems_1ht_manifest_ida = '';
                                        model.attributes.ht_manifest_revenuelineitems_1_name = '';
                                    }
                                    app.controller.context.trigger(viewDetails.cid + ':productCatalogDashlet:add', model.attributes);
                                }
                            })
                        }
                    })
                }
            },

            _sendItemToRecord: function (thisOfCall, rliModel, data) {
                var _self = this;
                this._massageDataBeforeSendingToRecord(data);

                if (data.is_bundle_product_c == 'parent') {
                    data.date_closed = (this.getExpectedCloseDate()).substring(0, 10);
                }

                var viewDetails = thisOfCall.closestComponent('record') ?
                        thisOfCall.closestComponent('record') :
                        thisOfCall.closestComponent('create');
                // need to trigger on app.controller.context because of contexts changing between
                // the PCDashlet, and Opps create being in a Drawer, or as its own standalone page
                // app.controller.context is the only consistent context to use
                if (!_.isUndefined(viewDetails)) {
                    app.controller.context.trigger('productCatalogDashlet:populate:RLI', data);
                }

                if (data.is_bundle_product_c == 'parent') {
                    // var productTemplates = App.data.createBean('ProductTemplates', {id: clickedTarget.id});
                    // productTemplates.fetch();
                    var rliRelatedRLIColl = rliModel.getRelatedCollection('revenuelineitems_revenuelineitems_1');
                    rliRelatedRLIColl = rliRelatedRLIColl.fetch({
                        relate: true,
                        limit: -1,
                        // Fetched in descending order because when the items are added in the subpanel-for-rli-create
                        // they stacked in the view over each other. in order to keep the same line order we fetch in desc order.
                        params: {
                            order_by: "line_number:desc",
                        },
                        success: function (coll) {
                            _.each(coll.models, function (model) {
                                _self._massageDataBeforeSendingToRecord(model.attributes);

                                var viewDetails = _self.closestComponent('record') ?
                                        _self.closestComponent('record') :
                                        _self.closestComponent('create');
                                // need to trigger on app.controller.context because of contexts changing between
                                // the PCDashlet, and Opps create being in a Drawer, or as its own standalone page
                                // app.controller.context is the only consistent context to use
                                if (!_.isUndefined(viewDetails)) {
                                    // To add the relationship between the revenuelineitems
                                    model.attributes.revenuelineitems_revenuelineitems_1revenuelineitems_ida = data.id;
                                    app.controller.context.trigger(viewDetails.cid + ':productCatalogDashlet:add', model.attributes);
                                }
                            })
                        }
                    })
                }
            },

            _massageDataBeforeSendingToRecord: function (data) {
                data.position = 0;
                data._forcePosition = true;

                // copy Template's id and name from RLI bundle or single RLI.
                data.product_template_id = data.product_template_id;
                data.product_template_name = data.product_template_name;

                // remove ID/etc since we dont want Template ID to be the record id
                delete data.id;
                delete data.status;
                delete data.date_entered;
                delete data.date_modified;
                delete data.pricing_formula;
            },

            setDateTimeFormate: function (value) {
                if (!value) {
                    return value;
                }
                value = app.date(value, app.date.convertFormat(this.getUserDateTimeFormat()), true);
                if (!value.isValid()) {
                    return;
                }
                return value.format();
            },

            /**
             * @param {Function} getUserDateTimeFormat
             * @Description : function to get user date and time format
             */
            getUserDateTimeFormat: function () {
                return app.user.getPreference('datepref') + ' ' + app.user.getPreference('timepref');
            },
            /**
             * @param {Function} _render
             * @Description : This function is override to set default date to next month (same day and time) for start date
             */
            getExpectedCloseDate: function () {
                var today = new Date();
                var value = new Date(new Date(today).setMonth(today.getMonth() + 1));
                return this.setDateTimeFormate(app.date(value).format(app.date.convertFormat(this.getUserDateTimeFormat())));
            },
        });
    });
})(SUGAR.App);