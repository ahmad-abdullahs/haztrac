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
 * Rowaction is a button that when selected will trigger a Backbone Event.
 *
 * @class View.Fields.Base.RowactionField
 * @alias SUGAR.App.view.fields.BaseRowactionField
 * @extends View.Fields.Base.ButtonField
 */
({
    /*
     * Row Action is customized application wide in order to stop the bundle row 
     * items to be edited through the list and subpanel view.
     */
    extendsFrom: 'RowactionField',

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this.plugins = _.union(this.plugins || [], ['FieldUtils']);
        this._super('initialize', [options]);
    },

    /*
     * We disabled the edit button in case the row is the parent bandle...
     * We can even hide the button through the function
     * _render: function () {
     *       if (model.get('is_bundle_product_c') == 'parent') {
     *           this.hide();
     *       } else {
     *           this._super('_render');
     *       }
     *   }, 
     */
    _render: function () {
        this._super('_render');
        // ++ This code is added to prevent the edit button from getting disabled 
        // when Revenue Line item is opened in the drawer...
        if (this.model.get('is_bundle_product_c') == 'parent') {
            if (!_.isUndefined(this.context.get('openInDrawer')) && !_.isNull(this.context.get('openInDrawer'))) {
                var openInDrawer = this.context.get('openInDrawer') || false;
                if (openInDrawer) {
                    return;
                }
            } else {
                this.disableListControl(this, {
                    'name': 'edit_button',
                }, this.model);
            }
        }
    },
})
