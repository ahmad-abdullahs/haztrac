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
 * @class View.Views.Base.FlexListView
 * @alias SUGAR.App.view.views.BaseFlexListView
 * @extends View.Views.Base.ListView
 */
({
    extendsFrom: 'FlexListView',
    className: 'flex-list-view',
    // Model being previewed (if any)
    _previewed: null,
    showOrderingIcon: false,

    /**
     * @inheritdoc
     */
    initialize: function (options) {
        this._super('initialize', [options]);
        if (this.context.parent) {
            if ((this.context.parent.get('module') == 'RevenueLineItems' || this.context.parent.get('module') == 'Accounts') &&
                    this.module == 'RevenueLineItems' &&
                    this.type == "subpanel-list") {
                this.showOrderingIcon = true;
            }
        }
    },

    /*
     * https://app.vivifyscrum.com/boards/71541/HPMB-228
     * This function was overrided to set the lastState of this._allListViewsFieldListKey, for instance
     * ["name","shipping_address_city","shipping_address_state","phone_office","ac_usepa_id_c"......]
     * @param {type} columns
     * @returns {undefined}
     */
    saveCurrentWidths: function (columns) {
        // Needed in order to fix the scroll helper whenever the widths change.
        this.resize();
        if (!this._thisListViewFieldListKey) {
            return;
        }
        var visibleFields = _.pluck(this._fields.visible, 'name');
        var decoded = {
            visible: visibleFields,
            widths: columns
        };
        var encoded = this._encodeCacheWidthData(decoded);
        this._toggleSettings('widths', true);

        /**
         * The list of user defined column widths for this specific view.
         *
         * @property {Array}
         * @protected
         */
        this._thisListViewFieldSizes = encoded;

        if (this._thisListViewFieldSizesKey) {
            app.user.lastState.set(this._thisListViewFieldSizesKey, encoded);
        }

        // Store new order if the order is changed #HPMB-228
        if (!_.isEmpty(app.user.lastState.get(this._thisListViewFieldListKey))) {
            var allField = _.pluck(this._fields.all, 'name');
            //Setting new order as base order to avoid messing up the widths
            app.user.lastState.set(this._allListViewsFieldListKey, allField);
        }
    }
})