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
 * @class View.Views.Base.Stage2NewsPreferencesHeaderpaneView
 * @alias SUGAR.App.view.views.BaseStage2NewsPreferencesHeaderpaneView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    events: {
        'click a[name=cancel_button]': 'close',
        'click a[name=save_button]': 'save'
    },

    /**
     * @inheritdoc
     * Add shortcuts for the save and close buttons.
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        app.shortcuts.register({
            id: 'Stage2:News:Preferences:Cancel',
            keys: ['esc', 'mod+alt+l'],
            component: this,
            description: 'LBL_SHORTCUT_CLOSE_DRAWER',
            callOnFocus: true,
            handler: function() {
                var $cancelButton = this.$('a[name=cancel_button]');
                if ($cancelButton.is(':visible') && !$cancelButton.hasClass('disabled')) {
                    $cancelButton.click();
                }
            }
        });

        app.shortcuts.register({
            id: 'Stage2:News:Preferences:Save',
            keys: ['mod+s', 'mod+alt+a'],
            component: this,
            description: 'LBL_SHORTCUT_RECORD_SAVE',
            callOnFocus: true,
            handler: function() {
                var $saveButton = this.$('a[name=save_button]');
                if ($saveButton.is(':visible') && !$saveButton.hasClass('disabled')) {
                    $saveButton.click();
                }
            }
        });
    },

    save: function() {
        app.events.trigger('news-preferences:save');
    },

    close: function() {
        app.events.trigger('news-preferences:cancel');
    }
});
