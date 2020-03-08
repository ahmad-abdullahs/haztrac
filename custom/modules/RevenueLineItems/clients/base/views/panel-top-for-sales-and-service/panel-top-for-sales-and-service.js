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
    /**
     * @inheritdoc
     */
    className: 'subpanel-header',

    /**
     * @inheritdoc
     */
    attributes: {
        'data-sortable-subpanel': 'true'
    },

    /**
     * @inheritdoc
     */
    events: {
        'click': 'togglePanel',
        'click a[name=create_button]:not(".disabled")': 'createRelatedClicked',
        'click a[name=edit_all_button]:not(".disabled")': 'editAllRowClicked',
        'click a[name=save_all_button]:not(".disabled")': 'saveAllRowClicked',
        'click a[name=cancel_all_button]:not(".disabled")': 'cancelAllRowClicked',
        'keydown [data-a11y=toggle]': '_handleKeyClick'
    },

    plugins: ['LinkedModel'],
    showEditAll: false,

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
        if (_.contains(["sales_and_services"], this.parentModule)) {
            this.showEditAll = true;
        }
    },

    bindDataChange: function () {
        this._super("bindDataChange");
        if (this.collection) {
            this.collection.on('reset', function () {
                this.$el.find('a[name*=_all_button]:not("a[name=edit_all_button]")').hide();
                this.$el.find('a[name=edit_all_button]').show();
            }, this);
        }
    },

    editAllRowClicked: function (ele) {
        var self = this;
        $.when(this.triggerEdit()).then(function () {
            if (self.collection.models) {
                self.$(ele.target).hide();
                self.$(ele.target).parent().parent().find('a[name="save_all_button"]').show();
                self.$(ele.target).parent().parent().find('a[name="cancel_all_button"]').show();
            }
        });
    },

    triggerEdit: function () {
        if (this.collection.models) {
            _.each(this.collection.models, function (model) {
                this.context.parent.trigger('edit:full:subpanel:cstm', model, {'def': {}});
            }, this);
        }
    },

    saveAllRowClicked: function (ele) {
        var self = this;
        $.when(this.triggerSave()).then(function () {
            if (self.collection.models) {
                self.$(ele.target).hide();
                self.$(ele.target).parent().parent().find('a[name="cancel_all_button"]').hide();
                self.$(ele.target).parent().parent().find('a[name="edit_all_button"]').show();
            }
        });
    },

    triggerSave: function () {
        if (this.collection.models) {
            this.context.parent.trigger('save:full:subpanel:cstm');
        }
    },

    cancelAllRowClicked: function (ele) {
        var self = this;
        $.when(this.triggerCancel()).then(function () {
            if (self.collection.models) {
                self.$(ele.target).hide();
                self.$(ele.target).parent().parent().find('a[name="save_all_button"]').hide();
                self.$(ele.target).parent().parent().find('a[name="edit_all_button"]').show();
            }
        });
    },

    triggerCancel: function () {
        if (this.collection.models) {
            this.context.parent.trigger('cancel:full:subpanel:cstm');
        }
    },

    openCreateDrawer: function (module, link) {
        link = link || this.context.get('link');
        //FIXME: `this.context` should always be used - SC-2550
        var context = (this.context.get('name') === 'tabbed-dashlet') ?
                this.context : (this.context.parent || this.context);
        var parentModel = context.get('model') || context.parent.get('model'),
                model = this.createLinkModel(parentModel, link),
                self = this;

        var groupItemUsageAllowed = false;

        if (this.parentModule == 'Accounts') {
            groupItemUsageAllowed = true;
        }

        var parentModule = parentModel.module || parentModel.get("module") || parentModel.get("_module");
        if (parentModule == "sales_and_services") {
            model.set('account_name', parentModel.get('accounts_sales_and_services_1_name'));
            model.set('account_id', parentModel.get('accounts_sales_and_services_1accounts_ida'));
        }
        if (parentModule == "RevenueLineItems") {
            model.set('account_name', parentModel.get('account_name'));
            model.set('account_id', parentModel.get('account_id'));
            model.set('revenuelineitems_revenuelineitems_1revenuelineitems_ida', parentModel.get('id'));
            model.set('revenuelineitems_revenuelineitems_1_name', parentModel.get('name'));
            model.set('sales_and_services_revenuelineitems_1_name', parentModel.get('sales_and_services_revenuelineitems_1_name'));
            model.set('sales_and_services_revenuelineitems_1sales_and_services_ida', parentModel.get('sales_and_services_revenuelineitems_1sales_and_services_ida'));
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
})
