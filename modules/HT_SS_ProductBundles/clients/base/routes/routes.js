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
(function(app) {
    app.events.on('router:init', function(router) {
        var routes = [
            {
                name: 'htProductBundlesList',
                route: 'HT_SS_ProductBundles',
                callback: function() {
                    app.router.redirect('#HT_SS_Quotes');
                }
            },
            {
                name: 'htProductBundlesCreate',
                route: 'HT_SS_ProductBundles/create',
                callback: function() {
                    app.router.redirect('#HT_SS_Quotes');
                }
            },
            {
                name: 'htProductBundlesRecord',
                route: 'HT_SS_ProductBundles/:id',
                callback: function(id) {
                    app.router.redirect('#HT_SS_Quotes');
                }
            }
        ];
        app.router.addRoutes(routes);
    });
})(SUGAR.App);
