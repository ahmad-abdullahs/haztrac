({
    extendsFrom: 'RowactionField',
    unixTimeSuffix: '',

    initialize: function (options) {
        this._super('initialize', [options]);
        this.type = 'rowaction';
        this.model.on('pullUpPrintPaperWorkDrawer', this.printPaperworkDrawer, this);
    },

    rowActionSelect: function (evt) {
        this.printPaperworkDrawer();
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
        this._downloadClicked();
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
                    }
                }, _.bind(function (context, taskmodel) {
                    // These are for code reference...
                }, self));
            },
            error: function (data) {
                app.error.handleHttpError(data, {});
            },
        }, {
            iframe: this.view.$el,
            // iframe: this.$el
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