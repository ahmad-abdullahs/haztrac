
({
    extendsFrom: 'BaseField',
    subpanelModule: null,
    attachmentCollection: null,
    columnsMeta: null,
    columns: null,
    subpanelModel: null,
    deletedCBIIds: [],
    // These arrays have the model attributes, dataSyncList is populated when 
    // the collection is fetched from data:sync:complete, while timeOutCallsSyncList s populated when 
    // the collection is fetched from window.setTimeout.
    // So these collections are compared to confirm where the data is properly loaded or not.
    // Means files are saved and now the file attributes like, name, file_ext, file_mime_type ... are loaded.
    dataSyncList: [],
    timeOutCallsSyncList: [],

    callCount: 0,
    timeOutHandle: {},

    events: {
        'click .addFile': 'createRecord',
        'click .deleteFile': 'deleteRecord',
        'click .signFile': 'signFile',
        'click .copyLinkToShare': 'copyLinkToShare',
        'click .lockAnnotation': 'lockAnnotation',
        'click .loadInDashlet': 'loadInDashlet',
    },

    customSupportedImageExtensions: {
        'image/jpeg': 'jpg',
        'image/png': 'png',
        'image/gif': 'gif'
    },
    /**
     * @inheritdoc
     * @param options
     */
    initialize: function (options) {
        this._super('initialize', [options]);
        this.init();
        this.model.on('data:sync:complete', function () {
            this.callCount = 0;
            this.fetchRecords(true);
        }, this);
        this.callCount = 0;
        this.dataSyncList = [];
        this.timeOutCallsSyncList = [];
        this.timeOutHandle = {};
        app.events.on('lockAnnotationOnDrawerClose', this.lockAnnotationOnDrawerClose, this);
    },

    loadInDashlet: function (ele) {
        app.events.trigger('loadTheFileInDashlet', {
            id: $(ele.currentTarget).attr('id'),
            file_ext: $(ele.currentTarget).attr('file_ext'),
            hrefLink: this.getFullViewUrl($(ele.currentTarget).attr('id'), 1),
//            hrefLink: $(ele.currentTarget).siblings('span').find('a').attr('href'),
            module: 'mv_Attachments',
        });
    },

    getFullViewUrl: function (beanID, flag) {
        var today = moment();
        var dateOfExpiry = today.add(1, 'day').utc().format();

        return app.config.signDocURL.url + 'annotationeer/viewer.html?file=../../pdfs/' + beanID + '.pdf' +
                '&token=' + window.btoa('&sugar_user_id=' + app.user.get('id') + '&full_name=' + app.user.get('full_name') +
                        '&document_id=' + beanID + '&hostUrl=' + app.config.signDocURL.url + '&is_locked=1&dateOfExpiry=' + dateOfExpiry);
    },

    init: function () {
        var self = this;
        self.columns = self.def.columns;
        self.attachmentCollection = new Backbone.Collection();
        self.subpanelModule = self.def.relatedModule;
        self.columnsMeta = self.getColumnsMeta();
        self.fetchRecords(false);
    },

    /**
     * In edit mode, render phone input fields using the edit-phone-field template.
     * @inheritdoc
     * @private
     */
    _render: function (a) {
        if (this.action == 'edit' && this.attachmentCollection.models.length == 0) {
            this.createRecord();
        }
        this._super("_render");
        this.renderSubpanelFields();
    },

    createRecord: function (e) {
        if (!$(".btn.addFile").hasClass('disabled')) {
            var self = this;
            var model = app.data.createBean(self.subpanelModule, {id: app.utils.generateUUID(), newRecord: true});
            model.setDefault(model.getDefault());
            model.template = 'edit';
            model.isnew = true;
            model.on('change:uploadfile', self.fileSave, this);
            self.attachmentCollection.add(model);
            self._render();
        }
    },

    renderSubpanelFields: function () {
        var self = this;
        $('.cbi-rowcell>span[sfuuid]').each(function () {
            var $this = $(this),
                    sfId = $this.attr('sfuuid');
            var field = self.view.fields[sfId];
            if (field) {
                field.setElement($this || self.$("span[sfuuid='" + sfId + "']"));
                try {
                    field.render();
                } catch (e) {
                    // error
                }
            }
        });
    },

    getColumnsMeta: function () {
        var meta = new Array;
        this.subpanelModel = app.data.createBean(this.subpanelModule);
        for (var index in this.columns) {
            var field = this.columns[index]['name'];
            var type = this.columns[index]['type'] || false;
            var span = this.columns[index]['span'] || 1;
            var options = this.columns[index]['options'] || false;
            var readonly = this.columns[index]['readonly'] || false;
            var link = this.columns[index]['link'] || false;
            if (this.primary_field && field == this.primary_field) {
                this.primary_field_label = app.lang.get(this.columns[index]['label'], this.subpanelModule);
            }
            var fmeta = this.subpanelModel.fields[field];
            if (type) {
                fmeta['type'] = type;
            }
            if (span) {
                fmeta['span'] = span;
            }
            if (options) {
                fmeta['options'] = options;
            }
            if (readonly) {
                fmeta['readonly'] = readonly;
            }
            if (link) {
                fmeta['link'] = link;
            }
            meta.push(fmeta);
        }
        return meta;
    },

    /**
     * Listener function for deleting clicked record.
     * @param {Object} e (current event)
     */
    deleteRecord: function (e) {
        var self = this;
        var row = $(e.currentTarget).parents('div.control-group.clearfix');
        var beanID = $(row).attr('data-id');
        app.alert.show('delete_confirmation', {
            level: 'confirmation',
            messages: app.lang.get('LBL_PRO_DELETE_CONFIRMATION'),
            onConfirm: _.bind(function () {
                var model = self.attachmentCollection.get(beanID);
                if (model.isnew) {
                    self.attachmentCollection.remove(model);
                    self._render();
                } else {
                    this.unlinkRecord(model);
                }
            }, self)
        });
    },
    /**
     * Listener function for signing clicked record.
     * @param {Object} e (current event)
     */
    signFile: function (e) {
        var self = this;
        var row = $(e.currentTarget).parents('div.control-group.clearfix');
        var beanID = $(row).attr('data-id');
        var model = self.attachmentCollection.get(beanID);
        var flag = (model.get('is_locked')) ? 1 : 0;

        app.drawer.open({
            layout: 'sign-doc',
            context: {
                url: 'signDoc/annotationeer/viewer.html?file=../../pdfs/' + beanID + '.pdf',
                document_id: beanID,
                is_locked: flag,
            }
        }, _.bind(function (context, model) {
            // comes here when its is closed
        }, self));

    },
    /**
     * Listener function for copying link to share with someone for external use.
     * @param {Object} e (current event)
     */
    copyLinkToShare: function (e) {
        var self = this;
        var row = $(e.currentTarget).parents('div.control-group.clearfix');
        var beanID = $(row).attr('data-id');
        var model = self.attachmentCollection.get(beanID);
        var flag = (model.get('is_locked')) ? 1 : 0;
        var today = moment();
        var dateOfExpiry = today.add(1, 'day').utc().format();

        var url = app.config.signDocURL.url + 'annotationeer/viewer.html?file=../../pdfs/' + beanID + '.pdf' +
                '&token=' + window.btoa('&sugar_user_id=' + app.user.get('id') + '&full_name=' + app.user.get('full_name') +
                        '&document_id=' + beanID + '&hostUrl=' + app.config.signDocURL.url + '&is_locked=' + flag +
                        '&dateOfExpiry=' + dateOfExpiry);

        $('#copyLinkToShareInput').val(url);
        var copyText = document.getElementById("copyLinkToShareInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");

        // When user click the copy link button it should lock the document. 
        e.keptLock = true;
        this.lockAnnotation(e);
    },
    /**
     * Listener function for locking the document to edit.
     * @param {Object} e (current event)
     */
    lockAnnotation: function (e) {
        var self = this;
        var row = $(e.currentTarget).parents('div.control-group.clearfix');
        var beanID = $(row).attr('data-id');
        if (beanID) {
            var model = self.attachmentCollection.get(beanID);
            var flag = (!model.get('is_locked')) ? 1 : 0;

            if (_.has(e, "keptLock")) {
                flag = flag || ((e.keptLock) ? 1 : 0);
            }

            // Send and api call to lock/unlock the document
            var url = 'HT_Manifest/' + beanID + '/lockOrUnlockDoc';

            // end lock/unlock call
            this.makeLockCall(url, flag);
        }
    },

    makeLockCall: function (url, flag) {
        var self = this;
        app.api.call('create', app.api.buildURL(url), {'flag': flag}, {
            success: _.bind(function (result) {
                self.attachmentCollection.reset();
                self.fetchRecords(true);
            }),
            error: _.bind(function (err) {
                console.log(err);
            }, this),
        });
    },

    /*
     * Automatically lock the document when drawer is closed
     */
    lockAnnotationOnDrawerClose: function (param) {
        var url = 'HT_Manifest/' + param.document_id + '/lockOrUnlockDoc';
        var flag = 1;
        if (!_.isUndefined(param.document_id) && !_.isEmpty(param.document_id)) {
            this.makeLockCall(url, flag);
        }
    },

    fileSave: function (model, value) {
        if (!model.get('uploadfile'))
            return;

        var self = this;
        var ajaxParams = {
            temp: true,
            iframe: true,
            deleteIfFails: false,
            htmlJsonFormat: true
        };
        var fieldName = "uploadfile";
        var field = $('[data-id="' + model.id + '"] :input');
        $("a[name='save_button']").addClass("disabled");
        $(".btn.addFile").addClass("disabled");
        app.alert.show(model.id, {
            level: 'process',
            title: 'Uploading file...'
        });
        model.uploadFile(fieldName, field, {
            success: _.bind(self._doValidateFileSuccess, model),
            error: _.bind(function (result) {
                app.alert.dismissAll();
                $("a[name='save_button']").removeClass("disabled");
                $(".btn.addFile").removeClass("disabled");
                app.alert.show('upload_failed', {
                    level: 'error',
                    title: 'Error Uploading file. ' + result
                });
                console.log("error " + result);
            }, this),
        }, ajaxParams);
    },

    _doValidateFileSuccess: function (data) {
        $("a[name='save_button']").removeClass("disabled");
        $(".btn.addFile").removeClass("disabled");
        var fieldName = "uploadfile";
        var model = this;
        app.alert.dismiss(model.id);
        var guid = data.record && data.record.id;
        if (!guid) {
            app.logger.error('Temporary file uploaded has no GUID.');
            return;
        }

        // Add the guid to the list of fields to set on the model.
        if (!model.fields[fieldName + '_guid']) {
            model.fields[fieldName + '_guid'] = {
                type: 'file_temp',
                group: fieldName
            };
        }

        model.set(fieldName + '_guid', guid);
        model.set('temp_file_ext', data.record.file_ext);

        // Update filename of the model with the value from response,
        // since it may have been modified on the server side
        model.set(fieldName, data.record[fieldName]);
        model.set('document_name', data.record.uploadfile);
    },

    fetchRecords: function (trigger) {
        if (this.model) {
            if (!_.isEmpty(this.model.get('id')) && !_.isEmpty(this.def.linkField)) {
                var self = this;
                var collection = app.data.createRelatedCollection(this.model, this.def.linkField);
                collection.fetch({
                    view: 'list',
                    relate: true,
                    limit: -1,
                    success: function (coll) {
                        // if trigger == true means called from data:sync:complete
                        // otherwise called from window.setTimeout.
                        if (trigger) {
                            self.dataSyncList = [];
                        } else {
                            self.timeOutCallsSyncList = [];
                        }

                        _.each(coll.models, function (model) {
                            var obj = {
                                id: model.get('id'),
                                name: model.get('name'),
                                document_name: model.get('document_name'),
                                filename: model.get('filename'),
                                file_ext: model.get('file_ext'),
                                file_mime_type: model.get('file_mime_type'),
                            };
                            if (trigger) {
                                self.dataSyncList.push(obj);
                            } else {
                                self.timeOutCallsSyncList.push(obj);
                            }
                        });

                        //Adding new models to collection
                        for (var i = 0; i < collection.models.length; i++) {
                            collection.models[i].template = "detail";
                            collection.models[i].URL = self._createFileObj(collection.models[i]['attributes']['name'], {
                                field: 'uploadfile',
                                module: 'mv_Attachments',
                                id: collection.models[i]['attributes']['id']
                            }, collection.models[i]);

                            self.attachmentCollection.add(collection.models[i]);
                            self.attachmentCollection.models[i].template = "detail";

                            if (collection.models[i].get('category_id') == 'Primary' && trigger) {
                                app.events.trigger('loadTheFileInDashlet', {
                                    id: collection.models[i].get('id'),
                                    file_ext: collection.models[i].get('file_ext'),
                                    module: 'mv_Attachments',
                                });
                            }
                        }

                        if (_.isEqual(self.dataSyncList, self.timeOutCallsSyncList)) {
                            self.callCount++;
                            // Make the 3 calls to confirm all the files are saved and the data loaded is the 
                            // proper data.
                            if (self.callCount == 3) {
                                window.clearTimeout(self.timeOutHandle);
                                self.callCount--;
                                self._render();
                                return;
                            }
                            self.timeOutHandle = window.setTimeout(_.bind(self.fetchRecords, self), 1500);
                        } else {
                            self.callCount++;
                            if (self.callCount == 3) {
                                window.clearTimeout(self.timeOutHandle);
                                self.callCount--;
                                self._render();
                                return;
                            }
                            self.timeOutHandle = window.setTimeout(_.bind(self.fetchRecords, self), 1500);
                            self._render();
                        }
                    }
                });
            }
        }
    },

    unlinkRecord: function (model) {
        var self = this;
        var chld_id = model.get('id');
        var url = 'mv_Attachments/' + chld_id;
        app.api.call('delete', app.api.buildURL(url), {}, {
            success: _.bind(function (result) {
                self.attachmentCollection.remove(model);
                self._render();
            }),
            error: _.bind(function (err) {
                console.log(err);
            }, this),
            complete: _.bind(function () {
            }, this)
        });
    },

    setMode: function (name) {
        var self = this;
        if (name === 'edit') {
            if (self.attachmentCollection.models.length == 0) {
                self.createRecord();
            }
        }
        if (name === 'detail') {
            for (var i = 0; i < self.attachmentCollection.models.length; i++) {
                if (typeof self.attachmentCollection.models[i].attributes.uploadfile == "undefined")
                {
                    self.attachmentCollection.remove(self.attachmentCollection.models[i]);
                }
            }
        }
        this._super('setMode', [name]);
    },

    _createFileObj: function (value, urlOpts, model) {
        var isImage = this.isImage(model.get('file_mime_type')),
                forceDownload = !isImage,
                mimeType = isImage ? 'image' : '',
                docType = 'uploadfile';

        var file_mime_type = '', file_ext = '', filename = '';

        if (!_.isUndefined(model.get('file_mime_type'))) {
            file_mime_type = model.get('file_mime_type');
        }
        if (!_.isUndefined(model.get('file_ext'))) {
            file_ext = model.get('file_ext');
        }
        if (!_.isUndefined(model.get('filename'))) {
            filename = model.get('filename');
        }

        if ((!_.isEqual(file_mime_type.indexOf('pdf'), -1) ||
                !_.isEqual(file_ext.indexOf('pdf'), -1) ||
                !_.isEqual(filename.indexOf('.pdf'), -1))) {
            var url = this.getFullViewUrl(model.get('id'), 1);
            mimeType = 'application/pdf';
            return {
                name: value,
                mimeType: mimeType,
                docType: docType,
                url: url,
//                url: '#bwc/index.php?entryPoint=openpdf&id=' + model.get('id'),
            };
        } else {
            return {
                name: value,
                mimeType: mimeType,
                docType: docType,
                url: app.api.buildFileURL(urlOpts, {
                    htmlJsonFormat: false,
                    passOAuthToken: false,
                    cleanCache: true,
                    forceDownload: forceDownload
                }),
            };
        }

    },

    isImage: function (mimeType) {
        return !!this.customSupportedImageExtensions[mimeType];
    },
})