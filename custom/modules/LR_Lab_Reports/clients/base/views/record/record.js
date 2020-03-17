({
    extendsFrom: 'RecordView',
    fieldTag: 'input[type=file]',

    labReportCustomerInfo: {},

    initialize: function (options) {
        this.labReportCustomerInfo = {};
        this._super('initialize', [options]);
    },

    handleSave: function (e) {
        var parent_id = this.model.get('id');
        var field = this.getField("multi_files", this.model);

        if (field.attachmentCollection.models.length) {
            _.each(field.attachmentCollection.models, function (model, index) {
                // To avoid the empty models to save
                if (model.get('document_name')) {
                    this.saveAttachments(model, parent_id);
                }
            }, this);
        }

        this._super('handleSave');
    },

    saveAttachments: function (model, parent_id) {
        var self = this;
        var url = 'LR_Lab_Reports/' + parent_id + '/link/lr_lab_reports_mv_attachments';

        var action = 'create';
        var obj = {
            deleted: false,
            assigned_user_id: app.user.id,
            uploadfile_guid: model.get('uploadfile_guid'),
            temp_file_ext: model.get('temp_file_ext'),
        };

        if (!model.isnew) {
            url = 'LR_Lab_Reports/' + parent_id + '/link/lr_lab_reports_mv_attachments/' + model.get('id');
            action = 'update';
            obj = {
                deleted: false,
                id: model.get('id'),
                category_id: model.get('category_id'),
                lab_ref_number: model.get('lab_ref_number'),
                assigned_user_id: app.user.id,
            };
        }

        app.api.call(action, app.api.buildURL(url), obj, {
            success: _.bind(function (result) {
                model.set('id', result.related_record.id);
                model.isnew = false;
                model.save(null, {
                    success: function () {
                    },
                });
            }),
            error: _.bind(function (err) {
                console.log(err);
            }, this),
            complete: _.bind(function () {
            }, this)
        });
    },

    /*cancelClicked: function () {
     this._super('cancelClicked');
     var field = this.getField("multi_files", this.model);
     field.render();
     },*/

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

        var url = app.api.buildURL('Accounts', 'lr_lab_reports_accounts', {id: accountId, link: true}, {
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