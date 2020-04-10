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
 * @class View.Views.Base.DashletToolbarView
 * @alias SUGAR.App.view.views.BaseDashletToolbarView
 * @extends View.View
 */
({
    extendsFrom: 'DashletToolbarView',
//    showRefreshButton: false,
//    events: {
//        'shown.bs.dropdown': '_toggleAria',
//        'hidden.bs.dropdown': '_toggleAria',
//        'click [name=custom_refresh_button]': 'refreshClicked',
//    },
//
//    initialize: function (options) {
//        this._super('initialize', [options]);
//        if (this.options.layout.meta.components[0]) {
//            if (this.options.layout.meta.components[0].view.url) {
//                var url = this.options.layout.meta.components[0].view.url;
//                if (this.options.context.parent.get('module') == 'LR_Lab_Reports' && url.search("Lab_Report_Preview") != -1) {
//                    this.showRefreshButton = true;
//                }
//            }
//        }
//    },

    popOutFullView: false,
    popOutFullViewLink: 'javascript:void(0);',
    events: {
        'shown.bs.dropdown': '_toggleAria',
        'hidden.bs.dropdown': '_toggleAria',
    },

    initialize: function (options) {
        this._super('initialize', [options]);
        if (this.options.context.parent.get('module') == 'LR_Lab_Reports') {
            if (this.options.layout.meta.components[0]) {
                if (this.options.layout.meta.components[0].view.url) {
                    this.popOutFullView = this.options.context.parent.get('model').get('fileExist');
                    this.popOutFullViewLink = this.options.context.parent.get('model').get('popOutFullViewLink');
                }
            }
        }
    },

    /**
     * Change to the spinning icon to indicate that loading process is triggered
     */
    refreshClicked: function () {
        var $el = this.$('[data-action=loading]');
        var self = this;
        var options = {};
        if ($el.length > 0) {
            $el.removeClass(this.cssIconDefault).addClass(this.cssIconRefresh);
            options.complete = function () {
                if (self.disposed) {
                    return;
                }
                $el.removeClass(self.cssIconRefresh).addClass(self.cssIconDefault);
            };
        }
        this.layout.reloadDashlet(options);
    },
})
