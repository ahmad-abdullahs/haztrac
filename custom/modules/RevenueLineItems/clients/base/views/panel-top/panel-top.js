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
({
    extendsFrom: 'CustomPanelTopView',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        var userACLs;

        this._super('initialize', [options]);

        if (this.parentModule === 'Accounts') {
            this.context.parent.on('editablelist:save', this._reloadOpportunities, this);
        }

        userACLs = app.user.getAcls();

        if (!(_.has(userACLs.Opportunities, 'edit') ||
                _.has(userACLs.RevenueLineItems, 'access') ||
                _.has(userACLs.RevenueLineItems, 'edit'))) {
            // need to trigger on app.controller.context because of contexts changing between
            // the PCDashlet, and Opps create being in a Drawer, or as its own standalone page
            // app.controller.context is the only consistent context to use
            app.controller.context.on('productCatalogDashlet:add', this.openRLICreate, this);
        }
    },

    /**
     * Refreshes the RevenueLineItems subpanel when a new Opportunity is added
     * @private
     */
    _reloadOpportunities: function () {
        var $oppsSubpanel = $('div[data-subpanel-link="opportunities"]');
        // only reload Opportunities if it is closed & no data exists
        if ($('li.subpanel', $oppsSubpanel).hasClass('closed')) {
            if ($('table.dataTable', $oppsSubpanel).length) {
                this.context.parent.trigger('subpanel:reload', {links: ['opportunities']});
            } else {
                this.context.parent.trigger('subpanel:reload');
            }
        } else {
            this.context.parent.trigger('subpanel:reload', {links: ['opportunities']});
        }
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function () {
        this._super('bindDataChange');
        this.context.parent.on('subpanel:reload', function (args) {
            if (!_.isUndefined(args) && _.isArray(args.links) && _.contains(args.links, this.context.get('link'))) {
                // have to set skipFetch to false so panel.js will toggle this panel open
                this.context.set('skipFetch', false);
                this.context.reloadData({recursive: false});
            }
        }, this);
    },

    /**
     * @inheritdoc
     */
    createRelatedClicked: function (event) {
        // close RLI warning alert
        app.alert.dismiss('opp-rli-create');

        this._super('createRelatedClicked', [event]);
    },

    openCreateDrawer: function (module, link) {
        var groupItemUsageAllowed = false;

        if (this.parentModule == 'Accounts') {
            groupItemUsageAllowed = true;
        }

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
                model: model,
                groupItemUsageAllowed: groupItemUsageAllowed,
            }
        }, function (context, model) {
            if (!model) {
                return;
            }

            self.trigger('linked-model:create', model);
        });
    },

    /**
     * Open a new Drawer with the RLI Create Form
     */
    openRLICreate: function (data) {
        var routerFrags = app.router.getFragment().split('/');
        var parentModel;
        var model;

        if (routerFrags[1] === 'create') {
            // if panel-top has been initialized on a record, but we're currently in create, ignore the event
            return;
        }

        parentModel = this.context.parent.get('model');
        model = this.createLinkModel(parentModel, 'revenuelineitems');

        data.likely_case = data.discount_price;
        data.best_case = data.discount_price;
        data.worst_case = data.discount_price;
        data.assigned_user_id = app.user.get('id');
        data.assigned_user_name = app.user.get('name');

        model.set(data);
        model.ignoreUserPrefCurrency = true;

        app.drawer.open({
            layout: 'create',
            context: {
                create: true,
                module: 'RevenueLineItems',
                model: model
            }
        }, _.bind(this.rliCreateClose, this));
    },

    /**
     * Callback for when the create drawer closes
     *
     * @param {Data.Bean} model
     */
    rliCreateClose: function (model) {
        var rliCtx;
        var ctx;

        if (!model) {
            return;
        }

        ctx = this.context;
        ctx.resetLoadFlag();
        ctx.set('skipFetch', false);
        ctx.loadData();

        // find the child collection for the RLI subpanel
        // if we find one and it has the loadData method, call that method to
        // force the subpanel to load the data.
        rliCtx = _.find(ctx.children, function (child) {
            return child.get('module') === 'RevenueLineItems';
        }, this);
        if (!_.isUndefined(rliCtx) && _.isFunction(rliCtx.loadData)) {
            rliCtx.loadData();
        }
    },

    /**
     * @inheritdoc
     */
    _dispose: function () {
        if (app.controller && app.controller.context) {
            app.controller.context.off('productCatalogDashlet:add', null, this);
        }

        this._super('_dispose');
    }
})
