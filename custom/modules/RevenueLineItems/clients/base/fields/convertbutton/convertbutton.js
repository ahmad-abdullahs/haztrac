/**
 * ClosebuttonField is a field for Meetings/Calls/Tasks that handles setting a value on a field in the model based on meta data with
 * an option to create a new record
 *
 * FIXME: This component will be moved out of clients/base folder as part of MAR-2274 and SC-3593
 *
 * @class View.Fields.Base.ConvertbuttonField
 * @alias SUGAR.App.view.fields.BaseConvertbuttonField
 * @extends View.Fields.Base.RowactionField
 */

({
    extendsFrom: 'RowactionField',

    /**
     * Setup click event handlers.
     * @inheritdoc
     *
     * @param {Object} options
     */
    initialize: function (options) {
        this.events = _.extend({}, this.events, options.def.events, {
            'click [name="record_convert"]': 'convertClicked'
        });

        this._super('initialize', [options]);
        this.type = 'rowaction';
    },

    /*
     * Disable the button if its the child RLI
     * @returns {undefined}
     */
    _render: function () {
        this._super('_render');

        if (this.model.get('is_bundle_product_c') == 'child') {
            this.disableListControl(this, {
                'name': 'record_convert',
            }, this.model);
        }
    },

    /**
     * Handle record convert to Product Template.
     *
     * @param {Event} event The click event for the convert button
     */
    convertClicked: function (event) {
        if (_.isEmpty(this.model.get('is_bundle_product_c')) || _.isNull(this.model.get('is_bundle_product_c'))) {
            this.openDrawerToConvertRecord();
        } else if (this.model.get('is_bundle_product_c') == 'parent') {
            // we need to open up the create view like record view
            // custom/modules/ProductTemplates/clients/base/views/record/record.js
            this.openDrawerToConvertBundleRecord();
        }
    },

    /**
     * Open a drawer to create a new Product Template record.
     */
    openDrawerToConvertRecord: function () {
        var rliBean;
        var self = this;
        var rliBean = app.data.createBean('RevenueLineItems', {
            id: this.model.get('id'),
        });
        rliBean.fetch({
            success: function (rliBean) {
                var module = 'ProductTemplates',
                        prefill = app.data.createBean(module);

                prefill.copy(rliBean);
                prefill.unset('id');

                app.drawer.open({
                    layout: 'create',
                    context: {
                        create: true,
                        model: prefill,
                        hideGroupCheckBox: true,
                        module: module,
                    }
                }, _.bind(self.loadParentView, self));
            },
            error: function (err) {
                app.logger.error('Failed to fetch RevenueLineItems Bean: ' + JSON.stringify(err));
            }
        });
    },

    openDrawerToConvertBundleRecord: function () {
        var rliBean;
        var self = this;
        var rliBean = app.data.createBean('RevenueLineItems', {
            id: this.model.get('id'),
        });
        rliBean.fetch({
            success: function (rliBean) {
                var module = 'ProductTemplates',
                        prefill = app.data.createBean(module);

                prefill.copy(rliBean);
                prefill.unset('id');

                app.drawer.open({
                    layout: 'convert-create',
                    context: {
                        create: true,
                        model: prefill,
                        module: module,
                        parentModelId: self.model.get('id'),
                    }
                }, _.bind(self.loadParentView, self));
            },
            error: function () {
                app.logger.error('Failed to fetch RevenueLineItems Bean: ' + JSON.stringify(err));
            }
        });
    },

    loadParentView: function () {
        if (this.parent) {
            this.parent.render();
        } else {
            this.render();
        }
    },
})
