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
    plugins: ['Stage2CssLoader'],

    css: ['hint-preview'],

    events: {
        'click [name=cancel_button]': 'closeDrawer',
        'click [name=save_button]': function() {
            app.events.trigger('hint:config:save');
        }
    },

    initialize: function() {
        this._super('initialize', arguments);
        this.title = this.context.get('title');
    },

    closeDrawer: function() {
        app.drawer.close();
        app.router.navigate(this.module, { trigger: true });
    }
});
