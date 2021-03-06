({
    extendsFrom: 'RecordView',
    unixTimeSuffix: '',
    pdfTemplateTypesList: {},

    initialize: function (options) {
        this._super('initialize', [options]);
        // Add listener for custom button
        this.context.on('button:close_drawer_button:click', this.closeDrawer, this);
        this.model.on('change:recurring_sale_c', this.takeUserToRecurringTab, this);
        // Add listener for print_paperwork_button
        this.context.on('button:print_paperwork_button:click', this.printPaperworkDrawer, this);
        /*This makes the field colored in detail view...*/
//        this.model.on('data:sync:complete', function (options) {
//            if (!_.isNull(this.model._relatedCollections))
//                this.model._relatedCollections.sales_and_services_revenuelineitems_1.on('data:sync:complete', _.bind(this.colourTheFields, this));
//        }, this);
    },

    duplicateClicked: function () {
        var self = this,
                prefill = app.data.createBean(this.model.module);

        prefill.copy(this.model);
        this._copyNestedCollections(this.model, prefill);
        self.model.trigger('duplicate:before', prefill);
        prefill.unset('id');
        app.drawer.open({
            layout: 'create',
            context: {
                create: true,
                model: prefill,
                copiedFromModelId: this.model.get('id'),
                copyFeature: true,
                _relatedCollections: _.clone(this.model._relatedCollections),
            }
        }, function (context, newModel) {
            if (newModel && newModel.id) {
                app.router.navigate(self.model.module + '/' + newModel.id, {trigger: true});
            }
        }, function (thisOfDrawer) {
            // Change is triggered to load the Related Revenue Line Items dashlet...
            if (!_.isUndefined(thisOfDrawer) && !_.isNull(thisOfDrawer)) {
                thisOfDrawer.model.trigger('change:accounts_sales_and_services_1accounts_ida');
                thisOfDrawer.context.trigger('load:revenuelineitems:subpanel-for-rli-create');
            }
        });

        prefill.trigger('duplicate:field', self.model);
    },

    setupDuplicateFields: function (prefill) {
        // On Copy unset these fields...
        var duplicateBlackList = ['on_date_c', 'on_time_c', 'name', 'destination_ship_to_c', 'account_id1_c'];
        _.each(duplicateBlackList, function (field) {
            if (field && prefill.has(field)) {
                prefill.unset(field);
            }
        });
    },

    colourTheFields: function () {
        if (this.model._relatedCollections.sales_and_services_revenuelineitems_1.length) {
//            var activeTab = app.user.lastState.get(app.user.lastState.key('activeTab', this));
//            if (activeTab != '#panel_completion') {
            // simple decimal field 
            $('tr[name*=RevenueLineItems_] td[name=estimated_quantity_c]').attr('style', 'background-color:#f4e429 !important');
            // drop down field
            $('tr[name*=RevenueLineItems_] td[name=product_uom_c]').attr('style', 'background-color:#f4e429 !important');
            // simple decimal field 
            $('tr[name*=RevenueLineItems_] td[data-column=estimated_quantity_c]').attr('style', 'background-color:#f4e429 !important');
            // drop down field
            $('tr[name*=RevenueLineItems_] td[data-column=product_uom_c]').attr('style', 'background-color:#f4e429 !important');
//            }
        }
    },

    takeUserToRecurringTab: function (model, fieldValue) {
        // If Recurring Sale checkbox is checked, take user to that tab
        if (fieldValue) {
            this.$('li.tab.panel_recurring > a').click();
        }
    },

    _render: function () {
        this._super('_render');

        /* When sales and service is opened up in the drawer from list view to complete the record
         * fetch the related collections, because they are not automatically laded and subpanel keep on showing the loading sign.
         * */
        if (this.context.get('loadSpecifiedPanels')) {
            var panelsListToLoad = this.context.get('loadSpecifiedPanels');
            _.each(panelsListToLoad, function (linkName) {
                this.model._relatedCollections[linkName].fetch();
            }, this);
        }

        // Get all the tabs with class like panel_
        // $('#recordTab > li.tab [class*=panel_]');

        var self = this;
        // Make the Revenue Line Items subpanel in non-editable mode when schedule tab is clicked
        this.$('li.tab.panel_body > a').on('click', function () {
            self.context.trigger('cancel:full:subpanel:cstm');
        });

        // Make the Revenue Line Items subpanel in editable mode when completion tab is clicked
        this.$('li.tab.panel_completion > a').on('click', function () {
            $.when(self.triggerEdit()).then(function () {
                //*** Make the Actual quantity, Unit of Measure and Unit price fields coloured.
                if (self.model._relatedCollections.sales_and_services_revenuelineitems_1) {
                    // simple decimal field 
                    $('tr[name*=RevenueLineItems_] input[name=quantity]').css('background-color', '#f4e429');
                    // drop down field
                    $('tr[name*=RevenueLineItems_] input[name=product_uom_c]').siblings('div').children('a').css('background-color', '#f4e429');
                    // currency field
                    $('tr[name*=RevenueLineItems_] input[name=discount_price]').css('background-color', '#f4e429');
                    $('tr[name*=RevenueLineItems_] input[name=discount_price]').siblings('span').children('div').children('a').css('background-color', '#f4e429');

                    //*** Remove the background color from Estimated Quantity and Unit of Measure from <td>
                    // simple decimal field 
                    $('tr[name*=RevenueLineItems_] td[name=estimated_quantity_c]').attr('style', '');
                    // drop down field
                    $('tr[name*=RevenueLineItems_] td[name=product_uom_c]').attr('style', '');
                    // simple decimal field 
                    $('tr[name*=RevenueLineItems_] td[data-column=estimated_quantity_c]').attr('style', '');
                    // drop down field
                    $('tr[name*=RevenueLineItems_] td[data-column=product_uom_c]').attr('style', '');
                }
            });
        });

        // Make the Revenue Line Items subpanel in non editable mode when any tab 
        // other than completion tab is clicked
        this.$('li.tab[class*=panel_]:not(.panel_completion) > a').on('click', function () {
            $.when(self.context.trigger('cancel:full:subpanel:cstm')).then(function () {
                //*** Make the Estimated Quantity and Unit of Measure fields coloured.
                /*This makes the field colored in detail view...*/
//                if (self.model._relatedCollections.sales_and_services_revenuelineitems_1) {
//                    self.colourTheFields();
//                }
            });
        });
    },

    triggerEdit: function () {
        if (this.model._relatedCollections.sales_and_services_revenuelineitems_1) {
            _.each(this.model._relatedCollections.sales_and_services_revenuelineitems_1.models, function (model) {
                this.context.trigger('edit:full:subpanel:cstm', model, {'def': {}});
            }, this);
        }
    },

    registerShortcuts: function () {
        this._super('registerShortcuts');
        app.shortcuts.register({
            id: 'Drawer:Close',
            keys: ['esc'],
            component: this,
            description: 'LBL_SHORTCUT_DRAWER_CLOSE',
            // callOnFocus: true,
            handler: function () {
                var $cancelButton = this.$('a[name=close_drawer_button]');
                if ($cancelButton.is(':visible') && !$cancelButton.hasClass('disabled')) {
                    $cancelButton.click();
                }
            }
        });
    },

    bindDataChange: function () {
        this._super('bindDataChange');
        // On the sales_and_services record view, when the _relatedCollections revenuelineitems subpannel is fetched.
        // make all the rows in that pannel editable.
        // if (this.model._relatedCollections.sales_and_services_revenuelineitems_1) {
        //     this.model._relatedCollections.sales_and_services_revenuelineitems_1.on('data:sync:complete', function () {
        //         _.each(this.model._relatedCollections.sales_and_services_revenuelineitems_1.models, function (model) {
        //             this.context.trigger('edit:full:subpanel:cstm', model, {'def': {}});
        //         }, this)
        //     }, this);
        // }
    },

    toggleEdit: function (isEdit) {
        this._super('toggleEdit', [isEdit]);
        // On the sales_and_services record view, when the _relatedCollections revenuelineitems subpannel is fetched.
        // make all the rows in that pannel editable.
//        if (isEdit) {
//            if (this.model._relatedCollections.sales_and_services_revenuelineitems_1) {
//                _.each(this.model._relatedCollections.sales_and_services_revenuelineitems_1.models, function (model) {
//                    this.context.trigger('edit:full:subpanel:cstm', model, {'def': {}});
//                }, this)
//            }
//        }
    },

    cancelClicked: function () {
        this.setButtonStates(this.STATE.VIEW);
        this.action = 'detail';
        this.handleCancel();
        this.clearValidationErrors(this.editableFields);
        // Only set the route if its the real record view, not the record view opened in the
        // drawer or list view.
        var initiatedByMapView = this.context.get('initiatedByMapView') || this.isOnTopOfListView() || false;
        if (!initiatedByMapView) {
            this.setRoute();
        }
        this.unsetContextAction();
        this.context.trigger('cancel:full:subpanel:cstm');
    },

    editClicked: function () {
        this.setButtonStates(this.STATE.EDIT);
        this.action = 'edit';
        this.toggleEdit(true);
        // Only set the route if its the real record view, not the record view opened in the
        // drawer, like we are opening in the record view in drawer for Maps.
        var initiatedByMapView = this.context.get('initiatedByMapView') || this.isOnTopOfListView() || false;
        if (!initiatedByMapView) {
            this.setRoute('edit');
        }
    },

    handleSave: function () {
        if (this.disposed) {
            return;
        }

        // Unformat the Transporter field because this needs to be unformated through this way,
        // Its a custom multirow field and its default unformat is not working.
        this.context.trigger('unformat:transporter:carrier');

        this._saveModel();
        this.$('.record-save-prompt').hide();

        if (!this.disposed) {
            this.setButtonStates(this.STATE.VIEW);
            this.action = 'detail';
            // Only set the route if its the real record view, not the record view opened in the
            // drawer, like we are opening in the record view in drawer for Maps.
            var initiatedByMapView = this.context.get('initiatedByMapView') || this.isOnTopOfListView() || false;
            if (!initiatedByMapView) {
                this.setRoute();
            }
            this.unsetContextAction();
            this.toggleEdit(false);
            this.inlineEditMode = false;
        }
    },

    _saveModel: function () {
        var options,
                successCallback = _.bind(function () {
                    // Call the trigger to notify the RevenueLineItem Subpanel to save all the items in the subpanel
                    this.context.trigger('save:full:subpanel:cstm');

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

    isOnTopOfListView: function () {
        var isOnTopOfListView = false;
        if (this.options.context) {
            if (this.options.context.parent) {
                if (this.options.context.parent.get('layout') == "records") {
                    isOnTopOfListView = true;
                }
            }
        }
        return isOnTopOfListView;
    },

    _buildGridsFromPanelsMetadata: function (panels) {
        this._super('_buildGridsFromPanelsMetadata', [panels]);

        // Only Add the Close button if this is initiated from the Maps View.
        var initiatedByMapView = this.context.get('initiatedByMapView') || this.isOnTopOfListView() || false;
        if (!initiatedByMapView) {
            this.options.meta.buttons = _.reject(this.options.meta.buttons, function (btn) {
                return _.contains(["close_drawer_button"], btn.name);
            }, this);
        }
    },

    closeDrawer: function () {
        app.drawer.close();
    },

    printPaperworkDrawer: function () {
        this.unixTimeSuffix = app.date().unix();
        // app.drawer.open({
        //     layout: 'print-paperwork',
        //     context: {
        //         create: true,
        //         module: this.model.module || this.model.get('_module'),
        //         model: this.model,
        //     }
        // }, _.bind(function (context, taskmodel) {
        //     // These are for code reference...
        // }, this));
        // This pdfTemplateTypesList is fetched here because we need this list before the 
        // print-paperwork work view initialize the meta, we are using this to dynamically create 
        // the tabs on print-paperwork drawer.
        this.pdfTemplateTypesList = app.data.createBeanCollection('pdf_template_types');
        this.pdfTemplateTypesList.fetch({
            'showAlerts': false,
            'limit': -1,
            params: {
                order_by: 'order_number:asc'
            },
            'success': _.bind(function (data) {
                this._downloadClicked();
            }, this)
        });
    },

    _downloadClicked: function () {
        app.bwc.login(null, _.bind(function () {
            this._triggerDownload(this._buildDownloadLink());
        }, this));
    },

    _triggerDownload: function (url) {
        var self = this;
        app.api.fileDownload(url, {
            success: function () {
                app.drawer.open({
                    layout: 'print-paperwork',
                    context: {
                        create: true,
                        module: self.model.module || self.model.get('_module'),
                        model: self.model,
                        unixTimeSuffix: self.unixTimeSuffix,
                        pdfTemplateTypesList: self.pdfTemplateTypesList,
                    }
                }, _.bind(function (context, taskmodel) {
                    // These are for code reference...
                }, self));
            },
            error: function (data) {
                app.error.handleHttpError(data, {});
            },
        }, {
            iframe: this.$el
        });
    },

    _buildDownloadLink: function () {
        var urlParams = $.param({
            'action': 'manifest',
            'module': this.model.get('_module'),
            'record': this.model.get('id'),
            'sugarpdf': 'pdfmanager',
            'putToDir': true,
            'unixTimeSuffix': this.unixTimeSuffix,
        });
        return '?' + urlParams;
    },
})