/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Fields.Base.NameField
 * @alias SUGAR.App.view.fields.BaseNameField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'NameField',
    events: {
        'click .open-in-drawer': 'openRecordInDrawer',
    },
    initialize: function (options) {
        this._super('initialize', [options]);
    },
    openRecordInDrawer: function () {
        var beanForDrawer = app.data.createBean(this.model.module, {
            id: this.model.id
        }),
                self = this;

        var loadSpecifiedPanels = [];
        if (this.options.module == "sales_and_services" && this.options.viewName == "list") {
            loadSpecifiedPanels = [
                'sales_and_services_revenuelineitems_1',
                'sales_and_services_tasks_1',
                'lr_lab_reports_sales_and_services_1',
                'sales_and_services_contacts_1',
                'notes',
            ];
        }

        beanForDrawer.fetch({
            // This view: 'record' is essential to add otherwise it will not fetch the comment collection 
            // and when this model is used for record view it will not show the data in comments dashlet.
            view: 'record',
            success: function (model) {
                app.drawer.open({
                    layout: 'record',
                    context: {
                        // This layout abbribute is essential to add, otherwise record in the drawer will not
                        // load the record view dashlets.
                        layout: 'record',
                        module: self.model.module,
                        model: model,
                        modelId: self.model.id,
                        openInDrawer: true,
                        // This is commented because if we keep it open it fetch the subpanel collection again
                        // and records not shown in the subpanels.
                        // loadSpecifiedPanels: loadSpecifiedPanels,
                        // action: model.get('is_bundle_product_c') == 'child' ? 'edit' : 'detail',
                    }
                }, _.bind(function () {
                    // On Close
                    app.router.refresh();
//                    if (self.collection) {
//                        self.collection.fetch();
//                    }
                }, this), _.bind(function (renderedComponent) {
                    // On Open make the record view in edit mode.
                    renderedComponent.context.trigger('button:edit_button:click');
                    if (self.model) {
                        if (self.model.module == 'RevenueLineItems') {
                            // We have trigger this because it was not triggering the dependency...
                            renderedComponent.model.trigger('change:is_bundle_product_c');
                        }
                    }
                    // We can handle it this way also by apassing it into the context.
                    // action: model.get('is_bundle_product_c') == 'child' ? 'edit' : 'detail',
                }, this));
            },
            error: function (err) {
                app.logger.error('Failed to fetch Bean: ' + JSON.stringify(err));
            }
        });
    },
    _render: function () {
        this.def.events = true;
        this._super('_render');
    }
})
