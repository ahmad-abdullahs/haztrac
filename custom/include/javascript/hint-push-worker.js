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
self.addEventListener('notificationclick', event => {
    event.notification.close();
    event.waitUntil(clients.openWindow(event.notification.data.sourceUrl));
});

self.addEventListener('push', function(event) {
    const promiseChain = self.showNotification(event);
    event.waitUntil(promiseChain);
});

function showNotification(event) {
    return new Promise(resolve => {
        /*
        //TODO: This would enable custom actions, however these are not supported on all platforms. Needs research and approoval.
        const actions = [{
            'action': 'yes', 'title': 'Yes', 'icon': '/images/hint-logo-square.png'
        }, {
            'action': 'no', 'title': 'No', 'icon': '/images/hint-logo-square.png'
        }];
        */
        const { title, tag, data } = JSON.parse(event.data.text());
        self.registration.getNotifications({ tag })
            .then(existingNotifications => {
                if (existingNotifications.length > 0) {
                    const notification = existingNotifications[0];
                    const options = {
                        //actions: actions,
                        tag: notification.tag,
                        body: notification.body,
                        image: notification.image,
                        data: notification.data,
                        icon: notification.icon
                    };
                    self.registration.showNotification(notification.title, options);
                    resolve();
                }
            })
            .then(() => {
                return self.registration.showNotification(title, {
                    //actions: actions,
                    tag: data.tag,
                    body: data.body,
                    icon: data.logoUrl,
                    image: data.logoUrl,
                    data: data
                });
            })
            .then(resolve);
    })
}
