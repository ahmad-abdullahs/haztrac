({
    extendsFrom: 'BaseField',
    isDuplicate: false,

    initialize: function (options) {
        this._super('initialize', [options]);
        // Add validation tasks
        this.model.addValidationTask('checkIfDuplicateManifestNumber', _.bind(this._doValidateDuplicateManifestNumber, this));
    },

    bindDataChange: function () {
        this._super('bindDataChange');

        this.model.on('change:manifest_no_actual_c', _.bind(this.isDuplicateManifestNumber, this));
    },

    isDuplicateManifestNumber: function (model, value) {
        var self = this;
        if (value) {
            // Make a call to update the RLIS
            app.api.call('read', app.api.buildURL('HT_Manifest/' + value + '/isDuplicateManifestNumber'), {}, {
                success: function (data) {
                    self.isDuplicate = false;
                    if (data) {
                        if (!self.model.get("id")) {
                            // This is create view
                            // Means the Manifest Number already exist
                            if (data.length > 0) {
                                self.isDuplicate = true;
                            }
                        } else {
                            // This is record, list... view
                            // Means the Manifest Number already exist
                            if (data.length > 1) {
                                self.isDuplicate = true;
                            } else if (data.length == 1) {
                                if (data[0] != self.model.get("id")) {
                                    self.isDuplicate = true;
                                }
                            }
                        }
                    }
                },
                error: function (e) {
                    throw e;
                }
            });
        }
    },

    _doValidateDuplicateManifestNumber: function (fields, errors, callback) {
        // Check if user puts the date for the first time and it was empty before.
        if (!_.isEmpty(this.model.get('manifest_no_actual_c'))) {
            if (this.isDuplicate) {
                errors['manifest_no_actual_c'] = errors['manifest_no_actual_c'] || {};
                errors['manifest_no_actual_c'].error = true;
                app.alert.show('duplicate_manifest_number', {
                    level: 'error',
                    autoClose: true,
                    messages: "Manifest Number should not be duplicate.",
                });
            } else {
                delete errors['manifest_no_actual_c'];
            }
        } else {
            delete errors['manifest_no_actual_c'];
        }

        callback(null, fields, errors);
    },
})