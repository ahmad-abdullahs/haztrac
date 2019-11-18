({
    extendsFrom: 'CreateView',

    events: {
        'click .btn[name=print_manifest]': 'printManifest',
    },

    _render: function () {
        this._super('_render');
    },

    bindDataChange: function () {
        this._super('bindDataChange');
    },

    printManifest: function (evt) {
        this._downloadClicked();
    },

    _buildDownloadLink: function () {
        var urlParams = $.param({
            'action': 'manifest',
            'module': this.model.get('_module'),
            'record': this.model.get('id'),
            'x': this.model.get('xaxis'),
            'y': this.model.get('yaxis'),
            'sugarpdf': 'pdfmanager',
        });
        return '?' + urlParams;
    },
    _downloadClicked: function () {
        app.bwc.login(null, _.bind(function () {
            this._triggerDownload(this._buildDownloadLink());
        }, this));
    },
    _triggerDownload: function (url) {
        app.api.fileDownload(url, {
            error: function (data) {
                app.error.handleHttpError(data, {});
            }
        }, {
            iframe: this.$el
        });
    },

})