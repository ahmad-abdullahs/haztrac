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
 * @class View.Fields.Base.HintNewsPreferencesTriggerField
 * @alias SUGAR.App.view.fields.BaseHintNewsPreferencesTriggerField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'ButtonField',

    events: {
        'click .hint-news-preferences-trigger': 'openNewsNotificationsPreferences'
    },

    openNewsNotificationsPreferences: function() {
        app.drawer.open({
            layout: 'stage2-news-preferences-drawer'
        });
    }
});
