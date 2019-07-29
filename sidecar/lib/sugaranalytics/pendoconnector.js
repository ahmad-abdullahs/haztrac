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
    app.analytics = app.analytics || {};
    app.analytics.connectors = app.analytics.connectors || {};

    app.analytics.connectors.Pendo  = {
        // disabling of IP address/geolocation tracking is handled by talking with Pendo directly
        // see https://help.pendo.io/resources/support-library/analytics/disable-ip-address-and-geo-location-logging.html

        /*
         * Called on app:init.
         *
         * @member SUGAR.App.analytics.connectors.Pendo
         */
        initialize: function() {
            // do nothing. pendo agent will be loaded by start() when id (apiKey) is available
        },

        /* 
         * Called on app:start, prepare or open the connection to the analytics system.
         *
         * @param {string} id Tracking id for the analytics system.
         * @param {Object} options SUGAR.App.config.analytics configuration.
         * @member SUGAR.App.analytics.connectors.Pendo
         */
        start: function (id, options) {
            // this code is taken directly from Pendo
            /* eslint-disable */
            (function(apiKey){
                (function(p,e,n,d,o){var v,w,x,y,z;o=p[d]=p[d]||{};o._q=[];
                    v=['initialize','identify','updateOptions','pageLoad'];for(w=0,x=v.length;w<x;++w)(function(m){
                        o[m]=o[m]||function(){o._q[m===v[0]?'unshift':'push']([m].concat([].slice.call(arguments,0)));};})(v[w]);
                    y=e.createElement(n);y.async=!0;y.src='https://cdn.pendo.io/agent/static/'+apiKey+'/pendo.js';
                    z=e.getElementsByTagName(n)[0];z.parentNode.insertBefore(y,z);})(window,document,'script','pendo');
            })(id);
            /* eslint-enable */
        },

        /*
         * Send user and account data.
         *
         * @member SUGAR.App.analytics.connector.Pendo
         */
        configure: function() {
            // user data
            var visitorId = app.user.get('site_user_id') || 'unknown_user';
            var userType = app.user.get('type') || 'unknown_user_type';
            var language = app.user.getLanguage() || 'unknown_language';
            var roles = app.user.get('roles');
            roles = Array.isArray(roles) ? (roles.length >= 1 ? roles.join(',') : 'no_roles') : 'unknown_roles';

            // account data
            var serverInfo = app.metadata.getServerInfo();
            var accountId = serverInfo.site_id || 'unknown_account';
            var siteUrl = _.isFunction(app.utils.getSiteUrl) ? app.utils.getSiteUrl() : 'unknown_domain';
            var version = serverInfo.version || 'unknown_version';
            var flavor = serverInfo.flavor || 'unknown_edition';

            pendo.initialize({
                visitor: {
                    id: visitorId,
                    user_type: userType,
                    language: language,
                    roles: roles
                },
                account: {
                    id: accountId,
                    domain: siteUrl,
                    edition: flavor,
                    version: version
                }
            });
        },

        /*
         * Track an activity.
         * 
         * Pendo auto-tracks most events.
         * You don't have to do this every single time you want to track something.
         * See https://help.pendo.io/resources/support-library/api/index.html?bash#track-events
         * @param {string} trackType Activity type.
         * @param {Object} trackData Activity metadata.
         * @member SUGAR.App.analytics.connectors.Pendo
         */
        track: function(trackType, trackData) {
            pendo.track(trackType, trackData);
        },

        /* 
         * Track a change of page.
         *
         * @param {string} pageUri Uri of the page viewed.
         * @member SUGAR.App.analytics.connectors.Pendo
         */
        trackPageView: function(pageUri) {
            // Pendo automatically collects page view data
            // see https://help.pendo.io/resources/support-library/api/index.html?bash#browser-interactions
        },

        /*
         * Track an event on the page.
         *
         * @param {Object} event Google Analytics event to track.
         * @param {string} event.category Category of the event.
         * @param {string} event.action Action of the event.
         * @param {string} event.label Always set to the route the user is on.
         * @param {number} [event.value] Value of the event.
         * @member SUGAR.App.analytics.connectors.Pendo
         */
        trackEvent: function(event) {
            // Pendo automatically collects some events
            // see https://help.pendo.io/resources/support-library/api/index.html?bash#browser-interactions
            // Pendo Agent API allows us to track more events if needed
            // see https://help.pendo.io/resources/support-library/api/index.html?bash#track-events
            // see app.analytics.track();
        },

        /*
         * Set tracker params.
         * 
         * Currently do nothing.
         * @param {string} key The param name.
         * @param {*} value The configuration value to send to the tracker.
         * @member SUGAR.App.analytics.connectors.Pendo
         */
        set: function(key, value) {
            // do nothing
        }
    };
})(SUGAR.App);
