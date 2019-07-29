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
    /**
     * @class View.ComposeAddressbookListView
     * @alias SUGAR.App.view.views.ComposeAddressbookListView
     * @extends View.FlexListView
     */
    extendsFrom: 'FlexListView',
    plugins: ['ListColumnEllipsis', 'Pagination'],

    /**
     * Override to inject field names into the request when fetching data for the list.
     *
     * @param module
     * @returns {Array}
     */
    getFieldNames: function(module) {
        // id and module always get returned, so name and email just need to be added
        return ['name', 'email'];
    },
    /**
     * Override to force translation of the module names as columns are added to the list.
     *
     * @param field
     * @private
     */
    _renderField: function(field) {
        if (field.name == 'process_et_field_type') {
            field.setViewName('edit');
            field.action = 'edit';
        }
        if (field.name == '_module') {
            field.model.set(field.name, app.lang.get('LBL_MODULE_NAME', field.module));
        }
        this._super('_renderField', [field]);
    }
})
