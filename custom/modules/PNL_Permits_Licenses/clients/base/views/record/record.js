({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super('initialize', [options]);
        // Add listener for custom button
        this.context.on('button:renew_drawer_button:click', this.openRecordInDrawer, this);
    },

    closeDrawer: function () {
        app.drawer.close();
    },

    openRecordInDrawer: function () {
        var self = this;
        var beanForDrawer = app.data.createBean(this.model.module, {
            id: this.model.id
        });

        beanForDrawer.fetch({
            // This view: 'record' is essential to add otherwise it will not fetch the comment collection 
            // and when this model is used for record view it will not show the data in comments dashlet.
            view: 'record',
            success: function (model) {
                // Fields to clear
                model.set({
                    'id_number_c': '',
                    'issuing_date_c': '',
                    'exp_date': '',
                    'renewal_date_c': '',
                    'file_mime_type': '',
                    'uploadfile': '',
                });

                app.drawer.open({
                    layout: 'minified-record',
                    context: {
                        // This layout abbribute is essential to add, otherwise record in the drawer will not
                        // load the record view dashlets.
                        layout: 'minified-record',
                        module: self.model.module,
                        model: model,
                        modelId: self.model.id,
                        openInDrawer: true,
                        parentOriginalModel: self.model,
                    }
                }, _.bind(function () {
                    // Refresh the page.
                    app.router.refresh();
                }, this), _.bind(function (renderedComponent) {
                    // On Open make the record view in edit mode.
                    if (renderedComponent) {
                        renderedComponent.context.trigger('button:edit_button:click');
                    }
                }, this));
            },
            error: function (err) {
                app.logger.error('Failed to fetch Bean: ' + JSON.stringify(err));
            }
        });
    },
})