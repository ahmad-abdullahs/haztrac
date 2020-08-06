/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 *
 * @class View.Fields.Base.RelateField
 * @alias SUGAR.App.view.fields.BaseRelateField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'RelateField',

    initialize: function (options) {
        this._super("initialize", [options]);
    },

    getFilterOptions: function (force) {
        if (this._filterOptions && !force) {
            return this._filterOptions;
        }

        this._filterOptions = new app.utils.FilterOptions().config({
            'initial_filter': 'filterByCompetitor',
            'initial_filter_label': 'LBL_FILTER_BY_COMPETITOR',
            'filter_populate': {
                'account_type_cst_c': ['Competitor'],
            }
        }).format();
        return this._filterOptions;
    },
})
