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
 * @class View.Views.Base.MarketingExtrasView
 * @alias SUGAR.App.view.views.BaseMarketingExtrasView
 * @extends View.View
 */
({
    marketingContentUrl: '',

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.receiveMessage = this.receiveMessage.bind(this);
        window.addEventListener('message', this.receiveMessage, false);
        this._super('initialize', [options]);
        this.fetchMarketingExtras();
    },

    /**
     * Listen for the marketing frame to post a navigation event on click
     * Expected format for the event data is a JSON encoded object.
     * {"marketing_content_navigate":"https://url.navto.com"}
     *
     * @param {MessageEvent} event Message event with the location to navigate to.
     */
    receiveMessage: function(event) {
        //First verify the message came from the page we expected
        if (this.marketingContentUrl.substr(0, event.origin.length) === event.origin) {
            var data = JSON.parse(event.data);
            if (data && data.marketing_content_navigate) {
                window.open(data.marketing_content_navigate, '_blank');
            }
        }
    },

    /**
     * @inheritdoc
     */
    unbind: function() {
        window.removeEventListener('message', this.receiveMessage, false);
        this._super('unbind', arguments);
    },

    /**
     * Retrieve marketing extras URL from login content endpoint
     */
    fetchMarketingExtras: function() {
        var config = app.metadata.getConfig();
        this.showMarketingContent = config.marketingExtrasEnabled;
        if (this.showMarketingContent) {
            var language = app.user.getLanguage();
            var url = app.api.buildURL('login/content', null, null, {selected_language: language});
            app.api.call('read', url, null, {
                success: _.bind(function(contents) {
                    if (contents && !_.isEmpty(contents.content_url)) {
                        this.marketingContentUrl = contents.content_url;
                        this.render();
                    }
                }, this)
            });
        }
    },
})
