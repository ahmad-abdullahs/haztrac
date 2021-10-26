({
    extendsFrom: 'ContactsRecordView',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    _saveModel: function () {
        var self = this;
        var options,
                successCallback = _.bind(function () {
                    // Loop through the visible subpanels and have them sync. This is to update any related
                    // fields to the record that may have been changed on the server on save.
                    _.each(this.context.children, function (child) {
                        if (child.get('isSubpanel') && !child.get('hidden')) {
                            if (child.get('collapsed')) {
                                child.resetLoadFlag({recursive: false});
                            } else {
                                child.reloadData({recursive: false});
                            }
                        }
                    });
                    if (this.createMode) {
                        app.navigate(this.context, this.model);
                    } else if (!this.disposed && !app.acl.hasAccessToModel('edit', this.model)) {
                        //re-render the view if the user does not have edit access after save.
                        this.render();
                    }

//                    if (self.refreshPage == true) {
//                        app.router.refresh();
//                    }
                }, this);

        //Call editable to turn off key and mouse events before fields are disposed (SP-1873)
        this.turnOffEvents(this.fields);

        options = {
            showAlerts: true,
            success: successCallback,
            error: _.bind(function (model, error) {
                if (error.status === 412 && !error.request.metadataRetry) {
                    this.handleMetadataSyncError(error);
                } else if (error.status === 409) {
                    app.utils.resolve409Conflict(error, this.model, _.bind(function (model, isDatabaseData) {
                        if (model) {
                            if (isDatabaseData) {
                                successCallback();
                            } else {
                                this._saveModel();
                            }
                        }
                    }, this));
                } else if (error.status === 403 || error.status === 404) {
                    this.alerts.showNoAccessError.call(this);
                } else {
                    this.editClicked();
                }
            }, this),
            lastModified: this.model.get('date_modified'),
            viewed: true
        };

        // ensure view and field are sent as params so collection-type fields come back in the response to PUT requests
        // (they're not sent unless specifically requested)
        options.params = options.params || {};
        if (this.context.has('dataView') && _.isString(this.context.get('dataView'))) {
            options.params.view = this.context.get('dataView');
        }

        if (this.context.has('fields')) {
            options.params.fields = this.context.get('fields').join(',');
        }

        options = _.extend({}, options, this.getCustomSaveOptions(options));

        this.model.save({}, options);
    },

})
