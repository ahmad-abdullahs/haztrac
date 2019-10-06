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
 * @class View.Views.Base.Home.WebpageView
 * @alias SUGAR.App.view.views.BaseHomeWebpageView
 * @extends View.View
 */
({
    extendsFrom: 'HomeWebpageView',
    _render: function () {
        if (!this.meta.config) {
            this.dashletConfig.view_panel[0].height = this.settings.get('limit') * this.rowHeight;
        }
        app.view.View.prototype._render.call(this);
        // Remove the class which restrict the height of dashlet.
        if (!_.isUndefined(this.meta) && this.meta.type == 'webpage') {
            var url = this.meta.url;
            if (url.includes('vivifyscrum') || url.includes('petroleum')) {
                this.$el.parent().removeClass();
                this.$el.children().find('iframe').height($(document).height() - 200);
            }
        }
    },
})
