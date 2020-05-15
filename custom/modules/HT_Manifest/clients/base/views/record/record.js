({
    extendsFrom: 'RecordView',
    fieldTag: 'input[type=file]',

    initialize: function (options) {
        var self = this;
        this._super('initialize', [options]);
        this.alerts = _.extend({}, this.alerts, {
            showInvalidModel: function () {
                var message = 'ERR_RESOLVE_ERRORS';
                if (!self instanceof app.view.View) {
                    app.logger.error('This method should be invoked by Function.prototype.call(), passing in as argument' +
                            'an instance of this view.');
                    return;
                }

                var completeDateField = self.getField('complete_date_c');
                if (!_.isEmpty(completeDateField._errors)) {
                    if (_.has(completeDateField._errors, 'isGreaterThan10thDay'))
                        message = "Please put the explanation in comments for completion after 10th Day: "
                                + moment.utc(self.model.get('manifest_tenth_day_date')).format('MM/DD/YYYY') + ".";
                }

                var name = 'invalid-data';
                self._viewAlerts.push(name);
                app.alert.show(name, {
                    level: 'error',
                    messages: message,
                });
            },
            showNoAccessError: function () {
                if (!self instanceof app.view.View) {
                    app.logger.error('This method should be invoked by Function.prototype.call(), passing in as argument' +
                            'an instance of this view.');
                    return;
                }
                // dismiss the default error
                app.alert.dismiss('data:sync:error');
                // display no access error
                app.alert.show('server-error', {
                    level: 'error',
                    messages: 'ERR_HTTP_404_TEXT_LINE1'
                });
                // discard any changes before redirect
                self.handleCancel();
                // redirect to list view
                var route = app.router.buildRoute(self.module);
                app.router.navigate(route, {trigger: true});
            }
        });

        this.model.off('error:validation');
        this.model.on("error:validation", function () {
            this.alerts.showInvalidModel();
        }, this);

        //add validation tasks
        this.model.addValidationTask('add_comment_if_completion_date_is_after_10th_day', _.bind(this.addCommentOnLateCompletion, this));
    },

    addCommentOnLateCompletion: function (fields, errors, callback) {
        // Check if user puts the date for the first time and it was empty before.
        if (!_.isEmpty(this.model.get('complete_date_c'))) {
            if (_.isEmpty(this.model._syncedAttributes.complete_date_c)) {
                var complete_date_c = Date.parse(this.model.get('complete_date_c'));
                var manifest_tenth_day_date = Date.parse(this.model.get('manifest_tenth_day_date'));
                if (complete_date_c > manifest_tenth_day_date) {
                    errors['complete_date_c'] = errors['complete_date_c'] || {};
                    errors['complete_date_c'].isGreaterThan10thDay = true;

                    // This needs to set in here otherwise you will not find this error in showInvalidModel function.
                    var _field = this.getField('complete_date_c');
                    _field._errors = errors['complete_date_c'];
                    this.fields[_field.sfId]._errors = errors['complete_date_c'];

                    this.setDefaultPlaceHolder(true);
                } else {
                    delete errors['complete_date_c'];
                }
            } else {
                delete errors['complete_date_c'];
            }
        } else {
            delete errors['complete_date_c'];
        }

        callback(null, fields, errors);
    },

    setDefaultPlaceHolder: function (flag) {
        var keysList = [
            8 /*backspace*/,
            46/*delete*/,
            65/*CTRL+A*/,
            37, 38, 39, 40/*SHFT+ left, right, up, down arrows*/,
        ];
        var text = "Explanation for late completion:";
        if (flag) {
            $('[name=commentContent]').text(text);
            $('[name=commentContent]').on('change keydown', function (e) {
                if (($('[name=commentContent]').text() == text) && _.contains(keysList, e.which)) {
                    e.preventDefault();
                }
            });
        } else {
            $('[name=commentContent]').off('change keydown');
        }
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
        var url = 'HT_Manifest/' + parent_id + '/link/ht_manifest_mv_attachments';

        var action = 'create';
        var obj = {
            deleted: false,
            assigned_user_id: app.user.id,
            uploadfile_guid: model.get('uploadfile_guid'),
            temp_file_ext: model.get('temp_file_ext'),
        };

        if (!model.isnew) {
            url = 'HT_Manifest/' + parent_id + '/link/ht_manifest_mv_attachments/' + model.get('id');
            action = 'update';
            obj = {
                deleted: false,
                id: model.get('id'),
                category_id: model.get('category_id'),
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
})