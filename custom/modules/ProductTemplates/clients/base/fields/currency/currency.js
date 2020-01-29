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
 * @class View.Fields.Base.CurrencyField
 * @alias SUGAR.App.view.fields.BaseCurrencyField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'CurrencyField',
    updateButton: false,

    'events': {
        'click': 'updateCss',
        'click a[name=update_rlis]': 'updateCostInCustomerRLIS',
    },

    initialize: function (options) {
        this._super('initialize', [options]);
        this.updateButton = this.name == 'cost_price';
    },

    _render: function () {
        this._super('_render');

        if (this.view.action == 'list' && this.action == 'edit' && this.name == 'cost_price') {
            this.setMode('list-edit');
        }
    },

    updateCostInCustomerRLIS: function () {
        var self = this,
                preConditionFailed = false;

        if (_.isNull(self.model.get('vendor_part_num'))
                || _.isUndefined(self.model.get('vendor_part_num')) || _.isEmpty(self.model.get('vendor_part_num'))) {
            app.alert.show('message-vendor', {
                level: 'warning',
                messages: "Vendor Part Number is empty.",
                autoClose: true,
            });
            preConditionFailed = true;
        }

        if (_.isNull(self.model.get('cost_price'))
                || _.isUndefined(self.model.get('cost_price')) || _.isEmpty(self.model.get('cost_price'))) {
            app.alert.show('message-cost', {
                level: 'warning',
                messages: "Cost Price is empty.",
                autoClose: true,
            });
            preConditionFailed = true;
        }

        if (preConditionFailed) {
            return;
        }

        this.proceedIfConfirm();
    },

    proceedIfConfirm: function () {
        var self = this;

        app.alert.show('cost-changed', {
            level: 'confirmation',
            messages: "Cost will be changed in all Customer Revenue Line Items having Vendor Part Number "
                    + self.model.get('vendor_part_num')
                    + ". Are you sure you want to proceed?",
            onConfirm: function () {
                // Show Processing alert.
                app.alert.show('update_cost', {level: 'process', title: 'Updating Revenue Line Items Cost'});
                // Make a call to update the RLIS
                app.api.call('read', app.api.buildURL('ProductTemplates/' + self.model.get('vendor_part_num')
                        + '/' + self.model.get('cost_price') + '/updateRLIsCost'), {}, {
                    success: function (data) {
                        // Dismiss the alert.
                        app.alert.dismiss('update_cost');
                        app.alert.show('update_cost_success', {
                            level: 'success',
                            autoClose: true,
                            messages: data,
                        });
                    },
                    error: function (e) {
                        throw e;
                    }
                });
            },
            onCancel: function () {

            }
        });
    },
})
