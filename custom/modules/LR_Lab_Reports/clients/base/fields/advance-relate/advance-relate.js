/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 *
 * @class View.Fields.Base.RelateField
 * @alias SUGAR.App.view.fields.BaseRelateField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'RelateField',
    linked: false,
    iconVisibility: false,

    initialize: function (options) {
        this.linked = false;
        this.iconVisibility = false;
        this.events = _.extend({}, this.events, {
            'click a[name=advance-relate-unlink]': 'needToLinkToAccountsPanel',
            'click a[name=advance-relate-link]': 'unlinkFromAccountsPanel',
        });
        this._super("initialize", [options]);
    },

    _render: function () {
        var fieldIdName = this.fieldDefs.id_name;
        if (!_.isEmpty(fieldIdName)) {
            var id = this.model.get(fieldIdName);
            if (!_.isEmpty(id)) {
                this.iconVisibility = true;
            }

            if (!_.isUndefined(this.view.labReportCustomerInfo))
                if (!_.isEmpty(this.view.labReportCustomerInfo[id])) {
                    // if (this.view.labReportCustomerInfo[id].id == this.model.get(id))
                    this.linked = true;
                }
        }
        this._super("_render");
    },

    unlinkFromAccountsPanel: function (ele) {
        var accountId = this.model.get('id'), type = 'unlink', labReportId = null;
        var fieldIdName = this.fieldDefs.id_name;
        if (!_.isEmpty(fieldIdName)) {
            labReportId = this.model.get(fieldIdName);
        }
        this.relationToAccount(accountId, labReportId, type);

    },

    needToLinkToAccountsPanel: function (ele) {
        var accountId = this.model.get('id'), type = 'link', labReportId = null;
        var fieldIdName = this.fieldDefs.id_name;
        if (!_.isEmpty(fieldIdName)) {
            labReportId = this.model.get(fieldIdName);
        }
        this.relationToAccount(accountId, labReportId, type);
    },

    relationToAccount: function (accountId, labReportId, type) {
        var self = this;
        var link = "lr_lab_reports_accounts";
        var message = type == 'link' ? 'Linking To Account' : 'Unlinking From Account';

        app.alert.show('relationToAccount', {
            level: 'process',
            title: message,
            autoClose: false
        });

        var url = app.api.buildURL('relationToAccount', link + '/' + accountId + '/' + labReportId + '/' + type);
        app.api.call('update', url, {}, {
            success: function (response) {
                app.alert.dismiss('relationToAccount');
                self.linked = (type == 'link') ? true : false;
                self.render();
            },
            error: function (response) {
            },
        });
    },
})
