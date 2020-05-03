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
 * @class View.Views.Base.Calls.CreateView
 * @alias SUGAR.App.view.views.CallsCreateView
 * @extends View.Views.Base.CreateView
 */
({
    extendsFrom: 'CreateView',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        var self = this;
        this._super('initialize', [options]);
        app.api.call('read', app.api.buildURL('getVendorPartNum'), {}, {
            success: function (data) {
                self.model.set('vendor_part_num', data);
            },
            error: function (e) {
                throw e;
            }
        });

        this.model.on('change:is_group_item_c', _.bind(this.setCategory, this));
    },

    render: function () {
        this._super('render');

        var is_group_item_c = this.getField('is_group_item_c');
        // When creating the Product Template Bundle or Group, set the is_bundle_product_c value to trigger the change.
        // So that it should hide the fields, panels and tabs.
        if (_.has(app.router, 'productGroupCreation') && app.router.productGroupCreation) {
            this.model.set('is_bundle_product_c', 'parent');
            // this.model.trigger('change:is_bundle_product_c');
            // If Group then set the is_group_item_c checked and readonly
            this.model.set('is_group_item_c', true);
            if (is_group_item_c) {
                is_group_item_c.setDisabled(true);
            }
        }

        if (_.has(app.router, 'productBundleCreation') && app.router.productBundleCreation) {
            this.model.set('is_bundle_product_c', 'parent');
            // this.model.trigger('change:is_bundle_product_c');
            // If Bundle hide the is_group_item_c checkbox.            
            this.model.set('is_group_item_c', false);
            if (is_group_item_c) {
                is_group_item_c.hide();
                is_group_item_c.$el.parents('div:first').addClass('vis_action_hidden');
            }
        }

        if (this.context) {
            if (this.context.get('hideGroupCheckBox') == true) {
                // In create we are creating the Product Template, 
                // so there is no need of is_group_item_c field to show.
                var is_group_item_c = this.getField('is_group_item_c');
                if (is_group_item_c) {
                    is_group_item_c.hide();
                    is_group_item_c.$el.parents('div:first').addClass('vis_action_hidden');
                }
            }
        }
    },

    setCategory: function (model, value) {
        if (value) {
            var self = this;
            var productTemplatesBean = app.data.createBean('ProductCategories', {
                id: 'e800d96a-6194-11ea-9e13-000c29e77cbc'
            });
            productTemplatesBean.fetch({
                success: function (bean) {
                    self.model.set('category_id', bean.get('id'));
                    self.model.set('category_name', bean.get('name'));
                },
            });
        } else {
            this.model.set('category_id', '');
            this.model.set('category_name', '');
        }
    },

    _dispose: function () {
        // Delete productBundleCreation, productGroupCreation so that, if simple Product Template is created after 
        // creating a bundle or Group, It should not be miss guided.
        delete app.router.productBundleCreation;
        delete app.router.productGroupCreation;
        this._super('_dispose');
    },
})
