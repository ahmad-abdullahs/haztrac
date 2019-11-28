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
                if (!_.isUndefined(viewDetails)) {
                    app.controller.context.trigger(viewDetails.cid + ':productCatalogDashlet:add', data);
                }

                if (data.is_bundle_product_c == 'parent') {
                    // var productTemplates = App.data.createBean('ProductTemplates', {id: clickedTarget.id});
                    // productTemplates.fetch();
                    var rliRelatedRLIColl = rliModel.getRelatedCollection('revenuelineitems_revenuelineitems_1');
                    rliRelatedRLIColl = rliRelatedRLIColl.fetch({
                        relate: true,
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
                                    model.attributes.product_template_id = '';
                                    model.attributes.product_template_name = '';
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

                // copy Template's id and name to where the QLI expects them
                data.product_template_id = data.id;
                data.product_template_name = data.name;

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