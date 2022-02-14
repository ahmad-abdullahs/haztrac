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

SUGAR.App.events.on('router:init', function () {
    if (!_.isEmpty(SUGAR.App.user.get('user_name'))) {
        var current_user = SUGAR.App.user.id;
        $.ajax({
            url: 'index.php?module=Home&action=getcustompreferences&sugar_body_only=true&to_pdf=true',
            type: 'GET',
            success: function (response) {
                var response = JSON.parse(response);
                if (!_.isEmpty(response)) {
                    var timestampBrowser = localStorage.getItem('prod:SugarCRM:' + current_user + 'user_custom_prefs_timestamp') || '';
                    var timestampDB = response['timeStamp'];
                    if (response['prefs'] !== '[]' && (_.isEmpty(timestampBrowser) || timestampDB > timestampBrowser)) {
                        localStorage.setItem('prod:SugarCRM:' + current_user + 'user_custom_prefs_timestamp', Date.now());
                        SUGAR.App.cache.set(current_user + 'user_custom_prefs_timestamp', Date.now());
                        _.each(response['prefs'], function (value, key) {
                            if (!_.isEmpty(value)) {
                                SUGAR.App.cache.set(key.replace('prod:SugarCRM:', ''), value);
                                localStorage.setItem(key, value);
                            }
                        }, this);
                        
                        // Added to reload the page to apply the preference because when the direct link
                        // http://127.0.0.1/haztrac/#{module_name} is loaded, it unfortunately dont apply
                        // the preferences and we have to reload the page.
                        SUGAR.App.router.refresh();
                    }
                }
            }
        });
    }
});