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
 * Actionmenu is an {@link View.Fields.Base.ActiondropdownField actiondropdown}
 * with a checkbox as the default action.
 *
 * Supported Properties:
 *
 * - {Boolean} disable_select_all_alert Boolean telling if we should show the
 *   'select all' and 'clear all' alerts when all checkboxes are checked.
 *   `true` to hide alerts. `false` to display them. Defaults to `false`.
 *
 * @class View.Fields.Base.ActionmenuField
 * @alias SUGAR.App.view.fields.BaseActionmenuField
 * @extends View.Fields.Base.ActiondropdownField
 */
({
    extendsFrom: 'ActionmenuField',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    toggleSelect: function (checked) {
        var event = !!checked ? 'mass_collection:add' : 'mass_collection:remove';
        this.context.trigger(event, this.model);
        this.addMapFilter();
    },

    toggleAll: function (checked) {
        var event = checked ? 'mass_collection:add:all' : 'mass_collection:remove:all';
        this.context.trigger(event, this.model);
        this.addMapFilter();
    },

    /*
     * When the row is selected on the sales and service list view.
     * It will get the selected row ids and call the app level trigger to
     * notify the dashlet to load the appropriate records on the Map. 
     */
    addMapFilter: function () {
        var ids = [];
        _.each(this.$el.parents('tbody').children('tr'), function (ele, key) {
            var $checkbox = $(ele).find('input[type=checkbox]');
            if ($checkbox.is(':checked')) {
                var trName = $(ele).attr('name');
                var trNameArr = trName.split('_');
                var id = trNameArr[trNameArr.length - 1];
                if (id) {
                    ids.push(id);
                }
            }
        });

        app.events.trigger('loadMapForSelectedRows', ids);
    },

})
