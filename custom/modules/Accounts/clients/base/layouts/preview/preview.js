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
 * @class View.Layouts.Base.PreviewLayout
 * @alias SUGAR.App.view.layouts.BasePreviewLayout
 * @extends View.Layout
 */
({
    extendsFrom: 'PreviewLayout',
    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
    },

    /**
     * Initializes the preview layout components using the correct module.
     *
     * @private
     * @param {Data.Bean} model The {@link Data.Bean model} being previewed.
     * @param {Data.BeanCollection} collection The
     *   {@link Data.BeanCollection collection} of preview models.
     */
    _initPreviewPanel: function (model, collection) {
        if (!this._isActive()) {
            return;
        }

        var attrs = {
            model: model,
            collection: collection,
            module: model.module,
            modelId: model.id
        };

        // If `this._components` is empty, its the first time we are
        // initializing the preview panel. Otherwise, if the modules are
        // different, we need to reinitialize the preview panel with the new
        // metadata from that module.
        var hasComponents = !_.isEmpty(this._components);
        var modelChanged = this.context.get('module') !== model.module;

        // ++ 
        // true is added to execute the below code everytime.
        if (!hasComponents || modelChanged || true) {
            this._disposeComponents();
            this.context.set(attrs);
            this.initComponents(this._componentsMeta, this.context, model.module);
            if (hasComponents) {
                // In case we already have components, reload the
                // data to remove previous load data (e.g. fetchCalled, etc)
                this.context.reloadData({resetCollection: false});
            } else {
                this.context.loadData();
            }
            this.render();
        } else {
            this.context.set(attrs);
            this.context.reloadData({resetCollection: false});
        }

        this.showPreviewPanel();
        app.events.trigger('list:preview:decorate', model, this);
    },

})
