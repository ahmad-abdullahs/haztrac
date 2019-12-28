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
 * @class View.Views.Base.Contacts.CreateView
 * @alias SUGAR.App.view.views.ContactsCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'ContactsCreateView',

    /**
     * Gets the portal status from metadata to know if we render portal specific fields.
     * @override
     * @param options
     */
    initialize: function (options) {
        // ++ 
        // This code is added to autopopulate the relatedAttributes, since creating a record 
        // through the module menu works on routing and it does not do the auto population of 
        // relatedAttributes.

        //Plugin is registered by the Contact record view
        this.plugins = _.union(this.plugins || [], ["ContactsPortalMetadataFilter", "LinkedModel"]);
        this._super("initialize", [options]);
        var relatedContext = this.getRelatedContext(this.module);
        if (relatedContext) {
            this.model = this.createLinkModel(app.controller.context.get('model'), relatedContext.link);
        }
    },

    getRelatedContext: function (module) {
        var meta = app.metadata.getModule(module),
                context;

        if (meta && meta.menu.quickcreate.meta.related) {
            var parentModel = app.controller.context.get('model');

            if (parentModel.isNew()) {
                return;
            }

            context = _.find(
                    meta.menu.quickcreate.meta.related,
                    function (metadata) {
                        return metadata.module === parentModel.module;
                    }
            );
        }

        return context;
    },
})
