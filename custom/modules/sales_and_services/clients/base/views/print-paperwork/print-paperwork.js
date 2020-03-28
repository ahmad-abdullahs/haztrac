({
    extendsFrom: 'CreateView',

//    events: {
//        'click .btn[name=print_manifest]': 'printManifest',
//        'click .btn[name=print_manifest_with_num]': 'printManifestWithNum',
//    },

    /*
     * Contain the name of fields which will be shown in the Print Paperwork view tabs .
     */
    tabViewFieldNamesList: [],
    primaryTeamId: '',

    /*
     * Deafult Printer settings for this record team
     */
    printer_setting: {},

    initialize: function (options) {
        var self = this;
        var firstAttrFlag = true;
        this.tabViewFieldNamesList = [];

        this._super('initialize', [options]);

        // Loop through all the PDF Template Type drop down list and add the metaata for each tab
        // along with a field need to be shown in it.
        _.each(app.lang.getAppListStrings('pdf_template_type_list'), function (val, key) {
            if (!_.isEmpty(key)) {
                this.tabViewFieldNamesList.push('service_panel' + '_' + key.replace(/[^A-Z0-9]/ig, "_"));
                var _meta = {
                    name: 'panel_body' + '_' + key.replace(/[^A-Z0-9]/ig, "_"),
                    columns: 2,
                    label: val,
                    title: "",
                    labelsOnTop: true,
                    placeholders: true,
                    newTab: true,
                    panelDefault: "expanded",
                    fields: [{
                            name: 'service_panel' + '_' + key.replace(/[^A-Z0-9]/ig, "_"),
                            label: "LBL_SERVICES_PANEL",
                            type: "templatepdfs-panel",
                            relatedModule: "PdfManager",
                            readonly: "true",
                            dismiss_label: true,
                            span: 7,
                            filterVal: key,
                            columns: [{
                                    name: "name",
                                    label: "LBL_PDFMANAGER_NAME",
                                    enabled: true,
                                    readonly: true,
                                    type: "relate",
                                    link: true,
                                    related_fields: [{
                                            0: "id",
                                        }],
                                }, {
                                    name: "default_printer",
                                    label: "LBL_DEFAULT_PRINTER",
                                    enabled: true,
                                    readonly: true,
                                    type: "text",
                                }],
                        },
                    ],
                };

                if (!firstAttrFlag) {
                    var length = this.meta.panels.length;
                    this.meta.panels[length] = _meta;
                } else {
                    this.meta.panels[this.meta.panels.length - 1] = _meta;
                    firstAttrFlag = false;
                }
            }
        }, this);

        // Default Printer Settings... 
        _.each(this.model.get('team_name'), function (team) {
            if (team.primary) {
                this.primaryTeamId = team.id;

                var teamBean = app.data.createBean('Teams', {id: team.id});
                teamBean.fetch({
                    success: function (_model) {
                        // Getting the manifest number from the team and putting it to the field.
                        self.model.set('on_fly_manifest_number', _model.get('active_manifest_number'));

                        var printer_setting = JSON.parse(_model.get('printer_setting') || '[]');
                        _.each(printer_setting, function (printer, key) {
                            self.printer_setting[printer.pdf_template_type] = printer.pdf_printer;
                        }, this);
                    }
                }, this);
            }
        }, this);

        // Object staructure of the Json, where key is the PDF Template id.
        this.layout.jsonFieldStructure = {};
        _.each(JSON.parse(this.model.get('pdf_template_printer_widget') || '[]'), function (val) {
            this.layout.jsonFieldStructure[val.pdf_template_printer_widget_name_id] = val;
        }, this);
    },

    /*Button Events Registerar*/
    delegateButtonEvents: function () {
        this.context.on('button:print_button:click', this.printCommand, this);
        this.context.on('button:print_queue_button:click', this.printQueueCommand, this);
        this.context.on('button:close_button:click', this.cancel, this);
        this.context.on('button:' + this.restoreButtonName + ':click', this.restoreModel, this);
    },

    printCommand: function () {
        if (!this.isValidFields()) {
            return;
        }

        if (!this.model.get('pdf_template_printer_widget') ||
                _.isEmpty(this.model.get('pdf_template_printer_widget')) ||
                this.model.get('pdf_template_printer_widget') == '[]') {
            app.alert.show('error_no_workorder_selected', {
                level: 'error',
                messages: 'Please select Work Order for printing.',
                autoClose: true
            });
            return;
        }

        var self = this;
        var isManifestRequired = this.isManifestRequired();
        if (isManifestRequired && (!this.model.get('on_fly_manifest_name') || !this.model.get('on_fly_manifest_number'))) {
            this.layout.$el.find('div[data-name=on_fly_manifest_name]').show();
            this.layout.$el.find('div[data-name=on_fly_manifest_number]').show();

            app.alert.show('add-item-warning', {
                level: 'warning',
                messages: "Please select the manifest, User can change the manifest number if required.",
                closeable: true,
                autoClose: true,
                autoCloseDelay: 5000,
            });
            return;
        } else {
            app.alert.show('sumbitting_r_to_printer', {
                level: 'process',
                title: 'Submitting request for Printer'
            });

            // Send the request to Printer, 
            // 1- This call will re-create the work orders. 
            // 2- Increment the manifest number by 1.
            var url = app.api.buildURL('sales_and_services/' + this.model.get('id') + '/SubmitToPrinter');
            var params = params || {};
            params['moduleName'] = this.module;
            params['modelId'] = this.model.get('id');
            params['isManifestRequired'] = isManifestRequired;
            params['fields'] = {
                'pdf_template_printer_widget': this.model.get('pdf_template_printer_widget'),
                'on_fly_manifest_name': this.model.get('on_fly_manifest_name'),
                'on_fly_manifest_id': this.model.get('on_fly_manifest_id'),
                'on_fly_manifest_number': this.model.get('on_fly_manifest_number'),
                'primaryTeamId': this.primaryTeamId,
            };

            app.api.call('create', url, params, {
                success: function (response) {
                    app.alert.dismiss('sumbitting_r_to_printer');
                    app.alert.show('successfully_r_submitted', {
                        level: 'success',
                        messages: 'Request successfully submitted.',
                        autoClose: true
                    });
                    self.cancel();
                }
            });
        }
    },

    isManifestRequired: function () {
        var flag = false;
        if (!_.isEmpty(this.model.get('sales_and_services_revenuelineitems_1'))) {
            _.each(this.model.get('sales_and_services_revenuelineitems_1').records, function (record, key) {
                if (record.is_bundle_product_c != 'parent' && record.manifest_required_c == true) {
                    flag = true;
                }
            });
        }
        return flag;
    },

    isValidFields: function () {
        var issueExist = false;
        _.each($('tbody > tr.ui-sortable-handle').find('input[name*=pdf_template_printer_widget_name__]'), function (ele) {
            if (!$(ele).val()) {
                issueExist = true;
                $(ele).siblings('div').find('a').css({'background-color': '#e61718'});
            } else {
                $(ele).siblings('div').find('a').css({'background-color': ''});
            }
        }, this);

        _.each($('tbody > tr.ui-sortable-handle').find('input[name*=pdf_template_printer_widget_printer__]'), function (ele) {
            if (!$(ele).val()) {
                issueExist = true;
                $(ele).siblings('div').find('a').css({'background-color': '#e61718'});
            } else {
                $(ele).siblings('div').find('a').css({'background-color': ''});
            }
        }, this);

        if (issueExist) {
            app.alert.show('empty_fields_error', {
                level: 'error',
                messages: "Please set the highlighted fields",
                autoClose: true
            });
            return false;
        }

        return true;
    },

    printQueueCommand: function () {
        if (!this.model.get('id'))
            return;

        if (!this.isValidFields()) {
            return;
        }

        if (!this.model.get('pdf_template_printer_widget') ||
                _.isEmpty(this.model.get('pdf_template_printer_widget')) ||
                this.model.get('pdf_template_printer_widget') == '[]') {
            app.alert.show('error_no_workorder_selected', {
                level: 'error',
                messages: 'Please select Work Order for printing.',
                autoClose: true
            });
            return;
        }

        var params = params || {};
        params['moduleName'] = this.module;
        params['modelId'] = this.model.get('id');
        params['fields'] = {
            'pdf_template_printer_widget': this.model.get('pdf_template_printer_widget')
        };

        app.alert.show('process_add_to_queue', {
            level: 'process',
            title: 'Adding To Queue'
        });

        var url = app.api.buildURL('sales_and_services/' + this.model.get('id') + '/handlePrinterQueueRoute');
        app.api.call('create', url, params, {
            success: function (response) {
                app.alert.dismiss('process_add_to_queue');
                app.alert.show('success_add_to_queue', {
                    level: 'success',
                    messages: 'Work Order is successfully added to the Queue.',
                    autoClose: true
                });
            }
        });
    },

    cancel: function () {
        // Code added to reload the list view collection when drawer is closed.
        if (this.context.parent.get('collection'))
            this.context.parent.get('collection').fetch();

        //Clear unsaved changes on cancel.
        app.events.trigger('create:model:changed', false);
        this.$el.off();
        if (app.drawer.count()) {
            app.drawer.close(this.context);
            this._dismissAllAlerts();
        } else {
            app.router.navigate(this.module, {trigger: true});
        }

    },

    _render: function () {
        this._super('_render');
    },

    bindDataChange: function () {
        this._super('bindDataChange');
    },

//    printManifest: function (evt) {
//        this._downloadClicked();
//    },
//
//    printManifestWithNum: function (evt) {
//        this._downloadClicked();
//    },
//
//    _buildDownloadLink: function () {
//        var urlParams = $.param({
//            'action': 'manifest',
//            'module': this.model.get('_module'),
//            'record': this.model.get('id'),
//            'sugarpdf': 'pdfmanager',
//        });
//        return '?' + urlParams;
//    },
//    _downloadClicked: function () {
//        app.bwc.login(null, _.bind(function () {
//            this._triggerDownload(this._buildDownloadLink());
//        }, this));
//    },
//    _triggerDownload: function (url) {
//        app.api.fileDownload(url, {
//            error: function (data) {
//                app.error.handleHttpError(data, {});
//            }
//        }, {
//            iframe: this.$el
//        });
//    },

})