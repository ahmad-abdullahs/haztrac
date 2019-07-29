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
 * @class View.Views.Base.HintAccountsets.DashletconfigurationHeaderpaneView
 * @alias SUGAR.App.view.views.BaseHintAccountsetsDashletconfigurationHeaderpaneView
 * @extends View.Views.Base.DashletconfigurationHeaderpaneView
 */
({
    extendsFrom: 'DashletconfigurationHeaderpaneView',

    events: {
        'click a[name=save_button]': 'initSave',
        'click a[name=cancel_button]': 'initClose'
    },

    /**
     * @inheritdoc
     * From an UI perspective we have a single Save and Cancel button for dashlet configuration.
     * In reality (in the backround) we have 2 for each. In case of the save button: one will save
     * the configuration, the other will add the dashlet. It is similar for the cancel button.
     * The buttons from the UI are children of this component - the other set is not visible and are
     * children of the news preferences layout and handle the more complex configuration logic.
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.initModelValues();
        this.bindNewsPreferencesEvents();
    },

    /**
     * The first phase of adding the dashlet. An event will be triggered which has to be caught by the
     * news preferences layout, which will run the more complex logic of saving the configuration.
     */
    initSave: function() {
        app.events.trigger('news-preferences:save', 'save');
    },

    /**
     * The first phase of canceling the add of the dashlet. An event will be triggered which has to be
     * caught by the news preferences layout, which will check if there are any unsaved configurations.
     */
    initClose: function() {
        app.events.trigger('news-preferences:cancel', 'cancel');
    },

    /**
     * We set the hint insights dashlet config here
     * so on save the dashlet could be generated automatically.
     */
    initModelValues: function() {
        this.model.set({
            componentType: 'view',
            config: true,
            label: 'LBL_HINT_NEWS_ALERT',
            limit: 20,
            module: 'Home',
            type: 'hint-news-dashlet'
        }, { silent: true });
    },

    /**
     * After the news preferences save/cancel logic has been executed, events will be
     * triggered and caught by the following listeners. The defaut save/close methods will be executed.
     */
    bindNewsPreferencesEvents: function() {
        app.events.on('dashletconfig:news-preferences:save', _.bind(this.save, this));
        app.events.on('dashletconfig:news-preferences:cancel', _.bind(this.close, this));
    },

    /**
     * @inheritdoc
     * Have to detach events listening to configuration save/cancel logic events.
     */
    _dispose: function() {
        app.events.off('dashletconfig:news-preferences:save');
        app.events.off('dashletconfig:news-preferences:cancel');
        this._super('_dispose');
    }
})
