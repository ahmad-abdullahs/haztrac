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
({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super('initialize', [options]);
        // Add listener for custom button
        this.context.on('button:close_drawer_button:click', this.closeDrawer, this);
    },

    // This function is called after all the validations on the model are done. 
    handleSave: function () {
        if (this.disposed) {
            return;
        }

        this.makeCopyAndSaveModel();
    },

    /*
     * Steps to perform in the function:
     * 
     // 1- First make the copy of the model, save it 
     // 2- Link it to the current record 
     // 3- Renew the record information.
     */
    makeCopyAndSaveModel: function () {
        var self = this;
        var newData = {
            'id_number_c': self.model.get('id_number_c'),
            'issuing_date_c': self.model.get('issuing_date_c'),
            'exp_date': self.model.get('exp_date'),
            'renewal_date_c': self.model.get('renewal_date_c'),
            'file_mime_type': self.model.get('file_mime_type'),
            'uploadfile': self.model.get('uploadfile'),
        }

        app.alert.show('renewing_license', {
            level: 'process',
            title: '<b>Renewing License<b>',
            autoClose: false,
        });

//        var permitAndLicense = app.data.createBean(this.module, {id: this.model.get('id')});
//        permitAndLicense.fetch({
//            'showAlerts': false,
//            'success': _.bind(function (originalModel) {
        var originalModel = self.context.get('parentOriginalModel');
        // Make the originalModel copy
        var copyModel = app.data.createBean(this.module);
        copyModel.copy(originalModel);
        copyModel.unset('id');
        // Unset the account id because it's ono-to-one relationship
        // If we not unset this field, it will unlink the account / third part from the original record.
        copyModel.unset('pnl_permits_licenses_accountsaccounts_idb');
        copyModel.unset('pnl_permits_licenses_accounts_name');
        copyModel.unset('pnl_permits_licenses_accounts');
        // Setting the link with the original model
        copyModel.set('pnl_permitfbdeicenses_ida', originalModel.get('id'));
        // Setting status to Expired for the old license
        copyModel.set('status_id', 'Expired');
        copyModel.set('archived', '1');

        // Create an dummy view to save the copyModel save
        var createView = app.view.createView({
            create: true,
            model: copyModel,
            copiedFromModelId: originalModel.get('id'),
        });

        // Setup the save options list
        var options = {
            success: function (_copyModel) {
                // Update the original model with the drawer data
                self.model.fetch({
                    'showAlerts': false,
                    'success': _.bind(function (model) {
                        self.model.set(newData);
                        self._saveModel();

                        self.$('.record-save-prompt').hide();
                        if (!self.disposed) {
                            self.setButtonStates(self.STATE.VIEW);
                            self.action = 'detail';
                            self.setRoute();
                            self.unsetContextAction();
                            self.toggleEdit(false);
                            self.inlineEditMode = false;
                        }
                        app.drawer.close();
                    }, this)
                }, this);

            }, error: function (err) {
                app.alert.dismiss('renewing_license');
            },
            viewed: true,
            params: {
                'after_create': {
                    'copy_rel_from': originalModel.get('id'),
                },
                'picture_duplicateBeanId': originalModel.get('id'),
                'uploadfile_duplicateBeanId': originalModel.get('id'),
                'team_name_duplicateBeanId': originalModel.get('id'),
            },
        };
        createView.model.save({silent: true}, options);
//            }, this)
//        }, this);
    },

    _saveModel: function () {
        var options,
                successCallback = _.bind(function () {
                    // Loop through the visible subpanels and have them sync. This is to update any related
                    // fields to the record that may have been changed on the server on save.
                    // ++
                    if (this.context) {
                        _.each(this.context.children, function (child) {
                            if (child.get('isSubpanel') && !child.get('hidden')) {
                                if (child.get('collapsed')) {
                                    child.resetLoadFlag({recursive: false});
                                } else {
                                    child.reloadData({recursive: false});
                                }
                            }
                        });
                    }
                    if (this.createMode) {
                        app.navigate(this.context, this.model);
                    } else if (!this.disposed && !app.acl.hasAccessToModel('edit', this.model)) {
                        //re-render the view if the user does not have edit access after save.
                        this.render();
                    }
                    // ++
                    app.alert.dismiss('renewing_license');
                }, this);

        //Call editable to turn off key and mouse events before fields are disposed (SP-1873)
        this.turnOffEvents(this.fields);

        options = {
            showAlerts: true,
            success: successCallback,
            error: _.bind(function (model, error) {
                // ++
                app.alert.dismiss('renewing_license');
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

    closeDrawer: function () {
        app.drawer.close();
    },
})