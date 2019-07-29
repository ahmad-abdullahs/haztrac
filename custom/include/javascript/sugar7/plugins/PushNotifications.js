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
    app.events.on('app:init', function() {
        /**
         * Plugin for managing push notifications.
         * 
         * There are 2 mandatory properties to be set on the component in order for this plugin to work as expected:
         * @param {String} pushNotificationFilePath The path to the file that receives the push notifications.
         * @param {Function} saveSubscription The method which will save the subscription on the server for future use.
         */
        app.plugins.register('PushNotifications', ['layout', 'view'], {
            /**
             * Will be set through the plugin. The key is necessary when saving the subscription.
             */
            pushNotificationKey: '',

            /**
             * The name of the service worker file without extension.
             */
            pushNotificationFileName: '',

            /**
             * Set initial state.
             */
            onAttach: function(component) {
                if (this.areDependenciesSet()) {
                    this.initialize();
                } else {
                    app.alert.show('pushnotif_missing_dependencies', {
                        level: 'error',
                        messages: app.lang.get('LBL_HINT_PUSH_ERROR', null, component)
                    });
                }
            },

            /**
             * Verifies if the plugin's dependencies are implemented.
             */
            areDependenciesSet: function() {
                return typeof this.pushNotificationFilePath === 'string'
                    && this.pushNotificationFilePath.length > 0
                    && typeof this.saveSubscription === 'function';
            },

            initialize: function() {
                this.pushMessageSupport = this.hasPushMessagesSupport();
                if (this.pushMessageSupport) {
                    this.setPushNotificationFileName();
                    this.setPushNotificationKey();
                }
            },

            setPushNotificationFileName: function() {
                this.pushNotificationFileName = _.last(this.pushNotificationFilePath.split('/')).replace('.js', '');
            },

            /**
             * Retrieves the public key for registering the browser for push notifications.
             */
            setPushNotificationKey: function() {
                var self = this;
                app.api.call('GET', app.api.buildURL('stage2/params'), null, {
                    success: function(data) {
                        self.pushNotificationKey = data.pushNotificationKey;
                    },
                    error: function(err) {
                        app.logger.error('Failed to get Hint params: ' + JSON.stringify(err));
                    }
                });
            },

            /**
             * We need to check if permissions are needed, are granted and if worker is needed and
             * if it has been registered already for being able to receive push notifications.
             * 
             * @param {Function} denyPermissionCallback he action for when the user does not agree to ask him for permissions.
             */
            setupPushNotifications: function(denyPermissionCallback) {
                if (this.pushMessageSupport && this.pushNotificationKey) {
                    if (this.hasNotificationPermission()) {
                        this.checkWorkerRegistration();
                    } else {
                        this.warnAboutPermissionRequest(denyPermissionCallback);
                    }
                }
            },

            /**
             * Notify the user the we are about to request his permission to show push notifications.
             * 
             * @param {Function} onCancel Cancel callback.
             */
            warnAboutPermissionRequest: function(onCancel) {
                app.alert.show('pushrequest_confirmation', {
                    level: 'confirmation',
                    messages: app.lang.get('LBL_HINT_PUSH_MESSAGES_PERMISSION', this.module),
                    onConfirm: _.bind(this.handlePermissionConfirm, this),
                    onCancel: onCancel || $.noop
                });
            },

            /**
             * Request permission to show notifications and if granted,
             * check if the service has been registered and if not trigger registration.
             */
            handlePermissionConfirm: function() {
                var permission = this.requestPushNotificationPermission();
                permission.then(_.bind(this.checkWorkerRegistration, this));
            },

            /**
             * Request permission from the user to show push notifications.
             * There are 2 APIs versions of the same API.
             * Both versions are handled here.
             */
            requestPushNotificationPermission: function() {
                var self = this;
                return new Promise(function(resolve, reject) {
                    const permissionResult = Notification.requestPermission(function(result) {
                        resolve(result);
                    });

                    if (permissionResult) {
                        permissionResult.then(resolve, reject);
                    }
                }).then(function(permissionResult) {
                    if (permissionResult !== 'granted') {
                        if (self.handleDeniedPermission) self.handleDeniedPermission();
                        throw new Error('Permission was not granted.');
                    }
                });
            },

            /**
             * Checks if the service worker responsible of push notifications has been registered.
             * 
             * @param {Array} registrations The list of registered workers on the current browser.
             * @return {Boolean} True if the worker for push notifications is found.
             */
            hasRegisteredWorker: function(registrations) {
                var self = this;
                return _.some(registrations, function(registration) {
                    return registration.active.scriptURL.indexOf(self.pushNotificationFileName) > -1;
                });
            },

            /**
             * Checks if the service worker has been registered and if not, it will try to registed it.
             */
            checkWorkerRegistration: function() {
                var self = this;
                navigator.serviceWorker.getRegistrations().then(function(registrations) {
                    if (!self.hasRegisteredWorker(registrations)) {
                        self.registerServiceWorker()
                    }
                });
            },

            /**
             * Register the service worker for the current browser so
             * the user would be able to read notifications in the future.
             */
            registerServiceWorker: function() {
                navigator.serviceWorker
                    .register(this.pushNotificationFilePath)
                    .then(_.bind(this.handleRegisteredWorkerStates, this))
                    .catch(this.handleFailedWorkerRegistration);
            },

            /**
             * Have to check if the worker has been activated successfully.
             * If not, we need to wait until it gets activated before we subscribe the user.
             */
            handleRegisteredWorkerStates: function(registration) {
                var worker = registration.installing || registration.waiting || registration.active;

                if (worker) {
                    if (worker.state === 'activated') {
                        this.subscribeUserToPushNotifications(registration);
                    } else {
                        var self = this;
                        worker.addEventListener('statechange', function(event) {
                            if (event.target.state === 'activated') {
                                self.subscribeUserToPushNotifications(registration);
                            }
                        });
                    }
                }
            },

            /**
             * Here we subscribe he user for push notifications.
             * 
             * @param {Object} registration Service worker.
             */
            subscribeUserToPushNotifications: function(registration) {
                registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: this.urlBase64ToUint8Array(this.pushNotificationKey)
                })
                    .then(_.bind(this.saveSubscription || $.noop, this))
                    .catch(this.handleFailedWorkerRegistration);
            },

            handleFailedWorkerRegistration: function(error) {
                var message = error.message ? error.message : JSON.stringify(error);
                app.logger.error('An error occured while registering a service worker: '.concat(message));
            },

            /**
            * Encode the public key used to make the connection to the push service.
            * 
            * @param {string} base64String a public vavid key
            */
            urlBase64ToUint8Array: function(base64String) {
                const padding = '='.repeat((4 - base64String.length % 4) % 4);
                const base64 = (base64String + padding)
                    .replace(/\-/g, '+')
                    .replace(/_/g, '/');

                const rawData = window.atob(base64);
                const outputArray = new Uint8Array(rawData.length);

                for (let i = 0; i < rawData.length; ++i) {
                    outputArray[i] = rawData.charCodeAt(i);
                }
                return outputArray;
            },

            /**
             * If Navigator.serviceWorker and PushManager API is supported
             * the user may be able to support push notifications.
             * 
             * @return {Boolean} True if push messages are supported.
             */
            hasPushMessagesSupport: function() {
                return ('serviceWorker' in navigator) && ('PushManager' in window);
            },

            /**
             * Check if the user has already granted permission for push notifications.
             * 
             * @return {Boolean} True if we have permission.
             */
            hasNotificationPermission: function() {
                return Notification.permission === 'granted';
            }
        });
    });
})(SUGAR.App);
