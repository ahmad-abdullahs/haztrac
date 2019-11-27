/**
 * @class View.Views.Base.Accounts.CreateView
 * @alias SUGAR.App.view.views.AccountsCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        this._super('initialize', [options]);
        app.controller.context.on('productCatalogDashlet:populate:RLI', this.onPopulateFromProductCatalog, this);
    },

    validateModelWaterfall: function (callback) {
        var self = this;
        this.model.doValidate(this.getFields(this.module), function (isValid) {
            if (self.context.parent.get('model').module == 'sales_and_services') {
                callback(!isValid || !self.checkTSDFValidity());
            } else {
                callback(!isValid);
            }
        });
    },

    checkTSDFValidity: function () {
        var isValidTSDF = true;
        var facilitiesInfo = {};

        // Subpanel RLIs
        _.each(this.context.parent.get('model')._relatedCollections.sales_and_services_revenuelineitems_1.models, function (model, key) {
            this.warnIfDifferentFacilities(model, facilitiesInfo);
        }, this);

        // The RLI which we are creating  right now in the create drawer.
        if (!this.warnIfDifferentFacilities(this.model, facilitiesInfo, true, true)) {
            isValidTSDF = false;
        }

        return isValidTSDF;
    },

    warnIfDifferentFacilities: function (model, facilitiesInfo, checkValidation, evaluateIt) {
        // Put RLI id and facility id in an object
        if (!_.isEmpty(model.attributes.v_vendors_id_c) && model.attributes.is_bundle_product_c != 'parent' && model.attributes.manifest_required_c) {
            facilitiesInfo[model.attributes.id] = model.attributes.v_vendors_id_c;
        }

        // If all the RLIs has been looped through and this is the last RLI
        // get the facilities ids and make then unique to check do we 
        // have multiple facilities or not
        if (evaluateIt) {
            if (_.unique(_.compact(_.values(facilitiesInfo))).length > 1) {
                app.alert.dismiss('multifacility-warning');
                app.alert.show('multifacility-warning', {
                    level: 'warning',
                    messages: 'You can\'t create an items which has different Ship To / TSDF, Please create a new Sales and Service for this Item.',
                    closeable: true,
                    autoClose: true,
                    autoCloseDelay: 12000,
                });

                if (checkValidation) {
                    return false;
                }
            }
        }
        return true;
    },

    onPopulateFromProductCatalog: function (data) {
        data = data || {};
        data.likely_case = data.discount_price;
        data.best_case = data.discount_price;
        data.worst_case = data.discount_price;
        data.assigned_user_id = app.user.get('id');
        data.assigned_user_name = app.user.get('name');

        var bean;

        bean = app.data.createBean('RevenueLineItems');
        bean.set(data);
        bean._module = bean.attributes._module = 'RevenueLineItems';
        delete bean.attributes.id;
        delete bean.id;

        // check the parent record to see if an assigned user ID/name has been set
        if (this.context && this.context.has('model')) {
            var rliModel = this.context.get('model'),
                    userId = rliModel.get('assigned_user_id'),
                    userName = rliModel.get('assigned_user_name');

            if (userId) {
                bean.setDefault('assigned_user_id', userId);
            }

            if (userName) {
                bean.setDefault('assigned_user_name', userName);
            }

            rliModel.set(bean.attributes);
        }
    },
})