({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    getCustomSaveOptions: function (options) {
        var self = this;
        // make copy of original function we are extending
        var origSuccess = options.success;
        // return extended success function with added alert
        return {
            success: _.bind(function () {
                if (_.isFunction(origSuccess)) {
                    origSuccess.apply(this, arguments);
                }
                var field = self.getField("multi_files", self.model);
                var ajaxParams = {
                    temp: true,
                    iframe: true,
                    deleteIfFails: false,
                    htmlJsonFormat: true
                };
                var parent_id = self.model.get('id');
                if (field.attachmentCollection.models.length > 0) {
                    _.each(field.attachmentCollection.models, function (model, index) {
                        if (model.isnew && typeof model.attributes.uploadfile != "undefined") {
                            // To avoid the empty models to save
                            if (model.get('document_name')) {
                                self.saveAttachments(model, parent_id);
                            }
                        }
                    });
                }
            }, this)
        };
    },

    saveAttachments: function (model, parent_id) {
        var url = 'LR_Lab_Reports/' + parent_id + '/link/lr_lab_reports_mv_attachments';
        app.api.call('create', app.api.buildURL(url), {deleted: false, assigned_user_id: app.user.id}, {
            success: _.bind(function (result) {
                model.set('id', result.related_record.id);
                model.isnew = false;
                model.save();
            }),
            error: _.bind(function (err) {
                console.log(err);
            }, this),
            complete: _.bind(function () {
            }, this),
        });
    },
})
