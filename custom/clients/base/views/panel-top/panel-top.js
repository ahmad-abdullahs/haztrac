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
 * Header section for Subpanel layouts.
 *
 * @class View.Views.Base.PanelTopView
 * @alias SUGAR.App.view.views.BasePanelTopView
 * @extends View.View
 */
({
    extendsFrom: 'PanelTopView',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    openCreateDrawer: function (module, link) {
        link = link || this.context.get('link');
        //FIXME: `this.context` should always be used - SC-2550
        var context = (this.context.get('name') === 'tabbed-dashlet') ?
                this.context : (this.context.parent || this.context);
        var parentModel = context.get('model') || context.parent.get('model'),
                model = this.createLinkModel(parentModel, link),
                self = this;

        // While record creation from the Accounts module detail view subpanels 
        // set the record Teams as it of Accounts module, so each new record creating
        // would have the same Teams as Accounts have.
        if (this.parentModule == 'Accounts') {
            model.set('team_name', parentModel.get('team_name'));
        }

        app.drawer.open({
            layout: 'create',
            context: {
                create: true,
                module: model.module,
                model: model
            }
        }, function (context, model) {
            if (!model) {
                return;
            }

            self.trigger('linked-model:create', model);
        });
    },
})
