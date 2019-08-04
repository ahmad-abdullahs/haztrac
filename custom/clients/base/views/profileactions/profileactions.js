/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
({
    extendsFrom: 'ProfileactionsView',
    initialize: function (options) {
        this._super('initialize', [options]);
        this.events = _.extend({}, this.events, {
            'click .profileactions-save-prefrences': 'updateProfilePreferences',
        });
    },
    /*
     * Save user preference to database
     * 
     * @returns {undefined}
     */
    updateProfilePreferences: function (evt) {
        var current_user = app.user.id;
        evt.preventDefault();
        evt.stopPropagation();
        app.alert.show('save_prefrences_confirmation', {
            level: 'confirmation',
            messages: 'LBL_SAVE_PREFERENCE_MSG',
            onConfirm: function () {
                var url = app.api.buildURL(current_user, 'savecustompreferences');
                var prefs = {
                    'user_custom_timestamp': Date.now(),
                };

                _.each(localStorage, function (_val, _key) {
                    if (localStorage.key(_key).includes(current_user + ':last-state')) {
                        prefs[localStorage.key(_key)] = localStorage.getItem(localStorage.key(_key));
                    }
                });

                app.api.call('create', url, prefs, {
                    success: _.bind(function (response) {
                        app.user.setPreference('user_custom_prefs', prefs);
                        app.user.setPreference(current_user + 'user_custom_prefs_timestamp', Date.now());
                        app.cache.set(current_user + 'user_custom_prefs_timestamp', Date.now());
                        app.alert.show('success_save', {
                            level: 'success',
                            messages: 'LBL_PREFERENCE_SAVED_MSG',
                            autoClose: true
                        });
                    }, this)
                });
            },
            onCancel: function () {
            }
        });
    },
})