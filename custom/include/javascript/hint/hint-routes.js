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
SUGAR.App.events.on('router:init', function() {
    SUGAR.App.router.route('hint/data-enrichment', 'hint-data-enrichment', function() {
        SUGAR.App.drawer.open({
            layout: 'hint-data-enrichment-drawer',
            context: {
                model: SUGAR.App.data.createBean('Accounts'),
                title: SUGAR.App.lang.get('LBL_HINT_CONFIG_TITLE')
            }
        });
    });

    SUGAR.App.router.route('hint/config', 'hint-config', function() {
        SUGAR.App.drawer.open({
            layout: 'hint-config-drawer',
            context: {
                model: SUGAR.App.data.createBean(),
                title: SUGAR.App.lang.get('LBL_HINT_CONFIG_TITLE', 'Administration')
            }
        });
    });

    SUGAR.App.router.route('hint/insights/resync', 'hint-insights-resync', function() {
        SUGAR.App.alert.show('resync_warning', {
            level: 'confirmation',
            title: SUGAR.App.lang.get('LBL_HINT_RESYNC_NOTIFICATION_TITLE', 'Administration'),
            messages: SUGAR.App.lang.get('LBL_HINT_RESYNC_NOTIFICATION_DESCRIPTION', 'Administration'),
            onConfirm: function() {
                console.log('Do something for resync confirm');
                SUGAR.App.api.call('create', SUGAR.App.api.buildURL('hint/insights/resync'), {}, {
                    success: function() {
                        console.log('Success resyncing Hint');
                        SUGAR.App.router.navigate('', { trigger: false });
                    },
                    error: function(err) {
                        console.log('Error resyncing Hint', err);
                        SUGAR.App.router.navigate('', { trigger: false });
                    }
                });
            },
            onCancel: function() {
                SUGAR.App.router.navigate('', { trigger: false });
            }
        });
    });
});
