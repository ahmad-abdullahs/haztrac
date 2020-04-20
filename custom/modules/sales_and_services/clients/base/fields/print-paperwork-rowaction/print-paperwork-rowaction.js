({
    extendsFrom: 'RowactionField',
    unixTimeSuffix: '',
    pdfTemplateTypesList: {},

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