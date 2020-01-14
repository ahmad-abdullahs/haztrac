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
 * "Link existing record" action used in Subpanels.
 *
 * It needs to be sticky so that we keep things lined up nicely.
 *
 * @class View.Fields.Base.LinkActionField
 * @alias SUGAR.App.view.fields.BaseLinkActionField
 * @extends View.Fields.Base.StickyRowactionField
 */
({
    extendsFrom: 'LinkActionField',
    events: {
        'click a[name=add_multiple_rli_button]': 'openDrawer'
    },

    openDrawer: function () {
        var model = app.data.createBean('sales_and_services');
        app.drawer.open({
            layout: 'multi-create',
            context: {
                create: true,
                // module: "sales_and_services",
                // model: model,
                // collection: this.filteredCollection,
            }
        });
    },
})
