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
 * Module menu provides a reusable and easy render of a module Menu.
 *
 * This also helps doing customization of the menu per module and provides more
 * metadata driven features.
 *
 * @class View.Views.Base.Users.ModuleMenuView
 * @alias SUGAR.App.view.views.BaseUsersModuleMenuView
 * @extends View.Views.Base.ModuleMenuView
 */
({
    extendsFrom: 'ModuleMenuView',

    handleRouteEvent: function(event) {
        if (App.config.idmModeEnabled && (event.target.getAttribute('data-navbar-menu-item') == 'LNK_NEW_USER')) {
            App.alert.show('idm_create_user', {
                level: 'info',
                messages: App.lang
                    .get('ERR_CREATE_USER_FOR_IDM_MODE', 'Users')
                    .replace('{0}', this.meta.cloudConsoleLink)
            });
        }
        this._super('handleRouteEvent', [event]);
    }
})
