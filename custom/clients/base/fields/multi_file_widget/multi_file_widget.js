
({
    extendsFrom: 'BaseField',
    subpanelModule: null,
    attachmentCollection: null,
    columnsMeta: null,
    columns: null,
    subpanelModel: null,
    deletedCBIIds: [],

    events: {
        'click .addFile': 'createRecord',
        'click .deleteFile': 'deleteRecord',
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
            this.fetchRecords(true);
        }, this);
    },

    loadInDashlet: function (ele) {
        app.events.trigger('loadTheFileInDashlet', {
            id: $(ele.currentTarget).attr('id'),
            file_ext: $(ele.currentTarget).attr('file_ext'),
            hrefLink: $(ele.currentTarget).siblings('span').find('a').attr('href'),
            module: 'mv_Attachments',
        });
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
        var row = $(e.currentTarget).closest('tr');
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
        if (!_.isEmpty(this.model.get('id')) && !_.isEmpty(this.def.linkField)) {
            var self = this;
            var collection = app.data.createRelatedCollection(this.model, this.def.linkField);
            collection.fetch({
                relate: true,
                limit: -1,
                success: function (coll) {
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
                    self._render();
                }
            });
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
                !_.isEqual(filename.indexOf('.pdf'), -1))
                ) {
            mimeType = 'application/pdf';
            return {
                name: value,
                mimeType: mimeType,
                docType: docType,
                url: '#bwc/index.php?entryPoint=openpdf&id=' + model.get('id'),
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

