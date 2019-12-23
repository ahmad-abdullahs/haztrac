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

        beanForDrawer.fetch({
            success: function (model) {
                app.drawer.open({
                    layout: 'record',
                    context: {
                        module: self.model.module,
                        model: model,
                        modelId: self.model.id,
                        openInDrawer: true,
                        // action: model.get('is_bundle_product_c') == 'child' ? 'edit' : 'detail',
                    }
                }, _.bind(function () {
                    // On Close
                    self.collection.fetch();
                }, this), _.bind(function (renderedComponent) {
                    // On Open make the record view in edit mode.
                    renderedComponent.context.trigger('button:edit_button:click');
                    // We have trigger this because it was not triggering the dependency...
                    renderedComponent.model.trigger('change:is_bundle_product_c');
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
