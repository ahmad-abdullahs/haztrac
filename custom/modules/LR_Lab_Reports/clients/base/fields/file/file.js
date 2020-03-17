({
    extendsFrom: 'FileField',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    /**
     * 
     * @overrid
     * @returns {fileAnonym$0._createFileObj.fileAnonym$1|fileAnonym$0._createFileObj.fileAnonym$2}
     */
    _createFileObj: function (value, urlOpts) {
        var isImage = this._isImage(this.model.get('file_mime_type')),
                forceDownload = !isImage,
                mimeType = isImage ? 'image' : '',
                docType = this.model.get('doc_type');

        var file_mime_type = '', file_ext = '', filename = '';

        if (!_.isUndefined(this.model.get('file_mime_type'))) {
            file_mime_type = this.model.get('file_mime_type');
        }
        if (!_.isUndefined(this.model.get('file_ext'))) {
            file_ext = this.model.get('file_ext');
        }
        if (!_.isUndefined(this.model.get('filename'))) {
            filename = this.model.get('filename');
        }

        if (!_.isEqual(file_mime_type.indexOf('pdf'), -1) ||
                !_.isEqual(file_ext.indexOf('pdf'), -1) ||
                !_.isEqual(filename.indexOf('.pdf'), -1)) {
            mimeType = 'application/pdf';
            return {
                name: value,
                mimeType: mimeType,
                docType: docType,
                url: '#bwc/index.php?entryPoint=openpdf&id=' + this.model.get('id') + '&module=' + this.module,
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
                })
            };
        }
    },
})
