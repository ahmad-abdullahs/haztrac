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
 * @class View.Layouts.Base.Stage2NewsPreferencesLayout
 * @alias SUGAR.App.view.layouts.BaseStage2NewsPreferencesLayout
 * @extends View.Layout
 */
({
    plugins: ['Stage2CssLoader', 'PushNotifications'],

    css: ['hint-notifications'],

    pushNotificationFilePath: './custom/include/javascript/hint-push-worker.js',

    events: {
        'click [data-action=addNewPreference]': 'addNewPreference'
    },

    minNrofPreferences: 1,

    maxNrofPreferences: 20,

    targetFields: ['sugar', 'browser', 'email-immediate', 'email-daily', 'email-weekly'],

    /**
     * Event name indicating dashlet configuration phase.
     * This flag is used exclusively by the dashlet configuration headerpane.
     * It allows us to detect if the drawer will be close by the configuration view
     * or needs to be closed from this layout.
     */
    configurationEvent: '',

    /**
     * Used for adding empty records to the layout.
     */
    newPreferenceTemplate: {
        'type': '',
        'category': '',
        'tag': [],
        'sugar': false,
        'browser': false,
        'email-immediate': false,
        'email-daily': false,
        'email-weekly': false
    },

    /**
     * @inheritdoc
     */
    initialize: function(opts) {
        this._super('initialize', [opts]);
        this.loadPreferences();
        this.bindEventHandlers();
    },

    bindEventHandlers: function() {
        app.events.on('news-preference:remove', _.bind(this.removePreference, this));
        app.events.on('news-preferences:cancel', _.bind(this.handleDrawerCancel, this));
        app.events.on('news-preferences:save', _.bind(this.initPreferencesSync, this));
        app.events.on('news-preference:enable-notifications', _.bind(this.handleBrowserTargetSelect, this));
    },

    /**
     * Creates a new collection of preferences, sets the
     * collection's initial state and loads the preferences.
     */
    loadPreferences: function() {
        this.collection = app.data.createBeanCollection('HintAccountsets');
        this.collection.pref_delete = [];
        this.collection.nrOfChanges = 0;
        this.collection.orderBy = {
            field: 'date_entered',
            direction: 'asc'
        };
        this.collection.fetch({
            myItems: true,
            success: _.bind(this.processPreferences, this)
        });
    },

    /**
     * Sets up the initial state of the preferences and the preferences UI.
     */
    processPreferences: function() {
        this.extendModels();
        this.checkNotificationSetup();
        _.each(this.collection.models, this.renderPreference, this);
        this.toggleButtons();
    },

    /**
     * Creates a preference row dynamically and renders it on the page.
     *
     * @param {Backbone.Model} model Representation of a user preference.
     */
    renderPreference: function(model) {
        var view = app.view.createView({
            layout: this,
            model: model,
            module: this.module,
            context: this.context,
            type: 'stage2-news-preference',
            pushMessages: this.pushMessageSupport
        });
        this.addComponent(view);
        view.render();
    },

    /**
     * @inheritdoc
     *
     * @override Place a preference row into the DOM, right before the add button.
     *
     * @param {Object} component
     */
    _placeComponent: function(component) {
        if (this.disposed) return;
        this.$el.find('.stage2-notifications-emptyline').before(component.el);
    },

    /**
     * Updates the layout control buttons (Add button and Remove button).
     * While there are at least 20 preferences, the add button has to be disabled.
     * While there is only 1 preference, the remove button has to be disabled.
     * In any other cases all buttons should be enabled.
     */
    toggleButtons: function() {
        var nrOfRecords = this.collection.models.length;

        if (nrOfRecords === 1) {
            this.$('.stage2-notification-pref-removebtn.real').addClass('hide');
            this.$('.stage2-notification-pref-removebtn.fake').removeClass('hide');
        } else if (nrOfRecords > 19) {
            this.$('.stage2-notification-pref-addbtn.real').addClass('hide');
            this.$('.stage2-notification-pref-addbtn.fake').removeClass('hide');
        } else {
            this.$('.stage2-notification-pref-addbtn.fake').addClass('hide');
            this.$('.stage2-notification-pref-addbtn.real').removeClass('hide');
            this.$('.stage2-notification-pref-removebtn.fake').addClass('hide');
            this.$('.stage2-notification-pref-removebtn.real').removeClass('hide');
        }
    },

    /**
     * Adds a new preference dynamically to the layout and collection.
     * The layout control buttons have to be updated to reflect the correct status after the addition.
     */
    addNewPreference: function() {
        if (this.collection.models.length < this.maxNrofPreferences) {
            var newPreference = app.data.createBean('HintAccountsets', this.newPreferenceTemplate);
            newPreference.setDefault({
                'assigned_user_id': app.user.id,
                'assigned_user_name': app.user.get('full_name')
            });
            this.collection.add(newPreference);
            this.renderPreference(newPreference);
            this.toggleButtons();
        }
    },

    /**
     * Remove a preference from the layout and collection.
     * The layout control buttons have to be updated to reflect the correct status after the removal.
     *
     * @param {View/View} view A view representing a preference setting.
     * @param {String} cid The component Id of the view.
     */
    removePreference: function(view, cid) {
        if (this.collection.models.length > this.minNrofPreferences) {
            var preferenceRecord = _.findWhere(this.collection.models, { cid: cid });
            if (preferenceRecord.id) {
                this.collection.pref_delete.push(preferenceRecord);
            }
            this.collection.remove(preferenceRecord);
            this.removeComponent(view);
            this.toggleButtons();
            view.dispose();
        }
    },

    /**
     * Checks each model for changes and makes a summary of the different changes that have been made.
     * If a model has no id yet, it means that it was just created. Else if it is changed, an update is necessary.
     */
    setCollectionDelta: function() {
        this.collection.pref_update = _.filter(this.collection.models, function(model) {
            return model.hasChanged();
        });

        this.collection.nrOfChanges = this.collection.pref_update.length + this.collection.pref_delete.length;
    },

    /**
     * Increments the counter that shows the number of changes that have been saved.
     * If all saves have been run, the drawer will be closed.
     * Note: result may not have a status if a bean is returned.
     * 
     * @param {Bean} model The preference that has been saved/deleted.
     * @param {Object} result Response results (model attributes OR error info).
     */
    updateSyncProgress: function(model, result) {
        this.completedRequests++;
        this.hasErrorsInSync |= result.message && result.status !== 200;
        this.runFinalSyncSteps();
    },

    hasFinishedSync: function() {
        return !this.disposed && this.completedRequests === this.collection.nrOfChanges;
    },

    /**
     * After all preferences have been saved successfully close the drawer.
     * In case of errors show an error message but do not close the drawer.
     */
    runFinalSyncSteps: function() {
        if (this.hasFinishedSync()) {
            if (this.hasErrorsInSync) {
                this.showSyncError();
            } else {
                this.closeView();
            }
        }
    },

    showSyncError: function() {
        app.alert.show('notification_sync_error', {
            level: 'error',
            messages: app.lang.get('LBL_NOTIFICATIONS_ERROR_MESSAGE_FAILEDSYNC')
        });
    },

    /**
     * Shows an error regarding the fact that some user preferences
     * have not been set correctly.
     */
    showRequiredError: function() {
        app.alert.show('notification_required_error', {
            level: 'error',
            messages: app.lang.get('LBL_NOTIFICATIONS_ERROR_MESSAGE_MISSING_REQUIRED')
        });
    },

    /**
     * Checks if a model has its required values completed.
     * Note: this method will not trigger any other functionalities/events
     * related to standard validation.
     * 
     * @param {Bean/Model} model A news preference model.
     * @returns {Boolean} True if requirements are met.
     */
    validateModel: function(model) {
        var type = model.get('type');
        var tags = model.get('tag');
        var category = model.get('category');
        var hasTags = (type === 'tags') ? (tags && !_.isEmpty(tags)) : true;
        return type && category && hasTags;
    },

    /**
     * Checks new and extisting preferences that are subject of an update.
     * If any of the preferences lack a required value, they are considered invalid.
     * 
     * @returns {Boolean} True if preferences have been completed properly.
     */
    arePreferencesValid: function() {
        return _.every(this.collection.pref_update, function(model) {
            return this.validateModel(model);
        }, this);
    },

    /**
     * Saves new preferences, updates existing ones and removes those which have been deleted.
     * If there are no changes the drawer needs to be closed. If at least one of the preferences
     * is not set correctly, an error will be shown, valid preferences will not ne saved until
     * all error have not been corrected.
     * @param {String} configurationEvent Event name indicating dashlet configuration phase.
     */
    initPreferencesSync: function(configurationEvent) {
        this.setCollectionDelta();
        this.completedRequests = 0;
        this.hasErrorsInSync = false;
        this.configurationEvent = configurationEvent;

        if (this.collection.nrOfChanges > 0) {
            if (this.arePreferencesValid()) {
                _.each(this.collection.pref_update, this.savePreference, this);
                _.each(this.collection.pref_delete, this.deletePreference, this);
            } else {
                this.showRequiredError();
            }
        } else {
            this.closeView();
        }
    },

    /**
     * Creates and/or updates a preference.
     *
     * @param {Bean} model A notification preference.
     */
    savePreference: function(model) {
        this.compressTargets(model);
        model.save(model.attributes, {
            error: _.bind(this.updateSyncProgress, this),
            success: _.bind(this.updateSyncProgress, this)
        });
    },

    /**
     * Deletes a notification preference.
     *
     * @param {Bean} model The preference to be deleted.
     */
    deletePreference: function(model) {
        model.destroy({
            error: _.bind(this.updateSyncProgress, this),
            success: _.bind(this.updateSyncProgress, this)
        });
    },

    /*****************/
    /* GENERAL LOGIC */
    /*****************/

    /**
    * Actions to be performed in case the user does not give permission
    * for push notificaitons. Revert all browser target to false.
    */
    handleDeniedPermission: function() {
        _.each(this.collection.models, function(model) {
            if (model.get('browser') === true) {
                model.set('browser', false);
            }
        });
    },

    /**
     * If we have at least one browser target, set up the push notifications.
     */
    checkNotificationSetup: function() {
        var hasBrowserTarget = _.find(this.collection.models, function(model) {
            return model.get('browser') === true;
        });
        if (hasBrowserTarget) this.setupPushNotifications();
    },

    /**
     * If the user activates a browser target we need to set up push notifications.
     * A warning will be triggered during the process; in case the user denies permission
     * the browser target will need to stay inactive.
     */
    handleBrowserTargetSelect: function(model) {
        var denyPermissionCallback = _.bind(function(model) {
            model.revertAttributes();
        }, this, model);
        this.setupPushNotifications(denyPermissionCallback);
    },

    /**
     * Save the subscription for push notifications on the server.
     * 
     * @param {String} subscription A JSON string.
     */
    saveSubscription: function(subscription) {
        app.data.createBean('HintNotificationTargets', {
            type: 'browser',
            assigned_user_id: app.user.id,
            credentials: JSON.stringify(subscription)
        }).save();
    },

    /**
     * Checks if there are any unsaved changes, if yes pops up a warning, if not, initiates closing.
     * @param {String} configurationEvent Event name indicating dashlet configuration phase.
     */
    handleDrawerCancel: function(configurationEvent) {
        this.setCollectionDelta();
        this.configurationEvent = configurationEvent;
        if (this.collection.nrOfChanges === 0) {
            this.closeView();
        } else {
            this.warnAboutUnsavedChanges();
        }
    },

    /**
     * A warning message about unsaved changes. If the intention of leaving is confirmed,
     * the changes will not be saved but the drawer will be closed.
     */
    warnAboutUnsavedChanges: function() {
        app.alert.show('leave_confirmation', {
            level: 'confirmation',
            onConfirm: _.bind(this.closeView, this),
            messages: app.lang.get('LBL_WARN_UNSAVED_CHANGES', this.module)
        });
    },

    /**
     * Leaving the view may happen in three distinct ways.
     * Through dashlet configuration save, closing will be handled
     * by dashlet configuration header view.
     * If the preferences were opened through a drawer, we close the drawer.
     * If the preferences were opened through a link, we navigate to the home page.
     */
    closeView: function() {
        if (this.configurationEvent) {
            app.events.trigger('dashletconfig:news-preferences:' + this.configurationEvent);
        } else if (app.drawer.count()) {
            app.drawer.close();
        } else {
            app.router.redirect('#Home');
        }
    },

    /**
     * @inheritdoc
     * Have to detach events.
     */
    _dispose: function() {
        app.events.off('news-preferences:save');
        app.events.off('news-preference:remove');
        app.events.off('news-preferences:cancel');
        app.events.off('news-preference:enable-notifications');
        this._super('_dispose');
    },

    /***************************/
    /* HACKS FOR TARGET FIELDS */
    /***************************/
    extendModels: function() {
        _.each(this.collection.models, this.extendTargets, this);
    },

    /**
     * Targets should be represented by standalone fields.
     * Extends an accountset with the individual target values.
     * NOTE: the syntax used in the each cycle can not be shortened
     * further due to limitations under IE.
     *
     * @param {Bean} model A preference record.
     */
    extendTargets: function(model) {
        var targets = model.get('targets');
        _.each(this.targetFields, function(field) {
            var IE_attribute = {};
            IE_attribute[field] = targets.indexOf(field) > -1;
            model.setDefault(IE_attribute);
        }, this);
    },

    /**
     * Targets should be represented by standalone fields, but saved as a list.
     * Compresses the individual target values into a list and sets them on the model.
     *
     * @param {Bean} model A preference record.
     */
    compressTargets: function(model) {
        var targetList = _.filter(this.targetFields, function(field) {
            return model.get(field);
        });
        model.set('targets', targetList);
    }
});
