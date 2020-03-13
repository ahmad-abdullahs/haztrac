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
})
