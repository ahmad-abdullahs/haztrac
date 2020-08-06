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
 * @class View.Views.Base.RecordView
 * @alias SUGAR.App.view.views.BaseRecordView
 * @extends View.View
 */
({
    extendsFrom: 'RecordInDrawerView',
    subpanelData: {},

    initialize: function (options) {
        this._super('initialize', [options]);
        this.subpanelData = {};

        // This code is added to make the record view in edit mode when the vendor_product_svc_descrp_c
        // field is updated in the magnifier popup.
        this.model.on('editClicked', function () {
            this.setButtonStates('edit');
            this.action = 'edit';
            this.toggleEdit(true);
        }, this);

        this.loadCompetitorCostData();
    },

    loadCompetitorCostData: function () {
        var self = this;
        var modelId = self.model.id;
        var obj = {
            viewName: self.name,
            modelId: modelId
        };
        var url = app.api.buildURL("RevenueLineItems", modelId + "/fetch_record_data");
        app.api.call('create', url, obj, {
            success: function (response) {
                self.apiResponseData = response;
                self.subpanelData = response.subpanelData;
                _.each(self.fields, function (field, key) {
                    if (field.name == 'subpanel_competitor_costs') {
                        field._render();
                    }
                });
            }
        });
    },

    render: function () {
        this._super('render');
        if (!_.isUndefined(this.subpanelData['competitor_cost_revenuelineitems'])) {
            _.each(this.fields, function (field, key) {
                if (field.name == 'subpanel_competitor_costs') {
                    field._render();
                }
            });
        }
    },

    /**
     * Don't save the last tab state, It's done application wide.
     * @inheritdoc
     */
    getActiveTab: function (options) {
        return false;
    },
})
