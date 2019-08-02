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
 * @class View.Views.Dashboards.DashboardHeaderpaneView
 * @alias SUGAR.App.view.views.DashboardsDashboardHeaderpaneView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    extendsFrom: 'DashboardsDashboardHeaderpaneView',
    className: 'preview-headerbar',

    initialize: function (options) {
        this._super('initialize', [options]);
    },

    /**
     * Render the view manually.
     *
     * This function handles the responsibility typically handled in _render,
     * but unlike `_render`, it is not called automatically.
     *
     * See #_render for more information.
     */
    _renderHeader: function () {
        app.view.View.prototype._render.call(this);
        this._setButtons();
        this.setButtonStates(this.context.get('create') ? 'create' : 'view');
        this.setEditableFields();
        if(_.isNull(this.context.parent)){
            this.$el.find('.headerpane').css({top: 95});
            this.$el.parents('.dashboard').css({top: 50});
            this.$el.siblings('.btn-group').removeClass();            
        }
    },
})
