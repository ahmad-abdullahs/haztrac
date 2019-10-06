({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super('initialize', [options]);
        // Add listener for custom button
        this.context.on('button:close_drawer_button:click', this.closeDrawer, this);
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
        if (isEdit) {
            if (this.model._relatedCollections.sales_and_services_revenuelineitems_1) {
                _.each(this.model._relatedCollections.sales_and_services_revenuelineitems_1.models, function (model) {
                    this.context.trigger('edit:full:subpanel:cstm', model, {'def': {}});
                }, this)
            }
        }
    },

    cancelClicked: function () {
        this._super('cancelClicked');
        this.context.trigger('cancel:full:subpanel:cstm');
    },

    editClicked: function () {
        this.setButtonStates(this.STATE.EDIT);
        this.action = 'edit';
        this.toggleEdit(true);
        // Only set the route if its the real record view, not the record view opened in the
        // drawer, like we are opening in the record view in drawer for Maps.
        var initiatedByMapView = this.context.get('initiatedByMapView') || false;
        if (!initiatedByMapView) {
            this.setRoute('edit');
        }
    },

    handleSave: function () {
        if (this.disposed) {
            return;
        }
        this._saveModel();
        this.$('.record-save-prompt').hide();

        if (!this.disposed) {
            this.setButtonStates(this.STATE.VIEW);
            this.action = 'detail';
            // Only set the route if its the real record view, not the record view opened in the
            // drawer, like we are opening in the record view in drawer for Maps.
            var initiatedByMapView = this.context.get('initiatedByMapView') || false;
            if (!initiatedByMapView) {
                this.setRoute();
            }
            this.unsetContextAction();
            this.toggleEdit(false);
            this.inlineEditMode = false;
        }
    },

    _buildGridsFromPanelsMetadata: function (panels) {
        this._super('_buildGridsFromPanelsMetadata', [panels]);

        // Only Add the Close button if this is initiated from the Maps View.
        var initiatedByMapView = this.context.get('initiatedByMapView') || false;
        if (!initiatedByMapView) {
            this.options.meta.buttons = _.reject(this.options.meta.buttons, function (btn) {
                return _.contains(["close_drawer_button"], btn.name);
            }, this);
        }
    },

    closeDrawer: function () {
        app.drawer.close();
    },
})