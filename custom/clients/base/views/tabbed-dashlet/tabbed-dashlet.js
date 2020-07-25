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
 * Tabbed dashlet is an abstraction that allows new tabbed dashlets to be
 * easily created based on a metadata driven configurable set of tabs, where
 * each new tab is created under a tabs array, where a specific set of
 * properties can be defined.
 *
 * Supported properties:
 *
 * - {Boolean} active If specific tab should be active by default.
 * - {String} filter_applied_to Date field to be used on date switcher, defaults
 *   to date_entered.
 * - {Array} filters Array of filters to be applied.
 * - {String} label Tab label.
 * - {Array} labels Array of labels (singular/plural) to be applied when
 *   LBL_MODULE_NAME_SINGULAR and LBL_MODULE_NAME aren't available or there's a
 *   need to use custom labels depending on the number of records available.
 * - {String} link Relationship link to be used if we're on a record view
 *   context, leading to only associated records being shown.
 * - {String} module Module from which the records are retrieved.
 * - {String} order_by Sort records by field.
 * - {String} record_date Date field to be used to print record date, defaults
 *   to 'date_entered' if none supplied.
 * - {Array} row_actions Row actions to be applied to each record.
 *
 * Example:
 * <pre><code>
 * // ...
 * 'tabs' => array(
 *     array(
 *         'filter_applied_to' => 'date_entered',
 *         'filters' => array(
 *             'type' => array('$equals' => 'out'),
 *         ),
 *         'labels' => array(
 *             'singular' => 'LBL_DASHLET_EMAIL_OUTBOUND_SINGULAR',
 *             'plural' => 'LBL_DASHLET_EMAIL_OUTBOUND_PLURAL',
 *         ),
 *         'link' => 'emails',
 *         'module' => 'Emails',
 *     ),
 *     //...
 * ),
 * //...
 * </code></pre>
 *
 * @class View.Views.Base.TabbedDashletView
 * @alias SUGAR.App.view.views.BaseTabbedDashletView
 * @extends View.View
 */
({
    extendsFrom: 'TabbedDashletView',
    hideHTML: false,

    initialize: function (options) {
        this._super('initialize', [options]);
        if ((this.action == "pending-activities" /*|| this.action == "account-history"*/) && this.module == "Accounts") {
            this.hideHTML = true;
        }
    },

    _renderHtml: function () {
        this._super('_renderHtml');

        if ((this.action == "pending-activities" /*|| this.action == "account-history"*/) && this.module == "Accounts") {
            var button = this.$el.find('div.control-group.dashlet-options');
            button.css("padding", "3px 0px 0px 0px");
            this.layout.$el.find('#customToolbarButtons').html(button);
        }
    },
})
