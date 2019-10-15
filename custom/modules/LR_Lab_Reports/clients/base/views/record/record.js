({
    extendsFrom: 'RecordView',
    labReportCustomerInfo: {},

    initialize: function (options) {
        this.labReportCustomerInfo = {};
        this._super('initialize', [options]);
    },

    loadData: function (options) {
        this._super('loadData', [options]);
        this.labReportCustomerInfo = {};
        this.model.on('data:sync:complete', function () {
            var accountIds = [];

            _.each(['accounts_lr_lab_reports_1accounts_ida',
                'accounts_lr_lab_reports_2accounts_ida',
                'accounts_lr_lab_reports_3accounts_ida'], function (name) {
                accountIds.push(this.model.get(name));
            }, this);

            _.each(_.uniq(accountIds), function (accountId) {
                if (!_.isEmpty(accountId)) {
                    this.checkIfLabReportIsLinkedOrNot(accountId);
                }
            }, this);
        }, this);
    },

    checkIfLabReportIsLinkedOrNot: function (accountId) {
        this.labReportCustomerInfo[accountId] = {};
        var self = this;

        var url = app.api.buildURL('Accounts', 'lr_lab_reports_accounts', {
            id: accountId,
            link: true,
        }, {
            limit: '-1',
        });
        app.api.call('read', url, null, {
            success: _.bind(function (response) {
                _.each(response.records, function (record) {
                    if (record.id == self.model.get('id')) {
                        self.labReportCustomerInfo[accountId] = {
                            id: record.id,
                        };
                    }
                });
                self.render();
            })
        });
    },

    duplicateClicked: function () {
        var self = this,
                prefill = app.data.createBean(this.model.module);

        prefill.copy(this.model);
        this._copyNestedCollections(this.model, prefill);
        self.model.trigger('duplicate:before', prefill);
        prefill.unset('id');
        prefill.unset('sample_id_number_c');
        app.drawer.open({
            layout: 'create',
            context: {
                create: true,
                model: prefill,
                copiedFromModelId: this.model.get('id')
            }
        }, function (context, newModel) {
            if (newModel && newModel.id) {
                app.router.navigate(self.model.module + '/' + newModel.id, {trigger: true});
            }
        });

        prefill.trigger('duplicate:field', self.model);
    },
})