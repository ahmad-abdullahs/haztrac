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
 * @class View.Fields.Base.TextareaField
 * @alias SUGAR.App.view.fields.BaseTextareaField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'TextareaField',
    events: {
        'click a[name=open_magnify_popup_button]': 'openMagnifyPopup'
    },

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    _render: function () {
        this._super('_render');
    },

    /**Function to open the magnifier pop-up*/
    openMagnifyPopup: function (e) {
        /**add class content-overflow-visible if client has touch feature*/
        if (Modernizr.touch) {
            app.$contentEl.addClass('content-overflow-visible');
        }

        /**
         * check whether the view already exists in the layout.
         * If not we will create a new view and will add to the components list of the record layout
         * */
        var magnifierView = this.view.layout.getComponent('magnifier-popup');
        if (!magnifierView) {
            /** Prepare the context object for the magnifier-popup view */
            var context = this.context.getChildContext({
                module: this.module,
            });

            context.prepare();
            context.originalModel = this.model;

            /** Create a new view object */
            magnifierView = app.view.createView({
                context: context,
                name: 'magnifier-popup',
                layout: this.view.layout,
                module: context.module,
            });

            magnifierView.meta.panels[0].fields[0].name = this.viewDefs.name;
            magnifierView.meta.panels[0].fields[0].label = this.viewDefs.label;

            /** add the new view to the components list of the record layout */
            this.view.layout._components.push(magnifierView);
            this.view.layout.$el.append(magnifierView.$el);
        }

        /** triggers an event to show the pop up magnifier-popup view */
        this.view.layout.trigger("app:view:magnifier-popup");
    },
})
