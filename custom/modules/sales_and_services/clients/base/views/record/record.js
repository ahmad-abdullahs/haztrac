({
    extendsFrom: 'RecordView',

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

        // Call the trigger to notify the RevenueLineItem Subpanel to save all the items in the subpanel
        this.context.trigger('save:full:subpanel:cstm');

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
    
    printPaperworkDrawer: function () {
        app.drawer.open({
            layout: 'print-paperwork',
            context: {
                create: true,
                module: this.model.module || this.model.get('_module'),
                model: this.model,
            }
        }, _.bind(function (context, taskmodel) {
            // These are for code reference...
        }, this));
    },
})