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
    extendsFrom: 'BaseView',

    className: 'stage2-notifications-pref',

    events: {
        'click [data-action=removePreference]': 'removePreference'
    },

    /**
     * @inheritdoc
     */
    initialize: function(opts) {
        this._super('initialize', [opts]);

        this.setCategoryClass();
        this.supportsPushMessages = opts.pushMessages;
        this.model.on('change:type', _.bind(this.toggleAccountTagsField, this));
        this.model.on('change:browser', _.bind(this.enableNotifications, this));
    },

    /**
     * Trigger the push notification access request process.
     * 
     * @param {Event} event The changes event
     * @param {Boolean} newValue Browser target value
     */
    enableNotifications: function(event, newValue) {
        if (newValue && this.supportsPushMessages) {
            app.events.trigger('news-preference:enable-notifications', event);
        }
    },

    /**
     * The category class name is used for the first dropdown in the view.
     */
    setCategoryClass: function() {
        this.categoryClass = this.model.get('type') === 'tags' ? ' short' : ' long';
    },

    /**
     * Delegate the remove event handling to the layout.
     *
     * @param {Event} event The click event on the remove button.
     */
    removePreference: function(event) {
        var el = event.currentTarget,
            cid = el.getAttribute('data-pref-cid');
        app.events.trigger('news-preference:remove', this, cid);
    },

    /**
     * If the accoun tags is selected for the main dropdown we need to show the tags field
     * As per current state a timeout is needed for the re-rendering in order to allow the
     * dropdowns to process the change event with their own listeners.
     */
    toggleAccountTagsField: function() {
        this.setCategoryClass();
        setTimeout(_.bind(this.render, this), 1);
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        this.model.off('change:type', _.bind(this.render, this));
        this.model.off('change:browser', _.bind(this.enableNotifications, this));
        this._super('_dispose');
    }
});
