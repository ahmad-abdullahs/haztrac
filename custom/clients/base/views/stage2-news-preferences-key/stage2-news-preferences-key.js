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
    extendsFrom: 'BaseView',

    plugins: ['Stage2CssLoader'],

    css: ['hint-notifications'],

    setKeys: function() {
        this.keys = [{
            icon: 'newspaper-o',
            title: app.lang.get('LBL_NOTIFICATIONS_KEY_TITLE_DASHLET')
        }, {
            icon: 'bell',
            title: app.lang.get('LBL_NOTIFICATIONS_KEY_TITLE_BROWSER'),
            details: app.lang.get('LBL_NOTIFICATIONS_KEY_DESCR_BROWSER')
        }, {
            icon: 'bell-slash',
            disabledClass: 'icon-disabled',
            details: app.lang.get('LBL_NOTIFICATIONS_KEY_DESCR_BROWSER_DISABLED')
        }, {
            icon: 'envelope',
            title: app.lang.get('LBL_NOTIFICATIONS_KEY_TITLE_EMAIL')
        }, {
            icon: 'calendar-o',
            title: app.lang.get('LBL_NOTIFICATIONS_KEY_TITLE_DAILY'),
            iconStack: '1'
        }, {
            icon: 'calendar-o',
            title: app.lang.get('LBL_NOTIFICATIONS_KEY_TITLE_WEEKLY'),
            iconStack: '7'
        }];
    },

    _render: function() {
        this.setKeys();
        this._super('_render');
    }
});
